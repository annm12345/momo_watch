<?php
require('../connection.php');
require('../function.php');

    if(isset($_GET['id'])){
        $user_id=get_safe_value($con,$_GET['id']);
        $user_res=mysqli_query($con,"select * from admin where id='$user_id'");
        $user_row=mysqli_fetch_assoc($user_res);
        $user_name=$user_row['name'];
    
    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product']) && isset($_POST['quantity']) && isset($_POST['price']) && isset($_POST['cupon']) && isset($_POST['total'])) {
        $products = $_POST['product'];
        $quantities = $_POST['quantity'];
        $prices = $_POST['price'];
        $cupons = $_POST['cupon'];
        $totals = $_POST['total'];
        date_default_timezone_set('Asia/Yangon');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        
        mysqli_query($con,"INSERT INTO `sale_list`(`uid`,`date`,`time`) VALUES ('$user_id','$date','$time')");
        $sale_id = mysqli_insert_id($con);

        // Loop through the data and insert each row into the database
        for ($i = 0; $i < count($products); $i++) {
            $product = mysqli_real_escape_string($con, $products[$i]);
            $quantity = intval($quantities[$i]);
            $price = floatval($prices[$i]);
            $cupon = floatval($cupons[$i]);
            $total = floatval($totals[$i]);

            // Insert sale data into the 'sale' table
            $insertSaleQuery = "INSERT INTO `sale`(`sale_id`, `product`, `quantity`, `price`, `discount`, `total`, `date`, `time`) 
                               VALUES ('$sale_id','$product','$quantity','$price','$cupon','$total','$date','$time')";
            $result = mysqli_query($con, $insertSaleQuery);

            if ($result) {
                // Insert record data into the 'record' table
                $recordDetails = "သည် $product အမျိုးအစား $quantity ခုကို လျော့ဈေး $cupon ဖြင့် စုစုပေါင်း $total ဖိုးရောင်းချခဲ့ပါသည်။";
                $insertRecordQuery = "INSERT INTO `record`(`details`, `date`, `time`) VALUES ('$recordDetails', '$date', '$time')";
                $recordResult = mysqli_query($con, $insertRecordQuery);

                if ($recordResult) {
                    echo "<script>alert('အရောင်းစာရင်းဖြည့်သွင်းခြင်းအောင်မြင်ပါသည်။');</script>";
                    echo "<script>window.location.href='index.php';</script>";
                } else {
                    echo "<script>alert('Error inserting record data: " . mysqli_error($con) . "');</script>";
                }
            } else {
                echo "<script>alert('Error inserting sale data: " . mysqli_error($con) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('အရောင်းစာရင်းဖြည့်သွင်းထားခြင်းမရှိပါ');</script>";
        echo "<script>window.location.href='sell_create.php';</script>";
    }
}
}

$con->close();
?>
