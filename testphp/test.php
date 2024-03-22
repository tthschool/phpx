<?php


    class DataBase
    {
        private $connection;
        function __construct($host , $username , $password , $database )
        {
            try
            {
                $dsn  = "mysql:host=$host;dbname=$database;charset=utf8";
                $conn = new PDO($dsn , $username , $password);
                $this->connection = $conn;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        function execute($sql  , $param = null)
        {
            if ($param != null)
            {

            }
            else
            {
                
            }
        }
    }
    class Takesql
    {
        private $db ;
        function __construct($db)
        {
            $this->db = $db;
        }
        function do_query($sql , $param = null)
        {
            if ($param != null)
            {

            }
            else
            {

            }
        }
    }
    class User
    {
        private $id ; 
        private $username;
        private $password;
        function __construct($username , $password)
        {
            $this->username = $username;
            $this->password = $password;
        }
        function get_data_for_sql()
        {
            $password = password_hash($this->password ,PASSWORD_DEFAULT);
            $user = [
                ":username"=>$this->username,
                ":password"=>$password
            ];
            return $user;
        }
    }
    class User_info
    {
        private $id;
        private $name;
        private $address;
        private $email;
        private $user_id ;
        function __construct($name , $address , $email , $user_id)
        {
            $this->name = $name;
            $this->address = $address;
            $this->email = $email;
            $this->user_id = $user_id;
        }
        function get_data_for_sql()
        {
            $user_info = [
                ":name"=>$this->name,
                ":address"=>$this->address,
                ":email"=>$this->email,
                ":user_id"=>$this->user_id
            ];
            return $user_info;

        }
        
    }
    class Cart
    {
        private $id ; 
        private $items;
        //owner id is id of user_info
        private $owner_id;
        function __construct($items , $owner_id)
        {
            $this->items = $items;
            $this->owner_id = $owner_id;
        }
        private function total_price()
        {
            $items = $this->items;
            $price = 0;
            foreach($items as $item)
            {
                $price+= $item["price"];
            }
            return $price;
        }
        public function get_cart()
        {
            $cart = [
                "owner"=>$this->owner_id,
                "items"=> $this->items,
                "total_price"=>$this->total_price()
            ];
            return $cart;
        }
    }
    class Items
    {
        private $name ; 
        private $price;
        private $expiry_date;
        function __construct($name , $price , $expiry_date)
        {
            $this->name  =$name;
            $this->price = $price;
            $this->expiry_date = $expiry_date;
        }
        public function get_item()
        {
            $item = ["name"=>$this->name,
                    "price"=>$this->price,
                    "expiry_date"=>$this->expiry_date];
            return $item;
        }
    }

    // $apple = new Items("apple" , 2 ,"2/3/2000");
    // $melon = new Items("melon" , 3 ,"2/3/2000");
    // $banana = new Items("banana" , 4 ,"2/3/2000");
    // $apple = $apple->get_item();
    // $banana = $banana->get_item();
    // $melon = $melon->get_item();
    // $items = [$apple , $banana , $melon];
    // $cart = new Cart($items , "234");
    // $cart = $cart->get_cart();
    // print_r($cart);
    // $cart = new Cart($item , "234");
    // $user = new User("ngochoang" , "anhhoang");
    // $user = $user->get_data_for_sql();
    // print_r($user);

    include("config.php");
    $db = new DataBase($config_file["host"] , $config_file["username"] , $config_file["password"],$config_file["database"]);
