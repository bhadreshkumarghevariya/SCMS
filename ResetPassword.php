<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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

        <div class="reg1">
            <form name="MyForm" method="POST">
                <table class="border1" >
                    <tr>
                        <td><label> New Password: </label></td>
                        <td><input type="password" name="pass" size="15" placeholder="Enter Your New Password"/></td>
                    </tr>
                    <tr>
                        <td><label> Confirm New Password: </label></td>
                        <td><input type="password" name="conpass" size="15" placeholder="Enter Your New Password, Again"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value="submit" name="Submit"/>
                        </td> 
                    </tr>

                </table>
            </form>
        </div>
    </body>
</html>
<?php
$emailIdtoUpdatePass = $_SESSION['emailIdtoUpdatePass'];
echo $emailIdtoUpdatePass;

if (isset($_POST['Submit'])) {
    if (!empty($_POST['pass'])) {
        $pass = $_POST['pass'];
        include './sqlConnection.php';
        $connect;
        $query = "UPDATE `tblUser` SET `password`='$pass' WHERE emailId = '$emailIdtoUpdatePass'";
        mysqli_query($connect, $query);

        if (empty(mysqli_error_list($connect))) {
//            echo '<br><h1>Successfully Updated Password</h1><br>';
            echo '<script>alert("Successfully Updated Password")</script>';
        } else {
//            echo 'Sorry ! We are facing Some Error!!!';
            echo '<script>alert("Sorry ! We are facing Some Error!!!")</script>';
        }
        print_r(mysqli_error_list($connect));
    }
}
?>