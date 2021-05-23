

$("#btn_add_tel").click((e)=>{
	let tel = $('#tel').val();
	//console.log('>>'+tel);
	$.getScript('../resource/include/register_script.js', function(){

		let tel_status = check_tel(tel);
		if(tel_status == '0' ){
			//console.log('เบอร์นี้ไม่ถูกต้องหรือมีผุ้ใช้แล้ว');

		}else {
			//console.log('เบอร์นี้ใช้งานได้');

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
						url:projectPath+"/resource/controller/update_profile_controller.php",
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
	});
});

