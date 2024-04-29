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
		case '3':
		case '4':
			// Start cases 1,2,3
			$GLOBALS['search_error'] =  "";
			$error = "";


			if (isset($_POST['edit'])) {
				$GLOBALS['search_error'] = "boom";
				$pid=$_POST['pid'];
				$name=$_POST['name'];
				$type=$_POST['type'];
				$desc=$_POST['desc'];
				$price=$_POST['price'];
				$qty=$_POST['qty'];

				// $insert = $db->query("UPDATE `tab_furniture` SET `pc_name` = 'The works' WHERE `tab_furniture`.`pc_id` = '$pid'");

				$insert = $db->query("UPDATE `tab_furniture` SET `pc_name` = '$name', `pc_type` = '$type', `description` = '$desc', `price` = '$price', `stock_qty` = '$qty' WHERE `tab_furniture`.`pc_id` = '$pid'");
				$GLOBALS['search_error'] = "Furniture details for piece $name has been updated";

			}
?>

			<header class="w3-display-container w3-content" style="max-width:1700px">
				<!-- <img class="" src="images/london2.jpg" alt="red" width="1700" height="800"> -->
				<div class="w3-white" style="margin: 5% auto; width:65%">

				<!-- Tabs -->
				<form action="" method="POST">
				<div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
				  <h2>Enter piece ID</h2>
				  <div class="w3-row-padding" style="margin:0 -16px;" id="name">
				    <div class="w3-col">
				      <label>Piece ID</label>				      
				    </div>
				    <div class="w3-col l2">
				      <input class="w3-input w3-border" name="pid" id="cid" type="text" placeholder="ID" required>	
				      <p class="w3-margin-top"><input type="submit" name="search" value="Search" class="w3-button w3-ripple w3-dark-grey"></p>
				    </div>
				 </div> 
				  <span><?php echo '<i class="w3-text-red">', $GLOBALS['search_error'], '</i>'; ?></span>
				</form>
			</header>			

<?php

			if (isset($_POST['search'])) {
				$pid = $_POST['pid'];
				$result = $db->query("SELECT * FROM `tab_furniture` WHERE `pc_id` = '$pid'");
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_object()) {				
?>

					<div class="w3-display-container w3-content" style="max-width:1700px">
					  <!-- <img class="" src="images/london2.jpg" alt="red" width="1700" height="800"> -->
					  <div class="w3-white" style="margin: 5% auto; width:65%">
					    
					    <!-- Tabs -->
					    <form action="" method="POST">
					    <div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
					      <h3>Edit piece Details</h3>
					      <p>Edit the details of the piece of furniture</p>
					      <div class="w3-row-padding" style="margin:0 -16px;" id="name">
					      			        <div class="w3-col l6">
					      			          <label>Name</label>
					      			          <input class="w3-input w3-border" name="name" id="name" type="text" placeholder="Piece Name" value="<?php echo htmlspecialchars($row->pc_name); ?>" required>
					      			        </div>
					      			      </div>
					      			      <div class="w3-row-padding" style="margin:10px -16px;" id="">
					      			        <div class="w3-col l3">
					      			          <label>Type</label>
					      			          <input class="w3-input w3-border" name="type" id="type" type="text" placeholder="Type of furniture" value="<?php echo htmlspecialchars($row->pc_type); ?>" required>
					      			        </div>
					      			        <div class="w3-col l1">
					      			        	<label>Stock</label>
					      			        	<input class="w3-input w3-border" type="text" name="qty" placeholder="Quantity" value="<?php echo htmlspecialchars($row->stock_qty); ?>" required>
					      			        </div>
					      			        <div class="w3-col l2">
					      			        	<label>Price</label>
					      			        	<input class="w3-input w3-border w3-right" type="text" name="price" placeholder="Price" value="<?php echo htmlspecialchars($row->price); ?>" pattern="^(?=.?\d)\d{0,14}(\.?\d{0,6})?$" required title="Insert amount in ruppees">
					      			        </div>
					      			      </div>
					      			      <div class="w3-row-padding" style="margin:0 -16px;" id="contact">
					      			        <div class="w3-col">
					      			          <label>Description</label>
					      			          <textarea class="w3-input w3-border" name="desc" id="desc" placeholder="Description of the furniture piece" rows="5" cols="100" style="resize: none;" required><?php echo htmlspecialchars($row->description); ?></textarea>
					      			        </div>
					      			      </div>
					      <input type="hidden" name="pid" value="<?php echo htmlspecialchars($row->pc_id); ?>">
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