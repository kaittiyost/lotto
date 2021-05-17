var projectPath = location.origin+"/lotto";
function login(){
			const username = $('#username').val();
			const password = $('#password').val();
			if(username==''||password==''){
						Swal.fire({
							icon: 'error',
							title: 'ข้อมูลว่าง',
							text: 'โปรดกรอกข้อมูลให้ครบ!'
						});
			}else{
				$.ajax({
						method:"POST",
						url:projectPath+"/resource/controller/login.php",
						contentType:"application/x-www-form-urlencoded; charset=utf-8",
						data:{"username":username,"password":password,"func":"login"}
					}
				).done((rs)=>{
					console.log(rs)
					rs = JSON.parse(rs);
					if(rs.status==0){
						Swal.fire({
							icon: 'error',
							title: 'เกิดข้อผิดพลาด!',
							text: 'usernameหรือรหัสผ่านไม่ตรงกัน!'
						});
					}else if(rs.status==1){
						location.href = projectPath+'/home';
					}
				});
			}
}







