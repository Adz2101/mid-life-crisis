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
              
        $sql = "SELECT id AS message_id FROM message WHERE category = ? AND riskMapping = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ss", $category, $riskMapping);
            
            // Execute SQL statement
            if (mysqli_stmt_execute($stmt)) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $message_id);
                
                // Fetch the result
                if (mysqli_stmt_fetch($stmt)) {
                    //echo "$message_id";
                    // Close the statement
                    mysqli_stmt_close($stmt);
                }
            }
        }
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
                            $row = mysqli_fetch_assoc($result);
                            $mi_id = $row['mit_id'];
                            //echo "$risk_id";
                            //echo"$message_id";
                        }       
                    }
                }
            }
        }
        $sql="UPDATE message set mitigation_approved=1, m_id=? where id=?";
        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt, "ii", $mi_id, $message_id);
        if (mysqli_stmt_execute($stmt)) {
            // Mitigation approved successfully
            echo "Mitigation approved successfully";  
        }
       
    }
?>