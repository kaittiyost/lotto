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
?>