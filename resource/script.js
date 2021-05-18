var projectPath = location.origin;
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
					if(rs==0){
						Swal.fire({
							icon: 'error',
							title: 'เกิดข้อผิดพลาด!',
							text: 'usernameหรือรหัสผ่านไม่ตรงกัน!'
						});
					}else if(rs==1){
						location.href = projectPath+'/home';
					}
				});
			}
}

//----------------------------------HOME----------------------------------
$('.digit-group').find('input').each(function(){
	$(this).attr('maxlength', 1);
	$(this).on('keyup', function(e) {
		var parent = $($(this).parent());
		
		if(e.keyCode === 8 || e.keyCode === 37) {
			var prev = parent.find('input#' + $(this).data('previous'));
			
			if(prev.length) {
				$(prev).select();
			}
		} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
			var next = parent.find('input#' + $(this).data('next'));
			
			if(next.length) {
				$(next).select();
			} 
		}
	});
});

$("#search_btn").click((e)=>{
	let key = "";
	for(let i=0;i<6;i++){
		let thisChar = $("#digit-"+(i+1)).val();
		key+=(String(thisChar)=="")?"a":thisChar;
	}
	$("#lotery_all").load(projectPath+"/home/?s="+key+" #lotery_rows");
});







