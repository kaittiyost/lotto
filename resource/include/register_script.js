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

function check_confirm_password(password,confirm_password){
	if(password.length < 8 && confirm_password.length < 8){
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

function change_password() {
	let email_or_tel = $('#email_or_tel').val();
	let new_password = $('#password').val();
	let confirm_new_password = $('#confirm_password').val();

	$.ajax({
		method:"POST",
		url:projectPath+"/resource/controller/check_register_controller.php",
		contentType:"application/x-www-form-urlencoded; charset=utf-8",
		data:{"email_or_tel":email_or_tel,"func":"check_email_or_tel"},
		success: function (rs){

			//console.log('email or tel >> '+rs);
			if(rs == 1){
				$('#alert_email_or_tel').html('<p style="color:green"><i class="fas fa-check-circle"></i></p>');
				//console.log('email ใช้งานได้');
				let password_status = check_confirm_password(new_password,confirm_new_password);
				//console.log('pass >> '+password_status);
				if(password_status == '1' && rs == '1'){
					//console.log('OK');
					Swal.fire({
						title: 'คุณต้องการบันทึกใช่หรือไม่?',
						text: 'กดปุ่ม "บันทึก" เพื่อยืนยัน',
						showDenyButton: true,
						showCancelButton: true,
						confirmButtonText: `บันทึก`,
						denyButtonText: `ยกเลิก`,
					}).then((result) => {
						if (result.isConfirmed) {
							$.ajax({
								method:"POST",
								url:projectPath+"/resource/controller/check_register_controller.php",
								contentType:"application/x-www-form-urlencoded; charset=utf-8",
								data:{"email_or_tel":email_or_tel,"password":new_password,"func":"update_password"},
								success: function (rs){
									console.log('rsssssss >'+rs);
									if(rs== '0'){
										Swal.fire({
											icon: 'error',
											title: 'เกิดข้อผิดพลาด!',
											text: 'เปลี่ยนหัสผ่านไม่ได้!'
										});
									}else if(rs== '1'){
										Swal.fire({
											icon: 'success',
											title: 'ยินดีด้วย!',
											text: 'เปลี่ยนรหัสผ่านสำเร็จแล้ว'

										}).then((result) => {
											location.href = '/';
										})

									}else{
								//console.log('someting wrong!'+rs);
							}
						}
					});
						} else if (result.isDenied) {
							Swal.fire('ถูกยกเลิกโดยผู้ใช้', '', 'info')
						}
					});
				}else{
					//console.log('5555');
				}
			}else{
				$('#alert_email_or_tel').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> ไม่พบผู้ใช้งาน</p>');
			}
		}
	});

}