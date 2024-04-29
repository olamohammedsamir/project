<?php
	require 'db/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/fonts.css">
	<title>Edit Customer Details</title>
</head>
<body class="w3-red">
	<?php include 'elements/navbar.php'; ?>
	<br>

<?php
	switch ($_SESSION['login_access']) {
		case '1':
		case '2':
		case '3':
			// Start cases 1,2,3
			$GLOBALS['search_error'] =  "";
			$error = "";
?>

			<header class="w3-display-container w3-content" style="max-width:1700px">
				<!-- <img class="" src="images/london2.jpg" alt="red" width="1700" height="800"> -->
				<div class="w3-white" style="margin: 5% auto; width:65%">

				<!-- Tabs -->
				<form action="" method="POST">
				<div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
				  <h2>Enter customer ID</h2>
				  <div class="w3-row-padding" style="margin:0 -16px;" id="name">
				    <div class="w3-col">
				      <label>Customer ID</label>
				      
				    </div>
				    <div class="w3-col l2">
				      <input class="w3-input w3-border" name="cid" id="cid" type="text" placeholder="ID" required>	
				      <p class="w3-margin-top"><input type="submit" name="search" value="Search" class="w3-button w3-ripple w3-dark-grey"></p>
				    </div>
				 </div> 
				  <span><?php echo '<i class="w3-text-red">', $GLOBALS['search_error'], '</i>'; ?></span>
				</form>
			</header>			

<?php
			if (isset($_POST['edit'])) {
				$cid=$_POST['cid'];
				$fname=$_POST['fname'];
				$lname=$_POST['lname'];
				$contact=$_POST['contact'];
				$house=$_POST['house'];
				$street=$_POST['street'];
				$city=$_POST['city'];
				$district=$_POST['district'];
				$zip=$_POST['zip'];

				$insert = $db->query("UPDATE `tab_customer` SET `first_name` = '$fname', `last_name` = '$lname', `contact_no` = '$contact', `house_no` = '$house', `street` = '$street', `city` = '$city', `district` = '$district', `postal_code` = '$zip' WHERE `tab_customer`.`cust_no` = '$cid'");		
				$error = "Customer details for $fname $lname has been updated";

			}

			if (isset($_POST['search'])) {
				$cid = $_POST['cid'];
				$result = $db->query("SELECT * FROM `tab_customer` WHERE `cust_no` = '$cid'");
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_object()) {				
?>

					<div class="w3-display-container w3-content" style="max-width:1700px">
					  <!-- <img class="" src="images/london2.jpg" alt="red" width="1700" height="800"> -->
					  <div class="w3-white" style="margin: 5% auto; width:65%">
					    
					    <!-- Tabs -->
					    <form action="" method="POST">
					    <div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
					      <h3>Edit Customer Details</h3>
					      <p>Edit the details of the customer</p>
					      <div class="w3-row-padding" style="margin:0 -16px;" id="name">
					        <div class="w3-half">
					          <label>Full Name</label>
					          <input class="w3-input w3-border" name="fname" id="fname" type="text" placeholder="First Name" value="<?php echo htmlspecialchars($row->first_name); ?>" required>
					        </div>
					        <div class="w3-half">
					          <label>&nbsp;</label>
					          <input class="w3-input w3-border" name="lname" id="lname" type="text" placeholder="Last Name" value="<?php echo htmlspecialchars($row->last_name); ?>" required>
					        </div>
					      </div>
					      <div class="w3-row-padding" style="margin:10px -16px;" id="address">
					        <div class="w3-col l2">
					          <label>Address</label>
					          <input class="w3-input w3-border" name="house" id="house" type="text" placeholder="House" value="<?php echo htmlspecialchars($row->house_no); ?>" required>
					        </div>
					        <div class="w3-col l7">
					          <label>&nbsp;</label>
					          <input class="w3-input w3-border" name="street" id="street" type="text" placeholder="Street" value="<?php echo htmlspecialchars($row->street); ?>" required>
					        </div>
					        <div class="w3-col l3">
					          <label>&nbsp;</label>
					          <input class="w3-input w3-border" name="city" id="city" type="text" placeholder="City" value="<?php echo htmlspecialchars($row->city); ?>" required>
					        </div>
					        <div class="w3-col l3">
					          <label>&nbsp;</label>
					          <input class="w3-input w3-border" name="district" id="district" type="text" placeholder="District" value="<?php echo htmlspecialchars($row->district); ?>" required>
					        </div>
					        <div class="w3-col l2">
					          <label>&nbsp;</label>
					          <input class="w3-input w3-border" name="zip" id="zip" type="text" placeholder="Postal Code" value="<?php echo htmlspecialchars($row->postal_code); ?>" required>
					        </div>
					      </div>
					      <div class="w3-row-padding" style="margin:0 -16px;" id="contact">
					        <div class="w3-third">
					          <label>Contact Number</label>
					          <input class="w3-input w3-border" name="contact" id="contact" type="text" placeholder="Contact number" value="<?php echo htmlspecialchars($row->contact_no); ?>" required>
					        </div>
					      </div>
					      <input type="hidden" name="cid" value="<?php echo htmlspecialchars($row->cust_no); ?>">
					      <p class="w3-margin-top"><input type="submit" name="edit" value="Edit" class="w3-button w3-ripple w3-dark-grey"></p>
					      <span><?php echo '<i class="w3-text-red">', $error, '</i>'; ?></span>
					    </div>
					    </form>
					</div>			
<?php }} else {
			$GLOBALS['search_error']="Customer not found";
	} ?>
<?php 		} ?>

</body>
</html>				
			
<?php
			break;
			// End cases		
		default:
			// echo "<br><br>Access Denied";
?>
			<header class="w3-display-container w3-content" style="max-width:1700px">
				<!-- <img class="" src="images/london2.jpg" alt="red" width="1700" height="800"> -->
				<div class="w3-white" style="margin: 5% auto; width:65%">

				<!-- Tabs -->
				<form action="" method="POST">
				<div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
				  <h2>Access Denied</h2>
				  <p>Your account may not have sufficient access to view this page</p>
			</header>
<?php
			break;
	}
?>	