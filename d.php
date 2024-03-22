<?php
    function get_user( $id= null, $name = null)
    {
        include("model.php");
        $db = new Takesql($conn);
        $users = new User;
        if ( $name == null  && $id == null)
        {
            $sql = "select * from users_table ";
            $result =$db->take_sql_from_user($sql);
        }
        else if ($name == null)
        {
            $param = [":id" => $id];
            $sql = "select * from users_table  where id = :id";
            $result =$db->take_sql_from_user($sql , $param);
        }
        else 
        {
            $sql = "SELECT * FROM users_table WHERE name = :name";
            $param = [":name" => $name];
            $result =$db->take_sql_from_user($sql , $param);
        }
        //return user depends on class User
        $result->setFetchMode(PDO::FETCH_CLASS,'User');
        $row = $result->rowCount();
        $user_list = [];
        if($row >0)
        {
            for($i = 0 ; $i<$row ; $i++)
            {
                $users = $result->fetch();
                $user_list[$i] = $users->get_user_data();
            }
        }
        return $user_list;
    }
    function check_admin_exist($user_list)
    {
        $admin_exist  = false;
        foreach($user_list as $user)
        {
            if($user["is_admin"])
            {
                $admin_exist = true;
            }
        }
        return $admin_exist;
    }
    function login($username,$pass)
    {
        $user_list = get_user();
        session_start();
        $is_exist = false;
        $user_id = null;
        $is_admin = false;
        $name = "";
        foreach($user_list as $user){
            if ($user["username"] == $username && password_verify($pass , $user["password"])){
                $is_exist = true;
                $user_id = $user["id"];
                $is_admin  = $user["is_admin"];
                $name = $user["name"];
            }
        }
        if(!$is_exist){
            return false;
        }
        else{
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $user_id;
            $_SESSION["is_admin"] =$is_admin;
            $_SESSION["name"]= $name;
            return true;
        }
    }
    //create admin
    function create_admin()
    {
        session_start();
        $_SESSION["create_admin"] = true;
        header("location:signuppage.php");
    }
    //logout
    if(isset($_POST["logout"])){
        session_start(); // Bắt đầu hoặc tiếp tục phiên làm việc
        session_destroy(); // Hủy bỏ phiên làm việc hiện tại
        session_unset(); // Xóa tất cả dữ liệu trong phiên làm việc
        session_regenerate_id(); // Tạo một phiên làm việc mới
        header("location:login.php");
    } 
    function signup($name , $username , $password ,$confirm_password , $user_list,  $is_admin ,$conn)
    {
        $valid_user = true;
        if(empty($name) or empty($username) or empty($password)){
            $valid_user = false;
        }
        foreach($user_list as $user){
            if($username == $user["username"]){
                $valid_user = false;
            }
        }
        if($password != $confirm_password){
            $valid_user = false;
        }
        if($valid_user){
            if ($is_admin){
                $is_admin = '1';
            }
            else{
                $is_admin = '0';
            }
            $password = password_hash($password ,PASSWORD_DEFAULT);
            $user = new User;
            $user->set_user_data($name,$username, $password , $is_admin);
            $user = $user->for_query_sql();
            $sql = "INSERT INTO users_table (name, username, password , is_admin) VALUES (:name, :username,:password ,:is_admin )";
            $db = new Takesql($conn);
            $db->take_sql_from_user($sql , $user);
            if(isset($_SESSION["create_admin"])){
                session_unset();
                session_destroy();
            }
            return true;
        }   
    }
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
    function set_user_message($message , $user_id , $conn)
    {
        $db = new Takesql($conn);
        $mess_manager = new MessageManager();
        $mess_manager->set_mess($message , $user_id);
        $sql = "insert into message(message , user_id) values (:message , :user_id)";
        $param  = $mess_manager->get_mess_for_sql();  
        $db->take_sql_from_user($sql , $param);
    }
    if(isset($_POST["login"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
    }
?>
