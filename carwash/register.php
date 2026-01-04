<?php
include 'db.php';
session_start();

// PHP Validation (Layer 3)
if (isset($_POST['submit'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $name = $_POST['cust_name'];
    $hp = $_POST['cust_hp'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $work = $_POST['work']; // Mapped to Vehicle Type per schema strategy

    // Check if any field is empty using PHP empty() function 
    if (empty($user) || empty($pass) || empty($name) || empty($hp) || empty($age) || empty($gender) || empty($work)) {
        echo "<script>alert('Please enter all fields');</script>"; // [cite: 35]
    } else {
        // Insert into customer table
        $sql = "INSERT INTO customer (username, password, cust_name, cust_hp, age, gender, work) 
                VALUES ('$user', '$pass', '$name', '$hp', '$age', '$gender', '$work')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Registration Successful!'); window.location='login.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-card">
    <h2>Create Account</h2>
    <form name="regForm" method="POST" onsubmit="return check()">
        
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="input-group">
            <label>Full Name</label>
            <input type="text" name="cust_name" required>
        </div>

        <div class="input-group">
            <label>Phone Number</label>
            <input type="text" name="cust_hp" required>
        </div>

        <div class="input-group">
            <label>Age</label>
            <input type="number" name="age" required>
        </div>

        <div class="input-group">
            <label>Gender</label>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="input-group">
            <label>Vehicle Type</label>
            <select name="work" required>
                <option value="Sedan">Sedan</option>
                <option value="SUV">SUV</option>
                <option value="MPV">MPV</option>
            </select>
        </div>

        <button type="submit" name="submit">Register Now</button>
    </form>
    <p style="margin-top:15px; font-size:14px;">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div>

</body>
</html>