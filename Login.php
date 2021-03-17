<?php
session_start();
error_reporting(0);
//require_once './sqlConnection.php';
if (isset($_POST['login'])) {
    $userid = $_POST['userid'];
    $pass = $_POST['pass'];

    if ($userid == "admin" & $pass == "admin") {
        $_SESSION['admin'] = $userid;
        $_SESSION['userId']=$userid;
        $_SESSION['userType']=$userid;
        $_SESSION['userName']=$userid;
        header("location:Admin.php");
    }
    include './sqlConnection.php';
    $query = "SELECT * from tblUser WHERE emailId='$userid' and password='$pass'";
    $result = mysqli_query($connect, $query);
    $userType;
    $userId;
    if (mysqli_num_rows($result) == 1) {
        echo mysqli_num_rows($result);
        while ($data = mysqli_fetch_array($result)) {
            $userId = $data['userId'];
            $userType = $data['userType'];
            $userName = $data['name'];
        }
//        echo "<br>" . $userId . "<br>";
//        echo "<br>" . $userType . "<br>";
//        echo "<br>" . $userName . "<br>";
        $_SESSION['userId']=$userId;
        $_SESSION['userType']=$userType;
        $_SESSION['userName']=$userName;
        header("location:Admin.php");
    }
}
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
        <title>Login Page</title>
        <link rel="stylesheet" href="CSS\SCMSStyle.css">
    </head>
    <body>

        <?php
        include 'HeaderPage.php';
        ?>
        <div class="div1">
            Login Page
        </div>

        <div class="reg1">
            <form name="MyForm" method="POST">
                <table class="border1" >
                    <tr>
                        <td><label> User ID: </label></td>
                        <td><input type="text" name="userid" size="15"/></td>
                    </tr>
                    <tr>
                        <td><label> Password: </label></td>
                        <td><input type="password" id="pass" name="pass"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="reset" value="Reset" name="reset"/>
                            <input type="submit" value="Login" name="login"/>                            
                        </td> 
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                    <center>
                        <a href="ForgotPassword.php" style="text-decoration: none;color: blue;" onMouseOver="this.style.color = 'red'"
                           onMouseOut="this.style.color = 'blue'">Forgot Password?</a><a> | </a>
                        <a href="Registration.php" style="text-decoration: none;color: blue;" onMouseOver="this.style.color = '#ffc107'"
                           onMouseOut="this.style.color = 'blue'">Registration for SCMS</a>
                    </center>
                    </td>

                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
