<?php
    session_start();
    include(__DIR__."/../database/db_config.php");
    include(__DIR__."/../include/util.php");
    // function login(){
    //     $conn = DB::getConnect();

    //     $username =$conn->escape_string( $_POST['username']);
    //     $password = hash("sha256",$conn->escape_string($_POST['password']),false);
    //     $sql = "SELECT * FROM user WHERE user_username='".$username
    //             ."' AND user_password='".$password."' limit 1";
    //     $result = $conn->query($sql);
    //     if($conn->affected_rows>0){
    //         $userData = $result->fetch_array();
    //         $_SESSION['userData'] = $userData;
    //         $_SESSION['loginStatus'] = true;
    //         echo '1';
    //     }else{
    //         echo '0';
    //     }
    // }
    function loginFb($userData){
        try {
            $conn = DB::getConnect();
            $fbId = htmlentities($conn->escape_string($userData["fb_id"]));
            $fbName = htmlentities($conn->escape_string($userData["fb_name"]));
            $sql = "SELECT * FROM fb_user WHERE FB_ID=".$fbId;
            $result = $conn->query($sql);
            if(($conn->affected_rows)>0){
                $userData = $result->fetch_array();
                $_SESSION['userData'] = $userData;
                $_SESSION['loginStatus'] = true;
                echo "old_user";
            }else{
                $fullName = explode(" ",$fbName);
                $sql = "INSERT INTO user SET USER_USERNAME='".$fbId."',USER_PASSWORD='".hash("sha256",Util::randomPassword(),false)."'".
                        ",USER_NAME='".$fullName[0]."',USER_LASTNAME='".(string)$fullName[(sizeof($fullName)-1)]."'";
                if($conn->query($sql)){
                    $lastId = $conn->insert_id;
                    $conn->query("INSERT INTO fb_user SET USER_ID=".$lastId.",FB_ID=".$fbId);
                    $result = $conn->query("SELECT * FROM user WHERE USER_ID=".$lastId." LIMIT 1");
                    $userData = $result->fetch_array();
                    $_SESSION['userData'] = $userData;
                    $_SESSION['loginStatus'] = true;
                    echo "new_user";
                }
            }
        } catch (Exception $th) {
            echo "Error -->".$th->getMessage();
        }
    }
    function logout(){
        try {
            session_destroy();
            echo 1;
        } catch (Exception $th) {
            echo "Error -->".$th->getMessage();
        }
    }

    if(isset($_POST["func"])){
        switch($_POST["func"]){
            // case "login" :
            //     login();
            //     break;
            case "loginFb":
                loginFb($_POST);
                break;
            case "logout" :
                logout();
                break;
        }
    }
?>