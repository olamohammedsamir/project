<?php
	require 'db/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/fonts.css">
	<title>View Customers</title>
</head>
<body>
	<?php include 'elements/navbar.php'; ?>
	


<?php
	switch ($_SESSION['login_access']) {
		case '1':
		case '2':
		case '3':
			// Start cases 1,2,3
			$error = '';
			$result = $db->query("SELECT * FROM `tab_customer`");
			if (isset($_POST['submit'])) {
				if (empty($_POST['cid']) && empty($_POST['name'])) {
					$error = 'Please enter an customer ID or a name';
				} else {
					if (!empty($_POST['cid'])) {
						$cid = $_POST['cid'];
						$result = $db->query("SELECT * FROM `tab_customer` WHERE `cust_no` = '$cid'");
					} else {
						$name = $_POST['name'];
						$result = $db->query("SELECT * FROM `tab_customer` WHERE `first_name` LIKE '$name' OR `last_name` LIKE '$name'");				
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
			      <h3>Search for a customer</h3>
			      <p>Enter a customers ID or name</p>
			      <div class="w3-row-padding" style="margin:0 -16px;">
			        <div class="w3-col" style="width: 150px;">
			          <label>ID</label>
			          <input class="w3-input w3-border" name="cid" id="cid" type="text" placeholder="Enter an ID">
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
				<table class="w3-table w3-border" style=" margin: 0 auto; width: 80%">
				    <tr>
				        <th class="w3-border">ID</th><th class="w3-border">Name</th><th class="w3-border">Address</th><th class="w3-border">Contact No</th>
				    </tr>
				    <?php while($row = $result->fetch_object()) { ?>
				    <tr>
				        <td class="w3-border"><?php echo $row->cust_no, '</td>
				        <td class="w3-border">', $row->first_name, ', ', $row->last_name, '</td>
				        <td class="w3-border">', $row->house_no, ', ', $row->street, ', ', $row->city, ', ', $row->district, ', ', $row->postal_code,'</td>
				        <td class="w3-border">', $row->contact_no; ?></td>
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
				<div id="search" class="w3-container w3-red w3-padding-16 myLink" style="display: block;">
				  <h2>Access Denied</h2>
				  <p>Your account may not have sufficient access to view this page</p>
			</header>
<?php
			break;
	}
?>	