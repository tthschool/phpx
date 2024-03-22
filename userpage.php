<?php
    session_start();
    // if(!$_SESSION["login"])
    // {
    //     header("location:login.php");
    // }
    include ("model.php");
    include ("authenticator.php");
    $user_id = $_SESSION["userid"];
    $message_list = get_user_message($user_id , $conn);
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
    <h1>hello <?php echo $_SESSION["name"] ?></h1>
    <div class ="user_page" >
        <table class = "table">
            <tr>
                <th class="tableth">message</th>
                <th class="tableth">create time</th>
            </tr>
            <?php
                foreach($message_list as $message)
                {
                    echo "<tr >";
                    echo "<td class = td> {$message['message']} </td>";
                    echo "<td class = td> {$message['create_time']}</td>";
                }
            ?>
        </table>
        <form action="authenticator.php" method= "post">
            <input type="submit" name="logout" value="log out">
        </form>
    </div>
</body>
</html>
 