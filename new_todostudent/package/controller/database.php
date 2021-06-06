<?php 
    class ConnectDB{
         function getConnect(){
                $conn = null;
                $conn = new mysqli('localhost','root','','todo_database');
                if($conn->connect_errno){
                    echo 'CONNECT DB ERROR!';
                }else{
                    $conn->set_charset('utf8mb4');
                    return $conn;
                }
        }
    }
?>