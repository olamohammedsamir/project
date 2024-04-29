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

// Check request method
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Check if order ID is provided in the URL
    if (preg_match('/^\/api\/orders\/cancel\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
        $order_id = $matches[1];
        
        // Check if order exists
        $check_order_query = "SELECT * FROM tab_order WHERE order_no = ?";
        $stmt = $conn->prepare($check_order_query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            // Cancel order
            $cancel_order_query = "UPDATE tab_order SET status = 'cancelled' WHERE order_no = ?";
            $stmt = $conn->prepare($cancel_order_query);
            $stmt->bind_param("i", $order_id);
            
            if ($stmt->execute()) {
                // Order cancelled successfully
                http_response_code(200);
                echo json_encode(array("message" => "Order cancelled successfully"));
            } else {
                // Failed to cancel order
                http_response_code(500);
                echo json_encode(array("message" => "Failed to cancel order"));
            }
        } else {
            // Order not found
            http_response_code(404);
            echo json_encode(array("message" => "Order not found"));
        }
    } else {
        // Invalid URL format
        http_response_code(400);
        echo json_encode(array("message" => "Invalid URL format"));
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed"));
}

// Close database connection
$conn->close();

?>