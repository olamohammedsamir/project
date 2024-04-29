<?php
	session_start(); // Starting Session
	$error=''; // Variable To Store Error Message
	if (isset($_POST['submit'])) {
		if (empty($_POST['username']) || empty($_POST['password'])) {
			$error = "Please enter a username and password";
		} else {
		// Define $username and $password
		$username = $_POST['username'];
		$password = $_POST['password'];
		// Calls the 'connect.php' to connect to the database and select the database
		require 'db/connect.php'; 
		// To protect MySQL injection for Security purpose
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysqli_real_escape_string($db, $username);
		$password = mysqli_real_escape_string($db, $password);
		
		// SQL query to fetch information of registerd users and finds user match.
		$result = $db->query("SELECT * FROM `tab_user` WHERE `usr_pwd`='$password' AND `usr_name`='$username'");
		if ($result->num_rows == 1) {
			$_SESSION['login_user'] = $username; // Initializing Session
			while($row = $result->fetch_object()) {
				$access_lvl = $row->access_lvl;
			}
			$_SESSION['login_access'] = $access_lvl;
			header("location: home.php"); // Redirecting To Other Page
		} else {
			$error = "Username or password is invalid";
		}
		mysqli_close($db); // Closing Connection
		}
	}
?>