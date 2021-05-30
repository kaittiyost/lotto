<?php
include(__DIR__."/../database/db_config.php");

function register(){
	try{
		$conn = DB::getConnect();

		$name = htmlentities($conn->escape_string( $_POST['name']));
		$surname =htmlentities($conn->escape_string( $_POST['surname']));
		$username = htmlentities($conn->escape_string( $_POST['username']));
		$password = htmlentities($conn->escape_string( $_POST['password']));
		$password_hash = hash("sha256",$password,false);
		$sql = "INSERT INTO `user` (`USER_ID`, `USER_USERNAME`, `USER_PASSWORD`, `USER_UUID`, `USER_LASTNAME`, `USER_NAME`, `USER_EMAIL`, `USER_TEL`, `REGIS_TIME`) VALUES (NULL,'".$username."', '".$password_hash."', NULL, '".$surname."', '".$name."',NULL, NULL, CURRENT_TIMESTAMP)";
		
		$result = $conn->query($sql);
		if($result){
			echo 1;
		}else{

			echo 0;
		}
	}catch(Exception $e){
		echo "error -->".$e->getMessage();
	}

}

function check_username(){
	
	$conn = DB::getConnect();
	$username =$conn->escape_string( $_POST['username']);

	$sql = 'SELECT COUNT(*) as c FROM user WHERE USER_USERNAME = "'.$username.'";';
	$result = $conn->query($sql);
	$count = $result->fetch_array();

	if($count['c'] == '1'){
		echo 0;
	}else{
		echo 1;
	}

}

function check_tel(){
	
	$conn = DB::getConnect();
	$tel =$conn->escape_string( $_POST['tel']);

	$sql = 'SELECT COUNT(*) as c FROM user WHERE USER_TEL = "'.$tel.'";';
	$result = $conn->query($sql);
	$count = $result->fetch_array();

	if($count['c'] == '1'){
		echo 0;
	}else{
		echo 1;
	}

}

function check_email(){
	
	$conn = DB::getConnect();
	$email =$conn->escape_string( $_POST['email']);

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo  0;
	}else{
		$sql = 'SELECT COUNT(*) as c FROM user WHERE USER_EMAIL = "'.$email.'";';
		$result = $conn->query($sql);
		$count = $result->fetch_array();

		if($count['c'] == '1'){
			echo 0;
		}else{
			echo 1;
		}
	}

}

function check_old_password(){
	session_start();
	$conn = DB::getConnect();
	$old_password =$conn->escape_string( $_POST['old_password']);
	$password_hash = hash("sha256",$old_password,false);
	$sql = "SELECT COUNT(`user`.USER_ID) as c FROM `user` \n".
	"WHERE `user`.USER_PASSWORD = '".$password_hash."' AND user.USER_ID = ".$_SESSION['userData']['USER_ID'];
	$result = $conn->query($sql);
	$count = $result->fetch_array();
	if($count['c'] == '1'){
		echo 1;
	}else{
		echo 0;
	}
}

// forgot password
function check_email_or_tel(){
	
	$conn = DB::getConnect();
	$data =$conn->escape_string( $_POST['email_or_tel']);
	$sql = "SELECT COUNT(`user`.USER_ID) as cc FROM `user` \n".
	"WHERE `user`.USER_TEL = '".$data."' \n".
	"OR `user`.USER_EMAIL = '".$data."';";
	$result = $conn->query($sql);
	$count = $result->fetch_array();

	if($count['cc'] == '1'){
		echo 1;
	}else{
		echo 0;
	}

}

function update_password(){
// update password in forgot_password/index.php
	$conn = DB::getConnect();
	$data = htmlentities($conn->escape_string( $_POST['email_or_tel']));
	$new_password = htmlentities($conn->escape_string( $_POST['password']));
	$password_hash = hash("sha256",$new_password,false);

	$sql = "UPDATE user SET USER_PASSWORD = '".$password_hash."' WHERE USER_TEL = '".$data."' OR USER_EMAIL = '".$data."'";

	$result = $conn->query($sql);
	if($result){
		echo 1;
	}else{

		echo 0;
	}
}

if(isset($_POST["func"])){
	if($_POST["func"]== "check_username"){
		check_username();
	}else if($_POST["func"]== "check_tel"){
		check_tel();
	}else if($_POST["func"]== "register"){
		register();
	}else if($_POST["func"]== "check_email"){
		check_email();
	}else if($_POST["func"]== "check_email_or_tel"){
		check_email_or_tel();
	}else if($_POST["func"]== "update_password"){
		update_password();
	}else if($_POST["func"]== "check_old_password"){
		check_old_password();
	}
}
?>