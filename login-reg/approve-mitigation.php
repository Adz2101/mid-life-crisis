<?php
    session_start();
    require_once "database.php"; 
    
    // Check if user is logged in
    if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
        header("Location: login.php");
        exit();
    }

    // Check if category and riskMapping parameters are set
    if (isset($_GET['category']) && isset($_GET['riskMapping'])) {
        // Retrieve category and riskMapping parameters
        $category = $_GET['category'];
        $riskMapping = $_GET['riskMapping'];
        
        // Prepare SQL statement to retrieve risk_id from the risk table
        $sql = "SELECT risk_id FROM risk WHERE category = ? AND riskMapping = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ss", $category, $riskMapping);
            
            // Execute SQL statement
            if (mysqli_stmt_execute($stmt)) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $risk_id);
                
                // Fetch the result
                if (mysqli_stmt_fetch($stmt)) {
                    // Close the statement
                    mysqli_stmt_close($stmt);
                    
                    // Prepare SQL statement to retrieve mitigation for the risk_id
                    $sql = "SELECT * FROM mitigation WHERE risk_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    
                    if ($stmt) {
                        // Bind parameter
                        mysqli_stmt_bind_param($stmt, "i", $risk_id);
                        
                        // Execute SQL statement
                        if (mysqli_stmt_execute($stmt)) {
                            // Get the result set
                            $result = mysqli_stmt_get_result($stmt);
                            
                            // Display mitigation
                            echo "<!DOCTYPE html>";
                            echo "<html lang='en'>";
                            echo "<head>";
                            echo "<meta charset='UTF-8'>";
                            echo "<title>Plan Mitigation</title>";
                            echo "<link rel='stylesheet' href='styles.css'>";
                            echo "</head>";
                            echo "<body>";
                            echo "<div class='mitigation-container'>";
                            echo "<h2>Mitigation Information</h2>";
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<p>Mitigation: {$row['mitigation']}</p>";
                            }
                            echo "</div>";
                            echo "</body>";
                            echo "</html>";
                        } else {
                            echo "Error executing SQL statement: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error preparing SQL statement: " . mysqli_error($conn);
                    }
                } else {
                    echo "No risk found with category: $category and risk mapping: $riskMapping";
                }
            } else {
                echo "Error executing SQL statement: " . mysqli_error($conn);
            }
        } else {
            echo "Error preparing SQL statement: " . mysqli_error($conn);
        }
    } else {
        echo "Category and riskMapping parameters are required.";
    }



            // Debugging: Output the received risk_id
           

//mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
