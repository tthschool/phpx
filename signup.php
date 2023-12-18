<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            display: grid;
            place-items: center;
            height: 120dvh;
            background-color: burlywood;
            font-size: 20px;
            
        }
    </style>
</head>
<body>
    <form action="signup.php" method = "POST">
    <label>name : </label><br>
    <input type="text" name = "name"><br>
    <label>username :</label><br>
    <input type = "text" name = "username"><br>
    <label>password : </label><br>
    <input type="password" name = "password"><br>
    <label>confirm password : </label><br>
    <input type="password" name = "confirm"><br>
    <input type="submit" name = "submit" value="sign up"><br>
    <a href="login.php">have an account!</a>
    </form>
</body>
</html>

<?php
    
    include("database.php");
    if(isset($_POST["submit"])){
        if (!empty($_POST["username"] && !empty($_POST["password"]) && !empty($_POST["confirm"]) &&!empty($_POST["name"]))){
            $username   = filter_input(INPUT_POST , "username" , FILTER_SANITIZE_SPECIAL_CHARS);
            $name   = filter_input(INPUT_POST , "name" , FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST , "password" , FILTER_SANITIZE_SPECIAL_CHARS );
            $confirm = filter_input(INPUT_POST , "confirm" , FILTER_SANITIZE_SPECIAL_CHARS);
            if ($password == $confirm){
                $password = password_hash($password , PASSWORD_DEFAULT);
                $sql = $conn -> prepare("INSERT INTO users (name,username,password) VALUES (?,?,?)");
                try{
                    $sql ->bind_param("sss" ,$name ,$username ,$password);
                    $sql -> execute();
                    $sql->close();
                    echo "suscessed";
                    header("location:login.php");
                }
                catch(mysqli_sql_exception)
                {
                    echo "username was taken";
                }
            }
            else{
                echo "password not match";
            }
            
        }
        else{
            echo "not hello";
        }
    }

?>