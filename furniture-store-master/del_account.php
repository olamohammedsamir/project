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

// Check if user ID is provided in the URL
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $delete_data);
    if (isset($delete_data["user_id"])) {
        $user_id = $delete_data["user_id"];

        // Check if user exists
        $check_user_query = "SELECT * FROM tab_customer WHERE cust_no = ?";
        $stmt = $conn->prepare($check_user_query);
        $stmt->bind_param("i", $cust_no);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Delete user account from the database
            $delete_query = "DELETE FROM users WHERE cust_no = ?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("i", $cust_no);
            if ($stmt->execute()) {
                // User account deleted successfully
                http_response_code(200);
                echo json_encode(array("message" => "User account deleted successfully"));
            } else {
                // Failed to delete user account
                http_response_code(500);
                echo json_encode(array("message" => "Failed to delete user account"));
            }
        } else {
            // User not found
            http_response_code(404);
            echo json_encode(array("message" => "User not found"));
        }
    } else {
        // User ID not provided
        http_response_code(400);
        echo json_encode(array("message" => "User ID not provided"));
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed"));
}

// Close database connection
$conn->close();

?>