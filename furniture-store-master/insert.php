<?php
	require 'db/connect.php';

	// Get values from form and assign them to variables

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$tel_no = $_POST['tel_no'];
	$house = $_POST['house'];
	$street1 = $_POST['street1'];
	
	// Handles when an address has no "Street 2" line

	if ($street2 = $_POST['street2'] == "") {
		$street2 = NULL;
	} else {
		$stree2 = $_POST['street2'];
	}

	$district = $_POST['district'];
	$zip = $_POST['zip'];

	// Assigning value for PK field
	
	// SQL Query w/ INSERT statement

	$db->query("INSERT INTO `customers` (`cust_no`, `first_name`, `last_name`, `contact_no`, `house_no`, `street1`, `street2`, `city`, `district`, `postal_code`) VALUES ('$cust_no', '$fname', '$lname', '$tel_no', '$house', '$street1', '$street2', '$city', '$district', '$zip')");
?>