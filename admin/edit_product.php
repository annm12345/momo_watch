<?php
require('top.php');
if(isset($_SESSION['USER_LOGIN']))
{
 $user_id=$_SESSION['USER_ID'];
 $user_res=mysqli_query($con,"select * from admin where id='$user_id'");
$user_row=mysqli_fetch_assoc($user_res);
$user_name=$user_row['name'];
}
$cat_id='';
$name='';
$model='';
$code='';
$qty='';
$price='';
if(isset($_GET['id'])){
    
    $id=get_safe_value($con,$_GET['id']);
    
        $res=mysqli_query($con,"select * from items where id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
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

            if(isset($_POST['create'])){
                $category=get_safe_value($con,$_POST['category']);
                $model=get_safe_value($con,$_POST['model']);
                $code=get_safe_value($con,$_POST['code']);
                $qty=get_safe_value($con,$_POST['qty']);
                $price=get_safe_value($con,$_POST['price']);

                
                    mysqli_query($con,"UPDATE `items` SET `catid`='$category',`code`='$code',`model`='$model',`date`='$added_on' WHERE id='$id'");
                    mysqli_query($con,"UPDATE `items_info` SET `item_code`='$code',`price_per_one`='$price',`item_number`='$qty' WHERE `item_id`='$id'");

                    $recordDetails = "$user_name သည် $cat_name အမျိုးအစား Brand Model No $model ၊ Code No $code အား အရေအတွက် $qty ခု ၊ တစ်ခု ဈေးနှုန်း $price ဖြင့် အသစ်ပြန်လည်ပြင်ဆင်ခဲ့ပါသည်။";
                    $insertRecordQuery = "INSERT INTO `edit_record`(`detail`, `date`, `time`) VALUES ('$recordDetails', '$date', '$time')";
                    $recordResult = mysqli_query($con, $insertRecordQuery);
                    
                    ?>
                    <script>
                        window.alert('အသစ် ပြင်ဆင်ခြင်းအောင်မြင်ပါသည်')
                    </script>
                    <?php
            }
        }
        
    
}else if(isset($_POST['create'])){
    $category=get_safe_value($con,$_POST['category']);
    $catres=mysqli_query($con,"SELECT * FROM `category` where id='$category'");
    $cat_row=mysqli_fetch_assoc($catres);
    $cat_name=$cat_row['name'];
    $model=get_safe_value($con,$_POST['model']);
    $code=get_safe_value($con,$_POST['code']);
    $qty=get_safe_value($con,$_POST['qty']);
    $price=get_safe_value($con,$_POST['price']);
    $res=mysqli_query($con,"SELECT * FROM `items` where `model`='$model'");
    date_default_timezone_set('Asia/Yangon');
    $added_on = date('Y-m-d H:i:s');
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $check=mysqli_num_rows($res);
    if($check>0){
        ?>
        <script>
            window.alert('! model already exist. please check the name.')
        </script>
        <?php
    }else{
        mysqli_query($con,"INSERT INTO `items`(`catid`, `code`, `model`,`date`) VALUES ('$category','$code','$model','$added_on')");
        $item_id = mysqli_insert_id($con);
        
        mysqli_query($con,"INSERT INTO `items_info`( `item_id`, `item_code`, `price_per_one`, `qty_id`, `item_number`) VALUES ('$item_id','$code','$price','1','$qty')");

        $recordDetails = "$user_name သည် $cat_name အမျိုးအစား Brand Model No $model ၊ Code No $code အား အရေအတွက် $qty ခု ၊ တစ်ခု ဈေးနှုန်း $price ဖြင့် အသစ်ဖြည့်သွင်းခဲ့ပါသည်။";
        $insertRecordQuery = "INSERT INTO `edit_record`(`detail`, `date`, `time`) VALUES ('$recordDetails', '$date', '$time')";
        $recordResult = mysqli_query($con, $insertRecordQuery);
        ?>
        <script>
            window.alert('အသစ် ဖြည့်သွင်းခြင်းအောင်မြင်ပါသည်')
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
                    <h2>Product အသစ်တစ်ခုထည့်သွင်းမည်</h2>
                    
                </div>
                
            </div>

            
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                }

                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                }

                h1 {
                    text-align: center;
                }

                label {
                    display: block;
                    font-weight: bold;
                    margin-top: 10px;
                }

                input[type="text"],input[type="number"],
                select {
                    width: 100%;
                    padding: 10px;
                    margin-top: 5px;
                    margin-bottom: 20px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                }

                .btn {
                    background-color: #007bff;
                    color: #fff;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }

                button:hover {
                    background-color: #0056b3;
                }
            </style>
            <div class="bottom-data">
                <div class="orders">
                
                    <h1>New Product Form</h1>
                    <form action="" method="post">
                        

                        <label for="category">Brand:</label>
                        <select id="category" name="category" required>
                            <option value="">Choose Brand</option>
                            <?php
                            $res=mysqli_query($con,"SELECT * FROM `category` where id='$cat_id' ORDER BY `id` asc  ");
                            if(mysqli_num_rows($res)>0){
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    echo "<option selected value=".$row['id'].">".$row['name']."</option>";
                                }
                            }else{
                                $cat=mysqli_query($con,"SELECT * FROM `category` ORDER BY `id` asc  ");
                                while($row=mysqli_fetch_assoc($cat))
                                {
                                    echo "<option value=".$row['id'].">".$row['name']."</option>";
                                }
                            }
                        ?>
                        </select>
                        
                        <label for="product-name">Model No:</label>
                        <input type="text" id="product-name" name="model" required value="<?php echo $model ?>">

                        <label for="product-name">Code No:</label>
                        <input type="text" id="product-name" name="code" required value="<?php echo $code ?>">

                        <label for="price">Qty:</label>
                        <input type="number" id="qty" name="qty" required value="<?php echo $qty ?>">

                        <label for="price">Price per one:</label>
                        <input type="number" id="price" name="price" required value="<?php echo $price ?>">


                        
                        <input type="submit" class="btn" value="Create Product" name="create">
                    </form>
   
                </div>

                

            </div>

        </main>

    </div>

    <script src="index.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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