<?php

$host = "localhost";
$dbname = "login_register";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}

// Check if the risk ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing risk details based on the ID
    $selectSql = "SELECT * FROM message WHERE id = ?";
    $selectStmt = mysqli_prepare($conn, $selectSql);

    if ($selectStmt) {
        mysqli_stmt_bind_param($selectStmt, "i", $id);
        mysqli_stmt_execute($selectStmt);
        $result = mysqli_stmt_get_result($selectStmt);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            $subject = $row['subject'];
            $category = $row['category'];
            $riskMapping = $row["riskMapping"];
            $currentImpact = $row['currentImpact'];
            $currentlikelihood = $row['currentlikelihood'];
            $risksource = $row['risksource'];
            $controlregulation = $row["controlregulation"];
            $controlno = $row["controlno"];
            $scoringmethod = $row["scoringmethod"];
            $owner = $row["owner"];
        } else {
            // Risk not found
            die("Risk not found");
        }

        mysqli_stmt_close($selectStmt);
    } else {
        // SQL statement preparation failed
        die("Preparation failed");
    }
} else {
    // Risk ID not provided in the URL
    die("Risk ID not provided");
}

// Handle the form submission for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newSubject = $_POST["subject"];
    $newCategory = $_POST["category"];
    $newriskMapping = $_POST["riskMapping"];
    $newCurrentImpact = $_POST["currentImpact"];
    $newCurrentlikelihood = $_POST["currentlikelihood"];
    $newRiskSource = $_POST["risksource"];
    $newcontrolregulation = $_POST["controlregulation"];
    $newcontrolno = $_POST["controlno"];
    $newscoringmethod = $_POST["scoringmethod"];
    $newowner = $_POST["owner"];

    // Update the risk details in the database
    $updateSql = "UPDATE message SET subject = ?, category = ?,  currentImpact = ?, riskMapping = ?, currentlikelihood = ?, risksource = ?, controlregulation = ?, controlno = ?, scoringmethod = ?, owner = ? WHERE id = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, "ssssssssssi",
            $newSubject,
            $newCategory,
            $newriskMapping,
            $newCurrentImpact,
            $newCurrentlikelihood,
            $newRiskSource,
            $newcontrolregulation,
            $newcontrolno,
            $newscoringmethod,
            $newowner,
            $id
        );

        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);

        // Redirect to the submitted risks page after editing
        header("Location: dashboard.php");
        exit();
    } else {
        // SQL statement preparation failed
        die("Preparation failed");
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Risk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h2>Edit Risk</h2>

    <form action="edit-form.php?id=<?php echo $id; ?>" method="post">
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" value="<?php echo $subject; ?>">

        <label for="category">Category:</label>
        <select id="category" name="category">
            
            <option value="physical" <?php echo ($category === 'physical') ? 'selected' : ''; ?>>Physical and Environmental Security</option>
            <option value="policies" <?php echo ($category === 'policies') ? 'selected' : ''; ?>>Information Security Policies</option>
            <option value="asset" <?php echo ($category === 'asset') ? 'selected' : ''; ?>>Asset Management</option>
            <option value="access" <?php echo ($category === 'access') ? 'selected' : ''; ?>>Access control</option>
        </select>

        <label for="riskMapping">Risk Mapping:</label>
<select id="riskMapping" name="riskMapping">
    <?php
    
    $categoryOptions = [
        'physical' => ['Natural Disasters', 'Man-Made Disaster', 'Insider Threats', 'Insufficient Environmental Controls'],
        'policies' => ['Outdated Policies', 'Insufficient Training and Education', 'Third-Party Risks', 'Lack of incidence response plan'],
        'asset' => ['Uncontrolled asset access', 'Insufficient Data Backup', 'Outdated or Unpatched Software', 'Data loss/leakage'],
        'access' => ['Lack of multi-Factor Authentication', 'Inadequate authorization controls', 'Denial of service', 'Unauthorised access'],
    ];

    foreach ($categoryOptions[$category] as $option) {
        echo "<option value=\"$option\" " . (($riskMapping === $option) ? 'selected' : '') . ">$option</option>";
    }
    ?>
</select>


        <label for="currentImpact">Current Impact:</label>
        <select id="currentImpact" name="currentImpact">
            
            <option value="insignificant" <?php echo ($currentImpact === 'insignificant') ? 'selected' : ''; ?>>Insignificant</option>
            <option value="minor" <?php echo ($currentImpact === 'minor') ? 'selected' : ''; ?>>Minor</option>
            <option value="moderate" <?php echo ($currentImpact === 'moderate') ? 'selected' : ''; ?>>Moderate</option>
            <option value="major" <?php echo ($currentImpact === 'major') ? 'selected' : ''; ?>>Major</option>
            <option value="Catastrophic" <?php echo ($currentImpact === 'Catastrophic') ? 'selected' : ''; ?>>Extreme/Catastrophic</option>
        </select>

        <label for="currentlikelihood">Current Likelihood:</label>
        <select id="currentlikelihood" name="currentlikelihood">
            
            <option value="remotely" <?php echo ($currentlikelihood === 'remotely') ? 'selected' : ''; ?>>Remotely</option>
            <option value="unlikely" <?php echo ($currentlikelihood === 'unlikely') ? 'selected' : ''; ?>>Unlikely</option>
            <option value="credible" <?php echo ($currentlikelihood === 'credible') ? 'selected' : ''; ?>>Credible</option>
            <option value="likely" <?php echo ($currentlikelihood === 'likely') ? 'selected' : ''; ?>>Likely</option>
            <option value="almostcertain" <?php echo ($currentlikelihood === 'almostcertain') ? 'selected' : ''; ?>>Almost Certain</option>
        </select>

        <label for="risksource">Risk Source:</label>
        <select id="risksource" name="risksource">
            
            <option value="external" <?php echo ($risksource === 'external') ? 'selected' : ''; ?>>External</option>
            <option value="people" <?php echo ($risksource === 'people') ? 'selected' : ''; ?>>People</option>
            <option value="process" <?php echo ($risksource === 'process') ? 'selected' : ''; ?>>Process</option>
            <option value="system" <?php echo ($risksource === 'system') ? 'selected' : ''; ?>>System</option>
        </select>

        <label for="controlregulation">Control Regulation:</label>
<select id="controlregulation" name="controlregulation">
    <option value="" selected disabled>Please select</option>
    <option value="iso27001" <?php echo ($controlregulation === 'iso27001') ? 'selected' : ''; ?>>ISO 27001</option>
    <option value="nist800" <?php echo ($controlregulation === 'nist800') ? 'selected' : ''; ?>>NIST 800-171</option>
    <option value="nistcsf" <?php echo ($controlregulation === 'nistcsf') ? 'selected' : ''; ?>>NIST CSF</option>
    <option value="nistrmf" <?php echo ($controlregulation === 'nistrmf') ? 'selected' : ''; ?>>NIST RMF</option>
    <option value="scf" <?php echo ($controlregulation === 'scf') ? 'selected' : ''; ?>>Secure Controls Framework(SCF)</option>
    <option value="hitrust" <?php echo ($controlregulation === 'hitrust') ? 'selected' : ''; ?>>HiTrust</option>
    <option value="aicpa" <?php echo ($controlregulation === 'aicpa') ? 'selected' : ''; ?>>AICPA tsc 2017</option>
    <option value="newit" <?php echo ($controlregulation === 'newit') ? 'selected' : ''; ?>>New IT Governance Framework</option>
    <option value="soc2" <?php echo ($controlregulation === 'soc2') ? 'selected' : ''; ?>>SOC2</option>
    <option value="itsg" <?php echo ($controlregulation === 'itsg') ? 'selected' : ''; ?>>ITSG-33</option>
    <option value="healthcare" <?php echo ($controlregulation === 'healthcare') ? 'selected' : ''; ?>>Healthcare CPG</option>
</select>

<label for="controlno">Control Number:</label>
<input type="text" id="controlno" name="controlno" value="<?php echo $controlno; ?>">

<label for="scoringmethod">Risk Scoring Method:</label>
<select id="scoringmethod" name="scoringmethod">
    <option value="" selected disabled>Please select</option>
    <option value="classic" <?php echo ($scoringmethod === 'classic') ? 'selected' : ''; ?>>Classic</option>
    <option value="cvss" <?php echo ($scoringmethod === 'cvss') ? 'selected' : ''; ?>>CVSS</option>
    <option value="owasp" <?php echo ($scoringmethod === 'owasp') ? 'selected' : ''; ?>>OWASP</option>
    <option value="custom" <?php echo ($scoringmethod === 'custom') ? 'selected' : ''; ?>>Custom</option>
    <option value="contributing" <?php echo ($scoringmethod === 'contributing') ? 'selected' : ''; ?>>Contributing Risks</option>
</select>

<label for="owner">Owner:</label>
<select id="owner" name="owner">
    <option value="" selected disabled>Please select</option>
    <option value="admin" <?php echo ($owner === 'admin') ? 'selected' : ''; ?>>Admin</option>
    <option value="demodirector" <?php echo ($owner === 'demodirector') ? 'selected' : ''; ?>>Demo Director</option>
    <option value="demomanager" <?php echo ($owner === 'demomanager') ? 'selected' : ''; ?>>Demo Manager</option>
    <option value="demouser" <?php echo ($owner === 'demouser') ? 'selected' : ''; ?>>Demo User</option>
    <option value="demovp" <?php echo ($owner === 'demovp') ? 'selected' : ''; ?>>Demo VP</option>
</select>


        <input type="submit" value="Save Changes">
    </form>

</body>
</html>