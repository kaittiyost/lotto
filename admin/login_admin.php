<!DOCTYPE html>
<html>
<head>
	<title>เข้าสู่ระบบ</title>
    <?php include(__DIR__."/../resource/include/script.html"); ?>
</head>
<body class="bg-dark">
	<center>
	<div class="container">
		<br><br>
		<div class="row">
			<div class="col" >
				<div class="card">
				   <div class="card-body">
					<h1 class="text-warning">Sangtian Admin</h1>
					<p style="font-size:10px">Sangtian lotto</p>
					<p class="badge badge-pill badge-warning text-light" >กรุณาเข้าสู่ระบบ</p>
					<form style="width:60%">
						  <div class="form-group">
						    <input type="text" class="form-control" id="username" placeholder="username">
						  </div>
						 <div class="form-group">
						    <input type="password" class="form-control" id="password" placeholder="รหัสผ่าน">
						  </div>
						  <button type="button" onClick="login_admin()" class="btn btn-outline-primary" style="width:100%;">เข้าสู่ระบบ</button>
						  <br><br>
					</form>
					</div>
				<div>
			</div>
	</div>
</div>
	<script src="/../resource/script.js"></script>			
	<style>
			@media (min-width:425px) {
				.card{
					width:400px;
				}
			}
	</style>
</body>
</html>