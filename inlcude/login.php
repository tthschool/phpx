<?php
include ("model.php");
    include("authenticator.php");
    $user_list = get_user($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="base.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class ="login-form">
        <form action="login.php" method = "POST">
            <label ></label><br>
            <label> username :</label><br>
            <input type="text" id = "username" name  = "username"><br>
            <label>password :</label><br>
            <input type="password" id = "password" name = "password"> <br>
            <button type="submit" id ="loginbtn" name = "login">log in</button><br>
            <a  href="signuppage.php">dont have account!!    </a><br>
        </form>
        <form action="login.php" method="post">
            <?php
                $admin_exist = check_admin_exist($user_list);
                    if(!$admin_exist){
                        echo "<input type='submit' name ='admin_create'  value='create admin account!!'>";
                    }
            ?>
        </form>
    </div>
        <!-- <script src="base.js"></script> -->
</body>
</html>
<?php

    if(isset($_POST["login"])){
        $username = filter_input(INPUT_POST , "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $pass = filter_input(INPUT_POST , "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $login_status = login($username,$pass ,$user_list);
        if($login_status)
        {
            // session_start();
            $is_admin = $_SESSION["is_admin"];
           
            if(!$is_admin){
                header("location:userpage.php");
            }
            else{
                header("location:homepage.php");
            }
        }
    }
    if(isset($_POST["admin_create"]))
    {
        create_admin();
    }
?>  