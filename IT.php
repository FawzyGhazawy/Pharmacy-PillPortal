<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['status'] != 'IT') {
    header('Location: index.html');
}
?>
<!DOCstatus html>
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

    <link rel="stylesheet" href="css/IT.css">
</head>

<body>
    <div class="container">
        <h1>IT Department Manager</h1>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#messaging">Messaging</a></li>
            <li><a data-toggle="tab" href="#hire">Hire Worker</a></li>
            <li><a data-toggle="tab" href="#fire">Fire Worker</a></li>
            <li class="pull-right"><a href="php/logout.php" class="btn btn-danger">Logout</a></li>
        </ul>
        <div class="tab-content">
            <div id="messaging" class="tab-pane fade in active">
                <h2>Contact</h2>
                <form id="contact-form" method="POST" action="php/message.php">
                    <div class="form-grouyp">
                        <label for="username">Username</label>
                        <input status="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button status="submit" class="btn btn-primary">Send</button>
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
                                    <span class="message-username"><?php echo $name; ?></span>
                                    <span class="message-timestamp"><?php echo $timestamp; ?></span>
                                    <button class="delete-btn btn btn-danger" onclick="deleteMessage('<?php echo $m_id; ?>')">Delete</button>
                                </div>
                                <div class="message-body">
                                    <p><?php echo $content; ?></p>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>


                    <!-- Add more messages here -->

                </div>
            </div>
            <div id="hire" class="tab-pane fade">
                <h2>Hire a Worker</h2>
                <form action="php/addWorker.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input status="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input status="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input status="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        <input status="date" class="form-control" id="dob" name="dob" required type="date">
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary:</label>
                        <input status="number" class="form-control" id="salary" name="salary" required>
                    </div>
                    <button status="submit" class="btn btn-primary">Hire</button>
                </form>

            </div>

            <div id="fire" class="tab-pane fade">
                <h2>Fire a Worker</h2>
                <div class="row">
                    <div class="col-md-12">
                        <form action="/path-to-your-search-script" method="GET" class="form-search">
                            <div class="input-group stylish-input-group">
                                <input status="text" class="form-control" id="search" name="search" placeholder="Enter worker's username" required>
                                <span class="input-group-addon">
                                    <button status="submit">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Worker ID</th>
                            <th>Name</th>
                            <th>Birthdate</th>
                            <th>Type</th>
                            <th>Phone</th>
                            <th>Salary</th>
                            <th>Date Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        require_once 'php/connection.php';
                        $query = 0;
                        $selected_worker = -1;
                        if (isset($_GET['worker']) && $_GET['worker'] != -1) {
                            $selected_worker = $_GET['worker'];

                            $query = "SELECT * FROM workers NATURAL JOIN users WHERE ( name LIKE '$selected_worker%' OR w_id LIKE'$selected_worker%') AND status != 'CEO' ORDER BY w_id ASC";
                        } else {
                            $query = "SELECT * FROM workers NATURAL JOIN users ORDER BY w_id ASC";
                        }

                        // $perPage = 10; // Change this to how many items you would like per page

                //         if (isset($_GET['page']) && !empty($_GET['page'])) {
                //             $page = $_GET['page'];
                //         } else {
                //           $page = 1;
                //         }

                        // $start = ($page - 1) * $perPage;

                        $result = mysqli_query($link, $query);
                        if (($result) && (mysqli_num_rows($result) > 0)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $rmid = $row["u_id"];
                                $salary = number_format($row["salary"], 2);
                                echo "<tr>   
                    <td>#" . $row["w_id"] . "</td>
                    <td>" . $row["username"] . "</td>
                    <td>" . $row["dateOfBirth"] . "</td>
                    <td>" . $row["status"] . "</td>
                    <td>" . $row["phone"] . "</td>
                    <td>" . $salary . "$</td>
                    <td>" . $row["timestamp"] . "</td>";

                                if ($row["status"] == 'pharmacist' || $row["w_id"] == $_SESSION['w_id']) {
                                    echo "<td></td>";
                                } else {
                                    echo "<td><button status=\"submit\" class=\"btn btn-danger\" onclick=\"fireWorker('" . $rmid . "')\">Fire</button></td>";
                                }

                                echo "</tr>";
                            }
                        } else {
                            echo "error";
                        }

                        // Count total records
                        $countQuery = "SELECT COUNT(*) as totalCount FROM workers NATURAL JOIN users";
                        if ($selected_worker != -1) {
                            $countQuery .= " WHERE ( name LIKE '$selected_worker%' OR w_id LIKE'$selected_worker%' ) AND status != 'CEO'";
                        }
                        // $countResult = mysqli_query($link, $countQuery);
                        // $totalCount = mysqli_fetch_assoc($countResult)['totalCount'];
                        // $totalPages = ceil($totalCount / $perPage);
                        ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <script>
   function fireWorker(rmid) {
    if (confirm("Are you sure you want to fire this worker?")) {
        window.location.href = 'http://localhost/pharmacy_pillportal/php/fireworker.php?rmid=' + rmid;
    } else {
        alert("Action canceled.");
    }
}


  </script>
</body>