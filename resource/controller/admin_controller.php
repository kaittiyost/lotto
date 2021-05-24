<?php 
    session_start();
    include(__DIR__."/../database/db_config.php");
    class GetData{
        function __construct(){
            if(!isset($_SESSION["adminLoginStatus"])){
                header("location:".$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]."/admin/login_admin.php");
            }
        }
    }

    class ExeData{

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
        }
    }
?>