<?php
require('top.php');
if(isset($_SESSION['USER_LOGIN']))
{
 $user_id=$_SESSION['USER_ID'];
 $user_res=mysqli_query($con,"select * from user where id='$user_id'");
 $user_row=mysqli_fetch_assoc($user_res);
 $user_name=$user_row['name'];
 
}
if(isset($_GET['catid'])){
    $category_id=get_safe_value($con,$_GET['catid']);
}
if(isset($_GET['action']) && ($_GET['id'])){
    $action=get_safe_value($con,$_GET['action']);
    $id=get_safe_value($con,$_GET['id']);
    if($action=='delete'){
        $res=mysqli_query($con,"select * from items where id='$id'");
        $row=mysqli_fetch_assoc($res);
        $cat_id=$row['catid'];
        $id=$row['id'];
        $item_res=mysqli_query($con,"SELECT * FROM `items_info` where item_id='$id'");
        $item_row=mysqli_fetch_assoc($item_res);
        $catres=mysqli_query($con,"SELECT * FROM `category` where id='$cat_id'");
        $cat_row=mysqli_fetch_assoc($catres);
        $cat_name=$cat_row['name'];
        $code=$item_row['item_code'];
        $model=$row['model'];
        $qty=$item_row['item_number'];
        $price=$item_row['price_per_one'];
        date_default_timezone_set('Asia/Yangon');
        $added_on = date('Y-m-d H:i:s');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        mysqli_query($con,"DELETE FROM `items` WHERE id='$id'");
        mysqli_query($con,"DELETE FROM `items_info` WHERE item_id='$id'");


        $recordDetails = "$user_name သည် $cat_name အမျိုးအစား Brand Model No $model ၊ Code No $code ၊အရေအတွက် $qty ခု ၊ တစ်ခု ဈေးနှုန်း $price အား ဖျက်သိမ်းခဲ့ပါသည်။";
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
                $user_res=mysqli_query($con,"select * from user where id='$user_id'");
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
                      <a href="edit_product.php" class="sell_btn">+အသစ်ထည့်သွင်းမည်</a>  
                    </ul>
                </div>
                
            </div>

            

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>အမျိုးအစားလိုက်စာရင်း</h3>
                        <i class='bx bx-filter'></i>
                        <i class='bx bx-search'></i>
                        <input type="text" id="message-search" placeholder="Search by product name" style="padding:0.2rem;outline:none;border-radius:5px;border:0.5px solid gray">
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Code No</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Quantity</th>
                                <th>Price per one</th>
                                <th>နောက်ဆုံးပြင်ဆင်ခဲ့သည့်ရက်စွဲ</th>
                                
                                
                                
                            </tr>
                        </thead>
                        <tbody id="data">
                            <?php
                            $res=mysqli_query($con,"SELECT * FROM `items` where catid='$category_id' order by catid asc");
                            while($row=mysqli_fetch_assoc($res)){
                                $cat_id=$row['catid'];
                                $id=$row['id'];
                                $item_res=mysqli_query($con,"SELECT * FROM `items_info` where item_id='$id'");
                                $item_row=mysqli_fetch_assoc($item_res);
                                $catres=mysqli_query($con,"SELECT * FROM `category` where id='$cat_id'");
                                $cat_row=mysqli_fetch_assoc($catres);
                                
                            ?>
                            <tr>
                                <td id="pname"><?php echo $item_row['item_code'] ?></td>
                                <td id="pname"><?php echo $cat_row['name'] ?></td>
                                <td id="pname"><?php echo $row['model'] ?></td>
                                <td id="pname"><?php echo $item_row['item_number'] ?></td>
                                <td id="pname"> <?php echo $item_row['price_per_one'] ?></td>
                                <td id="pname"><?php 
                                    if($row['date']=='0000-00-00 00:00:00'){
                                        echo '';
                                    }else{
                                        echo $row['date'];
                                    }
                                     ?>
                                </td>
                            </tr>
                            <?php } ?>
                            
                        </tbody>
                    </table>
                </div>

                

            </div>

        </main>

    </div>

    <script src="index.js"></script>
    <script src="jquery.min.js"></script>
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