

<?php
    include("model.php");
    include("authenticator.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="base.js"></script>
    <link rel="stylesheet" href="base.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script></script>
</head>
<body>
    <div class ="form-sign">
        <form action="signuppage.php" method = "POST">
        <label>name : </label><br>
        <input type="text" name = "name"><br>
        <label>username :</label><br>
        <input type = "text" name = "username"><br>
        <label>password : </label><br>
        <input id = "pass" type=" password" name = "password"><br>
        <label>confirm password : </label><br>
        <input id = "confirm-pass" type="password" name = "confirm"><br>
        <?php
            session_start();
            if(isset($_SESSION["create_admin"])){
                echo "<label>create admin</label>";
                echo "<input type='radio' name ='admin'><br>";
            }
        ?>
        <input id = "submitbtn" type="submit" name = "submit" value="sign up"><br>
        <a href="login.php">have an account!</a>
        </form>
    </div>
</body>
</html>
<?php
    $user_list = get_user($conn);
    if(isset($_POST["submit"])){
        $is_admin = false;
        // check if user is creating admin account
        // can create user if valid_user pass every check and have value is true;
        if(isset($_SESSION["create_admin"]) and isset($_POST["admin"])){
            $is_admin = true;
        }
        $password = filter_input(INPUT_POST , "password" , FILTER_SANITIZE_SPECIAL_CHARS);
        $confirm_password =  filter_input(INPUT_POST , "confirm" , FILTER_SANITIZE_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST , "name" , FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST , "username" , FILTER_SANITIZE_SPECIAL_CHARS);
        $oke = signup($name , $username , $password ,$confirm_password , $user_list,$is_admin,$conn );
        if ($oke)
        {
            header("location:login.php");

        }
    }
?>