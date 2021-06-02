<!DOCTYPE html>
<html>
<head>
	<title>เข้าสู่ระบบ</title>
	<?php include(__DIR__."/resource/include/script.html"); ?>
</head>
<body>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v10.0&appId=527242314963433&autoLogAppEvents=1" nonce="khs2hvpO"></script> 	<br><br><br>
	<center>
		<div class="container">
			<br><br>
			<div class="row">
				<div class="col" >
					<div class="card shadow p-3 mb-5 bg-white rounded">
						<div class="card-body">
							<h1>Sangtian lotto</h1>
							<p style="font-size:10px">เว็บแอพลิเคชั่นขายลอตเตอรี่ออนไลน์</p>
							<p class="badge badge-pill badge-warning text-light" >กรุณาเข้าสู่ระบบด้วยfacebook</p>
							<br>
							<!-- 
							<form style="width:80%">
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-user"></i>
										</div>
									</div>
									<input type="text" class="form-control" id="username" placeholder="username">
								</div>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-unlock"></i>
										</div>
									</div>
									<input type="password" class="form-control" id="password" placeholder="รหัสผ่าน">
								</div><a href="/forgot_password/" style="text-align:right;margin-left: 60%;font-size: :10px;" >ลืมรหัสผ่าน?</a><br><br>
								<button type="button" onClick="login()" class="btn btn-outline-primary" style="width:60%;"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</button>
								<br><br> -->
								<div onlogin="checkLoginStateFB();" class="fb-login-button" data-width="" data-size="medium" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true"></div>
								<br><br>
								<!-- <button type="button" onClick="go_register()" class="btn btn-outline-warning"><i class="fas fa-user-plus"></i> สมัครสมาชิก</button>
							</form> -->
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
				function go_register(){
					window.location = "register.php";
				}
				function checkLoginStateFB() {              
					FB.getLoginStatus(function(response) {  
						if(String(response.status)==="connected"){
							new Promise((resolve,reject)=>{
								FB.api("/me",(res)=>{resolve(res);});
							}).then((result)=>{
								loginByFB(result);
							})
						}
					});
				}
				function loginByFB(data){
					console.log(data)
					$.ajax({
						"type":"POST",
						"contentType":"application/x-www-form-urlencoded;charset=utf-8",
						"url":projectPath+"/resource/controller/login.php",
						"data":{"fb_id":data.id,"fb_name":data.name,"func":"loginFb"}
					})
					.done((response)=>{
						console.log(response);
						if(String(response)==="new_user"||String(response)==="old_user"){
							location.href = projectPath+'/home';
						}
					});
				}
			</script>
		</body>
		</html>