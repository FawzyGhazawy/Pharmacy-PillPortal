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

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

    <!-- font awesome style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700|Roboto:400,700&display=swap"
        rel="stylesheet">

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
        .my-carousel .owl-nav {
    position: absolute;
    top: 0px;
    width: 100%;
}

.my-carousel .owl-nav .owl-prev,
.my-carousel .owl-nav .owl-next {
    position: absolute;
}

.my-carousel .owl-nav .owl-prev {
    left: 10px; /* adjust this value as needed */
}

.my-carousel .owl-nav .owl-next {
    right: 10px; /* adjust this value as needed */
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
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
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

    <section class="health_section layout_padding">
        <div class="health_carousel-container">
            <h2 class="text-uppercase">
                Medicine & Health
            </h2>

            <?php
            include('php/stock.php');
            $all = getstock($link);
            if ($all == -1) {
                echo "no stock";
            } else {
                ?>
                <div class="carousel-wrap layout_padding2">
                <div class="owl-carousel owl-theme my-carousel">


                        <?php
                        for ($i = 0; $i < count($all[0]); ++$i) {
                            $stk_id = $all[0][$i]; //stk_id
                            ?>
                            <div class="item">
                                <div class="box">
                                    <div class="btn_container">
                                        <a href="http://localhost/pharmacy_pillportal/buynew.php?stk_id=<?php echo $stk_id; ?>">
                                            Buy Now
                                        </a>
                                    </div>
                                    <div class="img-box">
                                        <img src="data:image/jpeg;base64,<?php $pic = $all[6][$i];
                                        echo base64_encode($pic); //pic 
                                        ?>" alt="Medicine">
                                    </div>
                                    <div class="detail-box">
                                        <div class="text">
                                            <h6>
                                                <?php echo "" . $all[1][$i]; //name 
                                                        ?>
                                            </h6>
                                            <h6 class="price">
                                                <span>
                                                    $
                                                </span>
                                                <?php echo "" . $all[5][$i]; //price 
                                                        ?>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <?php ++$i;

                                if ($i < count($all[0])) {
                                    $stk_id = $all[0][$i]; //stk_id?>
                                     <div class="box">
                                    <div class="btn_container">
                                        <a href="http://localhost/pharmacy_pillportal/buynew.php?stk_id=<?php echo $stk_id; ?>">
                                            Buy Now
                                        </a>
                                    </div>
                                    <div class="img-box">
                                        <img src="data:image/jpeg;base64,<?php $pic = $all[6][$i];
                                        echo base64_encode($pic); //pic 
                                        ?>" alt="Medicine">
                                    </div>
                                    <div class="detail-box">
                                        <div class="text">
                                            <h6>
                                                <?php echo "" . $all[1][$i]; //name 
                                                        ?>
                                            </h6>
                                            <h6 class="price">
                                                <span>
                                                    $
                                                </span>
                                                <?php echo "" . $all[5][$i]; //price 
                                                        ?>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <?php } else { ?>
                                    <div class="box">

                                        <div class="img-box">
                                        </div>
                                        <div class="detail-box">

                                            <div class="text">
                                                <h6>

                                                </h6>
                                                <h6 class="price">
                                                    <span>

                                                    </span>

                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </section>
    <!-- info section -->
    <section class="info_section layout_padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="info_contact">
                        <h4>
                            Contact
                        </h4>
                        <div class="box">
                            <div class="img-box">
                                <img src="images/telephone-symbol-button.png" alt="">
                            </div>
                            <div class="detail-box">
                                <h6>
                                    +01 123567894
                                </h6>
                            </div>
                        </div>
                        <div class="box">
                            <div class="img-box">
                                <img src="images/email.png" alt="">
                            </div>
                            <div class="detail-box">
                                <h6>
                                    demo@gmail
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info_menu">
                        <h4>
                            Menu
                        </h4>
                        <ul class="navbar-nav  ">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.html"> About </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="medicine.html"> Medicine </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="buy.html"> Online Buy </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info_news">
                        <h4>
                            newsletter
                        </h4>
                        <form action="">
                            <input type="text" placeholder="Enter Your email">
                            <div class="d-flex justify-content-center justify-content-md-end mt-3">
                                <button>
                                    Subscribe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- end info section -->

    <!-- footer section -->
    <section class="container-fluid footer_section">
        <p>
            &copy; 2019 All Rights Reserved. Design by
            <a href="https://html.design/">Free Html Templates</a>
        </p>
    </section>
    <!-- footer section -->

    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js">
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        var owl = $(".owl-carousel");
        owl.owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
            autoplay: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });

        // keyboard navigation
        $(document).keydown(function(e) {
            if (e.keyCode === 37) {
                owl.trigger('prev.owl.carousel', [300]);
            } else if (e.keyCode === 39) {
                owl.trigger('next.owl.carousel', [300]);
            }
        });
    });
</script>

</body>

</html>