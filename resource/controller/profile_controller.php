<?php 
session_start();
include(__DIR__."/../database/db_config.php");
class GetData{
    public static function profile(){
        try{
            if(isset($_SESSION["loginStatus"])){
                $conn = DB::getConnect();
                $sql = "SELECT user_id,user_username,user_uuid FROM user WHERE user_id=".$_SESSION["userData"]["USER_ID"];
                $result  = $conn->query($sql);
                return (($conn->affected_rows)<=0)?Null:$result->fetch_array();
            }else{
                header("location:".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]);
                return Null;
            }
        }catch(Exception $e){
            echo "error->".$e->getMessage();
        }
    }
}
?>