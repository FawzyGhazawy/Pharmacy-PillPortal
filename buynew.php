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
  <title>Buy Medicine</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Custom CSS -->
  <!-- <link rel="stylesheet" href="login.css"> -->

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
    body {
      background-color: #f8f9fa;
    }

    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      border-radius: 5px;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    #medicine-name {
      color: #343a40;
      margin-top: 20px;
    }

    #medicine-price,
    #total-price {
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
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
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
  <div class="container py-5" style="margin-bottom: 10%;">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <?php
          $c_id = $_SESSION['c_id'];
          $stk_id = $_GET['stk_id'];
          $qty = 5;
          $price = 0;

          include('php/stock.php');
          $all = getstock2($link, $stk_id);
          if ($all == -1) {
            echo "no stock";
          } else if ($all['qty'] <= 0) {
            echo "<p style=\"color:red; font-size:50px;\">out of stock</p>";
            $qty = 0;
          } else {
          ?>
            <img src="data:image/jpeg;base64,<?php $pic = $all['pic'];
                                              echo base64_encode($pic); //pic 
                                              ?>" alt="Medicine Image" class="card-img-top img-fluid">

            <!-- <img src="OP_HD_Wall L@♫BerT_6.jpg" alt="Medicine Image" class="card-img-top img-fluid"> -->
        </div>
      </div>
      <div class="col-md-6">
        <div class="card p-4">
        <?php

            $price = $all['price'];
            $qty = $all['qty'];
          }

        ?>
        <h2 id="medicine-name"><?php echo $all['medicine']; ?></h2>
        <p id="medicine-type"><?php echo $all['type']; ?></p>

        <p id="medicine-description"><?php echo $all['description']; ?></p>
        <p id="medicine-qty">Quantity available: <?php echo $all['qty']; ?></p>
        <h4 id="medicine-price" data-price="<?php echo $all['price']; ?>">Price: $<?php echo $all['price']; ?></h4>
        <h4 id="total-price">Total: $<?php echo $all['price']; ?></h4>
        
        <form action="php/request.php" method="POST" enctype="multipart/form-data">
          <div class="form-group quantity">
            <label for="medicine-quantity">Quantity:</label>
            <button type="button" id="minus">-</button>
            <input type="number" class="form-control" id="medicine-quantity" name="qty" min="1" max="<?php echo $qty; ?>" step="1" required>
            <button type="button" id="plus">+</button>
          </div>
          <div class="form-group">
            <label for="prescription-upload">Upload Prescription:</label>
            <input type="file" class="form-control-file" id="prescription-upload" accept=".jpg,.jpeg,.png,.pdf" name="prescription" id="image">
          </div>
          <input type="hidden" name="stk_id" value="<?php echo $stk_id; ?>">
          <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
          <input type="hidden" name="price" value="<?php echo $price; ?>">
          <button type="submit" class="btn btn-primary">Buy</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- <div class="modal fade" id="prescriptionModal" tabindex="-1" role="dialog" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="prescriptionModalLabel">Missing Prescription</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Please upload a valid prescription before adding the medicine to your cart.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> -->

  <script>
    $(document).ready(function() {
      function updateTotal() {
        var price = $('#medicine-price').data('price');
        var quantity = $('#medicine-quantity').val();
        var total = price * quantity;
        $('#total-price').text('Total: $' + total);
      }

      $('#minus').click(function() {
        var quantity = $('#medicine-quantity').val();
        if (quantity > 1) {
          $('#medicine-quantity').val(quantity - 1);
          updateTotal();
        }
      });

      $('#plus').click(function() {
        var quantity = $('#medicine-quantity').val();
        $('#medicine-quantity').val(+quantity + 1);
        updateTotal();
      });

      $('#medicine-quantity').change(function() {
        updateTotal();
      });

      // $('form').submit(function(event) {
      //   var prescription = $('#prescription-upload')[0].files[0];
      //   if (!prescription) {
      //     event.preventDefault();
      //     $('#prescriptionModal').modal('show');
      //   }
      // });
    });
  </script>
</body>

</html>