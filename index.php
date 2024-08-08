<?php
require('top.php');
if(isset($_SESSION['USER_LOGIN']))
{
 $id=$_SESSION['USER_ID'];
 
}
if(isset($_GET['id'])&& ($_GET['action']))
    {
    $id=get_safe_value($con,$_GET['id']);
    $action=get_safe_value($con,$_GET['action']);
        if($action=='delete'){
            mysqli_query($con,"DELETE FROM `sale_list` WHERE id='$id'");
            mysqli_query($con,"DELETE FROM `sale` WHERE sale_id='$id'");
            ?>
            <script>
            window.location.href="index.php";
            </script>
            <?php
        }
    }
?>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
             <!---<form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>--->
            <span>
                <?php 
                $user_res=mysqli_query($con,"select * from user where id='$id'");
                $user_row=mysqli_fetch_assoc($user_res);
                echo $user_row['name'];
                ?>
            </span>
            <div id="datetime"></div>

            <script>
                function updateDateTime() {
                    const datetimeElement = document.getElementById('datetime');
                    const now = new Date();
                    const dateOptions = { year: 'numeric', month: 'long', day: 'numeric' };
                    const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
                    const dateString = now.toLocaleDateString(undefined, dateOptions);
                    const timeString = now.toLocaleTimeString(undefined, timeOptions);
                    datetimeElement.textContent = dateString + ' ' + timeString;
                }

                // Update the date and time every second (1000 milliseconds)
                setInterval(updateDateTime, 1000);

                // Initial update
                updateDateTime();
            </script>
        </nav>

        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Sell list</h1>
                    <ul class="breadcrumb">
                        
                    </ul>
                </div>
                
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bx-cart'></i>                    
                    <?php 
                    date_default_timezone_set('Asia/Yangon');
                    $date=date('Y-m-d');
                    $list_res=mysqli_query($con,"SELECT * FROM `sale_list` where date='$date'");
                    $list_count=mysqli_num_rows($list_res);
                    ?>
                    <span class="info">
                        <h3>
                            <?php echo $list_count ?>
                        </h3>
                        <p>Today Sale List</p>
                    </span>
                </li>
                <li><i class='bx bx-server'></i>
                <?php 
                    date_default_timezone_set('Asia/Yangon');
                    $date=date('Y-m-d');
                    $product_res=mysqli_query($con,"SELECT * FROM `sale` where date='$date'");
                    $product_count=mysqli_num_rows($product_res);
                    ?>
                    <span class="info">
                        <h3>
                        <?php echo $product_count ?>
                        </h3>
                        <p>Today Sale Product</p>
                    </span>
                </li>
                <li><i class='bx bx-line-chart'></i>
                <?php 
                    date_default_timezone_set('Asia/Yangon');
                    $date=date('Y-m-d');
                    $qty_res=mysqli_query($con,"SELECT SUM(quantity) AS total_qty FROM `sale` WHERE date = '$date'");
                    $row = mysqli_fetch_assoc($qty_res);
                    $total_qty = $row['total_qty'];
                    ?>
                    <span class="info">
                        <h3>
                            <?php echo $total_qty ?>
                        </h3>
                        <p>Today Sale Quantity</p>
                    </span>
                </li>
                <li><i class='bx bx-dollar-circle'></i>
                <?php 
                    date_default_timezone_set('Asia/Yangon');
                    $date=date('Y-m-d');
                    $total_res=mysqli_query($con,"SELECT SUM(total) AS cash FROM `sale` WHERE date = '$date'");
                    $row = mysqli_fetch_assoc($total_res);
                    $total_cash = $row['cash'];
                    ?>
                    <span class="info">
                        <h3>
                        <?php echo $total_cash ?> Ks
                        </h3>
                        <p>Total Sales Cash</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->
            <div class="sell">
                <a class="sell_btn" href="sell_create.php">+အရောင်းစာရင်းသစ်ရေးသွင်းရန်</a>
            </div>
            <style>
                @media print {
                    .no-print {
                        display: none;
                    }
                }
            </style>

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>ယနေ့ရောင်းချမှုစာရင်း</h3>
                       
                    </div>
                   
                    <table style="border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>ရက်စွဲ/အချိန်</th>
                                <th colspan='4' style="text-align:center">ရောင်းချသည့်ကုန်ပစ္စည်းများ</th>
                                <th>လျော့ဈေး</th>
                                <th>စုစုပေါင်း</th>
                                <th><i class="fa-solid fa-screwdriver-wrench"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            date_default_timezone_set('Asia/Yangon');
                            $date=date('Y-m-d');
                            $res=mysqli_query($con,"SELECT * FROM `sale_list` where date='$date' order by id desc");
                            while($row=mysqli_fetch_assoc($res)){
                                $id=$row['id'];
                                $uid=$row['uid'];
                                $saler_res=mysqli_query($con,"select * from user where id='$uid'");
                                $saler_row=mysqli_fetch_assoc($saler_res);
                               
                            ?>
                            <tr style="border-top:1px solid #000;margin-top:10px">
                                <td>
                                    <?php echo $row['date'] ?> <?php echo $row['time'] ?>
                                </td>
                                <td>                                   
                                        <th>Model No</th>
                                        <th>အရေအတွက်</th>
                                        <th>တစ်ခုဈေး</th>                                    
                                </td>
                                <td></td>
                                <td></td>
                                <td> <a href="print.php?id=<?php echo $id ?>"><i class="fa-solid fa-print" style="padding:0.5rem;border-radius:5px;border:none;background:blue;margin-top:1rem;margin-left:1rem;color:#fff"></i></button>  |<a href="index.php?action=delete&id=<?php echo $id ?>"><i class="fa-solid fa-trash" style="padding:0.5rem;border-radius:5px;border:none;background:red;margin-top:1rem;margin-left:1rem;color:#fff"></i></a></td>
                                <?php
                                $totalDiscount = 0; 
                                $totalAmount = 0; 
                                
                                $sale_res=mysqli_query($con,"SELECT * FROM `sale` where sale_id=$id  order by id asc");
                                while($sale_row=mysqli_fetch_assoc($sale_res)){
                                ?>
                                <tr>
                                    <td></td>
                                    <td>
                                        <td><?php echo $sale_row['product'] ?></td>
                                        <td><?php echo $sale_row['quantity'] ?></td>
                                        <td><?php echo $sale_row['price'] ?></td>
                                    </td>
                                    <td><span class="status completed"><?php echo $sale_row['discount'] ?></span></td>
                                    <td><?php echo $sale_row['total'] ?></td>
                                    <td>
                                   
                                    </td>
                                    
                                </tr>
                                
                                <?php 
                                 $totalDiscount += $sale_row['discount'];
                                 $totalAmount += $sale_row['total']; 
                                        } ?>
                                <tr style="color:#fff;background:darkblue;">
                                    <td>ရောင်းသူ : <?php echo $saler_row['name'] ?></td>
                                    <td colspan="4">Total</td>
                                    <td><span class="status completed"><?php echo $totalDiscount; ?></span></td>
                                    <td><?php echo $totalAmount; ?></td>
                                    <td></td>
                                </tr>
                            </tr>
                            <?php
                            } ?>
                            
                        </tbody>
                    </table>
                </div>

                

            </div>

        </main>

    </div>

    <script src="index.js"></script>
    <script>
        function printRow(button) {
            const row = button.parentElement.parentElement.parentElement;
            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid #000; padding: 8px;}</style>');
            printWindow.document.write('</head><body>');

            // Create a table in the print window
            printWindow.document.write('<table>');

            printWindow.document.write(row.outerHTML);

            printWindow.document.write('</table></body></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }

        function printTableRow(button) {
            const row = button.parentElement.parentElement.parentElement;
            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid #000; padding: 8px;}</style>');
            printWindow.document.write('</head><body>');

            // Create a table in the print window
            printWindow.document.write('<table>');

            printWindow.document.write(row.outerHTML);

            printWindow.document.write('</table></body></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }
    </script>
</body>

</html>