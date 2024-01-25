<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['status'] != 'pharmacist') {
    header('Location: index.html');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Pharmacy Manager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap4-prefixed.css" />
</head>

<style>
    /* .pull-right .btn-danger:hover {
        background-color: black;
        color: red;
    } */
    .messages-section {
        margin-top: 20px;
        margin-bottom: 5%;
    }

    .message {
        background-color: #f5f5f5;
        padding: 10px;
        margin-bottom: 10px;
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .message-username {
        font-weight: bold;
    }

    .message-timestamp {
        font-size: 12px;
        color: #888888;
    }

    .message-body {
        font-size: 14px;
    }

    .delete-btn {
        /* background-color: #ff0000;
        color: #ffffff; */
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn.btn-danger:hover {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff;
    }

    .modal-content {
        background: #f5f5f5;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    .modal-header .modal-title {
        color: #333;
        font-size: 24px;
    }

    .modal-body .form-group {
        margin-bottom: 15px;
    }

    .modal-body .form-group label {
        font-weight: 600;
        color: #555;
    }

    .modal-body .form-group input,
    .modal-body .form-group textarea {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        width: 100%;
    }

    .modal-footer {
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }

    .btn {
        border-radius: 4px;
        padding: 10px 20px;
        font-size: 16px;
    }

    .btn.btn-secondary {
        background: #6c757d;
        color: #fff;
    }

    .btn.btn-primary {
        background: #007bff;
        color: #fff;
    }

    .delete-btn {
        background: #FF6347;
        /* Tomato */
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .delete-btn:hover {
        background: #FF4500;
        /* OrangeRed */
    }

    .card {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        margin: 10% auto;
        max-width: 500px;
        border-radius: 10px;
    }

    .card-header {
        background-color: #007bff;
        color: white;
        font-size: 20px;
        padding: 10px 15px;
        border-radius: 10px 10px 0 0;
    }

    .card-body {
        padding: 20px;
    }

    .form-inline .form-control {
        margin: 10px 0;
    }
</style>

<body>
    <div class="container">
        <h1>PillPortal Pharmacy Manager</h1>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#statistics">Statistics</a></li>
            <li><a data-toggle="tab" href="#dollarRate">$ rate</a></li>
            <li><a data-toggle="tab" href="#messaging">Messaging</a></li>
            <li><a data-toggle="tab" href="#workers">Workers</a></li>
            <li><a data-toggle="tab" href="#medicines">Medicines</a></li>
            <li class="pull-right"><a href="php/logout.php" class="btn btn-danger">Logout</a></li>

        </ul>
        <div class="tab-content">
            <div id="statistics" class="tab-pane fade in active">
                <!-- Statistics field goes here -->
                <h2>Sales</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Client</th>
                            <th>Medicine</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Dollar rate</th>
                            <th>Prescription</th>
                            <th>Worker confirmed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once 'php/connection.php';
                        require_once 'php/sales.php';
                        require_once 'php/staff.php';
                        $sales = viewsales($link);
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
                                        <?php echo $request['c_name']; ?>
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
                                        <?php echo $request['dollar_rate']; ?>
                                    </td>
                                    <td class="prescription-image">
                                <!-- Trigger Button -->
                                <button type="button" class="btn btn-link prescription-btn" data-toggle="modal"
                                    data-target="#prescriptionModal<?php echo $request['s_id']; ?>"
                                    data-image-url="data:image/jpeg;base64,<?php echo $img2; ?>">View Prescription</button>
                            </td>
                                    <td>
                                        <?php
                                        $w_id = $request['w_id'];
                                        $emp = getEmpById($link, $w_id);
                                        echo $w_id . "- " . $emp;
                                        ?>
                                    </td>
                                </tr>
                                 <!-- Modal -->
                        <div class="bs4 modal fade" id="prescriptionModal<?php echo $request['s_id']; ?>" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:10%;">
                            <div class="bs4 modal-dialog" role="document">
                                <div class="bs4 modal-content">
                                    <div class="bs4 modal-header">
                                        <h5 class="bs4 modal-title">Prescription Image</h5>
                                        <button type="button" class="bs4 close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="bs4 modal-body">
                                        <img class="bs4 img-fluid" id="modal-image-<?php echo $request['s_id']; ?>"
                                            src="data:image/jpeg;base64,<?php echo $img2; ?>" alt="Prescription Image">
                                    </div>
                                </div>
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
            <?php foreach ($sales as $request) {
                $img = $request['prescription'];
                $imageData = base64_encode($img); ?>
                <!-- Modal -->

            <?php } ?>
            <?php
            // foreach ($requests as $request) {
            ?>
            <!-- Modal -->

            <?php
            //  } 
            ?>

            <div id="dollarRate" class="tab-pane fade">
                <div class="card">
                    <div class="card-header">
                        Dollar Rate Change
                    </div>
                    <div class="card-body">
                        <!-- Dollar rate change form -->
                        <form class="form-inline dollar-rate-change" method="POST" action="php/setrate.php">
                            <div class="form-group">
                                <label for="dollarRateChangeInput" class="mr-3">New rate: </label>
                                <input type="number" step="0.01" class="form-control mr-3" id="dollarRateChangeInput"
                                    placeholder="Enter new rate" name="dollar_rate" min="0.01" required>
                                <button type="submit" class="btn btn-primary">Change Rate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div id="messaging" class="tab-pane fade">
                <h2>Contact</h2>
                <form id="contact-form" method="POST" action="php/message.php">
                    <div class="form-grouyp">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>

                <!-- Messages section -->
                <div class="messages-section">
                    <h3>Messages</h3>
                    <?php
                    include('php/message.php');
                    $messages = viewMessages($link, $_SESSION['u_id']);

                    if ($messages == -1) {
                        echo '<div class="message">
        <div class="message-header">
            <span class="message-username">System</span>
            <span class="message-timestamp">Now</span>
        </div>
        <div class="message-body">
            <p>Checking messages...</p>
        </div>
        <button class="delete-btn btn btn-danger">No messages</button>
    </div>';
                    } else {
                        foreach ($messages as $message) {
                            $m_id = $message['m_id'];
                            $name = $message['name'];
                            $timestamp = $message['m_timestamp'];
                            $content = $message['message'];
                            ?>
                            <div class="message">
                                <div class="message-header">
                                    <span class="message-username">
                                        <?php echo $name; ?>
                                    </span>
                                    <span class="message-timestamp">
                                        <?php echo $timestamp; ?>
                                    </span>
                                    <button class="delete-btn btn btn-danger"
                                        onclick="deleteMessage('<?php echo $m_id; ?>')">Delete</button>
                                </div>
                                <div class="message-body">
                                    <p>
                                        <?php echo $content; ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>


                    <!-- Add more messages here -->

                </div>
            </div>



            <div id="workers" class="tab-pane fade">
                <!-- Workers field goes here -->
                <h2>Workers</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Id</th>
                            <th>Position</th>
                            <th>Phone</th>
                            <th>Salary</th>
                            <th>Date of birth</th>
                            <th>Date joined </th>
                        </tr>
                    </thead>
                    <?php
                    require_once 'php/connection.php';
                    $query = 0;
                    // if (isset($_POST['submit'])) {
                    //   $selected_worker = $_POST['worker'];
                    
                    //   $query = "SELECT * FROM workers NATURAL JOIN users WHERE ( name LIKE '$selected_worker%' OR w_id LIKE'$selected_worker%' OR branch LIKE '$selected_worker%') AND type != 'CEO' ORDER BY w_id ASC";
                    // } else {
                    
                    $query = "SELECT * FROM workers NATURAL JOIN users ORDER BY w_id ASC";
                    //}
                    $result = mysqli_query($link, $query);
                    if (($result) && (mysqli_num_rows($result) > 0)) {


                        while ($row = mysqli_fetch_assoc($result)) {

                            $rmid = $row["u_id"];
                            echo "<tr>   
                <td>" . $row["name"] . "</td>
                <td>" . $row["w_id"] . "</td>
                <td>" . $row["status"] . "</td>
                <td>" . $row["phone"] . "</td>
                <td>" . $row["salary"] . "$</td>
                <td>" . $row["dateOfBirth"] . "</td>
                <td>" . $row["timestamp"] . "</td> 
                </tr>";
                        }
                    }

                    ?>


                    <!-- Add more rows for each worker here -->
                    </tbody>
                </table>


            </div>
            <div id="medicines" class="tab-pane fade">
                <h2>Medicines</h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addMedicineModal">Add New
                    Medicine</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Medicine</th>
                            <th>ID</th>
                            <th>Quantity</th>
                            <th>Sold</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        require_once 'php/connection.php';
                        $query = 0;

                        $query = "SELECT * FROM stock ORDER BY type ASC";

                        $result = mysqli_query($link, $query);
                        if (($result) && (mysqli_num_rows($result) > 0)) {


                            while ($row = mysqli_fetch_assoc($result)) {

                                echo "<tr>   
                <td>" . $row["type"] . "</td>  
                <td>" . $row["medicine"] . "</td>
                <td>" . $rmid . "</td>
                <td>" . $row["qty"] . "</td>
                <td>" . $row["sold"] . "</td>
                <td>" . $row["price"] . "$</td>                
                <td>" . $row["description"] . "</td>
                ";

                                ?>
                                <td>
                                    <button type="button" class="btn btn-success increase-stock"
                                        data-stk_id="<?php echo $row["stk_id"]; ?>">Increase</button>
                                    <button type="button" class="btn btn-danger decrease-stock"
                                        data-stk_id="<?php echo $row["stk_id"]; ?>">Decrease</button>
                                    <form id="deleteform" method="POST" action="php/decrease.php">
                                        <input type="hidden" name="nbr" id="amount" class="form-control" value="-1">
                                        <input type="hidden" name="stk_id" value="<?php echo $row["stk_id"]; ?>">
                                        <button type="submit" class="delete-btn"
                                            data-stk_id="<?php echo $row["stk_id"]; ?>">Empty</button>
                                    </form>
                                </td>

                                <?php
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
            <div id="addMedicineModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Medicine</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form id="addMedicineForm" method="POST" action="php/addmedicine2.php"
                            enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" name="medicine" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Type:</label>
                                    <input type="text" name="type" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Quantity:</label>
                                    <input type="number" name="qty" required class="form-control" min="1">
                                </div>
                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea name="description" required class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Price:</label>
                                    <input type="number" name="price" required class="form-control" min="0.01"
                                        step="0.01">
                                </div>
                                <div class="form-group">
                                    <label>Image:</label>
                                    <input type="file" name="pic" required class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="popup" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enter Amount</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="increaseForm" method="POST" action="php/increase.php">
                            <div class="modal-body">
                                <p>Please enter the amount:</p>
                                <input type="number" name="nbr" required id="amount" class="form-control" min="1"
                                    max="1000">
                            </div>
                            <input type="hidden" name="stk_id" value="">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="cancel">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="confirm">OK</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="popupd" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enter Amount</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="decreaseForm" method="POST" action="php/decrease.php">
                            <div class="modal-body">
                                <p>Please enter the amount:</p>
                                <input type="number" name="nbr" required id="amount" class="form-control" min="1"
                                    max="1000">
                            </div>
                            <input type="hidden" name="stk_id" value="">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="canceld">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="confirm">OK</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Modal functionality
            const modals = document.querySelectorAll(".modal");

            // Loop through all modal buttons
            const prescriptionBtns = document.querySelectorAll(".prescription-btn");
            prescriptionBtns.forEach((btn, index) => {
                // Attach click event to each button
                btn.addEventListener("click", function () {
                    let imageUrl = this.getAttribute("data-image-url");
                    // Find corresponding modal and image elements
                    let modalContent = modals[index].querySelector(".modal-content");
                    let modalImage = modalContent.querySelector(".modal-image");
                    // Set the image source
                    modalImage.src = imageUrl;
                    // Show the modal
                    modals[index].style.display = "block";
                });
            });

            // Close modal when close button or outside modal is clicked
            modals.forEach(modal => {
                modal.addEventListener("click", function (event) {
                    if (event.target.classList.contains("modal") || event.target.classList.contains("close")) {
                        this.style.display = "none";
                    }
                });
            });

            // Close modal when a close button is clicked
            const closeButtons = document.querySelectorAll(".close");
            closeButtons.forEach((btn, index) => {
                btn.addEventListener("click", function (event) {
                    event.stopPropagation();
                    modals[index].style.display = "none";
                });
            });
        });
    </script> -->
    <script>
    $(document).ready(function(){
        $('.prescription-btn').on('click', function() {
            var imageUrl = $(this).attr('data-image-url');
            var modalTarget = $(this).attr('data-target');
            $(modalTarget).find('.img-fluid').attr('src', imageUrl);
        });
    });
</script>





    <script>
        // Select all "Deny" buttons and add a click event listener to each one
        const denyButtons = document.querySelectorAll('.decrease-stock');
        denyButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const r_id = button.dataset.id;
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `http://localhost/pharmacy_pillportal/php/deny.php?r_id=${r_id}`);
                xhr.onload = () => {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText); // Success message from deny.php
                        location.reload(); // Reload the page after the request has completed successfully
                    } else {
                        console.error(xhr.statusText); // Error message if request failed
                    }
                };
                xhr.send();
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Handle increase stock button click
            $('.increase-stock').on('click', function () {
                var stk_id = $(this).data('stk_id');
                $('#increaseForm input[name="stk_id"]').val(stk_id);

                $('#popup').data('stk_id', stk_id);

                // Show popup dialog
                $('#popup').show();



                // Set popup dialog position to center of screen
                var popup = $('#popup');
                var top = Math.max(0, ($(window).height() - popup.outerHeight()) / 2);
                var left = Math.max(0, ($(window).width() - popup.outerWidth()) /
                    2);
                popup.css({
                    'top': top + 'px',
                    'left': left + 'px'
                });
                // Set data-id attribute of confirm button to match clicked medicine ID
                var id = $(this).data('id');
                $('#confirm').data('id', id);

            });

            // Handle decrease stock button click
            $('.decrease-stock').on('click', function () {
                var stk_id = $(this).data('stk_id');
                $('#decreaseForm input[name="stk_id"]').val(stk_id);

                $('#popupd').data('stk_id', stk_id);

                // Show popup dialog
                $('#popupd').show();

                // Set popup dialog position to center of screen
                var popup = $('#popupd');
                var top = Math.max(0, ($(window).height() - popup.outerHeight()) / 2);
                var left = Math.max(0, ($(window).width() - popup.outerWidth()) / 2);
                popup.css({
                    'top': top + 'px',
                    'left': left + 'px'
                });

                // Set data-id attribute of confirm button to match clicked medicine ID
                var id = $(this).data('id');
                $('#confirm').data('id', id);

            });

            // Handle cancel button click
            $('#cancel').on('click', function () {
                // Hide popup dialog
                $('#popup').hide();

                // Reset amount input field
                $('#amount').val('');

            });

            // Handle cancel button click
            $('#canceld').on('click', function () {
                // Hide popup dialog
                $('#popupd').hide();

                // Reset amount input field
                $('#amount').val('');

            });

            // Handle confirm button click
            $('#confirm').on('click', function () {
                // Get medicine ID and quantity input
                var id = $(this).data('id');
                var quantity = $('#amount').val();

                // Validate quantity input
                if (quantity == '' || quantity == 0) {
                    alert('Please enter a valid quantity.');
                    return;
                }

                // Update medicine quantity in table and hide popup dialog
                var tdQuantity = $('tr[data-id="' + id + '"] td:nth-child(3)');
                var currentQuantity = parseInt(tdQuantity.text());
                var newQuantity = currentQuantity + parseInt(quantity);
                tdQuantity.text(newQuantity);
                $('#popup').hide();

                // Update revenue in table
                var tdRevenue = $('tr[data-id="' + id + '"] td:nth-child(6)');
                var price = parseFloat($('tr[data-id="' + id + '"] td:nth-child(5)').text().replace('$', ''));
                var newRevenue = newQuantity * price;
                tdRevenue.text('$' + newRevenue.toFixed(2));

            });
        });
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                $('#popup').hide();
            }
        });

        $('.close').on('click', function () {
            $('#popup').hide();
        });
    </script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>