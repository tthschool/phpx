
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="base.js"></script>
    <link rel="stylesheet" href="base.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class ="login-form">
        <form action="login.php" method = "POST">
            <label ></label><br>
            <p id="login-err"></p>
            <label> username :</label><br>
            <input type="text" id = "username" name  = "username"><br>
            <label>password :</label><br>
            <input type="password" id = "password" name = "password"> <br>
            <button type="submit" id ="loginbtn" name = "login">log in</button><br>
            <a  href="signuppage.php">dont have account!!</a><br>
        </form>
    </div>
</body>
</html>