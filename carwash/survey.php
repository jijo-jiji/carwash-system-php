<?php
session_start();
// PASTE DB CONNECTION HERE
$conn = mysqli_connect("localhost", "root", "", "carwash");

// Security: Check if user is logged in
if (!isset($_SESSION['cust_id'])) {
    echo "<script>alert('Please login first!'); window.location='login.php';</script>";
    exit();
}

$cust_id = $_SESSION['cust_id'];

if (isset($_POST['submit_survey'])) {
    
    // VALIDATION: Check for empty fields
    if (empty($_POST['branches']) || empty($_POST['q1']) || empty($_POST['q2'])) {
        echo "<script>alert('Please enter all fields');</script>";
    } else {
        // Handle "Other" text inputs safely
        $q1 = ($_POST['q1'] == 'Others' && !empty($_POST['q1_text'])) ? $_POST['q1_text'] : $_POST['q1'];
        $q2 = ($_POST['q2'] == 'Other' && !empty($_POST['q2_text'])) ? $_POST['q2_text'] : $_POST['q2'];
        
        // Safe defaults for radio buttons if missed
        $q3a = $_POST['q3a'] ?? '';
        $q3b = $_POST['q3b'] ?? '';
        $q3c = $_POST['q3c'] ?? '';
        $q3d = $_POST['q3d'] ?? '';
        $q3e = $_POST['q3e'] ?? '';
        $q3f = $_POST['q3f'] ?? '';
        
        $selected_branches = $_POST['branches']; 

        // Loop to save answer for EACH branch selected
        foreach ($selected_branches as $branch_id) {
            $sql = "INSERT INTO question (Q1, Q2, Q3a, Q3b, Q3c, Q3d, Q3e, Q3f, cust_id, branch_id)
                    VALUES ('$q1', '$q2', '$q3a', '$q3b', '$q3c', '$q3d', '$q3e', '$q3f', '$cust_id', '$branch_id')";
            mysqli_query($conn, $sql);
        }

        echo "<script>alert('Survey Submitted Successfully!'); window.location='result.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Satisfaction Survey</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CRITICAL FIX: Force the white card look */
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .wide-container {
            background-color: #ffffff; /* FORCE WHITE BACKGROUND */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 800px;
            margin: 20px auto; /* Centers the box */
        }

        /* Make text readable */
        h2 { color: #1e3c72; text-align: center; }
        h3 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 30px; }
        
        .checkbox-label { 
            display: block; 
            margin: 10px 0; 
            font-size: 16px; 
            color: #444; 
            cursor: pointer;
        }

        /* Fix input alignment */
        input[type="radio"], input[type="checkbox"] {
            transform: scale(1.2);
            margin-right: 10px;
        }
        
        .text-specify {
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
            margin-left: 10px;
        }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #eee; text-align: left; padding: 10px; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        
        /* Submit Button */
        .submit-btn {
            background: #27ae60;
            color: white;
            font-size: 18px;
            padding: 15px;
            width: 100%;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 30px;
        }
        .submit-btn:hover { background: #2ecc71; }
    </style>
</head>
<body>

<div class="wide-container">
    
    <h2>Customer Satisfaction Questionnaire</h2>
    <p style="text-align:center; color:#666;">Help us improve our service by answering the following questions.</p>
    
    <form method="POST" action="">
        
        <h3>Select Branch(es) visited:</h3>
        <p><i>(You may select more than one)</i></p>
        <?php
        $branch_query = "SELECT * FROM branch";
        $branch_res = mysqli_query($conn, $branch_query);
        while($row = mysqli_fetch_assoc($branch_res)) {
            echo '<label class="checkbox-label"><input type="checkbox" name="branches[]" value="'.$row['branch_id'].'"> ' . $row['branch_name'] . '</label>';
        }
        ?>

        <h3>1. How often do you use this car wash service?</h3>
        <label class="checkbox-label"><input type="radio" name="q1" value="First time" required> First time</label>
        <label class="checkbox-label"><input type="radio" name="q1" value="Once a month"> Once a month</label>
        <label class="checkbox-label"><input type="radio" name="q1" value="2-3 times a month"> 2-3 times a month</label>
        <label class="checkbox-label"><input type="radio" name="q1" value="Others"> Others: 
            <input type="text" name="q1_text" class="text-specify" placeholder="Specify...">
        </label>

        <h3>2. What type of car wash service did you use today?</h3>
        <label class="checkbox-label"><input type="radio" name="q2" value="Basic wash" required> Basic wash</label>
        <label class="checkbox-label"><input type="radio" name="q2" value="Exterior Wash"> Exterior Wash</label>
        <label class="checkbox-label"><input type="radio" name="q2" value="Interior Cleaning"> Interior Cleaning</label>
        <label class="checkbox-label"><input type="radio" name="q2" value="Full detailing"> Full detailing</label>
        <label class="checkbox-label"><input type="radio" name="q2" value="Other"> Other: 
            <input type="text" name="q2_text" class="text-specify" placeholder="Specify...">
        </label>

        <h3>3. Service Feedback:</h3>
        <table>
            <tr>
                <th>Statement</th>
                <th>Most of the time</th>
                <th>Some of the time</th>
                <th>Never</th>
            </tr>
            <tr>
                <td>a. I have to queue for a long time</td>
                <td><input type="radio" name="q3a" value="Most" required></td>
                <td><input type="radio" name="q3a" value="Some"></td>
                <td><input type="radio" name="q3a" value="Never"></td>
            </tr>
            <tr>
                <td>b. Cost was explained before service</td>
                <td><input type="radio" name="q3b" value="Most" required></td>
                <td><input type="radio" name="q3b" value="Some"></td>
                <td><input type="radio" name="q3b" value="Never"></td>
            </tr>
            <tr>
                <td>c. Waiting area is comfortable</td>
                <td><input type="radio" name="q3c" value="Most" required></td>
                <td><input type="radio" name="q3c" value="Some"></td>
                <td><input type="radio" name="q3c" value="Never"></td>
            </tr>
            <tr>
                <td>d. Staff handled the vehicle carefully</td>
                <td><input type="radio" name="q3d" value="Most" required></td>
                <td><input type="radio" name="q3d" value="Some"></td>
                <td><input type="radio" name="q3d" value="Never"></td>
            </tr>
            <tr>
                <td>e. The general service is good</td>
                <td><input type="radio" name="q3e" value="Most" required></td>
                <td><input type="radio" name="q3e" value="Some"></td>
                <td><input type="radio" name="q3e" value="Never"></td>
            </tr>
            <tr>
                <td>f. Price matches the quality of service</td>
                <td><input type="radio" name="q3f" value="Most" required></td>
                <td><input type="radio" name="q3f" value="Some"></td>
                <td><input type="radio" name="q3f" value="Never"></td>
            </tr>
        </table>

        <button type="submit" name="submit_survey" class="submit-btn">Submit Questionnaire</button>
        <p style="text-align:center; margin-top:20px;"><a href="result.php">View Previous Submissions</a></p>
    </form>
</div> </body>
</html>