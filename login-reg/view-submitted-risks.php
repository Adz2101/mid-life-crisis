<?php
session_start();
require_once "database.php"; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

// Check if admin is logged in
if (isset($_SESSION["admin"])) {
    $isAdmin = true;
} else {
    $isAdmin = false;
}

// Prepare the SQL statement to retrieve risks submitted by all users (if admin) or the logged-in user
if ($isAdmin) {
    $sql = "SELECT m.*, u.full_name FROM message m JOIN users u ON m.user_id = u.id";
} else {
    $user_id = isset($_SESSION["user"]["id"]) ? $_SESSION["user"]["id"] : null;
    $sql = "SELECT m.*, u.full_name FROM message m JOIN users u ON m.user_id = u.id WHERE m.user_id = ?";
}

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Error: Unable to prepare SQL statement. " . mysqli_error($conn));
}

// Bind the user ID parameter if applicable
if (!$isAdmin) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
}

// Execute the SQL statement
if (mysqli_stmt_execute($stmt)) {
    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if any risks are found
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Submitted Risks</h2>";
        echo "<table border='1'>";
        echo "<tr><th>User</th><th>Subject</th><th>Category</th><th>Risk Mapping</th><th>Current Impact</th><th>Current Likelihood</th><th>Risk Source</th><th>Control Regulation</th><th>Control Number</th><th>Risk Scoring Method</th><th>Owner</th><th>Owner's Manager</th>";
        if ($isAdmin) {
            echo "<th>Plan Mitigation</th>"; // Only display for admin
            //echo "<th>Approve Mitigation</th>"; // New column for approve button
        }
        echo "</tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['full_name']}</td>";
            echo "<td>{$row['subject']}</td>";
            echo "<td>{$row['category']}</td>";
            echo "<td>{$row['riskMapping']}</td>";
            echo "<td>{$row['currentImpact']}</td>";
            echo "<td>{$row['currentlikelihood']}</td>";
            echo "<td>{$row['risksource']}</td>";
            echo "<td>{$row['controlregulation']}</td>";
            echo "<td>{$row['controlno']}</td>";
            echo "<td>{$row['scoringmethod']}</td>";
            echo "<td>{$row['owner']}</td>";
            echo "<td>{$row['ownermanager']}</td>";
            if ($isAdmin) {
                // Plan Mitigation link
                $category = $row['category'];
                $riskMapping = $row['riskMapping'];
                if ($category && $riskMapping) {
                    $risk_id_query = "SELECT risk_id FROM risk WHERE category = ? AND riskMapping = ?";
                    $risk_stmt = mysqli_prepare($conn, $risk_id_query);
                    mysqli_stmt_bind_param($risk_stmt, "ss", $category, $riskMapping);
                    mysqli_stmt_execute($risk_stmt);
                    $risk_result = mysqli_stmt_get_result($risk_stmt);
                    $risk_row = mysqli_fetch_assoc($risk_result);
                    $risk_id = $risk_row ? $risk_row['risk_id'] : null;

                    if ($risk_id) {
                        echo "<td><a href='plan-mitigation.php?risk_id={$risk_id}&category={$category}&riskMapping={$riskMapping}' class='btn-plan-mitigation' data-risk-id='{$row['id']}'>Plan Mitigation</a></td>";
                    } else {
                        echo "<td>No Risk ID found</td>";
                    }
                } else {
                    echo "<td>Category and riskMapping parameters are required</td>";
                }

                // Approve Mitigation button
               // echo "<td><button class='btn-approve-mitigation' data-risk-id='{$row['id']}'>Approve</button></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No submitted risks found</p>";
    }
} else {
    // Error executing the SQL statement
    echo "Error: " . mysqli_error($conn);
}

// Close the prepared statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>