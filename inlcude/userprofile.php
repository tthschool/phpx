
<?php
    session_start();
    $user_id =  $_SESSION["user_id"];
    include("authenticator.php");
    include("model.php");
    $messlist = get_user_message($user_id , $conn);
    $user = get_user($conn ,id: $user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<a  href="homepage.php">back to homepage</a><br>

    <link rel="stylesheet" href="base.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <ul>
            <?php
                foreach($user as $element)
                {
                    echo "<h3>name : </h3>";
                    echo "<li class = 'li'>  {$element['name']} </li>";
                    echo "<h3>username </h3>";
                    echo "<li class ='li'> {$element['username']} </li>";
                }
                ?>
        </ul>
            <form action="userprofile.php"  method="POST">
                    <input type="text" name = "message">
                    <input type="submit" name = "submit">
            </form>
    </div>
    <div class  = "user_mess">
        <table class = "table_profile">
                <tr>
                    <th class=  "tableth">mess</th>
                    <th class = "tableth">date</th>
                </tr>
                <?php
                    foreach($messlist as $mess)
                    {
                        echo "<tr>";
                        echo "<td class='td'>{$mess["message"]}</td>";
                        echo "<td class='td'>{$mess["create_time"]}</td>";
                        echo "</tr>";
                    }

                ?>
                
        </table>
            
    </div>
</body>
</html>

<?php
    if(isset($_POST["submit"]))
    {
        $mess = filter_input(INPUT_POST , "message" , FILTER_SANITIZE_SPECIAL_CHARS);
        set_user_message($mess ,$user_id, $conn );
        header("location:userprofile.php");
    }

?>