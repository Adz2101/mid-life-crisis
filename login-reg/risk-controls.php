<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Risks and Controls</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h2>Risks and Controls</h2>
    
    <?php
    // Define risk information based on selected risk label
    $selected_risk = $_GET['risk'];
    echo "<p>Selected Risk Label: $selected_risk</p>"; // Debugging statement

    // Define the details for each risk label
    $risk_details = array(
        "Insider threat" => array(
            "Impact" => "Affects physical assets",
            "Affected Department" => "Security, HR"
        ),
        "Ransomware Attacks" => array(
            "Impact" => "Affects C-level executives",
            "Affected Department" => "IT, Finance"
        ),
        // Add details for other risk labels as needed
    );

    // Debugging statement to check the entire risk_details array
    echo "<pre>";
    print_r($risk_details);
    echo "</pre>";

    // Check if the selected risk label exists in the risk details array
    if (array_key_exists($selected_risk, $risk_details)) {
        echo "<h3>$selected_risk</h3>";
        echo "<table>";
        foreach ($risk_details[$selected_risk] as $key => $value) {
            echo "<tr><th>$key</th><td>$value</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No information available for the selected risk</p>";
    }
    ?>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
