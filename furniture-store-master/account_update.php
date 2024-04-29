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
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $put_data);
    if (isset($put_data["user_id"])) {
        $user_id = $put_data["user_id"];

        // Check if user exists
        $check_user_query = "SELECT * FROM tab_customer WHERE cust_no = ?";
        $stmt = $conn->prepare($check_user_query);
        $stmt->bind_param("i", $cust_no);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Extract updated user profile data
            $updated_user_profile = array();
            if (isset($put_data["name"])) {
                $updated_user_profile["name"] = $put_data["name"];
            }
            
            // Add more fields as needed

            // Update user profile in the database
            $update_query = "UPDATE tab_cust SET ";
            foreach ($updated_user_profile as $key => $value) {
                $update_query .= "$key = ?, ";
            }
            $update_query = rtrim($update_query, ", ");
            $update_query .= " WHERE cust_no = ?";
            $stmt = $conn->prepare($update_query);
            $types = str_repeat("s", count($updated_user_profile)) . "i";
            $params = array_values($updated_user_profile);
            $params[] = $cust_no;
            $stmt->bind_param($types, ...$params);
            if ($stmt->execute()) {
                // User profile updated successfully
                http_response_code(200);
                echo json_encode(array("message" => "User profile updated successfully"));
            } else {
                // Failed to update user profile
                http_response_code(500);
                echo json_encode(array("message" => "Failed to update user profile"));
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