<!DOCTYPE html>
<html>
<head>
	<title>เข้าสู่ระบบ</title>
    <?php include(__DIR__."/resource/include/script.html"); ?>
</head>
<body>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<br>
	<center>
	<div class="container">
		<br><br>
		<div class="row">
			<div class="col" >
				<div class="card">
				   <div class="card-body">
					<h1>Sangtian lotto</h1>
					<p style="font-size:10px">สมัครสมาชิกใหม่</p>
					<p class="badge badge-pill badge-warning text-light" >กรุณากรอกเข้ามูล</p>
					<form style="width:60%">
						<div class="form-group">
						    <input type="text" class="form-control" id="name" placeholder="ชื่อ">
						  </div>
						  <div class="form-group">
						    <input type="text" class="form-control" id="surname" placeholder="นามสกุล">
						  </div>
						  <div class="form-group">
						    <input type="text" class="form-control" id="username" placeholder="username">
						  </div>
						 <div class="form-group">
						    <input type="password" class="form-control" id="password" placeholder="รหัสผ่าน">
						  </div>
						  <div class="form-group">
						    <input type="password" class="form-control" id="confirm_password" placeholder="ยืนยันรหัสผ่าน">
						  </div>
						  <button type="button" onClick="register()" class="btn btn-outline-primary">ลงทะเบียน</button>
						  <br><br>
						  <button type="button" onClick="go_login()" class="btn btn-outline-warning">ย้อนกลับ</button>
					</form>
					</div>
				<div>
			</div>
	</div>
</div>
	<script src="resource/script.js"></script>			
	<style>
			@media (min-width:425px) {
				.card{
					width:400px;
				}
			}
	</style>
	<script type="text/javascript">
			function go_login(){
			window.location = "index.php";
		}
	</script>
</body>
</html>