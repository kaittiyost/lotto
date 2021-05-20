<?php 
    session_start();
    include(__DIR__."/../database/db_config.php");
    class GetData{
        public static function lottery($key){
            try{
                $conn = DB::getConnect();
                if(is_null($key)){
                    $sql = "SELECT * FROM lottery WHERE status = 1";
                    $result = $conn->query($sql);
                    return ($conn->affected_rows<=0)?NULL:$result;
                }else{
                    $key = htmlentities($conn->escape_string($key));
                    $key = str_replace("a","_",$key);
                    $sql = "SELECT * FROM lottery WHERE status = 1 AND number LIKE '".$key."'";
                    $result = $conn->query($sql);
                    return ($conn->affected_rows<=0)?NULL:$result;
                }
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }

    class ExeData{
        public function toCart($lottoId,$quan){
            $response = ["status"=>""];
            try{
                if(isset($_SESSION["loginStatus"])){
                    $conn = DB::getConnect();
                    $lottoId = htmlentities($conn->escape_string($lottoId));
                    $sql = "INSERT INTO bucket SET user_id = ".$_SESSION['userData']['USER_ID']
                            .",lottery_id = ".$lottoId.",quan = ".$quan;
                    if($conn->query($sql)){
                        $response["status"] = 1;
                        echo json_encode($response);
                    }else{
                        $response["status"] = 0;
                        echo json_encode($response);
                    }
                }else{
                    $response["status"] = "non_login";
                    echo json_encode($response);
                }
            }catch(Exception $e){
                echo "error -->".$e->getMessage();
            }
        }
    }

    if(isset($_POST["func"])){
        $choice = $_POST["func"];
        switch($choice){
            case "toCart":
                $exeData = new ExeData();
                $exeData->toCart($_POST["lotId"],$_POST["quan"]);
        }
    }
?>