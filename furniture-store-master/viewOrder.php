<?php
	error_reporting(0);
	require 'db/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/fonts.css">
	<title>View Order</title>
</head>
<body>
	<?php include 'elements/navbar.php'; ?>
	


<?php
	switch ($_SESSION['login_access']) {
		case '1':
		case '2':
		case '3':
		case '4':
			// Start cases 1,2,3
			$error = '';
			$set = 0;
			// $result = $db->query("SELECT * FROM `view_complete_order`");
			if (isset($_POST['submit'])) {
				if (empty($_POST['oid']) && empty($_POST['name'])) {
					$error = 'Please enter an order ID or a customer name';
				} else {
					if (!empty($_POST['oid']) && empty($_POST['name'])) {
						$oid = $_POST['oid'];
						$result = $db->query("SELECT * FROM `view_complete_order` WHERE `order_no`='$oid'");
						$tot_result = $db->query("SELECT * FROM `view_subtotal` WHERE `order_no`='$oid'");
					} else {
						$name = $_POST['name'];
						$result = $db->query("SELECT * FROM `view_complete_order` WHERE `order_no`IN (SELECT `order_no` FROM `view_complete_order` WHERE `cust_no`IN (SELECT `cust_no` FROM `tab_customer` WHERE `first_name` LIKE '$name' OR `last_name` LIKE '$name'))");
						#$tot_result = $db->query("SELECT * FROM `view_subtotal` WHERE `order_no`IN (SELECT `order_no` FROM `view_complete_order` WHERE `cust_no`IN (SELECT `cust_no` FROM `tab_customer` WHERE `first_name` LIKE '$name' OR `last_name` LIKE '$name'))");
					}

					if ($result->num_rows <= 0) {
						$error = 'No match found';
					}		
				}
			} 
?>
			
			<header class="w3-display-container w3-content w3-hide-small" style="max-width:1700px">
			  <img class="" src="images/london2.jpg" alt="red" width="1700" height="400">
			  <div class="w3-display-middle" style="width:65%">
			    
			    <!-- Tabs -->
			    <form action="" method="POST">
			    <div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
			      <h3>Search for an order</h3>
			      <p>Enter an order ID or customer name</p>
			      <div class="w3-row-padding" style="margin:0 -16px;">
			        <div class="w3-col" style="width: 150px;">
			          <label>ID</label>
			          <input class="w3-input w3-border" name="oid" id="oid" type="text" placeholder="Enter an ID">
			        </div>
			        <div class="w3-rest">
			          <label>Name</label>
			          <input class="w3-input w3-border" name="name" id="name" type="text" placeholder="Enter a customer name">
			        </div>
			      </div>
			      <p><input type="submit" name="submit" value="Search" class="w3-button w3-ripple w3-dark-grey"></p>
			      <span><?php echo '<i class="w3-text-red">', $error, '</i>'; ?></span>
			    </div>
			    </form>
			</header>

			<div class="w3-container w3-margin" id="table">
				<table class="w3-table w3-border" style="margin: 0 auto; width: 80%">
				    <tr>
				        <th class="w3-border">Order No</th>
				        <th class="w3-border">Customer No</th>
				        <th class="w3-border">Date Placed</th>
				        <th class="w3-border">Est. Delivery Date</th>
				        <th class="w3-border">Item</th>
				        <th class="w3-border">Quantity</th>
				        <th class="w3-border">Price</th>
				        <th class="w3-border">Status</th>
				    </tr>
				    <?php while($row = $result->fetch_object()) { ?>
				    <tr>
				        <td class="w3-border"><?php echo $row->order_no, '</td>
				        <td class="w3-border">', $row->cust_no, '</td>
				        <td class="w3-border">', $row->date_placed, '</td>
				        <td class="w3-border">', $row->delivery_date, '</td>
				        <td class="w3-border">', $row->pc_name, '</td>
				        <td class="w3-border">', $row->qty, '</td>
				        <td class="w3-border">', $row->tot_price, '</td>';
				        if ($row->status == 'PENDING') {
				        	$format = 'w3-text-red';
				        } else {
				        	$format = 'w3-text-green';
				        }
				        echo '<td class="w3-border ', $format, '">', $row->status, '</td>'; ?></td>
				    </tr>
				    <?php } ?>
				    <tr class="w3-border">
				    	<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>	
					    <th class="w3-border w3-light-grey" colspan="1">Subtotal</th>
					    <?php while($tot_row = $tot_result->fetch_object()) {
					    	echo '<td class="w3-border"><b>', $tot_row->net_total, '</b></td>'; 
					    } ?>
				    </tr>
				</table>
			</div>
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