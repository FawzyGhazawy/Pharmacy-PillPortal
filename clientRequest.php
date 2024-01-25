<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['status'] != 'client') {
    header('Location: index.html');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>PillPortal</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <!-- jQuery library -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!-- Bootstrap JavaScript -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

    <!-- font awesome style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700|Roboto:400,700&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />
    <link href="login.css" rel="stylesheet" />
    <style>
        #logout {
            background-color: transparent;
        }

        #logout:hover {
            background-color: #10e7f4;
            color: black;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        .table thead {
            background-color: #2F4F4F;
            color: #F5FFFA;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 12px;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #ddd;
        }
    </style>

</head>

<body>

    <!-- header section strats -->
    <header class="header_section">

        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
                <a class="navbar-brand" href="client.php">
                    <img src="images/logo.png" alt="">
                    <span>
                        PillPortal
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="d-flex  flex-column flex-lg-row align-items-center w-100 justify-content-between">
                    <ul class="navbar-nav  ">
                            <li class="nav-item active">
                                <a class="nav-link" href="client.php">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="clientHistory.php">History <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="clientRequest.php"> Requests </a>
                            </li>
                        </ul>
                        <form class="form-inline ">
                            <input type="search" placeholder="Search">
                            <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
                        </form>
                        <div class="btn " id="logout">
                            <a href="php/logout.php" style="color:white;">Logout
                                <img src="images/user.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>

            </nav>
        </div>
    </header>
    <div id="statistics">
        <!-- Statistics field goes here -->
        <h2 style="margin:2%; padding-left:42%;">Requests</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Price$</th>
                    <th>Total Price $</th>
                    <th>Total Price LL</th>
                    <th>Dollar rate</th>
                    <th>Prescription</th>
                    <th>denied</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'php/connection.php';
                require_once 'php/viewrequests.php';
                require_once 'php/staff.php';
                $sales = viewrequestsclient($link, $_SESSION['c_id']);
                if ($sales != -1) {
                    foreach ($sales as $request) {
                        $img = $request['prescription'];
                        $imageData = base64_encode($img);
                        $img1 = base64_encode($request['prescription']);
                        $img2 = str_replace(' ', '+', $img);

                ?>
                        <tr>
                            <td>
                                <?php echo $request['timestamp']; ?>
                            </td>
                            <td>
                                <?php echo $request['medicine']; ?>
                            </td>
                            <td>
                                <?php echo $request['s_qty']; ?>
                            </td>
                            <td>
                                <?php echo $request['total_price']; ?>
                            </td>
                            <td>
                                <?php echo $request['total_price'] * $request['s_qty']; ?>
                            </td>
                            <td>
                                <?php echo $request['total_price'] * $request['dollar_rate'] * $request['s_qty']; ?>
                            </td>
                            <td>
                                <?php echo $request['dollar_rate']; ?>
                            </td>
                            <td class="prescription-image">
                                <!-- Trigger Button -->
                                <button type="button" class="btn btn-link prescription-btn" data-toggle="modal"
                                            data-target="#prescriptionModal<?php echo $request['r_id']; ?>"
                                            data-image-url="data:image/jpeg;base64,<?php echo base64_encode($request['prescription']); ?>">
                                            View Prescription
                                        </button>
                            </td>
                            <td>
                                <?php echo $request['denied']; ?>
                            </td>
                        </tr>
                         <!-- Prescription Modal -->
                         <div id="prescriptionModal"<?php echo $request['r_id']; ?> class="modal">
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <img class="modal-image"
                                            src="data:image/jpeg;base64,<?php echo base64_encode($request['prescription']); ?>"
                                            alt="Prescription Image">
                                    </div>
                                </div>

                <?php
                    }
                } else {
                    echo "No sales found.";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        const modals = document.querySelectorAll(".modal");
        const btns = document.querySelectorAll(".prescription-btn");
        const images = document.querySelectorAll(".modal-image");
        const closes = document.querySelectorAll(".close");

        for (let i = 0; i < btns.length; i++) {
            btns[i].onclick = function () {
                const imageUrl = this.getAttribute("data-image-url");
                images[i].src = imageUrl;
                modals[i].style.display = "block";
            };

            closes[i].onclick = function (event) {
                modals[i].style.display = "none";
                event.stopPropagation();
            };

            window.onclick = function (event) {
                if (event.target.classList.contains("modal")) {
                    modals[i].style.display = "none";
                }
            };
        }
    </script>




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>

</body>

</html>