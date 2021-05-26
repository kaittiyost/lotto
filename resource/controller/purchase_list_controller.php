<?php 
session_start();
include(__DIR__."/../database/db_config.php");
class GetData{
    function __construct(){
        if(!isset($_SESSION["loginStatus"])){
            header("location:".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]);
        }
    }
    public static function purchase_list(){
        try{
            $conn = DB::getConnect();
            $sql = "SELECT sales.id ,\n".
            "sales.`status`,\n".
            "sales_det.lottery_id,\n".
            "sales_det.price as price,\n".
            "sales_det.quan ,\n".
            "user.USER_NAME, \n".
            "user.USER_LASTNAME, \n".
            "DATE_FORMAT(sales.reg_date,'%d-%m-%Y') as date, \n".
            "DATE_FORMAT(lottery.date,'%d-%m-%Y') as lot_date, \n".
            "TIME(sales.reg_date) as time ,\n".
            "lottery.number ,\n".
            "lottery.img,\n".
            "img_confirm.img,\n".
            "IFNULL(img_confirm.img ,'0') as slip\n".
            "FROM sales LEFT JOIN sales_det ON sales_det.sale_id = sales.id \n".
            "LEFT JOIN lottery ON sales_det.lottery_id = lottery.id\n".
            "LEFT JOIN user ON sales.user_id = user.USER_ID\n".
            "LEFT JOIN img_confirm ON img_confirm.sale_id = sales.id  \n".
            "AND sales.id = img_confirm.sale_id\n".
            "WHERE user.USER_ID = ".$_SESSION['userData']['USER_ID']." \n".
            "ORDER BY  sales.reg_date DESC";

            $result = $conn->query($sql);
            return (($conn->affected_rows)<=0)?Null:$result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function payment_list($sale_id){
        try{
            $conn = DB::getConnect();
            $sql = "SELECT sales.id as s_id , \n".
            "SUM(sales_det.price) as price ,\n".
            "SUM(sales_det.quan) as quan , \n".
            "DATE(sales.reg_date) as date,\n".
            "TIME_FORMAT(sales.reg_date,'%H:%i') as time ,\n".
            "ADDTIME(TIME_FORMAT(sales.reg_date,'%H:%i'), '0:30:0') as deadline\n".
            "FROM sales , sales_det\n".
            "WHERE sales.id=".$sale_id." \n".
            "AND sales.id = sales_det.sale_id";

            $result = $conn->query($sql);
            return (($conn->affected_rows)<=0)?Null:$result->fetch_array();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}

class ExeData{
    public function add_slip(){
        try {
            if(isset($_SESSION["loginStatus"])){
                if(isset($_FILES['img'])){
                    if($_FILES['img']['error']==0){
                            if($_FILES['img']['type']!='image/jpeg'){
                                echo 'file not jpg!';
                            }else{
                                $folder = 'slip';
                                $dirImg = $_FILES['img']['tmp_name'];
                                $targetPath = __DIR__.'/../images/'.$folder.'/'.$_FILES['img']['name'];
 
                                if(move_uploaded_file($dirImg,$targetPath)){
                                    echo 'uploaded!';
                                }else{
                                    echo 'upload error!';
                                }
                            }
                    }else{
                        echo 'upload error!';
                    }
                }
  
            }else{
                echo "non_login";
            }
        } catch (Exception $e) {
            echo "error-->".$e->getMessage();
        }
    }
}

if(isset($_POST["func"])){
 if($_POST["func"]== "add_slip"){
    $exeData = new ExeData();
    $exeData->add_slip();
    }
}
?>