<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}

// Retrieve user information from the session
$user = $_SESSION["user"];
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
            <li><a href="dashboard.php"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="#"><i class="fas fa-bahai"></i>Overview</a></li>
            <li><a href="#" onclick="openForm()"><i class="fas fa-asterisk"></i>Risk Management</a></li>
            <li><a href="#"><i class="fas fa-project-diagram"></i>Risks and Controls</a></li>
            <li><a href="#" onclick="loadCurrentRiskTrends()"><i class="fas fa-atom"></i>Current risk trends</a></li>
            <li><a href="#" onclick="viewSubmittedRisks()"><i class="fab fa-expeditedssl"></i> Submitted Risks</a></li>
            <li><a href="#" onclick="loadPlanMitigation()"><i class="fas fa-tasks"></i> View Mitigation</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul> 
    </div>
    <div class="main_content">
        <div class="header">
            <div>Welcome, <?php echo $user["full_name"]; ?></div>
            <!-- Other header content -->
        </div>  
        <div class="info" id="form-container">
            <!-- Form content will be loaded here -->
        </div>
        <div class="info" id="submitted-risks-container" style="display:none;">
            <!-- Submitted risks content will be loaded here -->
        </div>
        <div class="info" id="plan-mitigation-container" style="display:none;">
            <!-- Plan mitigation content will be loaded here -->
        </div>
        <div class="info" id="approved-mitigation-container" style="display:none;">
            <!-- Approved mitigation plans content will be loaded here -->
        </div>
    </div>
</div>

<script>
    // JavaScript to handle opening/closing the form and loading content
    function openForm() {
        // Load form content using jQuery
        $("#form-container").load("form.php");
        // Display the form container
        document.getElementById("form-container").style.display = "block";
        // Hide other containers if visible
        document.getElementById("submitted-risks-container").style.display = "none";
        document.getElementById("plan-mitigation-container").style.display = "none";
        document.getElementById("approved-mitigation-container").style.display = "none";
    }

    // JavaScript to handle opening/closing the submitted risks
    function viewSubmittedRisks() {
        // Load submitted risks content using jQuery
        $("#submitted-risks-container").load("view-submitted-risks.php");
        // Display the submitted risks container
        document.getElementById("submitted-risks-container").style.display = "block";
        // Hide other containers if visible
        document.getElementById("form-container").style.display = "none";
        document.getElementById("plan-mitigation-container").style.display = "none";
        document.getElementById("approved-mitigation-container").style.display = "none";
    }

    // JavaScript function to load approved mitigation
    function loadPlanMitigation() {
        // Load approved mitigation content using jQuery
        $("#plan-mitigation-container").load("view-mitigation.php");
        // Display the plan mitigation container
        document.getElementById("plan-mitigation-container").style.display = "block";
        // Hide other containers if visible
        document.getElementById("form-container").style.display = "none";
        document.getElementById("submitted-risks-container").style.display = "none";
        document.getElementById("approved-mitigation-container").style.display = "none";
    }

    function loadCurrentRiskTrends() {
        // Load current risk trends content using jQuery
        $("#form-container").load("current-risk-trends.php");
        // Hide submitted risks, plan mitigation, and approved mitigation containers if visible
        document.getElementById("submitted-risks-container").style.display = "none";
        document.getElementById("plan-mitigation-container").style.display = "none";
        document.getElementById("approved-mitigation-container").style.display = "none";
        // Display the form container
        document.getElementById("form-container").style.display = "block";
    }
</script>

<!-- Place this JavaScript code inside the <script> tag in dashboard.php -->

<script>
    // Function to load approved mitigation plans content
    function loadApprovedMitigation() {
        // Load approved mitigation content using jQuery AJAX
        $("#approved-mitigation-container").load("get-approved-mitigation.php");
        // Display the approved mitigation container
        $("#approved-mitigation-container").show();
        // Hide other containers if visible
        $("#submitted-risks-container, #form-container, #plan-mitigation-container").hide();
    }

    // Function to toggle the visibility of the approved mitigation container
    function toggleApprovedMitigation() {
        // Toggle visibility of the approved mitigation container
        $("#approved-mitigation-container").toggle();
        // Hide other containers if visible
        $("#submitted-risks-container, #form-container, #plan-mitigation-container").hide();
    }

    $(document).ready(function() {
        // Event handler for the "Approved Mitigation" link click
        $("#btn-approved-mitigation").click(function() {
            loadApprovedMitigation(); // Load approved mitigation plans content
        });

        // Event handler for toggling the visibility of the approved mitigation container
        $("#btn-toggle-approved-mitigation").click(function() {
            toggleApprovedMitigation(); // Toggle visibility of the approved mitigation container
        });
    });
</script>



</body>
</html>