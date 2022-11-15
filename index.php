<?php
session_start();
error_reporting(0);
include('confs/config.php');
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $sql = mysqli_query($conn, "SELECT id FROM tblusers WHERE email = '$email' && password = '$password'");
    $result = mysqli_fetch_array($sql);
    if ($result > 0) {
        $_SESSION['detsuid'] = $result['id'];
        header("location:dashboard.php");
    } else {
        $msg = "Invalid Details";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/navbar.css">

</head>

<body>
    <header>
        <nav class="nav">
            <div class="container">
            <img style="height: 100px;
width: 100px;
padding-top: -67px;
border-radius: 50%;
margin-top: -25px;
margin-bottom: -25px;" src="logo/logo.png" alt="">
                <ul>

                </ul>
            </div>
        </nav>
    </header>
    <form class="form" method="post" name="login" style="margin-top: 110px;">
        <h1 class="login-title">Login</h1>
        <?php if ($msg) echo $msg; ?>
        <input type="email" name="email" class="login-input" placeholder="E-mail" autofocus required>

        <input type="password" name="password" class="login-input" placeholder="Password" required>

        <button type="submit" class="login-button" name="login">Login</button>
        <p class="link">New User?<a href="register.php">Registration</a></p>
    </form>

</body>

</html>