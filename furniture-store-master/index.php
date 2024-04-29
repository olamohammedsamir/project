<?php
	include('login.php'); // Includes Login Script
	// echo 'Connected';

	if(isset($_SESSION['login_user'])){
		header("location: home.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Welcome!</title>
		<link href="css/w3.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/fonts.css">
	</head>
	<body class="w3-light-grey">
	<div class="w3-container" style="padding-top:10%; margin: 0 auto; width: 30%;" id="main">
	<div class="w3-card-4 w3-round-large w3-white">
		<div class="w3-container w3-red w3-center" style="margin:0 auto; border-top-right-radius: 8px; border-top-left-radius: 8px" id="title">
			<h1>Welcome</h1>
		</div>
			<div class="w3-container w3-center" id="sub-header">
				<h2 style="padding-bottom: 2%">Please login to proceed</h2>
			</div>
			<form action="" method="post">
			<div class="w3-container" style="padding: 2%" id="form">
				<div><label class="w3-padding">Username :</label></div>
				<input class="w3-input" id="name" name="username" placeholder="" type="text" style="margin: 0 auto; margin-bottom: 5%; width: 90%" required>

				<div><label class="w3-padding">Password :</label></div>
				<input class="w3-input" id="password" name="password" placeholder="" type="password" style="margin: 0 auto; margin-bottom: 5%; width: 90%" required=>

				<div class="w3-center"><input class="w3-btn w3-round w3-red w3-ripple" name="submit" type="submit" value="Login" style="margin-bottom: 5%"></div>
				<span style="color: red;"><i><?php echo '<center>', $error, '</center>'; ?></i></span>
			</div>
			</form>
	</div>
	</body>
</html>