<?php
	require 'db/session.php';
	error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/fonts.css">
	<title>Place an order</title>
</head>
<body class="w3-red">
	<?php include 'elements/navbar.php'; ?>
	


<?php
	switch ($_SESSION['login_access']) {
		case '1':
		case '2':
		case '3':
			// Start cases 1,2,3
			$error = "";
			$fur_results = $db->query("SELECT * FROM `tab_furniture`");
			$srm_results = $db->query("SELECT * FROM `tab_showroom`");
			if (isset($_POST['submit'])) {
				$cid=$_POST['cid'];
				$placed=date("Y/m/d");
				$delivery=$_POST['delivery'];
				$srm=$_POST['srm'];

				$insert = $db->query("INSERT INTO `tab_order` (`order_no`, `cust_no`, `date_placed`, `delivery_date`, `showroom`, `status`) VALUES (NULL, '$cid', '$placed', '$delivery', '$srm', 'PENDING')");		
				$error = "Order placed.";

				$order = $db->query("SELECT MAX(`order_no`) AS `order_no` FROM `tab_order`")->fetch_object()->order_no;

				for ($i = 1; $i <= 3; $i++) {
				    $pid = $_POST['item' . $i . 'pid'];
				    $qty = $_POST['item' . $i . 'qty'];

				    $item_qty = $db->query("SELECT `stock_qty` FROM `tab_furniture` WHERE `pc_id` = '$pid'")->fetch_object()->stock_qty;

				    if ($pid != "") {
					    if (($rem = $item_qty - $qty) > 0) {
					    	$db->query("UPDATE `tab_furniture` SET `stock_qty` = '$rem' WHERE `pc_id` = '$pid'");
					    } else {
					    	$needed = 0-$rem;
					    	$pname = $db->query("SELECT `pc_name` FROM `tab_furniture` WHERE `pc_id` = '$pid'")->fetch_object()->pc_name;
					    	$db->query("UPDATE `tab_furniture` SET `stock_qty` = '$rem' WHERE `pc_id` = '$pid'");
					    	$error .= "\r\nInsufficient '$pname' available. $needed, needed Place an order request.";
					    }
				    }

				    $insert_items=$db->query("INSERT INTO `tab_order_item` (`order_no`, `item_no`, `qty`) VALUES ('$order', '$pid', '$qty')");
				}
			}
			 
?>
			
			<header class="w3-display-container w3-content w3-hide-small" style="max-width:1700px">
			  <!-- <img class="" src="images/london2.jpg" alt="red" width="1700" height="800"> -->
			  <div class="w3-white" style="margin: 5% auto; width:65%">
			    
			    <!-- Tabs -->
			    <form action="" method="POST">
			    <div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
			      <h2>Place an order</h2>
			      <p>Order details</p>
			      <div class="w3-row-padding" style="margin:0 -16px;" id="name">
			        <div class="w3-col l2">
			          <label>Customer ID</label>
			          <input class="w3-input w3-border" name="cid" type="text" placeholder="ID" required>
			        </div>
			        <div class="w3-col l3">
			          <label>Showroom</label><br>
			          <select class="w3-select w3-border" name="srm" required>
			          	<option value="" selected>-- Select an option --</option>
			          <?php while ($srm_row=$srm_results->fetch_object()) {
			          ?>
			          	<option value=<?php echo "'$srm_row->srm_id' >", $srm_row->street1, ', ', $srm_row->city ?></option>
			          <?php } ?>	
			          </select>
			        </div>
			        <div class="w3-rest">
			          <label style="margin: 0 8px">Delivery Date</label><br>
			          <input type="date" class="w3-border" style="padding: 6.5px; margin: 0 8px" name="delivery">
			        </div>
			      </div>
			      <div class="fields">
				      <div class="w3-row-padding" style="margin:10px -16px;" id="">
				        <div class="items w3-col l3">
				          <label>Item 1</label>
				          <?php $fur_row=$fur_results->fetch_all() ?>
				          <select class="w3-select w3-border" name="item1pid" required>
				          	<option value="" selected>-- Select an option --</option>
				          <?php foreach ($fur_row as $row) {
				          ?>
				          	<option value=<?php echo "'$row[0]'>", $row[1]; ?></option>
				          <?php } ?>	
				          </select>
				        </div>
				        <div class="w3-col l1">
				        	<label>Quantity</label>
				        	<input class="w3-input w3-border" type="text" name="item1qty" placeholder="Quantity" value="0" required>
				        </div>
				      </div>
				      <div class="w3-row-padding" style="margin:10px -16px;" id="">
				        <div class="items w3-col l3">
				          <label>Item 2</label>
				          <select class="w3-select w3-border" name="item2pid">
				          	<option value="" selected>-- Select an option --</option>
				          <?php foreach ($fur_row as $row) {
				          ?>
				          	<option value=<?php echo "'$row[0]'>", $row[1]; ?></option>
				          <?php } ?>	
				          </select>
				        </div>
				        <div class="w3-col l1">
				        	<label>Quantity</label>
				        	<input class="w3-input w3-border" type="text" name="item2qty" placeholder="Quantity" value="0" >
				        </div>
				      </div>
				      <div class="w3-row-padding" style="margin:10px -16px;" id="">
				        <div class="items w3-col l3">
				          <label>Item 3</label>
				          <select class="w3-select w3-border" name="item3pid">
				          	<option value="" selected>-- Select an option --</option>
				          <?php foreach ($fur_row as $row) {
				          ?>
				          	<option value=<?php echo "'$row[0]'>", $row[1]; ?></option>
				          <?php } ?>>	
				          </select>
				        </div>
				        <div class="w3-col l1">
				        	<label>Quantity</label>
				        	<input class="w3-input w3-border" type="text" name="item3qty" placeholder="Quantity" value="0">
				        </div>
				      </div>
				  </div>
			      <p class="w3-margin-top"><input type="submit" name="submit" value="Add" class="w3-button w3-ripple w3-dark-grey"></p>
			      <span><?php echo '<i class="w3-text-red">', nl2br($error), '</i>'; ?></span>
			    </div>
			    </form>
			</header>

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