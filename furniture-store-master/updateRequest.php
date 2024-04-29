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
	<title>Change Order</title>
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


			if (isset($_POST['edit'])) {
				$oid=$_POST['oid'];
				// $delivery=$_POST['delivery'];
				$status=$_POST['status'];
				$pid=$_POST['pid'];

				// $insert = $db->query("UPDATE `tab_furniture` SET `pc_name` = 'The works' WHERE `tab_furniture`.`pc_id` = '$pid'");

				$update = $db->query("UPDATE `tab_request` SET `status` = '$status' WHERE `tab_request`.`ord_no` = '$oid' AND `tab_request`.`pc_id` = '$pid';");
				$GLOBALS['search_error'] = "UPDATE `tab_request` SET `status` = '$status' WHERE `tab_request`.`ord_no` = '$oid' AND `tab_request`.`pc_id` = '$pid';";

			}
?>

			<header class="w3-display-container w3-content" style="max-width:1700px">
				<!-- <img class="" src="images/london2.jpg" alt="red" width="1700" height="800"> -->
				<div class="w3-white" style="margin: 5% auto; width:65%">

				<!-- Tabs -->
				<form action="" method="POST">
				<div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
				  <h2>Enter order number</h2>
				  <div class="w3-row-padding" style="margin:0 -16px;" id="name">
				    <div class="w3-col">
				      <label>Order No</label>				      
				    </div>
				    <div class="w3-col l2">
				      <input class="w3-input w3-border" name="oid" id="oid" type="text" placeholder="Order No" required>	
				      <p class="w3-margin-top"><input type="submit" name="search" value="Search" class="w3-button w3-ripple w3-dark-grey"></p>
				    </div>
				 </div> 
				  <span><?php echo '<i class="w3-text-red">', $GLOBALS['search_error'], '</i>'; ?></span>
				</form>
			</header>			

<?php

			if (isset($_POST['search'])) {
				$oid = $_POST['oid'];
				$result = $db->query("SELECT * FROM `tab_request` WHERE `ord_no` = '$oid'");
				$fur_results = $db->query("SELECT * FROM `tab_furniture`");
				
				if ($result->num_rows > 0) {

?>

					<div class="w3-display-container w3-content" style="max-width:1700px">
					  <!-- <img class="" src="images/london2.jpg" alt="red" width="1700" height="800"> -->
					  <div class="w3-white" style="margin: 5% auto; width:65%">
					    
					    <!-- Tabs -->
					    <form action="" method="POST">
					    <div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
					      <h3>Edit order details</h3>
					      <p>Edit the details of the order</p>
					      <div class="w3-row-padding" style="margin:0 -16px;" id="name">
				      		<div class="w3-col l2">
  					          <label>Order No</label>
  					          <input class="w3-input w3-border" name="oid" type="text" placeholder="ID" value=<?php echo '"', htmlspecialchars($oid), '"'; ?> disabled>
  					        </div>
  					        <div class="w3-col l4">
  					          <label>Item</label><br>
  					          <select class="w3-select w3-border" name="pid">
  					          <?php while ($row=$result->fetch_object()) {
  					          	echo '<option value="', $row->pc_id, '">', $db->query("SELECT `pc_name` FROM `tab_furniture` WHERE `pc_id` = '$row->pc_id'")->fetch_object()->pc_name, '</opiton>'; 
  					          } ?>
  					          </select>
  					        </div>
  					      </div>
  					      <div class="w3-row-padding" style="margin:5px -16px">
  					      	<div class="w3-col l3">
  					      		<label>Status</label>
  					      		<select class="w3-select w3-border" name="status">
  					      			<option value="" selected>--Select status--</option>
	  					      		<option value="PENDING">PENDING</option>
	  					      		<option value="IN_PROGRESS">IN PROGRESS</option>
	  					      		<option value="COMPLETED">COMPLETED</option>
	  					      	</select>	
  					      	</div>
  					      </div>
  					      <input type="hidden" name="oid" value="<?php echo htmlspecialchars($oid); ?>">
  					      
					      
					      <p class="w3-margin-top"><input type="submit" name="edit" value="Update" class="w3-button w3-ripple w3-dark-grey"></p>
					      <span><?php echo '<i class="w3-text-red">', $error, '</i>'; ?></span>
					    </div>
					    </form>
					</div>			
<?php } else {
			$GLOBALS['search_error']="Request for order '$oid' not found";
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