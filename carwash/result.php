<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "carwash");

// Security Check: Kick out if not logged in
if (!isset($_SESSION['cust_id'])) {
    header("Location: login.php");
    exit();
}

$cust_id = $_SESSION['cust_id'];

// Handle "Cancel" (Delete) Action
if (isset($_GET['delete_id'])) {
    $qid = $_GET['delete_id'];
    // Security: Ensure user can only delete THEIR OWN data
    $del_sql = "DELETE FROM question WHERE Qid='$qid' AND cust_id='$cust_id'";
    
    if(mysqli_query($conn, $del_sql)) {
        echo "<script>alert('Submission cancelled successfully.'); window.location='result.php';</script>";
    }
}

// Fetch User's Answers Joined with Branch Name
$sql = "SELECT q.*, b.branch_name 
        FROM question q
        JOIN branch b ON q.branch_id = b.branch_id
        WHERE q.cust_id = '$cust_id'
        ORDER BY q.Qid DESC"; // Show newest first
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Submissions</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CRITICAL FIX: Force the layout to look like a white card */
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 40px 20px; /* Allow scrolling */
            color: #333;
        }

        .wide-container {
            background-color: #ffffff; /* FORCE WHITE BACKGROUND */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 900px;
            margin: 0 auto; /* Center horizontal */
        }

        /* Header Layout */
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        
        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
        th { background: #2a5298; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #ddd; vertical-align: top; }
        
        /* Badges for Ratings */
        .badge { 
            background: #f1f1f1; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 11px; 
            display: inline-block; 
            margin: 2px; 
            border: 1px solid #ddd;
        }

        /* Buttons */
        .btn-new { background: #27ae60; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .btn-logout { background: #7f8c8d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .btn-cancel { background: #e74c3c; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 12px; }
        
        h2 { margin: 0; color: #1e3c72; }
    </style>
</head>
<body>

<div class="wide-container">
    
    <div class="header-flex">
        <div>
            <h2>My Survey History</h2>
            <p style="color:#666; margin: 5px 0 0 0;">Welcome, <?php echo $_SESSION['cust_name']; ?></p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="survey.php" class="btn-new">+ New Survey</a>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Branch</th>
                    <th>Frequency</th>
                    <th>Wash Type</th>
                    <th width="35%">Your Ratings</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="font-weight:bold; color:#2a5298;">
                        <?php echo $row['branch_name']; ?>
                    </td>
                    <td><?php echo $row['Q1']; ?></td>
                    <td><?php echo $row['Q2']; ?></td>
                    <td>
                        <span class="badge">Queue: <?php echo $row['Q3a']; ?></span>
                        <span class="badge">Cost: <?php echo $row['Q3b']; ?></span>
                        <span class="badge">Comfort: <?php echo $row['Q3c']; ?></span>
                        <span class="badge">Staff: <?php echo $row['Q3d']; ?></span>
                        <span class="badge">Service: <?php echo $row['Q3e']; ?></span>
                        <span class="badge">Price: <?php echo $row['Q3f']; ?></span>
                    </td>
                    <td>
                        <a href="result.php?delete_id=<?php echo $row['Qid']; ?>" 
                           onclick="return confirm('Are you sure you want to cancel this submission?');" 
                           class="btn-cancel">
                           Cancel
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div style="text-align:center; padding: 50px; color:#777;">
            <h3>No surveys found.</h3>
            <p>You haven't submitted any feedback yet.</p>
            <br>
            <a href="survey.php" class="btn-new">Start Your First Survey</a>
        </div>
    <?php endif; ?>

</div>

</body>
</html>