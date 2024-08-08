<?php
require('connection.php');
require('function.php');
if(isset($_SESSION['USER_LOGIN']))
{
 $id=$_SESSION['USER_ID'];
 
}else
{
   
  ?>
  <script>
    window.location.href='login/login.php';
  </script>
  
  <?php
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome-free-6.6.0-web/css/all.min.css" />
    <script src="jquery.min.js"></script>
    <title>MoMo Watch Store</title>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo" style="text-align:center;margin-top:0.5rem;">
            
            <div class="logo-name">
            <i class="fa-solid fa-shop"></i>
                <span>MoMo <br>
                </span>Watch Store 
            </div>
        </a>
        <ul class="side-menu">
            <li><a href="index.php"><i class="fa-solid fa-cart-shopping"></i>အရောင်းစာရင်း</a></li>
            <li><a href="product.php"><i class="fa-solid fa-server"></i>ကုန်ပစ္စည်းစာရင်း</a></li>
            <li><a href="product_list.php"><i class="fa-solid fa-server"></i>အမျိုးအစားလိုက်စာရင်း</a></li>
            <li class=""><a href="month_list.php"><i class="fa-solid fa-clipboard"></i>စာရင်းပေါင်းချုပ်</a></li>
            <li class=""><a href="record.php"><i class="fa-solid fa-pen-to-square"></i>မှတ်တမ်း</a></li>
            <li><a href="login/logout.php"><i class="fa-solid fa-gear"></i>Go to admin site</a></li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="login/logout.php" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->