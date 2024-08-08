<?php
require('connection.php');
require('function.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    table{
        width:80%;
        margin:auto;
    }
    th,td{
        border:1px solid black;
        text-align:center;
        padding:0.7rem;
    }
    button{
        position:absolute;
        top:1rem;
        left:1rem;
    }
    button:hover{
        cursor:pointer;
        
    }
</style>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    // Fetch the data for the selected row with the given $id
    $query = "SELECT * FROM sale_list WHERE id = $id";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Generate a print-friendly version of the row
        $printContent = "<table style='border-collapse: collapse;'>";
        $printContent .= "<thead>";
        $printContent .= "<tr style='background:lightgray'>";
        $printContent .= "<th>ရက်စွဲ/အချိန်</th>";
        $printContent .= "<th colspan='3' style='text-align:center'>ရောင်းချသည့်ကုန်ပစ္စည်းများ</th>";
        $printContent .= "<th>လျော့ဈေး</th>";
        $printContent .= "<th>စုစုပေါင်း</th>";
        $printContent .= "</tr>";
        $printContent .= "</thead>";
        $printContent .= "<tbody>";
        $printContent .= "<tr>";
        $printContent .= "<td>". $row['date'] . " ".$row['time'] . "</td>";
        $printContent .= "<th style='background:lightyellow'>Model No</th>";
        $printContent .= "<th style='background:lightyellow'>အရေအတွက်</th>";
        $printContent .= "<th style='background:lightyellow'>တစ်ခုဈေး</th>";
        $printContent .= "<td></td>";
        $printContent .= "<td></td>";
        $printContent .= "<button style='border:none;background:none' onclick='window.print()'><i class='fa-solid fa-print' style='padding:1rem;border-radius:5px;border:none;background:blue;margin-top:1rem;margin-left:1rem;color:#fff;font-size:1.3rem;'></i></button>";
        $printContent .= "</tr>";

        $uid=$row['uid'];
        $saler_res=mysqli_query($con,"select * from user where id='$uid'");
        $saler_row=mysqli_fetch_assoc($saler_res);
       
        $totalDiscount = 0; 
        $totalAmount = 0; 
        $sale_res=mysqli_query($con,"SELECT * FROM `sale` where sale_id=$id order by id asc");
        while($sale_row=mysqli_fetch_assoc($sale_res)){
        // Add data from the selected row to the print content        
       $printContent .= "<tr>";
       $printContent .= "<td></td>";
       
       $printContent .= "<td >".$sale_row['product']."</td>";
       $printContent .= "<td>".$sale_row['quantity'] ."</td>";
       $printContent .= "<td>".$sale_row['price'] ."</td>";
   
       $printContent .= "<td><span class='status completed'>".$sale_row['discount'] ."</span></td>";
       $printContent .= "<td>".$sale_row['total'] ."</td>";
        
       $printContent .= "</tr>";
       
       $totalDiscount += $sale_row['discount'];
       $totalAmount += $sale_row['total']; 
    
        }
        $printContent .= "<tr>";
       
                                      
       $printContent .= "<tr style='color:#darkblue;background:lightgreen;font-weight:bold;'>";
       $printContent .= "<td>ရောင်းသူ: ". $saler_row['name']."</td>";
       $printContent .= "<td colspan='3'>Total</td>";
       $printContent .= "<td><span class='status completed'>".$totalDiscount ."</span></td>";
       $printContent .= "<td>".$totalAmount ."</td>";
       $printContent .= "</tr>";

        $printContent .= "</table>";

        // Display the print button and trigger the print action
        $printContent .= "<button style='border:none;background:none' onclick='window.print()'><i class='fa-solid fa-print' style=padding:1rem;border-radius:5px;border:none;background:blue;margin-top:1rem;margin-left:1rem;color:#fff;font-size:1.3rem;'></i></button>";

        // Display the generated content
        echo $printContent;
    } else {
        echo "Row with ID $id not found.";
    }
} else if(isset($_GET['to'])&& ($_GET['from']))
    {
    $from=get_safe_value($con,$_GET['from']);
    $to=get_safe_value($con,$_GET['to']);
    

    // Fetch the data for the selected row with the given $id
    $query = "SELECT * FROM `sale_list` WHERE date BETWEEN '$from' AND '$to' ";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        // Generate a print-friendly version of the row
        $id=$row['id'];
        $printContent = "<table style='border-collapse: collapse;'>";
        $printContent .= "<thead>";
        $printContent .= "<tr style='background:lightgray'>";
        $printContent .= "<th>ရက်စွဲ/အချိန်</th>";
        $printContent .= "<th colspan='3' style='text-align:center'>ရောင်းချသည့်ကုန်ပစ္စည်းများ</th>";
        $printContent .= "<th>လျော့ဈေး</th>";
        $printContent .= "<th>စုစုပေါင်း</th>";
        $printContent .= "</tr>";
        $printContent .= "</thead>";
        $printContent .= "<tbody>";
        $printContent .= "<tr>";
        $printContent .= "<td>". $row['date'] . " ".$row['time'] . "</td>";
        $printContent .= "<th style='background:lightyellow'>Model No</th>";
        $printContent .= "<th style='background:lightyellow'>အရေအတွက်</th>";
        $printContent .= "<th style='background:lightyellow'>တစ်ခုဈေး</th>";
        $printContent .= "<td></td>";
        $printContent .= "<td></td>";
        $printContent .= "<button style='border:none;background:none' onclick='window.print()'><i class='fa-solid fa-print' style='padding:1rem;border-radius:5px;border:none;background:blue;margin-top:1rem;margin-left:1rem;color:#fff;font-size:1.3rem;'></i></button>";
        $printContent .= "</tr>";

        $uid=$row['uid'];
        $saler_res=mysqli_query($con,"select * from user where id='$uid'");
        $saler_row=mysqli_fetch_assoc($saler_res);
        $totalDiscount = 0; 
        $totalAmount = 0; 
        $sale_res=mysqli_query($con,"SELECT * FROM `sale` where sale_id=$id order by id desc");
        while($sale_row=mysqli_fetch_assoc($sale_res)){
        // Add data from the selected row to the print content        
       $printContent .= "<tr>";
       $printContent .= "<td></td>";
       
       $printContent .= "<td >".$sale_row['product']."</td>";
       $printContent .= "<td>".$sale_row['quantity'] ."</td>";
       $printContent .= "<td>".$sale_row['price'] ."</td>";
   
       $printContent .= "<td><span class='status completed'>".$sale_row['discount'] ."</span></td>";
       $printContent .= "<td>".$sale_row['total'] ."</td>";
        
       $printContent .= "</tr>";
       
       $totalDiscount += $sale_row['discount'];
       $totalAmount += $sale_row['total']; 
    
        }
        $printContent .= "<tr>";
       
                                      
       $printContent .= "<tr style='color:#darkblue;background:lightgreen;font-weight:bold;'>";
       $printContent .= "<td>ရောင်းသူ: ". $saler_row['name']."</td>";
       $printContent .= "<td colspan='3'>Total</td>";
       $printContent .= "<td><span class='status completed'>".$totalDiscount ."</span></td>";
       $printContent .= "<td>".$totalAmount ."</td>";
       $printContent .= "</tr>";

        $printContent .= "</table>";

        // Display the print button and trigger the print action
        $printContent .= "<button style='border:none;background:none' onclick='window.print()'><i class='fa-solid fa-print' style=padding:1rem;border-radius:5px;border:none;background:blue;margin-top:1rem;margin-left:1rem;color:#fff;font-size:1.3rem;'></i></button>";

        // Display the generated content
        echo $printContent;
    } 
} else {
    echo "No ID specified.";
}
?>

