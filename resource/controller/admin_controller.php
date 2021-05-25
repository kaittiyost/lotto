<?php 
    session_start();
    include(__DIR__."/../database/db_config.php");
    class GetData{
        function __construct(){
            if(!isset($_SESSION["adminLoginStatus"])){
                header("location:".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]."/admin/login_admin.php");
            }
        }
        public function lottery($key){
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
        public function addLottery($img,$lottoData){
            try {
                if(isset($_SESSION["adminLoginStatus"])){
                    if(((string)$img["type"])!="image/jpeg"){
                        echo "non_type";
                    }else{
                        //---move file----
                        $conn = DB::getConnect();
                        $number  = htmlentities($conn->escape_string($lottoData["number"]));
                        $stock = htmlentities($conn->escape_string($lottoData["stock"]));
                        $price = htmlentities($conn->escape_string($lottoData["price"]));
                        $date = htmlentities($conn->escape_string($lottoData["date"]));
                        $status = htmlentities($conn->escape_string($lottoData["status"]));
                        $imgName = $number."-".date("d_m_Y").".".explode(".",$img["name"])[(sizeof(explode(".",$img["name"])))-1];
        
                        $imgOnServer = __DIR__."/../../images/item/".$imgName;
                        if(move_uploaded_file($img["tmp_name"],$imgOnServer)){
                            $sql = "INSERT INTO lottery SET number='".$number."',date='".$date."',stock=".$stock.",img='".$imgName."'"
                                   .",price=".$price.",status=".$status;
                            echo ($conn->query($sql))?"1":"error";
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

    class API{
        public function loginAdmin($loginData){
            try {
                $conn = DB::getConnect();

                $username =$conn->escape_string( $loginData['username']);
                $password = hash("sha256",$conn->escape_string($loginData['password']),false);

                $sql = "SELECT * FROM admin WHERE username='".$username
                        ."' AND password='".$password."' limit 1";
                $result = $conn->query($sql);
                if($conn->affected_rows>0){
                    $userData = $result->fetch_array();
                    $_SESSION['adminData'] = $userData;
                    $_SESSION['adminLoginStatus'] = true;
                    echo '1';
                }else{
                    echo '0';
                }
            } catch (Exception $e) {
                echo "Error -->".$th->getMessage();
            }

        }
        public function logout(){
            try {
                session_destroy();
                echo 1;
            } catch (Exception $th) {
                echo "Error -->".$th->getMessage();
            }
        }
    }

    if(isset($_POST["func"])){
        $choice = $_POST["func"];
        switch($choice){
            case "login_admin":
                $api = new API();
                $api->loginAdmin(["username"=>$_POST['username']
                                 ,"password"=>$_POST["password"]]);
                break;
            case "logout":
                $api = new API();
                $api->logout();
                break;
        }
    }

    if(isset($_FILES["img"])){
        $exeData = new ExeData();
        $exeData->addLottery($_FILES["img"],$_POST);
    }
?>