<?php
require('connection.php');
if (isset($_GET['model'])) {
    $modelNo = $_GET['model'];
    
    $res=mysqli_query($con,"SELECT * FROM `items_info` WHERE item_id='$modelNo'");
    $row=mysqli_fetch_assoc($res);
    $price=$row['price_per_one'];

    // Return the price as JSON
    echo json_encode(['price' => $price]);
}
?>