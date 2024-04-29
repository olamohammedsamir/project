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
header("Content-Type: application/json");

// Retrieve all products

    $sql = "SELECT * FROM tab_furniture";
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




// Close database connection
$conn->close();

?>