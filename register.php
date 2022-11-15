<?php

session_start();
error_reporting(0);
include('confs/config.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $password = md5($_POST['password']);

    $ret = mysqli_query($conn, "SELECT email from tblusers WHERE email = '$email'");
    $result = mysqli_fetch_array($ret);
    if ($result > 0) {
        $msg = "This e-mail is associated with another account";
    } else {
        $sql = mysqli_query($conn, "INSERT INTO tblusers (name, email, password) VALUES ('$name', '$email', '$password')");
        if ($sql) {
            $msg = "You have successfully registered";
            header("location:index.php");
        } else {
            $msg = "Something went wrong. Please try again!";
        }
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
    <form style="margin-top: 92px;" class="form" role="form" method="post" name="register" onsubmit="return checkpass();">
        <h1 class="login-title">Register</h1>
        <input type="text" class="login-input" name="name" placeholder="Your Name" autofocus required>
        <input type="email" class="login-input" name="email" placeholder="Your E-mail" required>

        <input type="password" class="login-input" name="password" placeholder="Type Password" required>
        <input type="password" class="login-input" name="repeatpassword" placeholder="Repeat Password" required>

        <button type="submit" class="login-button" name="submit">Register</button>
        <p class="link"><a href="index.php">Go to login</a></p>
    </form>
    <script>
        function checkpass() {
            if (document.register.password.value != document.register.repeatpassword.value) {
                alert('Repeat password field does not match to password!');
                document.register.repeatpassword.focus();
                return false;
            } else return true;
        }
    </script>

</body>

</html>