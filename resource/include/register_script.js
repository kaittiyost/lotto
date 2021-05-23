var projectPath = location.origin;

function check_username(username){
	if(username.length < 5){
		$('#alert_username').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> username อย่างน้อย 5 ตัวอักษร</p>');
		return '0';
	}else{
		if(username != ""){
			$.ajax({
				method:"POST",
				url:projectPath+"/resource/controller/check_register_controller.php",
				contentType:"application/x-www-form-urlencoded; charset=utf-8",
				data:{"username":username,"func":"check_username"}
			}
			).done((rs)=>{
				//console.log(rs)
				if(rs==0){
					$('#alert_username').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> username ถูกใช้งานแล้ว</p>');
					return '0';
				}else if(rs==1){
					$('#alert_username').html('<p style="color:green"><i class="fas fa-check-circle"></i> username ใช้งานได้</p>');
					return '1';
				}
			});
		}else{

		}
	}
}
function check_tel(tel){
	if(tel.length < 10 || tel.length > 10){
		$('#alert_tel').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> หมายเลขไม่ถูกต้อง</p>');
		return '0';
	}else{

			$.ajax({
				method:"POST",
				url:projectPath+"/resource/controller/check_register_controller.php",
				contentType:"application/x-www-form-urlencoded; charset=utf-8",
				data:{"tel":tel,"func":"check_tel"}
			}
			).done((rs)=>{
				//console.log(rs)
				if(rs==0){
					$('#alert_tel').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> หมายเลขนี้ถูกใช้งานแล้ว</p>');
					return '0';
				}else if(rs==1){
					$('#alert_tel').html('<p style="color:green"><i class="fas fa-check-circle"></i> หมายเลขนี้ใช้งานได้</p>');
					return '1';
				}
			});

	}
}


function check_confirm_password(password,confirm_password){
	if(password.length < 8 || confirm_password.length < 8){
		$('#alert_password').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> รหัสผ่านอย่างน้อย 8 ตัวอักษร</p>');
		return '0';
	}else{
		if(password != confirm_password ){
			$('#alert_password').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> รหัสผ่านไม่ตรงกัน</p>');
			return '0';
		}else if(password != "" & confirm_password != "" && password == confirm_password){
			$('#alert_password').html('<p style="color:green">รหัสผ่านตรงกัน</p>');
			return '1';
		}
	}
}

function register(){

	let name = $('#name').val();
	let surname = $('#surname').val();
	let username = $('#username').val();
	let password = $('#password').val();
	let confirm_password = $('#confirm_password').val();


	if(name != "" && surname != "" ){

		let username_status = check_username(username);
		let password_status = check_confirm_password(password,confirm_password);
		

		if(username_status != '0' && password_status != '0' ){
			$.ajax({
				method:"POST",
				url:projectPath+"/resource/controller/check_register_controller.php",
				contentType:"application/x-www-form-urlencoded; charset=utf-8",
				data:{"name":name,"surname":surname,"username":username,"password":password,"func":"register"}
			}
			).done((rs)=>{
				//console.log(rs)
				if(rs==0){
					Swal.fire({
						icon: 'error',
						title: 'เกิดข้อผิดพลาด!',
						text: 'สมัครสมาชิกไม่สำเร็จ!'
					});
				}else if(rs==1){
					Swal.fire({
						icon: 'success',
						title: 'ยินดีด้วย!',
						text: 'สมัครสมาชิกสำเร็จ'

					}).then((result) => {
						location.href = projectPath+'/';
					})

				}
			});

		}else{
			console.log('kuy');
		}

	}else{
		Swal.fire({
			icon: 'error',
			title: 'เกิดข้อผิดพลาด!',
			text: 'กรุณากรอกข้อมูลให้ครบ!'
		});

	}
}

function check_email(email){

			$.ajax({
				method:"POST",
				url:projectPath+"/resource/controller/check_register_controller.php",
				contentType:"application/x-www-form-urlencoded; charset=utf-8",
				data:{"email":email,"func":"check_email"}
			}
			).done((rs)=>{
				//console.log(rs)
				if(rs==0){
					$('#alert_tel').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> Emailนี้ถูกใช้งานแล้ว</p>');
					return '0';
				}else if(rs==1){
					$('#alert_tel').html('<p style="color:green"><i class="fas fa-check-circle"></i> Email นี้ใช้งานได้</p>');
					return '1';
				}
			});

}