<?php

use function PHPSTORM_META\type;

    session_start();
    if(!$_SESSION["login"]){
        header("location:login.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color: burlywood;
            place-items:  center;
            display: grid;
            height: 120vh;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <table >
        <tr>
            <th width = "50" >id</th>
            <th width = "200" >list user</th>
            <th width = "200" >username</th>
            <th>admin</th>
            <th width= 200> delete </th>
        </tr>
            <?php 
                include("result.php");
                foreach($data as $user){
                    echo "<tr>";
                    echo "<td style='text-align:center;'> {$user["id"]} </td>";
                    echo "<td style='text-align:center;'> {$user["name"]}</td>";
                    echo "<td style='text-align:center;'> {$user["username"]}</td>";
                    if ($user["is_admin"] == 1){
                        echo "<td style='text-align:center;'> true</td>";
                    }
                    else{
                        echo "<td style='text-align:center;'>false</td>";
                    }
                    echo "  <td style = 'text-align: center';>
                    <form action='homepage.php' method = 'post'>
                        <input type='hidden' name = 'user_id' value ={$user['id']}>
                        <input type='submit' name='delete' value= 'delete'>
                    </form>
                    </td>";
                }
            ?> 
    </table>
    <form action="homepage.php" method= "post">

        <input type="submit" name="logout" value="log out">
    </form>
</body>
    
</html>

<?php
    include("database.php");
    if(isset($_POST["logout"]))
    {
        session_destroy();
        header("location:login.php");
    }
    if(isset($_POST["delete"])){
            $a =  $_POST["user_id"];
            $b =  $_SESSION["user_id"] ;
            if($a != $b)
            {
                $sql = $conn->prepare("DELETE FROM users WHERE id=?");
                $sql->bind_param("i" , $a);
                $sql->execute();
                $sql->close();
                header("location:homepage.php");
            }
            else{
                echo "cant delete";
            }
       }
      
    mysqli_close($conn);
  
?>

