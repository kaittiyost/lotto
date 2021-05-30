<!DOCTYPE html>
<html>
<head>
	<title>เข้าสู่ระบบ</title>
	<?php include(__DIR__.'/../resource/include/script.html'); ?>
</head>
<body>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<br>
	<center>
		<div class="container">
			<br><br>
			<div class="row">
				<div class="col" >
					<div class="card shadow p-3 mb-5 bg-white rounded">
						<div class="card-body">
							<h1>ลืมรหัสผ่าน?</h1>
							<p class="badge badge-pill badge-warning text-light" >กรุณากรอกข้อมูล</p>
							<form style="width:60%">
								<div id="alert_email_or_tel"></div>
								<div class="form-group">
									<input type="email" class="form-control" id="email_or_tel" placeholder="เบอร์โทร หรือ email" autocomplete="off">
								</div>
								<div id="alert_password"></div>
								<div class="form-group">
									<input type="password" class="form-control" id="password" placeholder="รหัสผ่านใหม่" autocomplete="off">
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="confirm_password" placeholder="ยืนยันรหัสผ่านใหม่" autocomplete="off">
								</div>

								<button type="button" onClick="change_password()" class="btn btn-outline-primary">เปลี่ยนรหัสผ่าน</button>
								<br><br>
								<button type="button" onClick="go_login()" class="btn btn-outline-warning"><i class="fas fa-arrow-left"></i> ไปหน้าเข้าสู่ระบบ</button>
							</form>
						</div>
						<div>
						</div>
					</div>
				</div>
				<script src="../resource/script.js"></script>	
				<script src="../resource/include/register_script.js"></script>			
				<style>
				@media (min-width:425px) {
					.card{
						width:400px;
					}
				}
			</style>
			<script type="text/javascript">
				function go_login(){
					window.location = "/";
				}
			</script>
		</body>
		</html>