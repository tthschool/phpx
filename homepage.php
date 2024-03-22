<?php
    include("authenticator.php");
    session_start();
    echo $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="base.js"></script>
    <link href="base.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class ="form-search">
        <button class ="logout">log out</button>
        <form  class="search" action="homepage.php" method = "POST">
            <input autocomplete="off" autofocus placeholder="enter name" type="text" name ="search">
            <input type="submit" name="searchbtn" value="search">
        </form>
    </div>
    <div class = "table">
    <table >
        <tr>
            <th class="tableth">id</th>
            <th class="tableth">name</th>
            <th class="tableth">username</th>
            <th class="tableth">admin</th>
            <th class="tableth"> delete </th>
            <th class="tableth"> message </th>
        </tr>
            <?php
              $user_list = get_user();
              foreach($user_list as $user){
                  echo "<tr class='user-container'>";
                  echo "<td class='td' id='userid'>{$user["id"]}</td>";
                  echo "<td class='td'>{$user["name"]}</td>";
                  echo "<td class='td'>{$user["username"]}</td>";
                  if ($user["is_admin"] == 1){
                      echo "<td class='td'>true</td>";
                  } else {
                      echo "<td class='td'>false</td>";
                  }
                  echo "<td class='td'><button class='delete_user_btn' name='delete'>delete</button></td>";
                  echo "<td class='td'>
                          <form action='homepage.php' method='post'>
                              <input type='hidden' name='user_id' id='sendmessage' value='{$user['id']}'>
                              <input type='hidden' name='user_name'  value='{$user['name']}'>
                              <input type='submit' id='user_profile' name='user_profile' value='profile'>
                          </form>
                        </td>";
                  echo "<input type='hidden' id='session_id' value='{$_SESSION['user_id']}'>";
              }
            ?> 
    </table>
</div>
</body>
</html>
<?php
if(isset($_POST["user_profile"])){
    $_SESSION["userid"] = $_POST["user_id"];
    $_SESSION["name"] = $_POST["user_name"];
    header("location:userpage.php");
}