<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['status'] != 'worker') {
    header('Location: index.html');
}
require_once('php/connection.php');
require_once('php/viewrequests.php');
require_once('php/message.php');
?>
<html>

<head>
    <title>Pharmacy worker</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/worker.css">
</head>

<style>

</style>

<body>

    <div class="container">
        <h1>Worker Department Manager</h1>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#orders">Orders</a></li>
            <li><a data-toggle="tab" href="#messaging">Messages</a></li>
            <li class="pull-right"><a href="php/logout.php" class="btn btn-danger">Logout</a></li>
        </ul>
        <div class="tab-content">
            <div id="orders" class="tab-pane fade in active">
                <h2>View Orders</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Clients</th>
                            <th>Medicine</th>
                            <th>Quantity</th>
                            <th>Prescription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Call the function to get the requests from the database
                        $requests = viewRequests($link);
                        if ($requests != -1) {
                            foreach ($requests as $request) {
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
                                    <td class="prescription-image">
                                        <button type="button" class="btn btn-link prescription-btn" data-toggle="modal"
                                            data-target="#prescriptionModal<?php echo $request['r_id']; ?>"
                                            data-image-url="data:image/jpeg;base64,<?php echo base64_encode($request['prescription']); ?>">
                                            View Prescription
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success increase-stock"
                                            data-id="<?php echo $request['r_id']; ?>">Accept</button>
                                        <button type="button" class="btn btn-danger decrease-stock"
                                            data-id="<?php echo $request['r_id']; ?>">Deny</button>
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
                            echo "No requests found.";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Modal -->
                <!-- <div id="prescriptionModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content--
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img id="modal-image" src="" class="img-responsive center-block" style="max-width: 50%;">
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div id="messaging" class="tab-pane fade in ">
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
                    //include('php/message.php');
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

        </div>
    </div>

    <script>
        function deleteMessage(m_id) {
            if (confirm('Are you sure you want to delete this message?')) {
                window.location.href = 'http://localhost/pharmacy_pillportal/php/message.php?m_id=' + m_id;

            }
        }
    </script>

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


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
    <script>
        // Select all "Accept" buttons and add a click event listener to each one
        const acceptButtons = document.querySelectorAll('.increase-stock');
        acceptButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const r_id = button.dataset.id;
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `http://localhost/pharmacy_pillportal/php/accept.php?r_id=${r_id}`);
                xhr.onload = () => {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText); // Success message from accept.php
                        location.reload(); // Reload the page after the request has completed successfully
                    } else {
                        console.error(xhr.statusText); // Error message if request failed
                    }
                };
                xhr.send();
            });
        });
    </script>

</body>



</html>