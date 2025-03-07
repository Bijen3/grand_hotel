<?php
// Include database connection
include('db_connection.php');

// Function to calculate total price for the booking
function calculateTotalPrice($room_id, $check_in_date, $check_out_date) {
    global $connect;

    // Convert date strings to DateTime objects to calculate the difference
    $check_in = new DateTime($check_in_date);
    $check_out = new DateTime($check_out_date);
    
    // Calculate the number of nights
    $interval = $check_in->diff($check_out);
    $nights = $interval->days;

    // Get the price per night for the room
    $query = "SELECT price FROM rooms WHERE id = ?";
    if ($stmt = $connect->prepare($query)) {
        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        $stmt->bind_result($price);
        $stmt->fetch();
        $stmt->close();

        // Calculate total price
        if (isset($price)) {
            return $price * $nights;
        } else {
            return 0; // Room not found
        }
    }

    return 0; // Error in database query
}

// Example function to handle general queries (e.g., select)
function select($query, $params = [], $types = '') {
    global $connect;
    
    if ($stmt = $connect->prepare($query)) {
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    return false;
}

// Example function to handle insert queries (e.g., insert booking)
function insert($query, $params = [], $types = '') {
    global $connect;
    
    if ($stmt = $connect->prepare($query)) {
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        if ($stmt->execute()) {
            return $stmt->insert_id; // Return inserted ID
        } else {
            return false; // Error executing query
        }
    }
    
    return false; // Error preparing query
}
?>
