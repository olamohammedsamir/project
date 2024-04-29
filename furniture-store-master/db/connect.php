<?php
	$db = new mysqli('localhost','root','','db_furniture_store');

	if($db->connect_errno) {
		die('Sorry, we are unable to connect to the database at the moment.');
	}

?>