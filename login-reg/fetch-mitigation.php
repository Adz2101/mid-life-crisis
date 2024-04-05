<?php
session_start();
require_once "database.php"; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION["user"])) {
    // Return an error message if not logged in
    echo json_encode(array('error' => 'User not logged in'));
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION["user"]["id"];

if (isset($_GET['risk_id'])) {
    $risk_id = $_GET['risk_id'];
    
    // Query the database to retrieve the mitigation plan for the specified risk ID
    $sql = "SELECT * FROM mitigation WHERE risk_id = ? AND user_id = ? AND mitigation_approved = 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $risk_id, $user_id);


    if (mysqli_stmt_execute($stmt)) {
        // Get the result set
        $result = mysqli_stmt_get_result($stmt);

        // Fetch mitigation data
        $mitigation = mysqli_fetch_assoc($result);

        // Return mitigation data as JSON
        echo json_encode($mitigation);
    } else {
        // Error executing the SQL statement
        echo json_encode(array('error' => 'Error executing SQL statement'));
    }
} else {
    // Risk ID not provided
    echo json_encode(array('error' => 'Risk ID not provided'));
}

// Close the prepared statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
