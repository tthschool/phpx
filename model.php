<?php
    class Database {
        private $connection ;
        public function __construct($host,$username , $password , $database)
        {
            try{
               $dsn  = "mysql:host=$host;dbname=$database;charset=utf8";
               $this->connection= new PDO($dsn , $username, $password);
            }
            catch (PDOException $e){
                echo $e;
            }
        }
        public function doquery($sql){
         
            try{
                $query = $this->connection->prepare($sql);
                return  $query;
            }
            catch (PDOException $e)
            {
                echo "something went wrong in {$e}";
            }
        }
    }
    class User {
        private $id = null;
        private $name ;
        private $username ;
        private $password;
        private $is_admin ;
        //get data 
        public function get_user_data()
        {
            $user = [
                "id"=>$this->id,
                "name"=>$this->name,
                "username"=>$this->username,
                "password"=>$this->password,
                "is_admin"=>$this->is_admin,

            ];
            return $user;
        }
        public function set_user_data($name,$username , $password , $is_admin = false)
        {   
            $this->name  = trim(ucwords($name));
            $this->username = $username;
            $this->password = $password;
            $this->is_admin = $is_admin;
        }
        public function for_query_sql()
        {
        $user = [
            ":name"=>$this->name,
            ":username"=>$this->username,
            ":password"=>$this->password,
            ":is_admin"=>$this->is_admin,
        ];
        return $user;
        }
    }
    class Takesql{
        private $db ;
        public function __construct($db)
        {
            $this->db = $db;
        }
        private function query($sql ,$param = null ) 
        {
            if($param==null)
            {
                $result = $this->db->doquery($sql);
                $result->execute();
                return $result;
            }
            else
            {
                $result = $this->db->doquery($sql);
                foreach($param as $key=>&$value)
                {
                    $result->bindParam($key , $value);
                }
                $result->execute();
                return $result;
            }
        }
        public function take_sql_from_user($sql , $param=null)
        {
            $result = $this->query($sql , $param);
            return $result;
        } 
    }
    class MessageManager{
        private $id;
        private $message;
        private $create_time;
        private $user_id;
        public function set_mess($message , $user_id)
        {
            $this->message = $message ;
            $this->user_id = $user_id ;
        }
        public function get_mess_for_sql()
        {
            $message = [
                ":message"=>$this->message,
                ":user_id"=>$this->user_id,
            ];
            return $message;
        }
        public function get_mess()
        {
            $message = [
                "id" => $this->id,
                "message"=>$this->message,
                "create_time"=>$this->create_time,
                "user_id"=>$this->user_id,
            ];
            return $message;
        }
    }
    include("config.php");
    $conn = new Database($config_file["host"],
                        $config_file["username"] ,
                        $config_file["password"] ,
                        $config_file["database"]);
?>