<?php 
session_start();
include ('database.php');
include (__DIR__.'/../content/util.php');

//------find function-------
if(isset($_POST['func'])){
    switch($_POST['func']){
        case 'authen':
            authen();
            break;
        case 'addWork':
            addWork();
            break;
        case 'delWork':
            delWork();
            break;
        case 'editWork':
            editWork();
            break;
        case 'doneWork':
            doneWork();
            break;
        case 'logout':
            logout();
            break;
        case 'cancelLineNotify':
            cancelLineNotify();
            break;
        case 'addLineToken':
            addLineToken();
            break;
        case 'regis':
            regis();
            break;
    }
   
}

function authen(){
    $conn = ConnectDB::getConnect();

    $username =$conn->escape_string( $_POST['username']);
    $password = sha1($conn->escape_string($_POST['password']));
    $sql = "SELECT * FROM USER WHERE user_username='".$username."' limit 1";
   
    $result = $conn->query($sql);
    
    if($conn->affected_rows>0){
        $userData = $result->fetch_array();
        if($userData['USER_PASSWORD']!=$password){
            echo '1';
        }else{
            $_SESSION['userData'] = $userData;
            $_SESSION['loginStatus'] = true;
            setCookieSystem((int)$_POST['inSystem'],$userData['USER_UUID']);
            echo '2';
        }
    }else{
        echo '0';
    }
}

function setCookieSystem($status,$userId){
    $day = 30;
    $timeCookie = ($status==1)?($day*60*60*24):1800;
    setcookie('loginID',$userId,time()+$timeCookie,'/');
    setcookie('loginTime',$timeCookie,time()+$timeCookie,'/');
}

function regis(){
    $conn = ConnectDB::getConnect();
    $sql = "SELECT * FROM USER WHERE USER_USERNAME = '".$conn->escape_string($_POST['user_name'])."'";
    $result = $conn->query($sql);
    if($conn->affected_rows>0){
        echo '-1';
    }else{
        $util = new ThewinUtil();
        $sql = "INSERT INTO USER(USER_USERNAME,USER_NICKNAME,USER_PASSWORD,USER_UUID)"
                    ."      VALUES('".htmlentities($conn->escape_string($_POST['user_name']))."',"
                                    ."'".htmlentities($conn->escape_string($_POST['user_nickname']))."'"
                                    .",'".sha1($conn->escape_string($_POST['user_password']))."'"
                                    .",'".$util->gen_uuid()."')";
        echo ($conn->query($sql))?'1':'0';
    }
}

function addWork(){
    $conn = ConnectDB::getConnect();

    $userId = $_SESSION['userData']['USER_ID'];
    $addName = $conn->escape_string($_POST['add_name']);
    $addDesc = $conn->escape_string($_POST['add_descript']); 
    $addDate = $conn->escape_string($_POST['add_date']);

    $sql = "INSERT INTO WORK(USER_ID,WORK_NAME,WORK_DESC,WORK_DEADLINE,WORK_STATUS) \n"
                ."VALUES(".$userId.",'".htmlentities($addName)."','".htmlentities($addDesc)
                ."','".htmlentities($addDate)."',1)";

    if($conn->query($sql)){
        echo 'true';
    }else{
        echo 'false';
    }
}

function editWork(){
    $conn = ConnectDB::getConnect();
    $sql  = "UPDATE WORK SET WORK_NAME='".htmlentities($conn->escape_string($_POST['update_name']))."' "
                            ." ,WORK_DESC='".htmlentities($conn->escape_string($_POST['update_desc']))."' "
                            ." ,WORK_DEADLINE='".htmlentities($conn->escape_string($_POST['update_date']))."' "
                            ." WHERE WORK_ID='".htmlentities($conn->escape_string($_POST['update_id']))."' ";
    if($conn->query($sql)){
        echo 'true';
    }else{
        echo 'false';
    }
}

function doneWork(){
    $conn = ConnectDB::getConnect();
    $sql = 'UPDATE WORK SET work_status = 0 WHERE work_id ='.htmlentities($conn->escape_string($_POST['id']));
    if($conn->query($sql)){
        echo 'true';
    }else{
        echo 'false';
    }
}

function delWork(){
    $conn = ConnectDB::getConnect();
    $id = $conn->escape_string($_POST['id']);
    $sql = 'DELETE FROM WORK WHERE WORK_ID='.$id;
    if($conn->query($sql)){
        echo 'true';
    }else{
        echo 'false';
    }
}

function addLineToken(){
    $conn = ConnectDB::getConnect();
    $sql = "INSERT INTO USER_LINE_TOKEN(USER_ID,USER_TOKEN)".
            " VALUES(".$_SESSION['userData']['USER_ID'].",'".htmlentities($conn->escape_string($_POST['user_token']))."')";
    if($conn->query($sql)){
        echo 'true';
    }else{
        echo 'false';
    }
}

