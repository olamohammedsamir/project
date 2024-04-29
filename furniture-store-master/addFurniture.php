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
	<title>Add Customer</title>
</head>
<body class="w3-red">
	<?php include 'elements/navbar.php'; ?>
	


<?php
	switch ($_SESSION['login_access']) {
		case '1':
		case '3':
		case '4':
			// Start cases 1,2,3
			$error = "";
			if (isset($_POST['submit'])) {
				$id=$_POST['pc_id'];
				$name=$_POST['name'];
				$type=$_POST['type'];
				$desc=$_POST['desc'];
				$price=$_POST['price'];
				$qty=$_POST['qty'];
				// $filetype=$_FILES["file"]["type"];
                // $filename=$_FILES["file"]["name"];
				// $filepos = $_FILES["file"]["tmp_name"];
				// move_uploaded_file($filepos, "files/" . $name);
				// $file = "files/" . $name;
				if(isset($_POST['upload'])){
				$filetype=$_FILES["file"]["type"];
				$filename=$_FILES["file"]["name"];
				$filepos=$_FILES["file"]["tmp_name"];
				move_uploaded_file($filepos,"images/".$filename);
				}
				$file="images/".$filename;
				
				$insert = $db->query("INSERT INTO `tab_furniture` (`pc_id`, `pc_name`, `pc_type`, `description`, `price`, `stock_qty`,`position`) VALUES ('$id', '$name', '$type', '$desc', '$price', '$qty','$file')");		
				$error = "$name added";
			}
			 
?>
			
			<header class="w3-display-container w3-content w3-hide-small" style="max-width:1700px">
			  <!-- <img class="" src="images/london2.jpg" alt="red" width="1700" height="800"> -->
			  <div class="w3-white" style="margin: 5% auto; width:65%">
			    
			    <!-- Tabs -->
			    <form action="" method="POST">
			    <div id="search" class="w3-container w3-white w3-padding-16 myLink" style="display: block;">
			      <h2>Add a new furniture piece</h2>
			      <p>Fill the details about the piece</p>
			      <div class="w3-row-padding" style="margin:0 -16px;" id="name">
			        <div class="w3-col l6">
			          <label>Name</label>
			          <input class="w3-input w3-border" name="name" id="name" type="text" placeholder="Piece Name" required>
			        </div>
			      </div>
			      <div class="w3-row-padding" style="margin:10px -16px;" id="">
			        <div class="w3-col l3">
			          <label>Type</label>
			          <input class="w3-input w3-border" name="type" id="type" type="text" placeholder="Type of furniture" required>
			        </div>
			        <div class="w3-col l1">
			        	<label>Stock</label>
			        	<input class="w3-input w3-border" type="text" name="qty" placeholder="Quantity" value="0" required>
			        </div>
					<div class="w3-col l3">
			        	<label>Image</label>
			        	<input class="w3-input w3-border" type="file" name="file" placeholder="image"  required >
						<button name="upload" hidden></button>
			        </div>
			        <div class="w3-col l2">
			        	<label>Price</label>
			        	<input class="w3-input w3-border w3-right" type="text" name="price" placeholder="Price" pattern="^(?=.?\d)\d{0,14}(\.?\d{0,6})?$" required title="Insert amount in ruppees">
			        </div>
			      </div>
			      <div class="w3-row-padding" style="margin:0 -16px;" id="contact">
			        <div class="w3-col">
			          <label>Description</label>
			          <textarea class="w3-input w3-border" name="desc" id="desc" placeholder="Description of the furniture piece" rows="5" cols="100" style="resize: none;" required></textarea>
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