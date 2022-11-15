<?php

session_start();
error_reporting(0);
include('../confs/config.php');
$userid = $_SESSION['detsuid'];

$result_count = mysqli_query(
    $conn,
    "SELECT COUNT(*) As total_records FROM user_img WHERE user_id='$userid' "
    );
  
  $total_records = mysqli_fetch_array($result_count);
  $total_records = $total_records['total_records'];

  if($total_records>0){
    $sql = mysqli_query($conn, "SELECT url FROM user_img WHERE user_id = '$userid'");
    $result = mysqli_fetch_array($sql);
    $old_url = $result['url'];
    $old_file="../upload/$old_url";
    unlink($old_file);
    $delquery = mysqli_query($conn, "DELETE FROM user_img WHERE user_id = '$userid'");
    header("location: ../profile.php");
  }
  else{
    header("location: ../profile.php");
  }
