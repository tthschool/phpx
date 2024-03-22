<?php
    session_start();
    if(!$_SESSION["login"] || !$_SESSION["is_admin"]) {
        header("location:login.php");
    }
    include("model.php");
    include("authenticator.php");
    include ("control.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="homepage.js" ></script>
    <link href="base.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class ="form-search">
        <form class = "logout"action="authenticator.php" method= "post">
            <input type="submit" name="logout" value="log out">
        </form>
        <form  class="search" action="homepage.php" method = "POST">
            <input autocomplete="off" autofocus placeholder="enter name" type="text" name ="search">
            <input type="submit" name="searchbtn" value="search">
        </form>
    </div>

    <div class = "table">
    <table >
        <tr>
            <th class="tableth">id</th>
            <th class="tableth">list user</th>
            <th class="tableth">username</th>
            <th class="tableth">admin</th>
            <th class="tableth"> delete </th>
            <th class="tableth"> message </th>
        </tr>
            <?php
                ob_start();
                $user_list = [];
                $name = filter_input(INPUT_POST , "search" , FILTER_SANITIZE_SPECIAL_CHARS);

                if(!isset($_POST["searchbtn"]) && !empty($name))
                {
                    $user_list = get_user($conn);
                }
                else
                {
                    $user_list = get_user($conn ,name: $name);
                }
                foreach($user_list as $user){
                    echo "<tr>";
                    echo "<td class='td'> {$user["id"]} </td>";
                    echo "<td class='td'> {$user["name"]}</td>";
                    echo "<td class='td'> {$user["username"]}</td>";
                    if ($user["is_admin"] == 1){
                        echo "<td class='td'> true</td>";
                    }
                    else{
                        echo "<td class='td'>false</td>";
                    }
                    echo "<td class='td'>
                    <form id ='deleteuser' action='homepage.php' method = 'post'>
                        <input type='hidden' name = 'delete_user_id' id = 'delete_user'  value ={$user['id']}>
                        <input type= 'hidden' id = 'session_id' value = {$_SESSION['user_id']}>
                        <button type='submit' id = 'delete'>Xóa User</button>
                    </form>
                    </td>";
                    echo "<td class='td'>
                    <form action='homepage.php' method = 'post'>
                        <input type='hidden' name = 'user_id' id = 'sendmessage'  value ={$user['id']}>
                        <input type='submit' id = 'user_profile' name='user_profile' value = 'profile'>
                    </form>
                    </td>";
                }
            ?> 
    </table>
</div>
</body>
</html>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["delete_user_id"])){
    $user_id =  $_POST["delete_user_id"];

    delete_user($conn  , $user_id);
}
if(isset($_POST["user_profile"]))
{
    $_SESSION["user_id"] = $_POST["user_id"];
    echo $_SESSION["user_id"];
    header("location:userprofile.php");
    ob_end_flush();
    // cần phải chèn được user_id của người nhận vào cột user_id
}
?>