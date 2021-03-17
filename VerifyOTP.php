<?php
session_start();
error_reporting(0);
//if (isset($_POST['login'])) {
//    $userid = $_POST['userid'];
//    $pass = $_POST['pass'];
//
//    if ($userid == "admin" & $pass == "admin") {
//        $_SESSION['admin'] = $userid;
//        header("location:Admin.php");
//    }
//}
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Verify OTP Page</title>
        <link rel="stylesheet" href="CSS\SCMSStyle.css">
    </head>
    <body>
        <?php
        include 'HeaderPage.php';
        ?>
        <div class="div1">
            Check your email
        </div>
        <br/>
        <h5>You'll receive a code to verify here so you can reset your account password.</h5>
        <div class="reg1">
            <form name="MyForm" method="POST">
                <table class="border1" >
                    <tr>
                        <td><label> Code (OTP): </label></td>
                        <td><input type="text" name="otp" size="15" placeholder="Enter Your OTP Code"/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value="Verify" name="verify"/>
                        </td> 
                    </tr>
                    <tr>
                        <td></td>
                        <td><p style="width: 400px;">If you don't see the email, check other places it might be, like your junk, spam, social, or other folders.</p></td>
                    </tr>
                </table>
            </form>
        </div>

    </body>
    <?php
    $emailIdtoUpdatePass = $_SESSION['emailIdtoUpdatePass'];
    //1. Get OTP FROM DATABASE ADDED ON 16MARCH
    include './sqlConnection.php';
    $query = "SELECT * from tblOTP WHERE emailId='$emailIdtoUpdatePass'";
    $result = mysqli_query($connect, $query);
//    if(mysqli_num_rows($result)>0)
//    {
//        echo "<table>";
//        
//        while ($row = mysqli_fetch_assoc($result)) {
//            echo "<tr>";
//            echo "<td>$row[emailId]</td>";
//            echo "<td>$row[otp]</td>";
//            echo "<td>$row[generatedTime]</td>";
//            echo "</tr>";
//        }
//    echo "</table>";
//    }
    $otp = "NULL";
    $time = "";
    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_row($result)) {
            $GLOBALS['otp'] = $row[2];
            $GLOBALS['time'] = $row[3];
        }
    }
    echo $otp . "<br>";

    echo $time . "<br>";
    //1. CLOSE 

    print_r($result);
    echo $emailIdtoUpdatePass;
//    $otpCode = $_SESSION['otpCode'];
    $otpCode = $otp;
    if (isset($_POST['verify'])) {
        if (!empty($_POST['otp'])) {
            if ($otp == $_POST['otp']) {
                echo '<script>alert("OTP successfully Verified")</script>';

                //Update status of user
                $sql = "UPDATE tblUser SET status=1 WHERE emailId='$emailIdtoUpdatePass'";

                if ($connect->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $connect->error;
                }
                //User status upadated.
                
                if ($_SESSION['otpType'] == "Registration") {
                    echo "<center><b><a href='./Login.php'>Login</a></b></center>";
                } elseif ($_SESSION['otpType'] == "resetPass") {


                    echo "<center><b><a href='./ResetPassword.php'>Login</a></b></center>";
                }
            } else {
                echo '<script>alert("Wrong OTP")</script>';
            }
        } else {
            echo '<script>alert("Please Enter OTP")</script>';
        }
    }
//    echo $otpCode;
//    if (isset($_POST['verify'])) {
//        if (!empty($_POST['otp'])) {
//            if ($otpCode == $_POST['otp']) {
////                echo '<br><b>OTP successfully Verified</b><br>';
//                echo '<script>alert("OTP successfully Verified")</script>';
//                
////                header('location:ResetPassword.php');
//            } else {
//                //echo '<br><b>Wrong OTP</b><br>';
//                echo '<script>alert("Wrong OTP")</script>';
//            }
//        } else {
//            echo '<script>alert("Please Enter OTP")</script>';
//        }
//    }
    ?>
</html>
