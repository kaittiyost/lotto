<?php include(__DIR__.'/../resource/controller/login.php');?>
<!DOCTYPE html>
<html>
<head>
<?php 
include(__DIR__.'/../resource/include/script.html');
include(__DIR__.'/../resource/include/menu.php');
?>
<title>หวย</title>
</head>
<body>
	<br><br><br>
	<div class="container" style="text-align: center">
		<div class="alert alert-info text-dark" style="width:100% ; margin-top: 30px	">
			<div class="alert-body">
				<h2>ส่งข้อมูลเสร็จสิ้น</h2>
				<i class="far fa-check-circle" style="font-size: 50px; text-align: center;color: green"></i>
				<br><br>
				<label>รอยืนยันภายใน 24 ชัั่วโมง</label><br>
				<label>ขอบคุณครับ/ค่ะ</label><br>
			</div>
		</div>	   	  
		<br>
			 <button class="btn btn-outline-info" style="width: 100%;" onclick="go_home()">กลับหน้าแรก</button><br><br>
	</div>
	</div>

<script src='../resource/script.js'></script>
	<script type="text/javascript">
			function go_home(){
			window.location = "index.php";
		}
	</script>
</body>
</html>