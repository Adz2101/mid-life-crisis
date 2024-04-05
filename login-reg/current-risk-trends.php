<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Current Risk Trends</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

</head>
<body>
    <h2>Current Risk Trends</h2>
    <canvas id="riskTrendsChart" width="300" height="300"></canvas>

    <script>
        // JavaScript to initialize the chart
        var ctx = document.getElementById("riskTrendsChart").getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Insider threat", "Ransomware Attacks", "IOT Attacks", "Data breaches", "Phishing", "Cloud attacks", "Supply Chain Attacks", "Zero-Day Exploits", "Distributed Denial of Service (DDoS) Attacks", "SQL Injection"],
                datasets: [{
                    label: "Impact percentage on the organisation",
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"],
                    data: [5, 30, 30, 25, 15, 15, 10, 10, 5, 5]
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>
</html>
