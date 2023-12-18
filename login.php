<?php
    session_start();
?>
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
    <form action="login.php" method = "POST">
        <label> username :</label><br>
        <input type="text" name  = "username"><br>
        <label>password :</label><br>
        <input type="password" name = "password"><br>
        <input type="submit" name = "login" value = "log in"><br>
        <a href="signup.php">dont have account!!</a><br>
        <input type="submit" name = "admin"  value="create admin account!!">
    </form>
</body>
</html>

<?php
    include("database.php");
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])){
        // check if username and password are entered
        if(!empty($_POST["username"]) && !empty($_POST["password"])){
            $username = filter_input(INPUT_POST , "username" , FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST , "password" , FILTER_SANITIZE_SPECIAL_CHARS);
            // look for username in database if it exist or not
            $sql = "SELECT * FROM users WHERE username = '$username'";
            //do query
            $result = mysqli_query($conn , $sql);
            //there are 0 row if cant find any result
            $nums_rows = mysqli_num_rows($result);
            if ($nums_rows ==1){
                $row = mysqli_fetch_row($result);
                // print_r($row);
                if (password_verify( $password,$row["2"])){
                    $_SESSION["login"] = true;
                    $_SESSION["username"] = $row["3"];
                    $_SESSION["user_id"] =  $row["0"];
                    header("location:homepage.php");

                }
                else{
                    echo "username or password is invalid";
                }
            }

        }
        else{
            echo "username and password is required";
        }
    }
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["admin"])){
        $sql = "SELECT * FROM users";
        $res = mysqli_query($conn , $sql);
        $rows = mysqli_num_rows($res);
        if($rows == 0){
            header("location:adminsingin.php");
        }
        $admin = false;
        while($data = mysqli_fetch_row($res)){
            if($data["4"] == true){
                $admin = true;
                break ;
            }
        }
        if (!$admin){
            header("location:adminsignin.php");
        }
        else{
            echo "permission denied";
        }
        

    }
    mysqli_close($conn);

?>