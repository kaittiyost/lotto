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

			console.log('status :'+rs);

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
					} else if (result.isDenied) {
						Swal.fire('ถูกยกเลิกโดยผู้ใช้', '', 'info')
					}
				})
			}

		}
	});
	}
	return res;
}


$("#btn_add_tel").click((e)=>{
	let tel = $('#tel').val();
	check_tel(tel);
});

