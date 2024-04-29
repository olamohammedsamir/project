<?php
    error_reporting(0);
    require 'db/session.php';  // Connecting to the db


    if(!isset($_SESSION['login_user'])) { //if login in session is not set
        header("location: index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/w3.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/fonts.css">
    </head>
    <?php include('elements/navbar.php'); ?>

    <body class="w3-red">
        <header class="w3-container w3-white w3-text-red w3-center" style="padding:128px 16px">
            <h1 class="w3-margin w3-jumbo">Moratuwa Furniture</h1>
            <p class="w3-xlarge"></p>
            <a class="w3-button w3-black w3-padding-large w3-large w3-margin-top" href="addOrder.php">Place Order</a>
        </header>   

        <div class="container" style="margin: 0 auto; width: 89%;" id="main">
        <?php echo '<p class="w3-center">You\'re logged in as <i>', $_SESSION['login_user'], '</i>'; ?>
            <!-- <div>
                <table class="w3-table w3-bordered" style=" margin: 0 auto; width: 80%">
                <?php $result = $db->query('SELECT `usr_name`, `access_lvl` FROM `Users`'); ?>
                    <tr>
                        <th>Username</th><th>Access Level</th>
                    </tr>
                    <?php while($row = $result->fetch_object()) { ?>
                    <tr>
                        <td><?php echo $row->usr_name, '</td><td>', $row->access_lvl; ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div> -->
        </div>
    </body>
</html>