
<?php
require('../connection.php');
require('../function.php');
$otp='';
$email='';
$msg='';

    if(isset($_POST['resend'])){
        if(isset($_GET['id'])){
            $email=get_safe_value($con,$_GET['id']);
    

        $res=mysqli_query($con,"SELECT * FROM `tbl_user` where `email`='$email'");
        $check=mysqli_num_rows($res);
        if($check>0){
            $otp=rand(11111111,99999999);
            mysqli_query($con,"UPDATE `tbl_user` SET `otp`='$otp'  where `email`='$email'");
            require '../phpmailer/PHPMailerAutoload.php';
        
        
            $mail = new PHPMailer;
        
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'aungnyinyimin32439@gmail.com';                 // SMTP username
            $mail->Password = 'gdbcegflheqtzjjd';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
        
            $mail->setFrom('aungnyinyimin32439@gmail.com', 'beauty life');
            $mail->addAddress($email);               // Name is optional
        
            $mail->addAttachment('./assets/images/lms-letter-technology-logo-design-white-background-lms-creative-initials-letter-logo-concept-lms-letter-design-lms-letter-252935662.jpg');         // Add attachments
            $mail->isHTML(true);                                  // Set email format to HTML
        
            $mail->Subject = 'Welcome form Myanmar Realstate';
            $mail->Body    = 'Welcome form Myanmar Realstate. Here you can join any course what you want.Have a nice day . Your Verification otp code is ' . $otp;
        
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                $msg='Email Send!';
            }
    }else{
        $msg="There Error Session";
    }
        
    }
    }
    if(isset($_POST['verify'])){
        if(isset($_GET['id'])){
            $email=get_safe_value($con,$_GET['id']);
            $otp=get_safe_value($con,$_POST['otp']);
            $res=mysqli_query($con,"select * from tbl_user where `email`='$email' and `otp`='$otp'");
            $count=mysqli_num_rows($res);
            if($count>0)
            { 
                $res=mysqli_query($con,"select * from tbl_user where `email`='$email' ");
                $row=mysqli_fetch_assoc($res);
                $_SESSION['USER_LOGIN']='yes';
                $_SESSION['USER_EMAIL']=$row['email'];
                $_SESSION['USER_ID']=$row['id'];
                ?>
                <script>
                window.location.href='login.php';
                </script>
            <?php }
            else 
            {
                $msg="Please enter  correct OTP CODE";
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
                <h2>Verify Email</h2>
                <h6>Not registred yet?</h6>
                <a href="login.php" class="toggle">Sign up</a>
              </div>
              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text" name="otp"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                     value="<?php echo $otp ?>"
                  />
                  <label>OTP</label>
                </div>
                <?php echo $msg ?>
             
              <input type="submit" value="Verify" class="sign-btn" name="verify" />
              <input type="submit" value="Resend" class="sign-btn" name="resend" />
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
