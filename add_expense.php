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
        $query = mysqli_query($conn, "INSERT INTO tblexpenses(user_id, expense_date, expense_item, cost,creditdebit) VALUES ('$userid', '$exdate', '$item', '$itemcost','$creditdebit')");
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
            <h1 class="login-title">Add Expense</h1>

            <label>Amount</label>
            <input type="text" class="login-input" name="cost" required>
            <label>Credit/Debit</label>

            <div id="">
                <select id="select-input" style="width: 100%;
padding: 12px;
background: white;
margin-bottom: 25px;
border: 1px solid #ccc;" name='creditdebit'>

                    <option value="credit">Credit</option>
                    <option value="debit">Dabit</option>

                </select>
            </div>
            <label>Date of Expense</label>
            <input type="date" class="login-input" name="expense_date" required>
            <label>Note</label>
            <input list="suggestions" type="text" class="login-input" name="expense_item" required>
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