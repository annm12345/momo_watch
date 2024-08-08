
<?php
require('../connection.php');
require('../function.php');
$old_password='';
$new_password='';
$email='';
$msg='';

    if(isset($_POST['create'])){
        if(isset($_GET['email'])){
            $email=get_safe_value($con,$_GET['email']);
            $old_password=get_safe_value($con,$_POST['old_password']);
            $new_password=get_safe_value($con,$_POST['new_password']);
            $res=mysqli_query($con,"select * from tbl_user where `email`='$email' and `password`='$old_password'");
            $count=mysqli_num_rows($res);
            if($count>0)
            { 
              mysqli_query($con,"UPDATE `tbl_user` SET `password`='$new_password'  where `email`='$email'");
                ?>
                <script>
                window.location.href='login.php';
                </script>
            <?php }
            else 
            {
                $msg="Please enter correct old password";
            }
        }
    }
    


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up Form</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <main>
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">
            <form autocomplete="off" class="sign-in-form" method="post">
              <div class="logo">
                <img src="./img/logo1.png" alt="easyclass" />
                <h4>Realestate</h4>
              </div>

              <div class="heading">
                <h2>Create Password</h2>
                <h6>Not registred yet?</h6>
                <a href="login.php" class="toggle">Sign up</a>
              </div>
              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text" name="old_password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                     value="<?php echo $old_password ?>"
                  />
                  <label>Old password</label>
                </div>
              </div>
              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text" name="new_password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                     value="<?php echo $new_password ?>"
                  />
                  <label>Old password</label>
                </div>
              </div>
                <?php echo $msg ?>
              <input type="submit" value="Cteate Password" class="sign-btn" name="create" />
              </div>
            </form>
          </div>
          <div class="carousel">
            <div class="images-wrapper">
              <img src="./img/banner1.jpg" class="image img-1 show" alt="" />
              <img src="./img/banner2.jpg" class="image img-2" alt="" />
              <img src="./img/banner3.jpg" class="image img-3" alt="" />
            </div>

            <div class="text-slider">
              <div class="text-wrap">
                <div class="text-group">
                  <h2>Create your own Business</h2>
                  <h2>The Safe Job Here</h2>
                  <h2>Join us with confidence</h2>
                </div>
              </div>

              <div class="bullets">
                <span class="active" data-value="1"></span>
                <span data-value="2"></span>
                <span data-value="3"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Javascript file -->

    <script src="app.js"></script>
  </body>
</html>
