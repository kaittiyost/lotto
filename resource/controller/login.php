<?php
    session_start();
    include(__DIR__."/../database/db_config.php");
    function login(){
        $conn = DB::getConnect();

        $username =$conn->escape_string( $_POST['username']);
        $password = hash("sha256",$conn->escape_string($_POST['password']),false);
        $sql = "SELECT * FROM user WHERE user_username='".$username
                ."' AND user_password='".$password."' limit 1";
        $result = $conn->query($sql);
        if($conn->affected_rows>0){
            $userData = $result->fetch_array();
            $_SESSION['userData'] = $userData;
            $_SESSION['loginStatus'] = true;
            echo '1';
        }else{
            echo '0';
        }
    }

    if(isset($_POST["func"])){
        if($_POST["func"]=="login"){
            login();
        }
    }
?>