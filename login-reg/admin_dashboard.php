<?php
session_start();
if (!isset($_SESSION["admin"])) {
   header("Location: login.php");
}

// You can retrieve admin information from the session if needed
$admin = $_SESSION["admin"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Risk Management System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        /* Add this style to remove white border */
        .wrapper {
            border: none; /* Remove border */
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <h2>Risk Management System</h2>
        <ul>
            <li><a href="#"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="#"><i class="fas fa-bahai"></i>Overview</a></li>
            <li><a href="#" onclick="viewSubmittedRisks()"><i class="fab fa-expeditedssl"></i> Submitted Risks</a></li>
            <!-- <li><a href="plan_mitigation.php"><i class="fas fa-tasks"></i> Plan Mitigation</a></li> -->
            <li><a href="#"><i class="fas fa-atom"></i>Reports</a></li>
            <li><a href="user-management.php"><i class="fas fa-users-cog"></i>User Management</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul> 
    </div>
    <div class="main_content">
        <div class="header">
            <div>Welcome, <?php echo $admin["username"]; ?></div>
            <!-- Other header content -->
        </div>  
        <div class="info" id="submitted-risks-container">
            <!-- Submitted risks content will be loaded here -->
        </div>
    </div>
</div>

<script>
    // JavaScript to handle opening/closing the submitted risks
    function viewSubmittedRisks() {
        // Load submitted risks content using jQuery
        $("#submitted-risks-container").load("view-submitted-risks.php");
        $(document).ready(function() {
            $(".btn-plan-mitigation").click(function(e) {
    e.preventDefault();
    var riskId = $(this).data('risk-id');
    $.ajax({
        url: 'fetch-mitigation.php',
        type: 'GET',
        data: { risk_id: riskId }, // Pass the risk ID as a parameter
        dataType: 'json',
        success: function(response) {
            $('#mitigation-modal').html(response.mitigation);
            $('#controls-modal').html(response.controls);
            $('#myModal').css("display", "block");
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Error fetching mitigation and controls');
        }
    });
});


    });
    }
</script>

<script>
    $(document).ready(function() {
        // Event handler for the "Approve Mitigation" button click
        $(document).on("click", ".btn-approve-mitigation", function() {
            // Get the risk ID associated with the clicked button
            var riskId = $(this).data("risk-id");
            
            // Send an AJAX request to approve-mitigation.php
            $.ajax({
                url: "approve-mitigation.php?risk_id=" + riskId,
                type: "GET",
                success: function(response) {
                    // Display the response message (if needed)
                    alert(response);
                    // Optionally, you can refresh the submitted risks section
                    viewSubmittedRisks();
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

</body>
</html>