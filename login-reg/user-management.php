<?php
session_start();
if (!isset($_SESSION["admin"])) {
   header("Location: login.php");
}

// Database connection
require_once "database.php";

// Fetch users from the database
$sql = "SELECT full_name, email FROM users";
$result = mysqli_query($conn, $sql);

// Check if any users are found
if ($result && mysqli_num_rows($result) > 0) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $users = array();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - Risk Management System</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: #4b4bff;
            color: #fff;
            padding-top: 20px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
        }
        .sidebar ul li a i {
            margin-right: 10px;
        }
        .main_content {
            flex: 1;
            padding: 20px;
        }
        .header {
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #4b4bff;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <h2>Risk Management System</h2>
        <ul>
            <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fas fa-bahai"></i> Overview</a></li>
            <li><a href="#" onclick="viewSubmittedRisks()"><i class="fab fa-expeditedssl"></i> Submitted Risks</a></li>
            <li><a href="plan_mitigation.php"><i class="fas fa-tasks"></i> Plan Mitigation</a></li>
            <li><a href="#"><i class="fas fa-atom"></i> Reports</a></li>
            <li><a href="user-management.php"><i class="fas fa-users-cog"></i> User Management</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul> 
    </div>
    <div class="main_content">
        <div class="header">User Management</div>  
        <div class="info">
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['full_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle opening/closing the submitted risks
    function viewSubmittedRisks() {
        // Load submitted risks content using jQuery
        $("#submitted-risks-container").load("view-submitted-risks.php");
    }
</script>

</body>
</html>
