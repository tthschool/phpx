<?php
    function delete_user($conn , $id)
    {
       
        $db =new Takesql($conn);
        $param =  [":id"=>$id];

        $sql = ("DELETE FROM message WHERE user_id = :id");
        $db->take_sql_from_user($sql, $param);
        $sql = ("DELETE FROM users_table WHERE id=:id");
        $db->take_sql_from_user($sql , $param);
        header("location:homepage.php");

}