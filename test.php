<?php

    include("database.php");
    $sql = $conn->prepare("SELECT *  FROM users");
    //truyen thamn so
    // -- $sql-> bind_param("s" ,$name);
    //thuc thi 
    $sql->execute();
    // $sql->bind_result($result);
    // $sql->fetch();
    // echo $result;

    $resul = $sql->get_result();

    $rows  = $resul->fetch_all();
    $sql -> close();
    $data = [];
    for($i = 0 ; $i< $resul->num_rows; $i++){
        // print_r($rows[$i]);
        $data[$i] = [
            "id" => $rows[$i]["0"],
            "username" => $rows[$i]["1"],
            "name" => $rows[$i]["3"],
            "is_admin" => $rows[$i]["4"]
        ];
      
    }
    print_r($data)
   
    


?>