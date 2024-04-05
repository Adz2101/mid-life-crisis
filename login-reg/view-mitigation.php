<?php
session_start();
require_once "database.php"; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION["user"])) {
    // Redirect if not logged in
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user"]["id"];

// Query the database to retrieve approved mitigation plans submitted by the logged-in user
$sql = "SELECT m.* FROM mitigation m JOIN message r ON m.risk_id = r.id WHERE r.user_id = ? AND r.mitigation_approved = 1";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    if (mysqli_stmt_execute($stmt)) {
        // Get the result set
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Display the approved mitigation plans
            while ($row = mysqli_fetch_assoc($result)) {
                // Echo HTML code to display the mitigation plan details
                echo "<p>Mitigation: {$row['mitigation']}</p>";
                // Add more HTML formatting for other mitigation plan details as needed
            }
        } else {
            // No approved mitigation plans found for the logged-in user
            echo "<p>No approved mitigation plans found</p>";
        }
    } else {
        // Error executing the SQL statement
        echo "Error: " . mysqli_error($conn);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    // Error preparing SQL statement
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
