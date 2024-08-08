<?php
require('top.php');
if(isset($_SESSION['USER_LOGIN']))
{
 $user_id=$_SESSION['USER_ID'];
 $user_res=mysqli_query($con,"select * from admin where id='$user_id'");
    $user_row=mysqli_fetch_assoc($user_res);
    $user_name=$user_row['name'];
 
}
$name='';
$qty='';
if(isset($_GET['id'])){
    
    $id=get_safe_value($con,$_GET['id']);
    
        $res=mysqli_query($con,"select * from category where id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
            $row=mysqli_fetch_assoc($res);
            $name=$row['name'];
            $qty=$row['qty'];
            if(isset($_POST['create'])){
                $name=get_safe_value($con,$_POST['product_name']);
                $qty=get_safe_value($con,$_POST['qty']);
                date_default_timezone_set('Asia/Yangon');
                $added_on = date('Y-m-d H:i:s');
                $date = date('Y-m-d');
                $time = date('H:i:s');
                
                    mysqli_query($con,"UPDATE `category` SET `name`='$name',`qty`='$qty',`date`='$added_on' WHERE id='$id'");

                    $recordDetails = "$user_name သည် $name အမျိုးအစား Brand အား အရေအတွက် $qty ခုဖြင့် အသစ်ပြန်လည်ပြင်ဆင်ခဲ့ပါသည်။";
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
    $name=get_safe_value($con,$_POST['product_name']);
    $qty=get_safe_value($con,$_POST['qty']);
    $res=mysqli_query($con,"select * from category where name='$name'");
    $check=mysqli_num_rows($res);
    date_default_timezone_set('Asia/Yangon');
    $added_on = date('Y-m-d H:i:s');
    $date = date('Y-m-d');
    $time = date('H:i:s');
    if($check>0){
        ?>
        <script>
            window.alert('! Product name already exist. please check the name.')
        </script>
        <?php
    }else{
        mysqli_query($con,"INSERT INTO `category`(`name`, `qty`,`date`) VALUES ('$name','$qty','$added_on')");

        $recordDetails = "$user_name သည် $name အမျိုးအစား Brand အား အရေအတွက် $qty ခုဖြင့် အသစ်ဖြည့်သွင်းခဲ့ပါသည်။";
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
                    <h2>Brand အသစ်တစ်ခုထည့်သွင်းမည်</h2>
                    
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
                        <label for="product-name">Product Name:</label>
                        <input type="text" id="product-name" name="product_name" required value="<?php echo $name ?>">

                        <!--<label for="category">Quantity:</label>
                        <select id="category" name="category">
                            <option value="clothing">Clothing</option>
                            <option value="electronics">Electronics</option>
                            <option value="furniture">Furniture</option>
                            <option value="other">Other</option>
                        </select>-->

                        <label for="price">Qty:</label>
                        <input type="number" id="qty" name="qty" required value="<?php echo $qty ?>">

                        
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