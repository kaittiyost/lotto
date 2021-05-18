<!DOCTYPE html>
<html>
<head>
	<title>เข้าสู่ระบบ</title>
    <?php include(__DIR__."/resource/include/script.html"); ?>
</head>
<body>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v10.0&appId=156740843128977&autoLogAppEvents=1" nonce="khs2hvpO"></script> 	<br><br><br>
	<center>
	<div class="container">
		<br><br>
		<div class="row">
			<div class="col" >
				<div class="card">
				   <div class="card-body">
					<h1>Sangtian lotto</h1>
					<p style="font-size:10px">Sangtian lotto</p>
					<p class="badge badge-pill badge-warning text-light" >กรุณาเข้าสู่ระบบ</p>
					<form style="width:60%">
						  <div class="form-group">
						    <input type="text" class="form-control" id="username" placeholder="username">
						  </div>
						 <div class="form-group">
						    <input type="password" class="form-control" id="password" placeholder="รหัสผ่าน">
						  </div>
						  <button type="button" onClick="login()" class="btn btn-outline-primary" style="width:100%;">เข้าสู่ระบบ</button>
						  <br><br>
						  <div onlogin="checkLoginStateFB();" class="fb-login-button" data-width="" data-size="medium" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true"></div>
						  <br><br>
						  <button type="button" onClick="go_register()" class="btn btn-outline-warning">สมัครสมาชิก</button>
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
             $.ajax({
                  "type":"POST",
                  "contentType":"application/x-www-form-urlencoded;charset=utf-8",
                  "url":projectPath,
                  "data":{"fb_id":data.id,"fb_name":data.name,'inSystem':(i)?1:0,"func":"loginFb"}
             })
             .done((response)=>{
                  if(String(response)==="have_fb_user"||String(response)==="new_fb_user"){
                        location.href = projectPath+'/home';
                  }else{

                  }
             });
        }
	</script>
</body>
</html>