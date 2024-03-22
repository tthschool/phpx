<?php
    function get_user_message($user_id , $conn)
    {
        $db = new Takesql($conn);
        $message = new MessageManager();
        $mess_list = [];
        $sql  = "select * from message where user_id = :user_id";
        $param = [":user_id" => $user_id];
        $result = $db->take_sql_from_user($sql , $param);
        $result->setFetchMode(PDO::FETCH_CLASS,'MessageManager');
        for($i = 0 ; $i < $result->rowCount() ; $i++)
        {
            $message=$result->fetch();
            $mess_list[$i] = $message->get_mess();
        }
        return ($mess_list);
}
    function get_user(){
        include("model.php");
        $sql = "select  * from users_table";
        $control = new Takesql($conn);
        $result = $control->take_sql_from_user($sql);
        $result->setFetchMode(PDO::FETCH_CLASS,'User');
        $userlist = [];
        for($i = 0 ;  $i < $result->rowCount() ; $i++){
            $user = $result->fetch();
            $user = $user->get_user_data();
            $userlist[$user["username"]] = $user;
        }
        return $userlist;
    }
    function signup($name , $username ,$password){
        include("model.php");
        $sql = "select * from users_table where username =:username";
        $param = [
            ":username"=>$username
        ];
        $control = new Takesql($conn);
        $result = $control->take_sql_from_user($sql , $param);
        $rows = $result->rowCount();
        if(!$rows){
            $password = password_hash($password , PASSWORD_DEFAULT);
            $user = new User;
            $user->set_user_data($name , $username ,$password);
            $param = $user->for_query_sql();
            $sql = "INSERT INTO users_table (name, username, password , is_admin) VALUES (:name, :username, :password , :is_admin)";
            $control->take_sql_from_user($sql , $param);
            $response  = array("oke"=>true , "redirect"=>"login.php");
            echo json_encode($response);
        }
        else{
            $response=array("oke"=>false ,"message"=>"username already exist !!!");
            echo json_encode($response);

        }
    }
    function login($username  ,$password){
        include("model.php");
        $sql = "select * from users_table";
        $control = new Takesql($conn);
        $result = $control->take_sql_from_user($sql);
        $result->setFetchMode(PDO::FETCH_CLASS,'User');
        $valid_user = false;
        for($i = 0 ; $i< $result->rowCount() ; $i++){
            $user = $result->fetch();
            $user = $user->get_user_data();
            if($username == $user["username"]){
                if(password_verify($password , $user["password"])){
                    $valid_user = true;
                    session_start();
                    $_SESSION["user_id"] = $user["id"];
                }
            }
        }
        return $valid_user;
    }
    if(isset($_POST["login"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $login_status = login($username , $password);
        if($login_status){
            $response  = array("oke"=>true , "redirect"=>"homepage.php");
            echo json_encode($response);
        }
        else{
            $response = array("oke"=>false , "massage"=>"invalid username or password!!");
            echo json_encode($response);
        }
    }
    if(isset($_POST["signup"])){
        $name = $_POST["name"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        signup($name, $username , $password);
    }
?>
