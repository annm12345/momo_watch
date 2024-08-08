<?php
require('top.php');
if(isset($_SESSION['USER_LOGIN']))
{
 $user_id=$_SESSION['USER_ID'];
 
}

$id='';
$total_qty='';
$total_cash='';
$total_discount='';
$fromDate='';
$toDate='';
if(isset($_GET['id'])&& ($_GET['action']))
    {
    $id=get_safe_value($con,$_GET['id']);
    $action=get_safe_value($con,$_GET['action']);
        if($action=='delete'){
            mysqli_query($con,"DELETE FROM `sale_list` WHERE id='$id'");
            mysqli_query($con,"DELETE FROM `sale` WHERE sale_id='$id'");
            ?>
            <script>
            window.location.href="month_list.php";
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
                $user_res=mysqli_query($con,"select * from admin where id='$user_id'");
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
            <style>
                form {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                }

                label {
                    margin-right: 10px;
                }

                input[type="date"] {
                    padding: 5px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                }

                input[type="submit"] {
                    background-color: #007BFF;
                    color: #fff;
                    border: none;
                    margin-left:2rem;
                    border-radius: 5px;
                    padding: 5px 10px;
                    cursor: pointer;
                }

                input[type="submit"]:hover {
                    background-color: #0056b3;
                }
            </style>
                <div>
                <h4>ရက်အလိုက်၊ အပတ်လိုက်၊ လအလိုက်၊ နှစ်အလိုက် စာရင်းပေါင်းချုပ်ကြည့်ရန်</h4> <br>
                </div>
                <div>
                   <form action="" method="post">
                        <label for="from">From:</label>
                        <input type="date" name="from" id="from" required>
                        <label for="to">To:</label>
                        <input type="date" name="to" id="to" required>
                        <input type="submit" name="between_Find" value="Find">
                    </form> 
                </div>
                    
            </ul>
            
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
                        <h3>စာရင်းပေါင်းချုပ်</h3>
                        
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
                                if (isset($_POST['between_Find'])) {
                                $fromDate = $_POST['from'];
                                $toDate = $_POST['to'];
                                $res=mysqli_query($con,"SELECT * FROM `sale_list` WHERE date BETWEEN '$fromDate' AND '$toDate' order by id desc");
                            while($row=mysqli_fetch_assoc($res)){
                                $id=$row['id'];
                                $qty_res=mysqli_query($con,"SELECT SUM(quantity) AS total_qty FROM `sale` WHERE date BETWEEN '$fromDate' AND '$toDate'");
                                $qty_row = mysqli_fetch_assoc($qty_res);
                                $total_qty = $qty_row['total_qty'];
                                $total_res=mysqli_query($con,"SELECT SUM(total) AS cash FROM `sale` WHERE date BETWEEN '$fromDate' AND '$toDate'");
                                $total_row = mysqli_fetch_assoc($total_res);
                                $total_cash = $total_row['cash'];
                                $discount_res=mysqli_query($con,"SELECT SUM(discount) AS discounts FROM `sale` WHERE date BETWEEN '$fromDate' AND '$toDate'");
                                $discount_row = mysqli_fetch_assoc($discount_res);
                                $total_discount = $discount_row['discounts'];
                                $fromDate=$_POST['from'];
                                $toDate = $_POST['to'];
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
                                <td> <a href="print.php?id=<?php echo $id ?>"><i class="fa-solid fa-print" style="padding:0.5rem;border-radius:5px;border:none;background:blue;margin-top:1rem;margin-left:1rem;color:#fff"></i></button>  |<a href="month_list.php?action=delete&id=<?php echo $id ?>"><i class="fa-solid fa-trash" style="padding:0.5rem;border-radius:5px;border:none;background:red;margin-top:1rem;margin-left:1rem;color:#fff"></i></a></td>
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
                                    <td></td>
                                    <td colspan="4">Total</td>
                                    <td><span class="status completed"><?php echo $totalDiscount; ?></span></td>
                                    <td><?php echo $totalAmount; ?></td>
                                    <td></td>
                                </tr>
                            </tr>
                            
                            <?php
                            } } ?>
                            <?php 
                            if($fromDate==$toDate){
                                ?>
                                <h4><?php echo $fromDate ?> ရက်နေ့အတွက် စာရင်းပေါင်းချုပ်</h4>
                                <?php
                            }else{
                                ?>
                                <h4><?php echo $fromDate ?> မှ <?php echo $toDate ?> ရက်နေ့အထိ စာရင်းပေါင်းချုပ်</h4>
                                <?php
                            }
                            ?>
                            <div style="display:flex;padding:2rem;">
                                <div style="width:70%;display:flex;padding:0 4rem 0 4rem;">
                                    <div><p>ရောင်းရသည့်ကုန်ပစ္စည်းအရေအတွက် : </p></div>
                                    <div style="margin-left:4rem;"><span style="background: darkblue;padding:0.5rem;border-radius:5px;color:#fff"><?php echo $total_qty ?></span></div>
                                </div>
                                <div style="width:70%;display:flex;padding:0 4rem 0 4rem;">
                                    <div><p>လျော့ဈေးစုစုပေါင်း : </p></div>
                                    <div style="margin-left:4rem;"><span style="background: darkblue;padding:0.5rem;border-radius:5px;color:#fff"><?php echo $total_discount ?></span></div>
                                </div>
                                <div style="width:70%;display:flex;padding:0 4rem 0 4rem;">
                                    <div><p>ရောင်းရသည့်ငွေစုစုပေါင်း : </p></div>
                                    <div style="margin-left:4rem;"><span style="background: darkblue;padding:0.5rem;border-radius:5px;color:#fff"><?php echo $total_cash ?></span></div>
                                </div> 
                                <div>
                                    <a href="print.php?from=<?php echo $fromDate ?>&to=<?php echo $toDate ?>" style="padding:0.5rem;border-radius:5px;border:none;background:blue;margin-left:1rem;"><i class="fa-solid fa-floppy-disk" style="padding:0.5rem;font-size:1.3rem;color:#fff;"></i></a>
                                </div>
                                       
                         
                
                                
                            </div>
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