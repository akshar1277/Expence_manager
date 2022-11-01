<?php 
session_start();
error_reporting(0);
include('confs/config.php');
if(strlen($_SESSION['detsuid']==0)):
    header("location: logout.php");
else:
    if(isset($_POST['submit'])) {
        

       
       
    }    
?>
<?php
    //this is for photo
    $uid = $_SESSION['detsuid'];
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
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <?php include("navbar.php") ?>
    <div id='photodiv' >
        <img id="profileImg"  src="./upload/<?php echo $photo_url ?>" alt="">
    </div>
    <form  action="php/update.php"
    	      method="post"
    	      enctype="multipart/form-data">

    <!-- <div style="height:0px;overflow:hidden"> -->
    <div id="filediv">
    <input id="fileInput" type="file" 
		           class=""
		           name="fileToUpload"
                   id="fileToUpload"> 
    </div>
   
                   
    
    <div id="buttondiv">
        <button id="update" type="submit" >Update</button>
        </form>
        <form action="php/remove.php"
    	      method="post"
    	      enctype="multipart/form-data">
        <button id="remove">Remove</button>
        </form>
    </div> 
   


    <!-- <div id="buttondiv">
        <button>cancel</button>
    </div> -->
    <script>
        function chooseFile() {
            document.getElementById("fileInput").click();
   }
</script>
    
</body>
</html>
<?php endif; ?>