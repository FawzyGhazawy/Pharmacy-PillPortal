<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['status'] != 'client') {
    header('Location: index.html');
}
require_once 'php/connection.php';
?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>PillPortal</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="login.css">

  <!-- font awesome style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700|Roboto:400,700&display=swap" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <style>
    #logout {
      background-color: transparent;
    }

    #logout:hover {
      background-color: #10e7f4;
      color: black;
    }

    body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            border-radius: 5px;
        }
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
        #medicine-name {
            color: #343a40;
            margin-top: 20px;
        }
        #medicine-price, #total-price {
            color: #28a745;
            margin-top: 20px;
            font-weight: bold;
        }
        .btn-primary {
            background: linear-gradient(45deg, #1e7e34, #28a745);
            border-color: #28a745;
            transition: transform 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #155724, #218838);
            border-color: #1e7e34;
            transform: scale(1.05);
        }
        .form-group {
            margin-top: 20px;
        }
        .quantity {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .quantity button {
            background: transparent;
            border: none;
            color: #007bff;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.3s ease;
        }
        .quantity button:hover {
            color: #0056b3;
            transform: scale(1.2);
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
                                <a class="nav-link" href="about.html"> About </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="news.html"> News </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="client_msg.php">Contact us</a>
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
    name type qty description price pic
    </br>
    <?php
    $c_id = $_SESSION['c_id'];
    $stk_id = $_GET['stk_id'];
    $qty = 5;
    $price = 0;

    include('php/stock.php');
    $all = getstock2($link, $stk_id);
    if ($all == -1) {
        echo "no stock";
    } else if ($all[3] <= 0) {
        echo "out of stock";
    } else {
        for ($i = 1; $i < count($all); ++$i) {
            if ($i == 6) { ?>
                <img src="data:image/jpeg;base64,<?php $pic = $all[$i];
                                                    echo base64_encode($pic); //pic 
                                                    ?>" alt="Medicine">
    <?php } else {

                echo $all[$i] . " ";
            }
        }
        $price = $all[5];
        $qty = $all[3];
    }

    ?>
    </br>
    <form action="php/request.php" method="post" enctype="multipart/form-data">
        Quantity:<input type="number" name="qty" min="0" max="<?php echo $qty; ?>" step="1" required>
        </br>
        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image" required>
        <input type="hidden" name="stk_id" value="<?php echo $stk_id; ?>">
        <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
        <input type="hidden" name="price" value="<?php echo $price; ?>">

        <br><br>
        <input type="submit" value="Buy">
    </form>

</body>