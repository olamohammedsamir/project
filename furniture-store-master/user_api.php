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

// Check if user ID is provided in the URL
if (isset($_GET["cust_no"])) {
    $user_id = $_GET["cust_no"];

    // Query the database to retrieve user profile by user ID
    $sql = "SELECT * FROM tab_customer WHERE cust_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cust_no);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user profile is found
    if ($result->num_rows > 0) {
        // Fetch user profile data
        $user_profile = $result->fetch_assoc();

        // Return user profile data as JSON response
        // header('Content-Type: application/json');
        echo json_encode($user_profile);
    } else {
        // User profile not found
        header("HTTP/1.1 404 Not Found");
        echo json_encode(array("message" => "User profile not found"));
    }

    // Close statement
    $stmt->close();
} else {
    // User ID not provided
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(array("message" => "User ID not provided"));
}

// Close database connection
$conn->close();

?>
