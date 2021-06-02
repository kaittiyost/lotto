<?php 
    session_start();
    include(__DIR__."/../database/db_config.php");
    class GetData{
        function __construct(){
            if(!isset($_SESSION["adminLoginStatus"])){
                header("location:".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]."/admin/login_admin.php");
            }
        }
        public function sales($status){
            try {
                $conn = DB::getConnect();
                $sql = "SELECT sales.*,user.USER_USERNAME,USER_NAME,USER_LASTNAME,SUM(sd.price) as sum,IFNULL(img_confirm.img,'no_confirm') as img FROM \n".
                    "(\n".
                    "	SELECT * FROM sales\n".
                    ") as sales\n".
                    "INNER JOIN\n".
                    "(\n".
                    "	SELECT * FROM user\n".
                    ") as user\n".
                    "ON sales.user_id = user.USER_ID\n".
                    "INNER JOIN\n".
                    "(\n".
                    "	SELECT * FROM sales_det\n".
                    ") as sd\n".
                    "ON sales.id = sd.sale_id\n".
                    "INNER JOIN (".
                        "SELECT * FROM img_confirm".
                    ") as img_confirm ".
                    "ON sales.id = img_confirm.sale_id\n".
                    "WHERE sales.status=".$status."\n".
                    "GROUP BY sales.id;";
                $result = $conn->query($sql);
                return (($conn->affected_rows)>0)?$result:Null;
            } catch (Exception $e) {
                echo "eror-->".$e->getMessage();
            }
        }
    }

    class ExeData{
        function confirmSale($id){
            try {
                if(!isset($_SESSION["adminLoginStatus"])){
                    echo "non_login";
                }else{
                    $conn = DB::getConnect();
                    $id = htmlentities($conn->escape_string($id));
                    $sql = "UPDATE sales SET status = 1 WHERE id=".$id;
                    echo ($conn->query($sql))?1:0;
                    $conn->close();
                }
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
       
    }

    class API{
        public function getSalesDet($sale_id){
            try{
                if(!isset($_SESSION["adminLoginStatus"])){
                    echo "non_login";
                }else{
                    $conn = DB::getConnect();
                    $sale_id = htmlentities($conn->escape_string($sale_id));
                    $sql = "SELECT sales.id,lottery.number,lottery.price,sales_det.quan\n".
                    "FROM \n".
                    "sales\n".
                    "INNER JOIN sales_det ON sales.id = sales_det.sale_id\n".
                    "INNER JOIN lottery ON sales_det.lottery_id = lottery.id\n".
                    "WHERE sales.id = ".$sale_id;
                    $result = $conn->query($sql);
                    $resultJson = [];
                    while(($row=$result->fetch_array())!=null){
                        array_push($resultJson,$row);
                    }
                    echo json_encode($resultJson);
                }
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }

    if(isset($_POST["func"])){
        $choice = $_POST["func"];
        switch($choice){
            case "getSalesDet" :
                API::getSalesDet($_POST["sales_id"]);
                break;
            case "confirmSale" :
                ExeData::confirmSale($_POST["sales_id"]);
                break;
        }
    }
?>