<?php
session_start();
error_reporting(0);
include('confs/config.php');
if (strlen($_SESSION['detsuid'] == 0)) :
    header("location: logout.php");
else :
    if (isset($_POST['submit'])) {
        $userid = $_SESSION['detsuid'];
        $exdate = $_POST['expense_date'];
        $item = $_POST['expense_item'];
        $itemcost = $_POST['cost'];
        $creditdebit = $_POST['creditdebit'];
        $editid = intval($_GET['editid']);



        $query = mysqli_query($conn, "UPDATE `tblexpenses` SET `expense_date`='$exdate',`expense_item`='$item',`cost`='$itemcost',`creditdebit`='$creditdebit' WHERE `id`='$editid' && `user_id`='$userid'   ");




        if ($query) {
            echo "<script>alert('Expense has been added');</script>";
            header("location: dashboard.php");
        } else {
            echo "<script>alert('Something went wrong. Please try again!');</script>";
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add expense</title>
        <link rel="stylesheet" href="css/login.css">

    </head>

    <body>
        <?php
        include("navbar.php")

        ?>

        <form class="form" method="post" style="margin-top: 100px;">
            <?php
            $editid = intval($_GET['editid']);
            $getitem = mysqli_query($conn, "SELECT * FROM tblexpenses WHERE id='$editid' ");
            $item = mysqli_fetch_array($getitem)
            ?>
            <h1 class="login-title">Edit expense</h1>

            <label>Amount</label>
            <input type="text" class="login-input" value="<?php echo $item["cost"]; ?>" name="cost" required>
            <label>Credit/Debit</label>

            <div id="">
                <select id="select-input" value="<?php echo $item["creditdebit"]; ?>" style="width: 100%;
padding: 12px;
background: white;
margin-bottom: 25px;
border: 1px solid #ccc;" name='creditdebit'>

                    <option value="credit">Credit</option>
                    <option value="debit">Dabit</option>

                </select>
            </div>
            <label>Date of Expense</label>
            <input type="date" class="login-input" value="<?php echo $item["expense_date"]; ?>" name="expense_date" required>
            <label>Note</label>
            <input type="text" list="suggestions" class="login-input" value=" <?php echo $item["expense_item"]; ?>" name="expense_item" required>
            <datalist id="suggestions">
                <option value="Salary">Salary</option>
                <option value="Shopping">Shopping</option>
                <option value="Grocery">Grocery</option>
                <option value="Fuel">Fuel</option>
                <option value="Interest">Interest</option>
                <option value="Insurance">Insurance</option>
                <option value="Premium">Premium</option>
                
            </datalist>
            <button type="submit" class="login-button" name="submit">Add</button>

        </form>

    </body>

    </html>
<?php endif; ?>