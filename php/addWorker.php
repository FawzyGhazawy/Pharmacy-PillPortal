<?php
require_once 'connection.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../login.php');
    exit;
}
extract($_POST);

$pass = $_POST['password'];
$password = md5($pass);
$status='worker';

$query = "SELECT * FROM users WHERE username='$username'"; //check duplicate
$result = mysqli_query($link, $query);
if (($result) && (mysqli_num_rows($result) < 1)) {

    $query = "INSERT INTO users(username,password,status) VALUES ('$username','$password','$status')";

    if (mysqli_query($link, $query)) {
        $u_id = mysqli_insert_id($link); // Get the ID of the newly inserted user

        $query = "INSERT INTO workers (u_id, name,  phone,  dateOfBirth, salary) VALUES ('$u_id', '$username', '$phone', '$dob', '$salary')";
        if (mysqli_query($link, $query)) {
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
        ">Worker Hired Successfully.</p>
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

            <?php // Return success message
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
        ">Error inserting worker information.</p>
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
        ">Error inserting worker information.</p>
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
    ">Already Added.</p>
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
?>
