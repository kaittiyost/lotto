<?php 
    session_start();
    include(__DIR__."/../database/db_config.php");
    class GetData{
        function __construct(){
            if(!isset($_SESSION["loginStatus"])){
                header("location:".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]);
            }
        }
        function cart(){
            try {
                $conn = DB::getConnect();
                $sql = "SELECT bucket.user_id\n".
                        "			,bucket.lottery_id\n".
                        "			,lottery.number\n".
                        "			,lottery.price\n".
                        "			,lottery.status\n".
                        "           ,lottery.img\n".
                        "			,SUM(bucket.quan) as quan\n".
                        "FROM \n".
                        "(\n".
                        "	SELECT * FROM bucket \n".
                        ")as bucket\n".
                        "INNER JOIN \n".
                        "(\n".
                        "	SELECT * FROM lottery\n".
                        ") as lottery\n".
                        "ON bucket.lottery_id = lottery.id\n".
                        "INNER JOIN \n".
                        "(\n".
                        "	SELECT * FROM user \n".
                        ") as user\n".
                        "ON user.USER_ID = bucket.user_id\n".
                        "WHERE bucket.user_id =".$_SESSION['userData']['USER_ID']."\n".
                        "GROUP BY bucket.lottery_id";
                $result = $conn->query($sql);
                return (($conn->affected_rows)<=0)?Null:$result;
            } catch (Exception $e) {
                 echo "error".$e->getMessage();
            }
        }
    }
    class ExeData{
        public function del($lotId){
            try{
                $conn = DB::getConnect();
                $lotId = htmlentities($conn->escape_string($lotId));
                $sql = "DELETE FROM bucket WHERE lottery_id = ".$lotId." AND user_id = ".$_SESSION["userData"]["USER_ID"] ;
                $response = ["status"=>""];
                $response["status"] = ($conn->query($sql))?1:0;
                echo json_encode($response);
            }catch(Exception $e){
                echo "error-->".$e->getMessage();
            }
        }
    }
    if(isset($_POST["func"])){
        $choice = $_POST["func"];
        switch($choice){
            case "del":
                $exeData = new ExeData();
                $exeData->del($_POST["lotId"]);
        }
    }
?>