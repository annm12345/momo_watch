<?php
require('connection.php');
require('function.php');
if(isset($_GET['id'])){
    $user_id=get_safe_value($con,$_GET['id']);
    $user_res=mysqli_query($con,"select * from user where id='$user_id'");
    $user_row=mysqli_fetch_assoc($user_res);
    $user_name=$user_row['name'];
    
    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product']) && isset($_POST['item']) && isset($_POST['quantity']) && isset($_POST['price']) && isset($_POST['cupon']) && isset($_POST['total'])) {
        $products = $_POST['product'];
        $items = $_POST['item'];
        $quantities = $_POST['quantity'];
        $prices = $_POST['price'];
        $cupons = $_POST['cupon'];
        $totals = $_POST['total'];
        date_default_timezone_set('Asia/Yangon');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        
        mysqli_query($con,"INSERT INTO `sale_list`(`uid`,`date`,`time`) VALUES ('$user_id','$date','$time')");
        $sale_id = mysqli_insert_id($con);

        for($q=0;$q<count($items);$q++){
            $item = mysqli_real_escape_string($con, $items[$q]);
            $qty = intval($quantities[$q]);
            $getItemNumberQuery = "SELECT `item_number` FROM `items_info` WHERE `item_id` = '$item'";
            $itemNumberResult = mysqli_query($con, $getItemNumberQuery);
            $row = mysqli_fetch_assoc($itemNumberResult);
            $currentItemNumber = $row['item_number'];

            // Subtract the sold quantity from the item_number
            $newItemNumber = $currentItemNumber - $qty;

            // Update the item_number in the database
            $updateItemNumberQuery = "UPDATE `items_info` SET `item_number` = $newItemNumber WHERE `item_id` = '$item'";
            mysqli_query($con, $updateItemNumberQuery);
        }

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
                $recordDetails = "$user_name သည် $product အမျိုးအစား $quantity ခုကို လျော့ဈေး $cupon ဖြင့် စုစုပေါင်း $total ဖိုးရောင်းချခဲ့ပါသည်။";
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
