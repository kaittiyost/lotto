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
                $sql = "SELECT sales.*,user.USER_USERNAME,SUM(sd.price) as sum FROM \n".
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
       
    }

    class API{

    }

    if(isset($_POST["func"])){
        $choice = $_POST["func"];
        switch($choice){
            case "" :
                break;
        }
    }
?>