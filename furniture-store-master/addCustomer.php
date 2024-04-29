<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add New Customer</title>
	<link rel="stylesheet" type="text/css" href="css/w3.css">
</head>
<body>
<?php include 'elements/navbar.php'; ?>
	<div class="w3-container" style="margin: 0 auto; width: 74%">
		<div class="w3-card-4 w3-round">
			<div class="w3-container w3-blue" style="border-top-right-radius: 5px; border-top-left-radius: 5px">
				<h1>Add New Customer :</h1>
			</div>
			<div class="w3-container w3-padding-large" style="margin: 0 auto; width: 95%" id="form">
				<form action="" method="POST" >
				<table class="w3-table">
					<tr>
						<td>
							<label style="">First Name : </label>
						</td>
						<td>
							<label style="">Last Name : </label>
						</td>
					</tr>
					<tr>
						<td><input class="w3-input" type="text" id="fname" name="fname" required></td>
						<td><input class="w3-input" type="text" id="lname" name="lname" required></td>
					</tr>
					<tr><td><label>Contact Number : </label></td></tr>	
					<tr><td><input class="w3-input" type="text" id="tel_no" name="tel_no" required></td></tr>
					<tr>
						<td><label>House No : </label></td>
						<td><label>Street : </label></td>
					</tr>
					<tr>
						<td><input class="w3-input" type="text" id="house" name="house" required></td>
						<td><input class="w3-input" type="text" id="street" name="street" required></td>
					</tr>
					<tr>
						<td><label>City : </label></td>
						<td><label>District : </label></td>
					</tr>
					<tr>
						<td><input class="w3-input" type="text" id="city" name="city" required></td>
						<td><input class="w3-input" type="text" id="district" name="district" required></td>
					</tr>
					<tr>
						<td><label>Postal Code : </label></td>
					</tr>
					<tr>
						<td><input class="w3-input" type="text" id="zip" name="zip" required></td>
					</tr>
				</table>
				&nbsp;
				<div class="w3-container w3-padding-large w3-center">
						<input class="w3-btn w3-ripple w3-black" type="submit" name="submit">								
						<input class="w3-btn w3-ripple w3-red" type="reset" name="reset">
					</div>
				</form>
			</div>
		</div>		
	</div>
</body>
</html>

<?php

	if (isset($_POST['submit'])) {

		// Connect to the database

		require 'db/connect.php';

		// Generate unique key value

		// Get values from form and assign them to variables

		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$tel_no = $_POST['tel_no'];
		$house = $_POST['house'];
		$street = $_POST['street'];
		$city = $_POST['city'];
		$district = $_POST['district'];
		$zip = $_POST['zip'];

		// Assigning value for PK field

		$db->query("INSERT INTO `customers` (`cust_no`, `first_name`, `last_name`, `contact_no`, `house_no`, `street`, `city`, `district`, `postal_code`) VALUES (NULL, '$fname', '$lname', '$tel_no', '$house', '$street', '$city', '$district', '$zip')");
	}

?>