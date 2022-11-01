
<?php

session_start();
error_reporting(0);
include('confs/config.php');

if(strlen($_SESSION['detsuid'] == 0)):
    header("location: logout.php");
else:
    if(isset($_GET['delid'])) {
        $rowid = intval($_GET['delid']);
        $query = mysqli_query($conn, "DELETE FROM tblexpenses WHERE id = '$rowid'");
        if($query) {
            // echo "<script>alert('Record successfully deleted.');</script>";
            // echo "<script>window.location.href='manage-expense.php'</script>";
            // header('location:manage-expense.php');
            $msg = "A record deleted.";
        }else {
            $msg = "Something went wrong. Please try again!";
            // echo "<script>alert('Something went wrong. Please try again!');</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/table.css">
   <link rel="stylesheet" href="css/pagination.css">
    <title>index</title>
</head>
<body>
<?php
include("navbar.php")

?>
<?php
$uid = $_SESSION['detsuid'];
//this is for user name
$sql = mysqli_query($conn, "SELECT name FROM tblusers WHERE id = '$uid'");
$result = mysqli_fetch_array($sql);
$name = $result['name'];
?>
    <h1 style="text-align: left; margin-left: 60px;padding:1rem;">Hello <?php echo $name; ?> </h1>
    <div class="container">
       <div class="row">
       <?php
                    #Monthly Expense
                        $userid=$_SESSION['detsuid'];
                        $creditdebit=$_SESSION['creditdebit'];
                        $monthdate=  date("Y-m-d", strtotime("-4 month")); 
                        $crrntdte=date("Y-m-d");
                        // (expense_date BETWEEN '$monthdate' AND '$crrntdte') &&
                        $query3=mysqli_query($conn,"SELECT sum(cost) AS monthlyexpense FROM tblexpenses WHERE  (user_id='$userid') && creditdebit='credit' ") ;
                        $result3=mysqli_fetch_array($query3);
                        $sum_monthly_expense=$result3['monthlyexpense'];
                    ?>
            <div id="credit" class="col-6">Total credit
               <p id="total1">
               <?php if($sum_monthly_expense==""){
                                echo "0";
                                } else {
                                    echo $sum_monthly_expense;
                                }
                   
                            ?>
               </p> 
            </div>
            <?php
                    #Monthly Expense
                        $userid=$_SESSION['detsuid'];
                        $creditdebit=$_SESSION['creditdebit'];
                        $monthdate2=  date("Y-m-d", strtotime("-4 month")); 
                        $crrntdte2=date("Y-m-d");
                        // (expense_date BETWEEN '$monthdate2' AND '$crrntdte2') && 
                        $query2=mysqli_query($conn,"SELECT sum(cost) AS monthlyexpense2 FROM tblexpenses WHERE (user_id='$userid') && creditdebit='debit' ") ;
                        $result2=mysqli_fetch_array($query2);
                        $sum_monthly_expense2=$result2['monthlyexpense2'];
                    ?>
            <div id="debit" class="col-6">Total debit
            <p id="total2">
            <?php if($sum_monthly_expense2==""){
                                echo "0";
                                } else {
                                    echo $sum_monthly_expense2;
                                }
                   
                            ?>
               </p> 
            </div>
        
       </div>

       <div class="row" id="record" class="col-12">
        <p id="add_record" > <a style="text-decoration: none;" href="add_expense.php"> Add reacord</a></p>
       </div>
            
    </div>


   
   

    <div class="container" style="margin-top: 45px;">
    
  <table class="rwd-table">
    <tbody>
  
      <tr>
        <th>id</th>
        <th>Amount</th>
        <th>credit/debit</th>
        <th>Date</th>
        <th>Note</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
      <?php
    if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
        } else {
            $page_no = 1;
            }
    
    $total_records_per_page = 10;
    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";

    $userid=$_SESSION['detsuid'];
    $result_count = mysqli_query(
        $conn,
        "SELECT COUNT(*) As total_records FROM tblexpenses WHERE user_id='$userid' "
        );

    $total_records = mysqli_fetch_array($result_count);
    $total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1; 

    // $result = mysqli_query($conn,"SELECT * FROM `tblexpenses`  WHERE user_id='$userid' LIMIT $offset, $total_records_per_page");
    $userid=$_SESSION['detsuid'];
    $ret=mysqli_query($conn,"SELECT * FROM tblexpenses WHERE user_id='$userid'  LIMIT $offset, $total_records_per_page    ");
    $cnt=1;
    while ($row=mysqli_fetch_array($ret)):
    
     
                    
    ?>   
      <tr>
      <td data-th="id"><?php echo $cnt;?></td>
        <td data-th="Amount">
        <?php echo $row["cost"]; ?>
        </td>
        <td data-th="crdit/debit">
        <?php echo $row["creditdebit"]; ?>
        </td>
        <td data-th="Date">
        <?php echo $row["expense_date"]; ?>
        </td>
        <td data-th="Note">
        <?php echo $row["expense_item"]; ?>
        </td>
        <td data-th="Edit">
            <p id="edit"  ><a style="text-decoration: none ; color:white;" href="edit.php?editid=<?php echo $row['id'];?>">Edit</a></p>
          
        </td>
        <td data-th="Delete">
        <p id="delete"><a style="text-decoration: none ; color:white;" href="dashboard.php?delid=<?php echo $row['id'];?>">Delete</a></p>
        </td>
      </tr>
      <?php 
        $cnt=$cnt+1;
        endwhile; 
        ?>  
      
    </tbody>
  </table>
  <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>
  <ul class="pagination" style="margin-top: 45px;">
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
	<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}                  
       }
       echo "<li><a>...</a></li>";
	   echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
	   echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>



</div>
</body>
</html>
<?php endif; ?>