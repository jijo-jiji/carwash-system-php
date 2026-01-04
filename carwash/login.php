<?php
session_start();
// PASTE YOUR DATABASE CONNECTION HERE IF NOT USING INCLUDE
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carwash";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM customer WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['cust_id'] = $row['cust_id'];
        $_SESSION['cust_name'] = $row['cust_name'];
        header("Location: survey.php"); 
    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-card">
        <h2>Customer Login</h2>
        
        <form method="POST">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="login" class="btn-login">Login</button>
        </form>
        
        <div class="links">
            <p>Don't have an account? <a href="register.php">Register Here</a></p>
            <p>Staff Access: <a href="admin_login.php">Admin Login</a></p>
            <p><a href="index.html">← Back to Home</a></p>
        </div>
    </div>

</body>
</html>