function cancelLineNotify(){
    $conn = ConnectDB::getConnect();
    $sql ='DELETE FROM USER_LINE_TOKEN WHERE USER_ID ='.$_SESSION['userData']['USER_ID'];
    if($conn->query($sql)){
        echo 'true';
    }else{
        echo 'false';
    }
}

function logout(){
    setcookie('loginID',null,time()+0,'/');
    session_destroy();
    echo 'true';
}

//------get Data-------------
function checkLogin(){
    if(isset($_COOKIE['loginID'])&&strlen($_COOKIE['loginID'])>3){
            $_SESSION['userData'] = findUserDataByUUID($_COOKIE['loginID']);
            $_SESSION['loginStatus'] = true;
            return true;
    }else{
            return false;
    }
}

function findUserDataByUUID($uuid){
    $conn = ConnectDB::getConnect();
    $sql = "SELECT * FROM USER WHERE USER_UUID = '".$uuid."' LIMIT 1";
    $result = $conn->query($sql);
    return ($conn->affected_rows>0)?$result->fetch_array():null;
}

function getAllWork($workStatus){
    $conn = ConnectDB::getConnect();
    $sql ="SELECT USER_ID,WORK_ID,WORK_NAME,IFNULL(WORK_DESC,'') AS 'WORK_DESC'\n".
        ",WORK_STATUS\n" .
        ",WORK_DEADLINE as 'ORIGIN_DEADLINE' \n ".
        ",IFNULL(IF(DATEDIFF(WORK_DEADLINE,CURRENT_DATE)<=7,DATEDIFF(WORK_DEADLINE,CURRENT_DATE)".
        ",WORK_DEADLINE),'ไม่กำหนด') \n".
        "AS 'WORK_DEADLINE'\n".
        "FROM WORK WHERE user_id =".$_SESSION['userData']['USER_ID']." and work_status = ".$workStatus." \n".
        "ORDER BY DATE(ORIGIN_DEADLINE) ASC";
    return $conn->query($sql);
}

function getCountWork(){
    $conn = ConnectDB::getConnect();
    $sql = "SELECT COUNT(*) as 'COUNT' FROM WORK WHERE USER_ID=".$_SESSION['userData']['USER_ID']." AND WORK_STATUS=1";
    $result = $conn->query($sql);
    return (int) $result->fetch_array()['COUNT'];
}

function checkRegisLineNotify(){
    $conn = ConnectDB::getConnect();
    $sql = 'SELECT * FROM USER_LINE_TOKEN WHERE USER_ID='.$_SESSION['userData']['USER_ID'];
    $conn->query($sql);
    return ($conn->affected_rows>0)?true:false;
}

function getCountWorkMonth($allWork){
    $conn = ConnectDB::getConnect();
    $data  = [];
    $sql = '';
    for($i=3;$i>=0;$i--){

        if($allWork){
            $sql = "	SELECT COUNT(*) AS COUNT FROM WORK\n".
                    "	WHERE \n".
                    "	MONTH(WORK_DEADLINE) = MONTH(DATE_ADD(CURRENT_DATE,INTERVAL -".$i." MONTH))\n".
                    "	AND USER_ID = ".$_SESSION['userData']['USER_ID'];
        }else{
            $sql = "SELECT COUNT(*) AS COUNT FROM \n".
                    "(\n".
                    "	SELECT * FROM WORK_DONE_LOG\n".
                    "	WHERE \n".
                    "	MONTH(TIME_REG)=MONTH(DATE_ADD(CURRENT_DATE,INTERVAL -".$i." MONTH))\n".
                    "	AND \n".
                    "	YEAR(TIME_REG)=YEAR(DATE_ADD(CURRENT_DATE,INTERVAL -".$i." MONTH))\n".
                    ")AS D\n".
                    "INNER JOIN\n".
                    "(\n".
                    "	SELECT * FROM WORK\n".
                    "    WHERE USER_ID = ".$_SESSION['userData']['USER_ID']." \n".
                    ")AS W\n".
                    "ON\n".
                    "W.WORK_ID = D.WORK_ID \n".
                    "GROUP BY W.USER_ID";
        }

        $row = $conn->query($sql)->fetch_array();
        $numOfMonth =(int)(isset($row['COUNT']))?$row['COUNT']:"0";
        array_push($data,$numOfMonth);
    }
    return json_encode($data);
}

function backDateByCurrentDate($month){
    $monthSet = [];
    $date = date_create(date('Y-m-d'));
    $util = new ThewinUtil();

    for($i=$month;$i>=0;$i--){
        $backMonth = ($i==$month)?0:1;
        date_add($date,date_interval_create_from_date_string('-'.$backMonth.' MONTH'));
      
        $row = $util->dateIsoToThai(date_format($date,'Y-m-d'),'-');
        $row = explode('-',$row)[1].'/'.explode('-',$row)[2];
      
        array_push($monthSet,$row);
    }

    return json_encode(array_reverse($monthSet));
}
?>