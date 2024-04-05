<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Risk Management System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <h2>Risk Management System</h2>
        <ul>
            <li><a href="#"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="#"><i class="fas fa-bahai"></i>Overview</a></li>
            <li><a href="#" onclick="openForm()"><i class="fas fa-asterisk"></i>Risk Management</a></li>
            <li><a href="#"><i class="fas fa-project-diagram"></i>Risks and Controls</a></li>
            <li><a href="#"><i class="fas fa-atom"></i>Reports</a></li>
            <li><a href="#" onclick="viewSubmittedRisks()"><i class="fab fa-expeditedssl"></i> Submitted Risks</a></li>
        </ul> 
    </div>
    <div class="main_content">
        <div class="header">Welcome to our risk management system</div>  
        <div class="info" id="form-container">
            <!-- Form content will be loaded here -->
        </div>
        <div class="info" id="submitted-risks-container" style="display:none;">
            <!-- Submitted risks content will be loaded here -->
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
        // Hide submitted risks container
        document.getElementById("submitted-risks-container").style.display = "none";
    }

    // JavaScript to handle opening/closing the submitted risks
    function viewSubmittedRisks() {
        // Load submitted risks content using jQuery
        $("#submitted-risks-container").load("view-submitted-risks.php");
        // Display the submitted risks container
        document.getElementById("submitted-risks-container").style.display = "block";
        // Hide the form container
        document.getElementById("form-container").style.display = "none";
    }
</script>

</body>
</html>