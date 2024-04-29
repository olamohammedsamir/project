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
			$result = $db->query("SELECT * FROM `tab_request`");
			// $result = $db->query("SELECT * FROM `view_complete_order`");
			if (isset($_POST['submit'])) {
				if (!empty($_POST['oid'])) {
				
					$oid = $_POST['oid'];
					$result = $db->query("SELECT * FROM `tab_request` WHERE `ord_no`='$oid'");
					
					if ($result->num_rows <= 0) {
						$error = 'No match found';
					}		
				} else {
					$error = 'Please enter an order ID or a customer name';
				}
			} 
?>
			
			<header class="w3-display-container w3-content w3-hide-small" style="max-width:1700px">
			  <img class="" src="images/london2.jpg" alt="red" width="1700" height="400">
			  <div class="w3-display-middle" style="width:65%">
			    
			    <!-- Tabs -->
			    <form action="" method="POST">
			    <div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
			      <h3>Search for an item request</h3>
			      <p>Enter an order ID</p>
			      <div class="w3-row-padding" style="margin:0 -16px;">
			        <div class="w3-col" style="width: 150px;">
			          <label>ID</label>
			          <input class="w3-input w3-border" name="oid" id="oid" type="text" placeholder="Enter an ID">
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
				        <th class="w3-border">Item ID</th>
				        <th class="w3-border">Quantity</th>
				        <th class="w3-border">Status</th>
				    </tr>
				    <?php while($row = $result->fetch_object()) { ?>
				    <tr>
				        <td class="w3-border"><?php echo $row->ord_no, '</td>
				        <td class="w3-border">', $row->pc_id, '</td>
				        <td class="w3-border">', $row->qty, '</td>';
				        if ($row->status == 'PENDING') {
				        	$format = 'w3-text-red';
				        } elseif ($row->status == 'IN_PROGRESS') {
				        	$format = 'w3-text-orange';
				        } else {
				        	$format = 'w3-text-green';
				        }
				        echo '<td class="w3-border ', $format, '">', $row->status, '</td>'; ?></td>
				    </tr>
				    <?php } ?>
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