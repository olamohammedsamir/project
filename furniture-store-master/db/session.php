<?php
	require 'connect.php';
	session_start();	// Starting Session
	// Storing Session
	$user_check=$_SESSION['login_user'];
	// SQL query to fetch user information
	$ses_sql = $db->query("SELECT `usr_name` FROM `tab_user` where `usr_name`='$user_check'");
	$row = $ses_sql->fetch_object();
	$login_session = $row->usr_name;
	if(!isset($login_session)) {
		mysqli_close($db); // Closing connection
		header('Location: index.php'); // Redirecting to login page
	}
?>