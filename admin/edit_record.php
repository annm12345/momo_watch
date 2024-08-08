<?php
require('top.php');
if(isset($_SESSION['USER_LOGIN']))
{
 $user_id=$_SESSION['USER_ID'];
 
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
                    <h1>Admin ပြင်ဆင်ခဲ့သည့်အချက်အလက်များ</h1>
                    <ul class="breadcrumb">
                        
                    </ul>
                </div>
                
            </div>

            

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>မှတ်တမ်း</h3>
                        <i class='bx bx-filter'></i>
                        <i class='bx bx-search'></i>
                        <input type="text" id="message-search" placeholder="Search by product name" style="padding:0.2rem;outline:none;border-radius:5px;border:0.5px solid gray">
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ရက်စွဲ</th>
                                <th>အချိန်</th>
                                <th>အကြောင်းအရာ</th>                          
                                
                            </tr>
                        </thead>
                        <tbody id="data">
                            <?php
                            $res=mysqli_query($con,"SELECT * FROM `edit_record` order by id desc");
                            while($row=mysqli_fetch_assoc($res)){
                               
                                
                            ?>
                            <tr>
                                <td id="pname"><?php echo $row['date'] ?></td>
                                <td id="pname"><?php echo $row['time'] ?></td>
                                <td id="pname"><?php echo $row['detail'] ?></td>
                                
                            </tr>
                            <?php } ?>
                            
                        </tbody>
                    </table>
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