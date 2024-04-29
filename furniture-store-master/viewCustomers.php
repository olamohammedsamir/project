<?php
	require 'db/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title></title>
</head>
<body>
<?php include 'elements/navbar.php';?>
<?php switch ($_SESSION['login_access']) {
		case '1':
		case '2':
		case '3':
			$error = '';
?>

<!-- Code goes here... -->
	<header class="w3-container w3-red" style="padding:30px 16px 1px 16px" id="header">
			<h1 class="w3-margin w3-jumbo">View Customers</h1>
	</header>
	<div class="w3-container w3-margin" id="main">
		<div class="w3-container w3-margin" id="form">
			<form method="POST">
				<table class="w3-table w3-border" style="width: 50%">
					<tr>
						<td style="width: 20%; vertical-align: middle;"><label>Customer ID</label></td>
						<td><input class="w3-input" style="width: 80px" type="text" name="id" id="id"></td>
						<td class="w3-center" style="width: 30%; vertical-align: middle;" rowspan="2">
							<div class="w3-center"><input class="w3-btn w3-round w3-red w3-ripple" name="submit" type="submit" value="Search" style="margin-bottom: 5%"></div>
						</td>
					</tr>
					<tr>
						<td style="width: 15%; vertical-align: middle;"><label>Customer Name</label></td>
						<td><input class="w3-input" type="text" name="name" id="name"></td>
				</table>
				<span style="color: red;"><i><?php echo '<center>', $error, '</center>'; ?></i></span>
			</form>
		</div>

		<div class="w3-container w3-center" id="results">
		<?php
			if (isset($_POST['submit'])) {
				if (empty($_POST['id']) && empty($_POST['name'])) {
					$error = 'Enter either a customer name or id';
				} elseif (empty($_POST['name'])){
					$id = $_POST['id'];
					$result = $db->query("SELECT * FROM `tab_customer` WHERE `cust_no` = '$id'");
					$row = $result->fetch_object();
				
		?>
				<table class="w3-table w3-border">
					<tr>
						<th>Name</th>
					</tr>
					<tr>
						<td><?php echo $row->first_name, ' ', $row->last_name; ?></td>
					</tr>
				</table>
		</div>
	</div>

		<?php
				} else {
					$name = $_POST['name'];
					$result = $db->query("SELECT * FROM `tab_customer` WHERE `first_name` LIKE '$name' OR `last_name` LIKE '$name' ");
					

		?>
				<table class="w3-table w3-border">
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Address</th>
						<th>Contact</th>
					</tr>
					<?php while ($row = $result->fetch_object()) { ?>
					<tr>
						<td><?php echo $row->cust_no; ?></td>
						<td><?php echo $row->first_name, ' ', $row->last_name; ?></td>
						<td><?php echo $row->house_no, ', ', $row->street1, ', ', $row->street2, ', ', $row->city, ', ', $row->district, ', ', $row->postal_code ;?>
						<td><?php echo $row->contact_no; ?></td>
					</tr>
					<?php } ?>
				</table>
			<?php
			}
 			break;
	}	
		case '4':
		case '5':
		case '6':
			echo '<br><br>
				<div class="w3-container" style="margin: 0 auto; width=90%" id="main">
					<div class="w3-card w3-round w3-margin" style="width: 60%; padding: 16px 16px 40px 30px;">
						<h1>Access Denied</h1>
						<div style="padding-bottom= 30%;">Your access level is insufficient to view this page</div>
					</div>
				</div>';
			break;
	
	
} ?>
</body>
</html>