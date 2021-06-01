<?php 
session_start();
include(__DIR__."/../database/db_config.php");
class GetData{
    function __construct(){
        if(!isset($_SESSION["adminLoginStatus"])){
            header("location:".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]."/admin/login_admin.php");
        }
    }
    public function bank_account_list(){
        try {
            $conn = DB::getConnect();
            $sql = "SELECT bank_account.id , \n".
            "bank_account.bank_type , \n".
            "bank_account.bank_account_id,\n".
            "bank_account.bank_account_name,\n".
            "bank_account.status , \n".
            "bank.id as bank_id,\n".
            "bank.name ,\n".
            "bank.img \n".
            "FROM bank_account , bank \n".
            "WHERE  bank.id = bank_account.bank_id;";
            $result = $conn->query($sql);
            return (($conn->affected_rows)>0)?$result:Null;
        } catch (Exception $e) {
            echo "eror-->".$e->getMessage();
        }
    }
    public function all_bank(){
        try {
            $conn = DB::getConnect();
            $sql = "SELECT * FROM bank";
            $result = $conn->query($sql);
            return (($conn->affected_rows)>0)?$result:Null;
        } catch (Exception $e) {
            echo "eror-->".$e->getMessage();
        }
    }
}

class ExeData{
    function add_bank_account(){
        try {
            if(!isset($_SESSION["adminLoginStatus"])){
                echo "non_login";
            }else{
             $conn = DB::getConnect();
             $bank_account_id = htmlentities($conn->escape_string( $_POST['bank_account_id']));
             $bank_id = htmlentities($conn->escape_string( $_POST['bank_id']));
             $bank_type = htmlentities($conn->escape_string( $_POST['bank_type']));
             $bank_account_name = htmlentities($conn->escape_string( $_POST['bank_user_name']));

             $sql = "INSERT INTO `bank_account` (`id`, `bank_account_name`, `bank_id`, `bank_type`, `bank_account_id`, `bank_user`, `status`, `time_reg`) VALUES (NULL, '".$bank_account_name."', '".$bank_id."', '".$bank_type."', '".$bank_account_id."', '".$_SESSION['adminData']['id']."', '0', current_timestamp());";

             echo ($conn->query($sql))?1:0;
             $conn->close();
         }
     } catch (Exception $e) {
        $e->getMessage();
    }
}
function edit_bank_account(){
    try {
        if(!isset($_SESSION["adminLoginStatus"])){
            echo "non_login";
        }else{
         $conn = DB::getConnect();
         $bank_account_id = htmlentities($conn->escape_string( $_POST['bank_account_id']));
         $account_id = htmlentities($conn->escape_string( $_POST['account_id']));
         $bank_id = htmlentities($conn->escape_string( $_POST['account_bank']));
         $account_type = htmlentities($conn->escape_string( $_POST['account_type']));
         $account_name = htmlentities($conn->escape_string( $_POST['account_name']));
         $account_status = htmlentities($conn->escape_string( $_POST['account_status']));

         $sql = "UPDATE `bank_account` SET  `bank_account_name` = '".$account_name."', `bank_id` = '".$bank_id."', `bank_type` = '".$account_type."', `bank_account_id` = '".$account_id."', `bank_user` = '".$_SESSION['adminData']['id']."', `status` = '".$account_status."', `time_reg` = current_timestamp() WHERE `bank_account`.`id` = ".$bank_account_id ;
        // echo $sql;
         echo ($conn->query($sql))?1:0;
         $conn->close();
     }
 } catch (Exception $e) {
    $e->getMessage();
}
}
function del_bank_account(){
    try {
        if(!isset($_SESSION["adminLoginStatus"])){
            echo "non_login";
        }else{
         $conn = DB::getConnect();
         $account_id = $_POST['account_id'];
         $sql = "DELETE FROM bank_account WHERE id =".$account_id;

         echo ($conn->query($sql))?1:0;
         $conn->close();
     }
 } catch (Exception $e) {
    $e->getMessage();
}
}

}

class API{

}

if(isset($_POST["func"])){
    $choice = $_POST["func"];
    switch($choice){
        case "add_bank_account" :
        ExeData::add_bank_account();
        break;       
        case "del_bank_account" :
        ExeData::del_bank_account();
        break;
        case "edit_bank_account" :
        ExeData::edit_bank_account();
        break;
    }
}
?>