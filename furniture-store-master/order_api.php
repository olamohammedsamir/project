<?php
 $servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_furniture_store";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set headers for JSON response
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin:n *");
header("Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");
header("Access-Control-Max-Age:3600");
// Retrieve all products

    $sql = "SELECT * FROM tab_order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $products = array();
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode($products);
        
    } else {
        echo json_encode(array("message" => "No products found"));
    }
