
<?php
require('../connection.php');
require('../function.php');


$name='';
$password='';
$msg='';
if(isset($_POST['signup'])){
  
  $name=get_safe_value($con,$_POST['name']);
  $password=get_safe_value($con,$_POST['password']);
  $role=get_safe_value($con,$_POST['role']);
  date_default_timezone_set('Asia/Yangon');
  $added_on=date('Y-m-d h:i:s');

  if($role=='admin'){
    $res=mysqli_query($con,"SELECT * FROM `admin` where `name`='$name'");
    $check=mysqli_num_rows($res);
    if($check>0){
      $msg="Your name already exist";
    }else{
      
    mysqli_query($con,"INSERT INTO `admin`(`name`,`password`,`date`) VALUES ('$name','$password','$added_on')");

    date_default_timezone_set('Asia/Yangon');
    $date=date('Y-m-d');
    $time=date('h:i:s');
    $recordDetails = "$name သည် $date ရက်နေ့ $time အချိန်တွင် အကောင့်အသစ်တစ်ခုဖန်တီးခဲ့ပါသည်။";
    $insertRecordQuery = "INSERT INTO `record`(`details`, `date`, `time`) VALUES ('$recordDetails', '$date', '$time')";
    $recordResult = mysqli_query($con, $insertRecordQuery);
    ?>
    <script>
      window.location.href='login.php';
    </script>
    <?php
    }
  }else if($role=='user'){
    $res=mysqli_query($con,"SELECT * FROM `user` where `name`='$name'");
    $check=mysqli_num_rows($res);
    if($check>0){
      $msg="Your name already exist";
    }else{
      
    mysqli_query($con,"INSERT INTO `user`(`name`,`password`,`date`) VALUES ('$name','$password','$added_on')");
    
    date_default_timezone_set('Asia/Yangon');
    $date=date('Y-m-d');
    $time=date('h:i:s');
    $recordDetails = "$name သည် $date ရက်နေ့ $time အချိန်တွင် အကောင့်အသစ်တစ်ခုဖန်တီးခဲ့ပါသည်။";
    $insertRecordQuery = "INSERT INTO `record`(`details`, `date`, `time`) VALUES ('$recordDetails', '$date', '$time')";
    $recordResult = mysqli_query($con, $insertRecordQuery);

    ?>
    <script>
      window.location.href='login.php';
    </script>
    <?php
    }
  }

  
}
if(isset($_POST['login'])){
    $name=get_safe_value($con,$_POST['name']);
    $password=get_safe_value($con,$_POST['password']);
    $role=get_safe_value($con,$_POST['role']);
    if(empty(get_safe_value($con,$_POST['name'])))
    {
        $msg="Please enter user name";
    }
    else if(empty(get_safe_value($con,$_POST['password'])))
    {
        $msg="Please enter user password";
    }
    else if(empty(get_safe_value($con,$_POST['role'])))
    {
        $msg="Please choose user role";
    }
    else 
    {
        if($role=='admin'){
          $res=mysqli_query($con,"select * from admin where name='$name' and password='$password'");
          $count=mysqli_num_rows($res);
          if($count>0)
          { 
              $row=mysqli_fetch_assoc($res);
              $_SESSION['USER_LOGIN']='yes';
              $_SESSION['USER_NAME']=$row['name'];
              $_SESSION['USER_ID']=$row['id'];

              date_default_timezone_set('Asia/Yangon');
              $date=date('Y-m-d');
              $time=date('h:i:s');
              $recordDetails = "$name သည် $date ရက်နေ့ $time အချိန်တွင် အကောင့် login ဝင်ခဲ့ပါသည်။";
              $insertRecordQuery = "INSERT INTO `record`(`details`, `date`, `time`) VALUES ('$recordDetails', '$date', '$time')";
              $recordResult = mysqli_query($con, $insertRecordQuery);
                        
                ?>
              <script>
              window.location.href='../admin/';
              </script>
              <?php
              
          }
          else 
          {
              $msg="Please enter login correct detail";
          }

        }else if($role=='user'){
          $res=mysqli_query($con,"select * from user where name='$name' and password='$password'");
          $count=mysqli_num_rows($res);
          if($count>0)
          { 
              $row=mysqli_fetch_assoc($res);
              $_SESSION['USER_LOGIN']='yes';
              $_SESSION['USER_NAME']=$row['name'];
              $_SESSION['USER_ID']=$row['id'];

              date_default_timezone_set('Asia/Yangon');
              $date=date('Y-m-d');
              $time=date('h:i:s');
              $recordDetails = "$name သည် $date ရက်နေ့ $time အချိန်တွင် အကောင့် login ဝင်ခဲ့ပါသည်။";
              $insertRecordQuery = "INSERT INTO `record`(`details`, `date`, `time`) VALUES ('$recordDetails', '$date', '$time')";
              $recordResult = mysqli_query($con, $insertRecordQuery);
              
                ?>
              <script>
              window.location.href='../index.php';
              </script>
              <?php
              
          }
          else 
          {
              $msg="Please enter login correct detail";
          }
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
                
                <h4>MoMO Watch Store</h4>
              </div>

              <div class="heading">
                <h2>Welcome Back</h2>
                <h6>Not registred yet?</h6>
                <a href="#" class="toggle">Sign up</a>
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="name" name="name"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required value="<?php echo $name ?>"
                  />
                  <label>Email</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="password" name="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required value="<?php echo $password ?>"
                  />
                  <label>Password</label>
                </div>
                <div class="input-wrap">
                  <select name="role" id="" class="input-field" required>
                    <option value="">Choose user role</option>
                    <option value="admin">Admin</option>
                    <option value="user">user</option>
                  </select>
                </div>
                <p class="text" style="color:red">
                  <?php echo $msg ?>
                </p>

                <input type="submit" value="Sign In" class="sign-btn" name="login" />

                <p class="text">
                  Forgotten your password or you login datails?
                  <a href="forget_password.php">Get help</a> signing in
                </p>
              </div>
            </form>

            <form autocomplete="off" class="sign-up-form" method="post">
              <div class="logo">                
                <h4>MoMO Watch Store</h4>
              </div>

              <div class="heading">
                <h2>Get Started</h2>
                <h6>Already have an account?</h6>
                <a href="#" class="toggle">Sign in</a>
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text" name="name"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required value="<?php echo $name ?>"
                  />
                  <label>Name</label>
                </div>
                <div class="input-wrap">
                  <input
                    type="password" name="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required value="<?php echo $password ?>"
                  />
                  <label>Password</label>
                </div>
                <div class="input-wrap">
                  <select name="role" id="" class="input-field" required>
                    <option value="">Choose user role</option>
                    <option value="admin">Admin</option>
                    <option value="user">user</option>
                  </select>
                </div>
                

                <input type="submit" value="Sign Up" class="sign-btn" name="signup" />

                <p class="text">
                  By signing up, I agree to the
                  <a href="#">Terms of Services</a> and
                  <a href="#">Privacy Policy</a>
                </p>
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
                  <h2>Save Your Time</h2>
                  <h2>when The Men make the Job</h2>
                  <h2>We are all need</h2>
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
