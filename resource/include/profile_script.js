var projectPath = location.origin;

function check_tel(tel){
	var res = '' ;
	if(tel.length != 10){
		$('#alert_tel').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> หมายเลขไม่ถูกต้อง</p>');
		res = '0';
	}else{
		$.ajax({
			method:"POST",
			url:projectPath+"/resource/controller/check_register_controller.php",
			dataType:"json",
			data:{"tel":tel,"func":"check_tel"},
			success:function(rs){

				//console.log('status :'+rs);

				if(rs==0){
					res = '0';
					$('#alert_tel').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> หมายเลขนี้ถูกใช้งานแล้ว</p>');
				}else if(rs==1){
					res= '1';
					$('#alert_tel').html('<p style="color:green"><i class="fas fa-check-circle"></i> หมายเลขนี้ใช้งานได้</p>');
					console.log('เบอร์นี้ใช้งานได้');

					Swal.fire({
						title: 'คุณต้องการบันทึกใช่หรือไม่?',
						text: 'หมายเลขติดต่อของคุณ คือ '+tel,
						showDenyButton: true,
						showCancelButton: true,
						confirmButtonText: `บันทึก`,
						denyButtonText: `ยกเลิก`,
					}).then((result) => {

						if (result.isConfirmed) {
							$.ajax({
								method:"POST",
								url:projectPath+"/resource/controller/profile_controller.php",
								contentType:"application/x-www-form-urlencoded; charset=utf-8",
								data:{"tel":tel,"func":"add_tel"}
							}
							).done((rs)=>{
								if(rs==0){
									Swal.fire({
										icon: 'error',
										title: 'เกิดข้อผิดพลาด!',
										text: 'เพิมหมายเลขติดต่อไม่ได้!'
									});
								}else if(rs==1){
									Swal.fire({
										icon: 'success',
										title: 'ยินดีด้วย!',
										text: 'เพิ่มหมายเลขติดต่อสำเร็จ'

									}).then((result) => {
										location.href = projectPath+'/profile/';
									})

								}
							});
						}
					})
				}

			}
		});
	}
	return res;
}

function check_email(email){
	//console.log('check_email_func data:'+email);
	$.ajax({
		method:"POST",
		url:projectPath+"/resource/controller/check_register_controller.php",
		dataType:"json",
		data:{"email":email,"func":"check_email"},
		success:function(rs){
			//console.log('status :'+rs);

			if(rs==0){
				res = '0';
				$('#alert_email').html('<p style="color:red"><i class="fas fa-exclamation-triangle"></i> Email ไม่ถูกต้องหรือถูกใช้งานแล้ว</p>');
			}else if(rs==1){
				res= '1';
				$('#alert_email').html('<p style="color:green"><i class="fas fa-check-circle"></i> Email เลขนี้ใช้งานได้</p>');
				//console.log('เบอร์นี้ใช้งานได้');

				Swal.fire({
					title: 'คุณต้องการบันทึกใช่หรือไม่?',
					text: 'Email ของคุณ คือ '+email,
					showDenyButton: true,
					showCancelButton: true,
					confirmButtonText: `บันทึก`,
					denyButtonText: `ยกเลิก`,
				}).then((result) => {

					if (result.isConfirmed) {
						$.ajax({
							method:"POST",
							url:projectPath+"/resource/controller/profile_controller.php",
							contentType:"application/x-www-form-urlencoded; charset=utf-8",
							data:{"email":email,"func":"add_email"}
						}
						).done((rs)=>{
							if(rs==0){
								Swal.fire({
									icon: 'error',
									title: 'เกิดข้อผิดพลาด!',
									text: 'เพิม Email ไม่ได้!'
								});
							}else if(rs==1){
								Swal.fire({
									icon: 'success',
									title: 'ยินดีด้วย!',
									text: 'เพิ่ม Email สำเร็จ'

								}).then((result) => {
									location.href = projectPath+'/profile/';
								})

							}
						});
					}
				})
			}
		}
	});
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

function update_password(new_password){
	// update password in profile
	$.ajax({
		method:"POST",
		url:projectPath+"/resource/controller/profile_controller.php",
		dataType:"text",
		data:{"new_password":new_password,"func":"update_password"},
		success:function(rs){
			//console.log(rs);
			if(rs==0){
				Swal.fire({
					icon: 'error',
					title: 'เกิดข้อผิดพลาด!',
					text: 'เปลี่ยนนหัสผ่านไม่สำเร็จ!'
				});
			}else if(rs==1){
				Swal.fire({
					icon: 'success',
					title: 'ยินดีด้วย!',
					text: 'เปลี่ยนรหัสผ่านสำเร็จแล้ว'

				}).then((result) => {
					location.href = projectPath+'/profile/';
				})

			}
		}
	});
}
function check_old_password(old_password,new_password,confirm_new_password){
	$.ajax({
		method:"POST",
		url:projectPath+"/resource/controller/check_register_controller.php",
		dataType:"text",
		data:{"old_password":old_password,"func":"check_old_password"},
		success:function(rs){
			//console.log('old_password status ->'+rs);
			if(rs == 1){
			//	console.log('รหัสผ่านเดิมถูกต้อง');
			$('#alert_old_password').html('<p style="color:green"><i class="fas fa-check-circle"></i></p>');
			let password_status = check_confirm_password(new_password,confirm_new_password);
			console.log('password_status > '+password_status);
			if(password_status == 1){
				Swal.fire({
					title: 'คุณต้องการบันทึกใช่หรือไม่?',
					text: 'กดปุ่ม "บันทึก" เพื่อยืนยัน',
					showDenyButton: true,
					showCancelButton: true,
					confirmButtonText: `บันทึก`,
					denyButtonText: `ยกเลิก`,
				}).then((result) => {
					if (result.isConfirmed) {
						update_password(new_password);
					} else if (result.isDenied) {
						Swal.fire('ถูกยกเลิกโดยผู้ใช้', '', 'info')
					}
				});
				
			}
		}else{
			//	console.log('รหัสผ่านเดิมไม่ถูกต้อง');
			$('#alert_old_password').html('<p style="color:red"><i class="fas fa-times-circle"></i></p>');
		}
	}
});
}

$("#btn_add_tel").click((e)=>{
	let tel = $('#tel').val();
	check_tel(tel);
});

$("#btn_add_email").click((e)=>{
	let email = $('#email').val();
	check_email(email);
});

$("#btn_change_password").click((e)=>{
	let old_password = $('#old_password').val();
	let new_password = $('#new_password').val();
	let confirm_new_password = $('#confirm_new_password').val();

	check_old_password(old_password,new_password,confirm_new_password);
});

