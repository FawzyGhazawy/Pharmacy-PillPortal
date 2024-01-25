<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['status'] != 'pharmacist') {
    header('Location: ../index.html');
}
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['stk_id']) && !empty($_POST['stk_id'])) {
        // Get the values of the form fields
        $stk_id = $_POST["stk_id"];
        $nbr = $_POST["nbr"];

        if ($nbr == -1) {
            $updateQuery = "UPDATE stock SET qty = '0' WHERE stk_id = '$stk_id'";
            if (mysqli_query($link, $updateQuery)) {?>
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
                ">Quantity got emptied.</p>
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
                exit;
            }
        }

        $updateQuery = "UPDATE stock SET qty = qty - '$nbr' WHERE stk_id = '$stk_id'";
        if (mysqli_query($link, $updateQuery)) {?>
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
            ">Quantity decreased successfully.</p>
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
            echo "Error updating record: " . mysqli_error($link);
        }
    } else {
        echo "no nbr";
    }
} else {
    echo "No requests found.";
}
