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
        <p id = "signup-erro"></p>
        <form action="signuppage.php" method = "POST">
        <label>name : </label><br>
        <input id = "name" type="text" name = "name"><br>
        <label>username :</label><br>
        <input id="username" type = "text" name = "username"><br>
        <label>password : </label><br>
        <input id = "pass" type=" password" name = "password"><br>
        <label>confirm password : </label><br>
        <input id = "confirm-pass" type="password" name = "confirm"><br>
        <input id = "signupbtn" type="submit" name = "submit" value="sign up"><br>
        <a href="login.php">have an account!</a>
        </form>
    </div>
</body>
</html>
