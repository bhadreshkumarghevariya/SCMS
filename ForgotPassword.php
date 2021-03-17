<!DOCTYPE html> <!-- To change this license header, choose License Headers in Project Properties. To change this template file, choose Tools | Templates and open the template in the editor. --> 
<?php
require './Exception.php';
require './PHPMailer.php';
require './SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
error_reporting(0);
?>
<html>     
    <head>         
        <meta charset="UTF-8">         
        <title>Reset Password Page</title>         
        <link rel="stylesheet" href="CSS\SCMSStyle.css">
    </head>     
    <body>
        <?php
        include 'HeaderPage.php';
        ?>
        <div class="div1">
            SCMS Password Reset
        </div>


        <h1>How do you want to reset your password?</h1>
        <h5>You can use the information associated with your account.</h5>
        <div class="reg1">
            <form action="#" method="POST">              
                <div class="otp"> 
                    <table class="border1" >
                        <tr>
                            <td><label>Email Id: </label></td>
                            <td><input type="text" name="mail" placeholder="Enter Email ID"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="sh"name="VerifyOtp" value="Send OTP"/></td>
                        </tr>
                    </table>    

                    <!--                <label> Enter OTP: </label>                 
                                    <input type="text" name="otp">                 
                                    <br/><input type="submit" name="login" value="Login"/>             -->
                </div>          
            </form>
        </div>
        <?php
//        session_start();
        if (isset($_POST['Login'])) {
            if ($_POST['user'] == $_SESSION['mail'] && $_POST['otp'] == $_SESSION['otp']) {
                session_start();
                $_SESSION['loginUser'] = $_POST['user'];
            } else {
                echo " <script>alert('Login Failed!!')</script> ";
            }
        }
        if (isset($_POST['VerifyOtp'])) {
            $mail = $_POST['mail'];
            $query = "select * from tblUser where emailId='$mail'";
            include 'sqlConnection.php';
            $res = mysqli_query($connect, $query);
            
//            print_r(mysqli_error_list($connect)) ;
//            echo mysqli_num_rows($res);
            if (mysqli_num_rows($res) == 1) {

                $code = rand(1111, 9999);
                if (isset($_POST['VerifyOtp'])) {
                    if (isset($_POST['mail'])) {
                        $code = rand(1111, 9999);
                        $emailID = $_POST['mail'];
                        $mail = new PHPMailer();
                        $mail->isSMTP();
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPAuth = "true";
                        $mail->SMTPSecure = "tls";
                        $mail->Port = "587";
                        $mail->Username = "maxveni015@gmail.com"; //Your Email ID
                        $mail->Password = "Max@Veni#015"; //Enter Email ID
                        $mail->Subject = "Check Mail";
                        $mail->setFrom("maxveni015@gmail.com"); //Your Email ID
                        $mail->Body = "$code. is Your One Time Verfication(OTP) code to confirm your User ID at SCMS for Reset Password...";
                        $mail->addAddress($_POST['mail']);
                        if ($mail->send()) {
//                            echo "mail sent";
                            echo '<script>alert("Mail Sent")</script>';
//                    ob_flush();
                            $_SESSION['emailIdtoUpdatePass'] = $_POST['mail'];
                            $_SESSION['otpCode'] = $code;
                            $_SESSION['otpType']="resetPass";
                            header("location:VerifyOTP.php");
                        } else {
//                            echo 'Not Sent';
                            echo '<script>alert("Mail Not Sent")</script>';
                        } $mail->smtpClose();
                    }
                }
            } else {
//                echo '<b>Please Enter Correct Email id</b>';
                echo '<script>alert("Please Enter Correct Email id")</script>';
            }
        }
        ?>        
    </body> 
</html>