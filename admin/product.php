<?php
require('top.php');
if(isset($_SESSION['USER_LOGIN']))
{
 $user_id=$_SESSION['USER_ID'];
 $user_res=mysqli_query($con,"select * from admin where id='$user_id'");
 $user_row=mysqli_fetch_assoc($user_res);
 $user_name=$user_row['name'];
 
}
if(isset($_GET['action']) && ($_GET['id'])){
    $action=get_safe_value($con,$_GET['action']);
    $id=get_safe_value($con,$_GET['id']);
    date_default_timezone_set('Asia/Yangon');
    $added_on = date('Y-m-d H:i:s');
    $date = date('Y-m-d');
    $time = date('H:i:s');
    if($action=='delete'){
        $res=mysqli_query($con,"select * from category where id='$id'");
        $row=mysqli_fetch_assoc($res);
        $name=$row['name'];
        $qty=$row['qty'];        
        mysqli_query($con,"DELETE FROM `category` WHERE id='$id'");
        

        $recordDetails = "$user_name သည် $name အမျိုးအစား Brand ၊ အရေအတွက် $qty ခုအား ဖျက်သိမ်းခဲ့ပါသည်။";
        $insertRecordQuery = "INSERT INTO `edit_record`(`detail`, `date`, `time`) VALUES ('$recordDetails', '$date', '$time')";
        $recordResult = mysqli_query($con, $insertRecordQuery);
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
            <input type="checkbox" id="theme-toggle" hidden>
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
                    <h1>Product list</h1>
                    <ul class="breadcrumb">
                      <a href="edit_category.php" class="sell_btn">+အသစ်ထည့်သွင်းမည်</a>  
                    </ul>
                </div>
                
            </div>

            

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>ကုန်ပစ္စည်းစာရင်း</h3>
                        <i class='bx bx-filter'></i>
                        <i class='bx bx-search'></i>
                        <input type="text" id="message-search" placeholder="Search by product name" style="padding:0.2rem;outline:none;border-radius:5px;border:0.5px solid gray">
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>အမျိုးအမည်</th>
                                <th>အရေအတွက်</th>
                                <th>နောက်ဆုံးပြင်ဆင်ခဲ့သည့်ရက်စွဲ</th>
                                <th></th>
                                
                            </tr>
                        </thead>
                        <tbody id="data">
                        <?php
                                $res = mysqli_query($con, "SELECT * FROM `category` ORDER BY `name` ASC");
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $cat_id = $row['id'];
                                    $item_res = mysqli_query($con, "SELECT * FROM `items` WHERE catid='$cat_id'");
                                    $totalCash = 0;

                                    while ($item_row = mysqli_fetch_assoc($item_res)) {
                                        $item_id = $item_row['id'];
                                        $total_res = mysqli_query($con, "SELECT SUM(item_number) AS cash FROM `items_info` WHERE item_id='$item_id'");
                                        $total_row = mysqli_fetch_assoc($total_res);
                                        $totalCash += $total_row['cash'];
                                    }
                                ?>
                            
                            <tr>
                            <td id="pname"><a href="product_list_detail.php?catid=<?php echo $row['id'] ?>" style="color: #000;"><?php echo $row['name']; ?></a></td>
                            <td id="pname"><?php echo $totalCash; ?></td>
                            <td id="pname">
                                <?php
                                if ($row['date'] != '0000-00-00 00:00:00') {
                                    echo $row['date'];
                                }
                                ?>
                            </td>
                                <td><a href="edit_category.php?id=<?php echo $row['id'] ?>"><i class="fa-solid fa-pen"></i>Edit</a> | <a href="product.php?action=delete&id=<?php echo $row['id'] ?>"><i class="fa-solid fa-trash"></i>Delete</a></td>
                            </tr>
                            <?php } ?>
                            
                        </tbody>
                    </table>
                </div>

                

            </div>

        </main>

    </div>

    <script src="index.js"></script>
    
    <script>
            $(document).ready(function() {
            const messageSearch = $('#message-search');
            const data = $('#data tr');

            const searchMessage = () => {
                const val = messageSearch.val().toLowerCase();
                
                data.each(function() {
                    const name = $(this).find('#pname').text().toLowerCase();
                    if (name.indexOf(val) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            // Search chat
            messageSearch.on('input', searchMessage);
        });

    </script>                                                                                                   




</body>

</html>