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
            "ADDTIME(TIME_FORMAT(sales.reg_date,'%H:%i'), '0:30:0') as deadline,\n".
            "img_confirm.img , \n".
            "sales.`status`\n".
            "FROM sales , sales_det , img_confirm\n".
            "WHERE sales.id=".$sale_id."\n".
            "AND sales.id = sales_det.sale_id\n".
            "AND sales.id = img_confirm.sale_id";

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
           $conn = DB::getConnect();
           if(isset($_SESSION["loginStatus"])){
            if(isset($_FILES['img'])){
                if($_FILES['img']['error']==0){
                    if($_FILES['img']['type']!='image/jpeg'){
                        echo 'file not jpg!';
                    }else{
                        $img = $_FILES['img'];
                        $folder = 'slip';
                        $imgName = 'SLIP'.date("d_m_Y")."SID".$_POST['sale_id'].'.'.explode(".",$img["name"])[(sizeof(explode(".",$img["name"])))-1];;
                        $imgOnServer = __DIR__."/../../images/slip/".$imgName;
                           //   echo 'img name = '.$imgName;
                        if(move_uploaded_file($img["tmp_name"],$imgOnServer)){
                            $sql = "UPDATE `rotto`.`img_confirm` SET `img` = '".$imgName."', `date_upload` = '".$_POST['date_upload']."', `time_upload` = '".$_POST['time_upload']."', `bank_upload` = '".$_POST['bank']."' WHERE `sale_id` = ".$_POST['sale_id'];
                            $result = $conn->query($sql);
                            if($result){
                                echo 1;
                            }else{
                                echo 0;
                            }
                        }else{

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

function del_order(){
    try{
        if(isset($_SESSION["loginStatus"])){
            $conn = DB::getConnect();
            $sale_id = $_POST['sale_id'];
            $sql_del_img = "DELETE FROM `rotto`.`img_confirm` WHERE `sale_id` = ".$sale_id;
            $sql_sale_det = "DELETE FROM `rotto`.`sales_det` WHERE `sale_id` = ".$sale_id ;
            $sql_sale = "DELETE FROM `rotto`.`sales` WHERE `id` = ".$sale_id;

            $conn->query($sql_del_img);
            $conn->query($sql_sale_det);
            $conn->query($sql_sale);
            
            echo '1';
        }else{
          echo 'non login';
      }
  }catch(Exception $e){
    echo "error -->".$e->getMessage();
}
}
}

if(isset($_POST["func"])){
 if($_POST["func"]== "add_slip"){
    $exeData = new ExeData();
    $exeData->add_slip();
}else  if($_POST["func"]== "del_order"){
    $exeData = new ExeData();
    $exeData->del_order();
}
}
?>