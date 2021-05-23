<?php 
session_start();
include(__DIR__."/../database/db_config.php");

function update_profile(){

    try{
        if(isset($_SESSION["loginStatus"])){
            $conn = DB::getConnect();

            $name = htmlentities($conn->escape_string( $_POST['name']));
            $lastname = htmlentities($conn->escape_string( $_POST['lastname']));
            $tel = htmlentities($conn->escape_string( $_POST['tel']));
            $email = htmlentities($conn->escape_string( $_POST['email']));

            $sql = "UPDATE user SET  USER_NAME ='".$name."' , USER_LASTNAME ='".$lastname."' , USER_TEL = '".$tel."' , USER_EMAIL = '".$email."' WHERE USER_ID = ".$_SESSION['userData']['USER_ID'];
            $result = $conn->query($sql);
            if($result){

                echo 1;
            }else{

                echo 0;
            }
        }else{
          echo 'non login';
      }
  }catch(Exception $e){
    echo "error -->".$e->getMessage();
}
}

function add_tel(){
   try{
    if(isset($_SESSION["loginStatus"])){
        $conn = DB::getConnect();
        $tel = htmlentities($conn->escape_string( $_POST['tel']));

        $sql = "UPDATE user SET  USER_TEL = '".$tel."' WHERE USER_ID = ".$_SESSION['userData']['USER_ID'];
        $result = $conn->query($sql);
        if($result){

            echo 1;
        }else{

            echo 0;
        }
    }else{
      echo 'non login';
  }
}catch(Exception $e){
    echo "error -->".$e->getMessage();
    }
}


if(isset($_POST["func"])){
    
    if($_POST["func"]== "update_profile"){
        update_profile();
    }else  if($_POST["func"]== "add_tel"){
        add_tel();
    }
}

?>