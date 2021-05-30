<?php 
session_start();
include(__DIR__."/../database/db_config.php");
class GetData{
    function __construct(){
        if(!isset($_SESSION["loginStatus"])){
            header("location:".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]);
        }
    }
    public function profile(){
        try{
            $conn = DB::getConnect();
            $sql = "SELECT user_id,user_username,user_uuid,user_lastname , user_tel , user_email,user_name FROM user WHERE user_id=".$_SESSION["userData"]["USER_ID"];
            $result  = $conn->query($sql);
            return (($conn->affected_rows)<=0)?Null:$result->fetch_array();
        }catch(Exception $e){
            echo "error->".$e->getMessage();
        }
    }
}

class EexData{
    public function update_profile(){
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

public function add_tel(){
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
public function add_email(){
   try{
    if(isset($_SESSION["loginStatus"])){
        $conn = DB::getConnect();
        $email = htmlentities($conn->escape_string( $_POST['email']));
        
        $sql = "UPDATE user SET  USER_EMAIL = '".$email."' WHERE USER_ID = ".$_SESSION['userData']['USER_ID'];
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

public function update_password(){
   try{
    if(isset($_SESSION["loginStatus"])){
        $conn = DB::getConnect();
        $new_password = htmlentities($conn->escape_string( $_POST['new_password']));
        $password_hash = hash("sha256",$new_password,false);

        $sql = "UPDATE user SET  USER_PASSWORD = '".$password_hash."' WHERE USER_ID = ".$_SESSION['userData']['USER_ID'];
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
}

class API{

}

if(isset($_POST["func"])){

    if($_POST["func"]== "update_profile"){
       // update_profile();
    }else  if($_POST["func"]== "add_tel"){
        EexData::add_tel();
    }else  if($_POST["func"]== "add_email"){
        EexData::add_email();
    }else  if($_POST["func"]== "update_password"){
        EexData::update_password();
    }
}
?>