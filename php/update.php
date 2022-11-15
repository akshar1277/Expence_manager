
<?php

session_start();
error_reporting(0);
include('../confs/config.php');
$userid = $_SESSION['detsuid'];

$uploadOk = 1;
//check file already in data base or not
$result_count = mysqli_query(
  $conn,
  "SELECT COUNT(*) As total_records FROM user_img WHERE user_id='$userid' "
);

$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];



$path = '../upload/' . $userid;

if (!file_exists($path)) {
  mkdir($path, 0777, true);
}

$target_dir = $path;
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if ($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}


// Allow certain file formats
if (
  $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif"
) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
  header("location: ../profile.php");
}

if ($total_records > 0) {
  $sql = mysqli_query($conn, "SELECT url FROM user_img WHERE user_id = '$userid'");
  $result = mysqli_fetch_array($sql);
  $old_url = $result['url'];
  $old_file = "../upload/$old_url";
  unlink($old_file);
  $delquery = mysqli_query($conn, "DELETE FROM user_img WHERE user_id = '$userid'");
}




// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
} else {


  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";

    $fileurl = $userid . $_FILES["fileToUpload"]["name"];
    $query = mysqli_query($conn, "INSERT INTO `user_img`( `user_id`, `url`) VALUES ('$userid','$fileurl') ");
    header("location: ../profile.php");
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
