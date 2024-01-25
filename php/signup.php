<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_POST['username']) && isset($_POST['password'])) {
        require('connection.php');
        extract($_POST); //$username and $password

        //insert code for duplicate check
        $username = $_POST['username'];
        $username = mysqli_real_escape_string($link, $username); //strip username from escape charcters

        $pass = $_POST['password'];
        $password = md5($pass);

        $c_name = $_POST['c_name'];
        $c_name = mysqli_real_escape_string($link, $c_name);
        $c_phone = $_POST['c_phone'];
        $c_address = $_POST['c_address'];
        $c_address = mysqli_real_escape_string($link, $c_address);

        $guest = false;

        $query = "INSERT INTO users(username,password) VALUES ('$username','$password')";

        if (mysqli_query($link, $query)) {
            // this returns the id that mysql used for the new tuple
            //if successful ->Login
            $u_id = mysqli_insert_id($link);

            //u_id,pay_id,c_name,c_phone,c_address,c_longitude,c_latitude,c_district,guest,rating`) 
            //VALUES ('3', NULL, 'test3', 'test3', 'test3', NULL, NULL, 'Batroun','0', NULL);
            $query = "INSERT INTO clients(u_id,c_name,c_phone,c_address) 
                VALUES ('$u_id','$c_name','$c_phone','$c_address')";

            if (mysqli_query($link, $query)) {
                //LOGIN CODE
                $query = "SELECT * FROM users WHERE username = '$username';";

                $result = mysqli_query($link, $query);
                if (($result) && (mysqli_num_rows($result) == 1)) {
                    $u_info = mysqli_fetch_assoc($result);

                    if (($u_info['username'] == $username) &&
                        ($u_info['password'] == md5($pass))
                    ) {
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $u_info['username'];
                        $_SESSION['u_id'] = $u_info['u_id'];
                        $_SESSION['status'] = $u_info['status'];

                        if ($_SESSION['status'] == 'client') {
                            $query = "SELECT * FROM clients WHERE u_id = '$u_id';"; //get its info
                            $result = mysqli_query($link, $query);
                            $u_info = mysqli_fetch_assoc($result);
                            $_SESSION['c_id'] = $u_info['c_id'];
                            $_SESSION['c_name'] = $u_info['c_name'];
                            $_SESSION['c_address'] = $u_info['c_address'];
                            $_SESSION['c_phone'] = $u_info['c_phone'];
                            $_SESSION['c_timestamp'] = $u_info['c_timestamp'];
                            header('Location: ../client.php');
                        } else {
                            $query = "SELECT * FROM workers WHERE u_id = '$u_id';"; //get its info
                            $result = mysqli_query($link, $query);
                            $u_info = mysqli_fetch_assoc($result);
                            $_SESSION['w_id'] = $u_info['w_id'];
                            $_SESSION['name'] = $u_info['name'];
                            $_SESSION['phone'] = $u_info['phone'];
                            $_SESSION['branch'] = $u_info['branch'];
                            $_SESSION['dateOfBirth'] = $u_info['dateOfBirth'];
                            $_SESSION['salary'] = $u_info['salary'];
                            $_SESSION['timestamp'] = $u_info['timestamp'];

                            if ($_SESSION['status'] == 'pharmacist') {
                                header('Location: ../pharmacist.php');
                            } else if ($_SESSION['status'] == 'worker') {
                                header('Location: ../worker.php');
                            } else if ($_SESSION['status'] == 'IT') {
                                header('Location: ../IT.php');
                            }
                        }
                    } else {
                        //header('Location: login.html');
                        echo "-2";
                    }
                } else {
                    //header('Location: login.html');
                    echo "-3";
                }
                mysqli_close($link);
            } else {
                echo "-1";
            }
        }
    } else {
        //header('Location: login.html');
        echo "-1";
    }

    ?>
</body>

</html>