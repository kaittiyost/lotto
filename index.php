<!DOCTYPE html>
<html>
<head>
	<title>เข้าสู่ระบบ</title>
	<?php include(__DIR__."/resource/include/script.html"); ?>
</head>
<body>
	<meta name="google-signin-client_id" content="1036552871785-hp22bf6mmcfgdto7nrkajn39s558on4j.apps.googleusercontent.com">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v10.0&appId=527242314963433&autoLogAppEvents=1" nonce="PywkciAJ"></script>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<center>
		<div class="container">
			<br><br>
			<div class="row">
				<div class="col" >
					<div class="card shadow p-3 mb-5 rounded" style="background-color:#FFCBE3">
						<div class="card-body">
							<h1>Sangtian lotto</h1>
							<p style="font-size:10px">เว็บแอพลิเคชั่นขายลอตเตอรี่ออนไลน์</p>
							<p class="badge badge-pill badge-dark text-light" >กรุณาเข้าสู่ระบบ</p>
							<br>
								<div onlogin="checkLoginStateFB();" class="fb-login-button" data-width="" data-size="large" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true"></div>
								<br><br>
								<div data-onsuccess="googleLogin" class="g-signin2" data-width="250"></div>
								<br><br>				
						</div>
						<div>
						</div>
					</div>
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
				window.onload = ()=>{
					var auth2 = gapi.auth2.getAuthInstance();
          			auth2.signOut();
				}
				function go_register(){
					window.location = "register.php";
				}
				function checkLoginStateFB() {              
					FB.getLoginStatus(function(response) {  
						if(String(response.status)==="connected"){
							new Promise((resolve,reject)=>{
								FB.api("/me",(res)=>{resolve(res);});
							}).then((result)=>{
								console.log(result);
								loginByFB(result);
							})
						}
					});
				}
				function loginByFB(data){
					$.ajax({
						"type":"POST",
						"contentType":"application/x-www-form-urlencoded;charset=utf-8",
						"url":projectPath+"/resource/controller/login.php",
						"data":{"fb_id":data.id,"fb_name":data.name,"img":"http://graph.facebook.com/"+data.id+"/picture?type=large","func":"loginFb"}
					})
					.done((response)=>{
						console.log(response);
						if(String(response)==="new_user"||String(response)==="old_user"){
							location.href = projectPath+'/home';
						}
					});
				}

				function googleLogin(googleUser) {
					var profile = googleUser.getBasicProfile();
					let userData ={};
					userData.tokenId = googleUser.getAuthResponse().id_token;
					userData.func = "loginGoogle";
					$.ajax({
						"type":"POST",
						"contentType":"application/x-www-form-urlencoded;charset=utf-8",
						"url":projectPath+"/resource/controller/login.php",
						"data":userData
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