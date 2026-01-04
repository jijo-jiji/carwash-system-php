<?php

$conn = mysqli_connect("localhost", "root", "", "carwash");
session_start();

// Security: Kick out if not admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Base Query
$sql = "SELECT c.cust_name, c.age, c.gender, c.work, q.* FROM customer c 
        JOIN question q ON c.cust_id = q.cust_id 
        WHERE 1=1";

// Handle Filters
if (isset($_POST['filter'])) {
    if (!empty($_POST['filter_age'])) {
        $age_group = $_POST['filter_age'];
        if ($age_group == 'under 22') $sql .= " AND c.age < 22";
        elseif ($age_group == '22-34') $sql .= " AND c.age BETWEEN 22 AND 34";
        elseif ($age_group == '35-54') $sql .= " AND c.age BETWEEN 35 AND 54";
        elseif ($age_group == '55+') $sql .= " AND c.age >= 55";
    }
    
    if (!empty($_POST['filter_gender'])) {
        $gen = $_POST['filter_gender'];
        $sql .= " AND c.gender = '$gen'";
    }

    if (!empty($_POST['filter_vehicle'])) {
        $veh = $_POST['filter_vehicle'];
        $sql .= " AND c.work = '$veh'"; 
    }
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CRITICAL FIX: Force the white card layout */
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 40px 20px;
            color: #333;
        }

        .wide-container {
            background-color: #ffffff; /* FORCE WHITE BACKGROUND */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 1000px; /* Slightly wider for admin table */
            margin: 0 auto;
        }

        /* Top Navigation */
        .top-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        .top-nav h2 { margin: 0; color: #1e3c72; }

        /* Filter Section Styling */
        .filter-box { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 10px; 
            margin-bottom: 30px; 
            border: 1px solid #ddd; 
        }
        
        .filter-row { 
            display: flex; 
            gap: 15px; 
            flex-wrap: wrap; 
            align-items: center;
        }

        select { 
            flex: 1; 
            padding: 10px; 
            border-radius: 5px; 
            border: 1px solid #ccc;
            min-width: 150px;
        }

        /* Buttons */
        .btn-green { background: #27ae60; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px; border:none; cursor: pointer; }
        .btn-red { background: #c0392b; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px; border:none; }
        .btn-filter { background: #2980b9; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-reset { background: #7f8c8d; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #2c3e50; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #ddd; }
        tr:hover { background-color: #f1f1f1; }

    </style>
</head>
<body>

<div class="wide-container">
    
    <div class="top-nav">
        <h2>Customer Feedback Data</h2>
        <div>
            <a href="admin_report.php" class="btn-green">View Stats Report</a>
            <a href="logout.php" class="btn-red">Logout</a>
        </div>
    </div>

    <div class="filter-box">
        <h3 style="margin-top:0; font-size:16px; color:#555;">Filter Results:</h3>
        <form method="POST">
            <div class="filter-row">
                <select name="filter_age">
                    <option value="">-- All Ages --</option>
                    <option value="under 22">Under 22</option>
                    <option value="22-34">22-34</option>
                    <option value="35-54">35-54</option>
                    <option value="55+">55 and over</option>
                </select>

                <select name="filter_gender">
                    <option value="">-- All Genders --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <select name="filter_vehicle">
                    <option value="">-- All Vehicles --</option>
                    <option value="Sedan">Sedan</option>
                    <option value="SUV">SUV</option>
                    <option value="MPV">MPV</option>
                </select>
                
                <button type="submit" name="filter" class="btn-filter">Apply Filter</button>
                <a href="admin_view.php" class="btn-reset">Reset</a>
            </div>
        </form>
    </div>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Age</th>
                    <th>Vehicle</th>
                    <th>Frequency</th>
                    <th>Wash Type</th>
                    <th>Ratings (a-f)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td style='font-weight:bold; color:#2980b9;'>" . $row['cust_name'] . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['work'] . "</td>";
                        echo "<td>" . $row['Q1'] . "</td>";
                        echo "<td>" . $row['Q2'] . "</td>";
                        echo "<td>" . 
                             "Queue: " . $row['Q3a'] . "<br>" . 
                             "Cost: " . $row['Q3b'] . "<br>" . 
                             "Service: " . $row['Q3e'] . 
                             "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center; padding:30px; color:#777;'>No results found matching your filter.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>