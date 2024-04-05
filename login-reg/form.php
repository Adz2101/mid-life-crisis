<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Assessment Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
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
            background-color: #66a3ff; /* Lighter blue */
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4d94ff; /* Darker blue on hover */
        }

        #riskMappingField {
            display: none;
        }
    </style>
</head>
<body>

<h1>Submit Risk</h1>

<form action="process-form.php" method="post">
    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject">

    <label for="category">Category:</label>
    <select id="category" name="category" onchange="showRiskMapping()">
        <option value="" selected disabled>Please select</option>
        <option value="Physical and Environmental Security">Physical and Environmental Security</option>
        <option value="Information Security Policies">Information Security Policies</option>
        <option value="Asset Management">Asset Management</option>
        <option value="Access control">Access control</option>
    </select>

    <div id="riskMappingField">
        <label for="riskMapping">Risk Mapping:</label>
        <select id="riskMapping" name="riskMapping">
            <option value="" selected disabled>Please select</option>
        </select>
    </div>

    <label for="currentImpact">Current Impact:</label>
    <select id="currentImpact" name="currentImpact">
        <option value="" selected disabled>Please select</option>
        <option value="insignificant">Insignificant</option>
        <option value="minor">Minor</option>
        <option value="moderate">Moderate</option>
        <option value="major">Major</option>
        <option value="Catastrophic">Extreme/Catastrophic</option>
    </select>

    <label for="currentlikelihood">Current Likelihood:</label>
    <select id="currentlikelihood" name="currentlikelihood">
        <option value="" selected disabled>Please select</option>
        <option value="remotely">Remotely</option>
        <option value="unlikely">Unlikely</option>
        <option value="credible">Credible</option>
        <option value="likely">Likely</option>
        <option value="almostcertain">Almost Certain</option>
    </select>

    <label for="risksource">Risk Source:</label>
    <select id="risksource" name="risksource">
        <option value="" selected disabled>Please select</option>
        <option value="external">External</option>
        <option value="people">People</option>
        <option value="process">Process</option>
        <option value="system">System</option>
    </select>

    <label for="controlregulation">Control Regulation:</label>
    <select id="controlregulation" name="controlregulation">
        <option value="" selected disabled>Please select</option>
        <option value="iso27001">ISO 27001</option>
        <option value="nist800">NIST 800-171</option>
        <option value="nistcsf">NIST CSF</option>
        <option value="nistrmf">NIST RMF</option>
        <option value="scf">Secure Controls Framework(SCF)</option>
        <option value="hitrust">HiTrust</option>
        <option value="aicpa">AICPA tsc 2017</option>
        <option value="newit">New IT Governance Framework</option>
        <option value="soc2">SOC2</option>
        <option value="itsg">ITSG-33</option>
        <option value="healthcare">Healthcare CPG</option>
    </select>

    <label for="controlno">Control Number:</label>
    <input type="text" id="controlno" name="controlno">

    <label for="scoringmethod">Risk Scoring Method:</label>
    <select id="scoringmethod" name="scoringmethod">
        <option value="" selected disabled>Please select</option>
        <option value="classic">Classic</option>
        <option value="cvss">CVSS</option>
        <option value="owasp">OWASP</option>
        <option value="custom">Custom</option>
        <option value="contributing">Contributing Risks</option>
    </select>

    <label for="owner">Owner:</label>
    <select id="owner" name="owner">
        <option value="" selected disabled>Please select</option>
        <option value="admin">Admin</option>
        <option value="demodirector">Demo Director</option>
        <option value="demomanager">Demo Manager</option>
        <option value="demouser">Demo User</option>
        <option value="demovp">Demo VP</option>
    </select>

    <label for="ownermanager">Owner's Manager:</label>
    <select id="ownermanager" name="ownermanager">
        <option value="" selected disabled>Please select</option>
        <option value="admin">Admin</option>
        <option value="demodirector">Demo Director</option>
        <option value="demomanager">Demo Manager</option>
        <option value="demouser">Demo User</option>
        <option value="demovp">Demo VP</option>
    </select>

    <input type="submit" value="Submit">
</form>

<script>
    function showRiskMapping() {
        var category = document.getElementById("category").value;
        var riskMappingField = document.getElementById("riskMappingField");
        var riskMappingDropdown = document.getElementById("riskMapping");

        riskMappingField.style.display = "block";
        riskMappingDropdown.innerHTML = '<option value="" selected disabled>Please select</option>';

        if (category === "Physical and Environmental Security") {
            addOption(riskMappingDropdown, "Natural Disasters");
            addOption(riskMappingDropdown, "Man-Made disaster");
            addOption(riskMappingDropdown, "Insider Threats");
            addOption(riskMappingDropdown, "Insufficient Environmental Controls");
        } else if (category === "Information Security Policies") {
            addOption(riskMappingDropdown, "Outdated Policies");
            addOption(riskMappingDropdown, "Insufficient Training and Education");
            addOption(riskMappingDropdown, "Third-Party Risks");
            addOption(riskMappingDropdown, "Lack of incidence response plans");
        } else if (category === "Asset Management") {
            addOption(riskMappingDropdown, "Uncontrolled asset access");
            addOption(riskMappingDropdown, "Insufficient Data Backup");
            addOption(riskMappingDropdown, "Outdated or Unpatched Software");
            addOption(riskMappingDropdown, "Data loss/leakage");
        } else if (category === "Access control") {
            addOption(riskMappingDropdown, "Lack of multi-Factor Authentication");
            addOption(riskMappingDropdown, "Inadequate authorization controls");
            addOption(riskMappingDropdown, "Denial of service");
            addOption(riskMappingDropdown, "Unauthorised access");
        } else {
            riskMappingField.style.display = "none";
        }
    }

    function addOption(selectElement, optionText) {
        var option = document.createElement("option");
        option.text = optionText;
        selectElement.add(option);
    }
</script>

</body>
</html>
