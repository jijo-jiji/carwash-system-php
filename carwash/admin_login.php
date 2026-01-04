<?php
session_start();
include 'db.php'; // Ensure this file is present and working

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check admin table
    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['admin_name'] = $row['username'];
        
        // Redirect to the Admin View
        header("Location: admin_view.php"); 
    } else {
        echo "<script>alert('Invalid Admin Credentials');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-card" style="border-top: 5px solid #e74c3c;"> <h2>Admin Access</h2>
        <form method="POST">
            <div class="input-group">
                <label>Admin Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login" style="background-color: #c0392b;">Login as Admin</button>
        </form>
        <p style="margin-top:15px;"><a href="index.html">← Back Home</a></p>
    </div>

</body>
</html>