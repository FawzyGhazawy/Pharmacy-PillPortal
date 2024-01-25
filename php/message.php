<?php
require_once 'connection.php';
require_once 'staff.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $send_id = $_SESSION['u_id'];
    $username = $_POST['username'];
    $receive_id = getEmpByUsername($link, $username);

    if ($receive_id > 0) {
        $message = $_POST['message'];

        $query = "INSERT INTO messages (u_id, receive_id, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, 'iis', $send_id, $receive_id, $message);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            ?>
            <div style="
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #10e7f4;
        transition: all 0.3s ease;
    ">
        <div style="
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            transition: all 0.3s ease;
        ">
            <p style="
                margin-bottom: 20px;
                font-size: 18px;
                color: #333;
                text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            ">Message sent successfully.</p>
            <button onclick="goBack()" style="
                display: inline-block;
                padding: 10px 20px;
                background: #0e1d34;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
                transition: all 0.3s ease;
            ">Back</button>
        </div>
    </div>
    <script>
    function goBack() {
        window.history.back();
    }
    </script>
    
            <?php
        } else {
            echo "Error: " . mysqli_error($link);
        }
    } else {?>
        <div style="
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #10e7f4;
    transition: all 0.3s ease;
">
    <div style="
        width: 300px;
        padding: 20px;
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        text-align: center;
        transition: all 0.3s ease;
    ">
        <p style="
            margin-bottom: 20px;
            font-size: 18px;
            color: #333;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        ">Error: User doesn't exist.</p>
        <button onclick="goBack()" style="
            display: inline-block;
            padding: 10px 20px;
            background: #0e1d34;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        ">Back</button>
    </div>
</div>
<script>
function goBack() {
    window.history.back();
}
</script>

        <?php
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['m_id'])) {
    $m_id = $_GET['m_id'];
    deleteMessage($link, $m_id);
}

function viewMessages($link, $receive_id)
{
    $query = "SELECT * FROM messages NATURAL JOIN workers NATURAL JOIN users WHERE receive_id=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'i', $receive_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $messages = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = [
                'm_id' => $row['m_id'],
                'w_id' => $row['w_id'],
                'name' => $row['name'],
                'type' => $row['status'],
                'message' => $row['message'],
                'm_timestamp' => $row['m_timestamp']
            ];
        }
    } else {
        return -1; // No messages
    }

    return $messages;
}

function deleteMessage($link, $m_id)
{
    $query = "DELETE FROM messages WHERE m_id=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'i', $m_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        //header('Location: ../viewMessages.php');
        ?>
            <div style="
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #10e7f4;
        transition: all 0.3s ease;
    ">
        <div style="
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            transition: all 0.3s ease;
        ">
            <p style="
                margin-bottom: 20px;
                font-size: 18px;
                color: #333;
                text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            ">Message deleted successfully.</p>
            <button onclick="goBack()" style="
                display: inline-block;
                padding: 10px 20px;
                background: #0e1d34;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
                transition: all 0.3s ease;
            ">Back</button>
        </div>
    </div>
    <script>
    function goBack() {
        window.history.back();
    }
    </script>
    
            <?php
    } else {
        ?>
        <div style="
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #10e7f4;
    transition: all 0.3s ease;
">
    <div style="
        width: 300px;
        padding: 20px;
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        text-align: center;
        transition: all 0.3s ease;
    ">
        <p style="
            margin-bottom: 20px;
            font-size: 18px;
            color: #333;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        "><?php echo "Error: " . mysqli_error($link); ?></p>
        <button onclick="goBack()" style="
            display: inline-block;
            padding: 10px 20px;
            background: #0e1d34;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        ">Back</button>
    </div>
</div>
<script>
function goBack() {
    window.history.back();
}
</script>

        <?php
        
    }
}
