<?php 
	function getConnect(){
		$conn = new Mysqli("localhost","root","","db_name");
		if($conn->connect_errno){
			echo 'connection ERROR!';
		}
		$conn->set_charset('utf8mb4');
		return $conn;
	}
 ?>