<?php
// PASTE DB CONNECTION HERE IF NOT USING INCLUDE
$conn = mysqli_connect("localhost", "root", "", "carwash");
session_start();

// Security: Kick out if not admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// 1. Calculate Frequency of Visits (Q1)
$sql_visits = "SELECT Q1, COUNT(*) as count FROM question GROUP BY Q1";
$res_visits = mysqli_query($conn, $sql_visits);

// 2. Calculate Service Ratings (Q3e - General Service)
$sql_ratings = "SELECT Q3e, COUNT(*) as count FROM question GROUP BY Q3e";
$res_ratings = mysqli_query($conn, $sql_ratings);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Management Report</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CRITICAL FIX: Force white card layout */
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 40px 20px;
            color: #333;
        }

        .wide-container {
            background-color: #ffffff;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header & Nav */
        .header-flex { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 30px; }
        h1 { margin: 0; color: #1e3c72; font-size: 24px; }
        
        /* Buttons */
        .btn-back { text-decoration: none; color: #2980b9; font-weight: bold; font-size: 14px; }
        .btn-print { background: #2c3e50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; display: block; margin: 30px auto 0; }
        .btn-print:hover { background: #34495e; }

        /* Report Tables */
        h2 { color: #2c3e50; font-size: 18px; margin-top: 30px; border-left: 5px solid #2980b9; padding-left: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #ecf0f1; color: #333; padding: 10px; text-align: left; border-bottom: 2px solid #bdc3c7; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        
        /* Print Styles - Hides buttons when printing */
        @media print {
            body { background: white; padding: 0; }
            .wide-container { box-shadow: none; padding: 0; max-width: 100%; }
            .btn-back, .btn-print, .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="wide-container">
    
    <div class="header-flex">
        <div>
            <h1>Management Report</h1>
            <p style="color:#777; margin: 5px 0 0 0;">Summary of customer feedback data.</p>
        </div>
        <div class="no-print">
            <a href="admin_view.php" class="btn-back">← Back to Dashboard</a>
        </div>
    </div>

    <h2>1. Frequency of Car Wash Visits (Q1)</h2>
    <table>
        <tr>
            <th>Visit Frequency</th>
            <th width="100">Count</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($res_visits)): ?>
        <tr>
            <td><?php echo $row['Q1']; ?></td>
            <td><?php echo $row['count']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>2. General Service Rating (Q3e)</h2>
    <p style="font-style:italic; color:#666; font-size:13px;">Question: "The general service is good"</p>
    <table>
        <tr>
            <th>Rating (Response)</th>
            <th width="100">Count</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($res_ratings)): ?>
        <tr>
            <td><?php echo $row['Q3e']; ?></td>
            <td><?php echo $row['count']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <button onclick="window.print()" class="btn-print">🖨 Print Report</button>

</div>

</body>
</html>