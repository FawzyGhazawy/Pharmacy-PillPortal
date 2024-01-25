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
		$username = mysqli_real_escape_string($link, $username); //strip username from escape charcters

		$query = "SELECT * FROM users WHERE username = '$username';"; //get its info

		$result = mysqli_query($link, $query); // this returns the id that mysql used for the tuple

		if ($result && mysqli_num_rows($result) == 1) {
			$u_info = mysqli_fetch_assoc($result);

			if ($u_info['password'] == md5($_POST['password'])) {
				session_start();
				$_SESSION['loggedin'] = true;
				$_SESSION['username'] = $u_info['username'];
				$_SESSION['u_id'] = $u_info['u_id'];
				$u_id = $_SESSION['u_id'];
				$_SESSION['status'] = $u_info['status'];

				if ($_SESSION['status'] == 'client') {
					$query = "SELECT * FROM clients WHERE u_id = '$u_id'";
					$result = mysqli_query($link, $query);

					if ($result && mysqli_num_rows($result) == 1) {
						$u_info = mysqli_fetch_assoc($result);
						$_SESSION['c_id'] = $u_info['c_id'];
						$_SESSION['c_name'] = $u_info['c_name'];
						$_SESSION['c_address'] = $u_info['c_address'];
						$_SESSION['c_phone'] = $u_info['c_phone'];
						$_SESSION['c_timestamp'] = $u_info['c_timestamp'];
						header('Location: ../client.php');
						exit;
					}
				} else {
					$query = "SELECT * FROM workers WHERE u_id = '$u_id'";
					$result = mysqli_query($link, $query);

					if ($result && mysqli_num_rows($result) == 1) {
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
							exit;
						} else if ($_SESSION['status'] == 'worker') {
							header('Location: ../worker.php');
							exit;
						} else if ($_SESSION['status'] == 'IT') {
							header('Location: ../IT.php');
							exit;
						} else {
							echo "Invalid user status.";
						}
					}
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
				">Invalid email or password.</p>
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
			">Please sign up first!</p>
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

		mysqli_close($link);
	} else {
		header('Location: ../index.html');
		exit;
	}
	?>
</body>

</html>