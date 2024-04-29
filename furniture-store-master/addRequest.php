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
	<title>Place an item request</title>
</head>
<body class="w3-red">
	<?php include 'elements/navbar.php'; ?>
	


<?php
	switch ($_SESSION['login_access']) {
		case '1':
		case '2':
		case '3':
			// Start cases 1,2,3,4
			$error = "";
			$fur_results = $db->query("SELECT * FROM `tab_furniture`");
			// $order_results = $db->query("SELECT * FROM `tab_order`");
			if (isset($_POST['submit'])) {
				$oid=$_POST['oid'];
				$status='PENDING';

				# $error = "Item request created";

				for ($i = 1; $i <= 3; $i++) {
					// if ($pid = $_POST['item' . $i . 'pid'] != 0) {
						$pid = $_POST['item' . $i . 'pid'];
						$qty = $_POST['item' . $i . 'qty'];

					    $insert = $db->query("INSERT INTO `tab_request` (`ord_no`, `pc_id`, `qty`, `status`) VALUES ('$oid', '$pid', '$qty', 'PENDING')");
					    $error .= "\nINSERT INTO `tab_request` (`ord_no`, `pc_id`, `qty`, `status`) VALUES ('$oid', '$pid', '$qty', 'PENDING')";		
					// }
				}
			}
			 
?>
			
			<header class="w3-display-container w3-content w3-hide-small" style="max-width:1700px">
			  <!-- <img class="" src="images/london2.jpg" alt="red" width="1700" height="800"> -->
			  <div class="w3-white" style="margin: 5% auto; width:65%">
			    
			    <!-- Tabs -->
			    <form action="" method="POST">
			    <div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
			      <h2>Place an item request</h2>
			      <p>Request details</p>
			      <div class="w3-row-padding" style="margin:0 -16px;" id="name">
			        <div class="w3-col l2">
			          <label>Order No</label>
			          <input class="w3-input w3-border" name="oid" type="text" placeholder="Order No" required>
			        </div>
			      </div>
					<div class="fields">
					  <div class="w3-row-padding" style="margin:10px -16px;" id="">
					    <div class="items w3-col l3">
					      <label>Item 1</label>
					      <?php $fur_row=$fur_results->fetch_all() ?>
					      <select class="w3-select w3-border" name="item1pid" required>
					      	<option value="0" selected>-- Select an option --</option>
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
					      	<option value="0" selected>-- Select an option --</option>
					      <?php foreach ($fur_row as $row) {
					      ?>
					      	<option value=<?php echo "'$row[0]'>", $row[1]; ?></option>
					      <?php } ?>	
					      </select>
					    </div>
					    <div class="w3-col l1">
					    	<label>Quantity</label>
					    	<input class="w3-input w3-border" type="text" name="item2qty" placeholder="Quantity" value="0">
					    </div>
					  </div>
					  <div class="w3-row-padding" style="margin:10px -16px;" id="">
					    <div class="items w3-col l3">
					      <label>Item 3</label>
					      <select class="w3-select w3-border" name="item3pid">
					      	<option value="0" selected>-- Select an option --</option>
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
			      <span><?php echo '<i class="w3-text-red">', $error, '</i>'; ?></span>
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