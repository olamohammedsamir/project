<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_furniture_store";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Search products
    if (isset($_GET['q'])) {
        $query = $_GET['q'];

        // Perform search query
        $search_query = "SELECT * FROM tab_furniture WHERE product_name LIKE ?";
        $stmt = $conn->prepare($search_query);
        $search_param = "%$query%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Products found
            $products = array();
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            http_response_code(200);
            echo json_encode($products);
        } else {
            // No products found
            http_response_code(404);
            echo json_encode(array("message" => "No products found"));
        }
    } else {
        // Query parameter not provided
        http_response_code(400);
        echo json_encode(array("message" => "Query parameter not provided"));
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed"));
}

// Close database connection
$conn->close();

?>