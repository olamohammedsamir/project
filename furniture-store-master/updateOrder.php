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
				$oid = $_POST['oid'];
				$delivery = $_POST['delivery'];
				$pid = $_POST['pid'];
				$qty = $_POST['qty'];
				$item_qty = $db->query("SELECT `stock_qty` FROM `tab_furniture` WHERE `pc_id` = '$pid'")->fetch_object()->stock_qty;

				    if ($pid != "") {
					    if (($rem = $item_qty - $qty) > 0) {
					    	$db->query("UPDATE `tab_furniture` SET `stock_qty` = '$rem' WHERE `pc_id` = '$pid'");
					    } else {
					    	$needed = 0-$rem;
					    	$pname = $db->query("SELECT `pc_name` FROM `tab_furniture` WHERE `pc_id` = '$pid'")->fetch_object()->pc_name;
					    	$db->query("UPDATE `tab_furniture` SET `stock_qty` = '$rem' WHERE `pc_id` = '$pid'");
					    	$GLOBALS['search_error'] .= "Insufficient '$pname' available. $needed, needed Place an order request.\r\n";
					    }
				    }
				$status = $_POST['status'];

				// $insert = $db->query("UPDATE `tab_furniture` SET `pc_name` = 'The works' WHERE `tab_furniture`.`pc_id` = '$pid'");

				$insert = $db->query("UPDATE `tab_order` SET `delivery_date` = '$delivery', `status` = '$status' WHERE `tab_order`.`order_no` = '$oid'");
				$insert_items = $db->query("INSERT INTO `tab_order_item` (`order_no`, `item_no`, `qty`) VALUES ('$oid', '$pid', '$qty')");
				$GLOBALS['search_error'] = "Order details for order $oid has been updated";

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
				$result = $db->query("SELECT * FROM `tab_order` WHERE `order_no` = '$oid'");
				$fur_results = $db->query("SELECT * FROM `tab_furniture`");
				
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_object()) {				
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
  					          <label>Customer ID</label>
  					          <input class="w3-input w3-border" name="cid" type="text" placeholder="ID" value=<?php echo '"', htmlspecialchars($row->cust_no), '"'; ?> disabled>
  					        </div>
  					        <div class="w3-col l3">
  					          <label>Showroom</label><br>
  					          <?php $srm_row = $db->query("SELECT * FROM `tab_showroom` WHERE `srm_id` = '$row->showroom'")->fetch_object(); ?>
  					          <input class="w3-input w3-border" type="text" name="srm" value=<?php echo '"', htmlspecialchars($srm_row->street1), ', ', htmlspecialchars($srm_row->city), '"'; ?> disabled>
  					        </div>
  					        <div class="w3-rest">
  					          <label style="margin: 0 8px">Delivery Date</label><br>
  					          <input type="date" class="w3-border" value=<?php echo '"', $row->delivery_date ,'"' ?> style="padding: 6.5px; margin: 0 8px" name="delivery">
  					        </div>
  					      </div>
  					      <div class="w3-row-padding" style="margin:5px -16px">
  					      	<div class="w3-col l3">
  					      		<label>Status</label>
  					      		<select class="w3-select w3-border" name="status">
	  					      		<option value="PENDING">PENDING</option>
	  					      		<option value="DELIVERED">DELIVERED</option>
	  					      	</select>	
  					      	</div>
  					      </div>
  					      <input type="hidden" name="oid" value="<?php echo htmlspecialchars($row->order_no); ?>">
  					      <div class="fields">
  						      <div class="w3-row-padding" style="margin:10px -16px;" id="">
  						        <div class="items w3-col l3">
  						          <label>Item</label>
  						          <?php $fur_row=$fur_results->fetch_all() ?>
  						          <select class="w3-select w3-border" name="pid" required>
  						          	<option value="0" selected>-- Select an option --</option>
  						          <?php foreach ($fur_row as $row) {
  						          ?>
  						          	<option value=<?php echo "'$row[0]'>", $row[1]; ?></option>
  						          <?php } ?>	
  						          </select>
  						        </div>
  						        <div class="w3-col l1">
  						        	<label>Quantity</label>
  						        	<input class="w3-input w3-border" type="text" name="qty" placeholder="Quantity" value="0" required>
  						        </div>
  						      </div>
					      
					      <p class="w3-margin-top"><input type="submit" name="edit" value="Update" class="w3-button w3-ripple w3-dark-grey"></p>
					      <span><?php echo '<i class="w3-text-red">', nl2br($error), '</i>'; ?></span>
					    </div>
					    </form>
					</div>			
<?php }} else {
			$GLOBALS['search_error']="Order not found";
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