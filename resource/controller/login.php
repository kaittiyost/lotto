<?php
    session_start();
    include(__DIR__."/../database/db_config.php");
    include(__DIR__."/../include/util.php");
    require(__DIR__."/../ex_package/vendor/autoload.php");

    function loginFb($userData){
        try {
            $conn = DB::getConnect();
            $fbId = htmlentities($conn->escape_string($userData["fb_id"]));
            $fbName = htmlentities($conn->escape_string($userData["fb_name"]));
            $imgProfile = htmlentities($conn->escape_string($userData["img"]));
            $sql = "SELECT user.* FROM fb_user INNER JOIN user ON fb_user.user_id = user.USER_ID \n".
                    " WHERE FB_ID=".$fbId;
            $result = $conn->query($sql);
            if(($conn->affected_rows)>0){
                $userData = $result->fetch_array();
                $_SESSION['userData'] = $userData;
                $_SESSION['loginStatus'] = true;
                echo "old_user";
            }else{
                $fullName = explode(" ",$fbName);
                $sql = "INSERT INTO user SET USER_USERNAME='".$fbId."',USER_PASSWORD='".hash("sha256",Util::randomPassword(),false)."'".
                        ",USER_NAME='".$fullName[0]."',USER_LASTNAME='".(string)$fullName[(sizeof($fullName)-1)]."',img='".$imgProfile."'";
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

    function loginGoogle($userData){
        try {
            $CLIENT_ID = "1036552871785-hp22bf6mmcfgdto7nrkajn39s558on4j.apps.googleusercontent.com";
            $client = new Google_Client(['client_id' => $CLIENT_ID]); 
            $payload = $client->verifyIdToken($userData["tokenId"]);
            if ($payload){
                $userid = $payload['sub'];
                $conn = DB::getConnect();
                $sql = "SELECT user.* FROM gg_user INNER JOIN user ON gg_user.user_id = user.USER_ID\n".
                        "WHERE gg_user.gg_id='".$userid."'";
                $result = $conn->query($sql);
                if(($conn->affected_rows)>0){
                    $userData = $result->fetch_array();
                    $_SESSION['userData'] = $userData;
                    $_SESSION['loginStatus'] = true;
                    echo "old_user";
                }else{
                    $fullName = explode(" ",$payload["name"]);
                    $sql = "INSERT INTO user SET USER_USERNAME='".$userid."',USER_PASSWORD='".hash("sha256",Util::randomPassword(),false)."'".
                            ",USER_NAME='".$fullName[0]."',USER_LASTNAME='".(string)$fullName[(sizeof($fullName)-1)]."',USER_EMAIL='".$payload["email"]."'".
                            ",img='".$payload["picture"]."'";
                    if($conn->query($sql)){
                        $lastId = $conn->insert_id;
                        $conn->query("INSERT INTO gg_user SET user_id=".$lastId.",gg_id=".$userid);
                        $result = $conn->query("SELECT * FROM user WHERE USER_ID=".$lastId." LIMIT 1");
                        $userData = $result->fetch_array();
                        $_SESSION['userData'] = $userData;
                        $_SESSION['loginStatus'] = true;
                        echo "new_user";
                    }
                }
            } else {
                echo "0";
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
            case "loginFb":
                loginFb($_POST);
                break;
            case "loginGoogle":
                loginGoogle($_POST);
                break;
            case "logout" :
                logout();
                break;
        }
    }
?>