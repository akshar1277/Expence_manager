<?php

session_start();
error_reporting(0);
include('confs/config.php');

if (strlen($_SESSION['detsuid'] == 0)) :
  header("location: logout.php");
else :
  $uid = $_SESSION['detsuid'];
  //this is for user name
  $sql = mysqli_query($conn, "SELECT name FROM tblusers WHERE id = '$uid'");
  $result = mysqli_fetch_array($sql);
  $name = $result['name'];
  //this is for photo
  $photo = mysqli_query($conn, "SELECT url FROM user_img WHERE user_id = '$uid'");
  $img = mysqli_fetch_array($photo);
  $photo_url = $img['url'];

?>




  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>

  <body>
    <nav class="nav">
      <div class="container">
        <!-- <h1 class="logo"><a href="dashboard.php">My Website</a></h1> -->
        <a href="dashboard.php"><img style="height: 100px;
width: 100px;
padding-top: -67px;
border-radius: 50%;
margin-top: -38px;
margin-bottom: -40px;" src="logo/logo.png" alt=""></a>
        <ul>
          <li><img id="user_image" style="object-fit: cover;" src="./upload/<?php echo $photo_url ?>" alt=""></li>
          <div class="dropdown">
            <button class="dropbtn" style="font-weight:bold;">Hello <?php echo $name; ?>
              <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
              <a href="#"></a>
              <a href="profile.php">Update profile</a>
              <a href="logout.php">Logout</a>
            </div>
          </div>

        </ul>
      </div>
    </nav>

  </body>

  </html>
<?php endif; ?>