var projectPath = location.origin;

function add_bank_account(){
	let bank_id = $('#bank_id').val();
	let bank_name = $('#bank_name').val();
	let bank_type = $('#bank_type_add').val();
	let bank_user_name = $('#bank_user_name').val();
	console.log('bank_id = '+bank_id+' , bank_name ='+bank_name+" ,bank_type = "+bank_type+" , bank_user_name ="+bank_user_name);
	if(bank_id == '' || bank_name == '' || bank_type == '' || bank_user_name == ''){
		//console.log('กรอกข้อมูลไม่ครบ');
		Swal.fire({
			icon: 'error',
			title: 'ข้อมูลไม่ครบ!',
			text: 'กรุณากรอกข้อมูลให้ครบทุกช่อง'
		});
	}else{
		//console.log('bank_id = '+bank_id+' , bank_name ='+bank_name+" ,bank_type = "+bank_type+" , bank_user_name ="+bank_user_name);
		Swal.fire({
			title: 'คุณต้องการบันทึกใช่หรือไม่?',
			text: 'กดปุ่ม "บันทึก" เพื่อยืนยันบัญชีนี้',
			showDenyButton: true,
			showCancelButton: true,
			confirmButtonText: `บันทึก`,
			denyButtonText: `ยกเลิก`,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					method:"POST",
					url:projectPath+"/resource/controller/bank_account_controller.php",
					contentType:"application/x-www-form-urlencoded; charset=utf-8",
					data:{"bank_account_id":bank_id,"bank_id":bank_name,"bank_type":bank_type,"bank_user_name":bank_user_name,"func":"add_bank_account"}
				}
				).done((rs)=>{
					console.log('rs > '+rs);
					if(rs==0){
						Swal.fire({
							icon: 'error',
							title: 'เกิดข้อผิดพลาด!',
							text: 'บันทึกบัญชีไม่สำเร็จ!'
						});
					}else if(rs==1){
						Swal.fire({
							icon: 'success',
							title: 'บันทึกบัญชีสำเร็จแล้ว'
						}).then((result) => {
							location.reload();
						})

					}
				});

			} 
		});


	}
	
}

function del_bank_account(account_id) {
//	console.log('del_bank_account id'+account_id);

$.ajax({
	method:"POST",
	url:projectPath+"/resource/controller/bank_account_controller.php",
	contentType:"application/x-www-form-urlencoded; charset=utf-8",
	data:{"account_id":account_id,"func":"del_bank_account"}
}
).done((rs)=>{
	//console.log('rs > '+rs);
	Swal.fire({
		title: 'คุณต้องการลบใช่หรือไม่?',
		text: 'กดปุ่ม "ลบ" เพื่อลบบัญชีนี้',
		showDenyButton: true,
		showCancelButton: true,
		confirmButtonText: `ลบ`,
		denyButtonText: `ยกเลิก`,
	}).then((result) => {
		if (result.isConfirmed) {
			if(rs==0){
				Swal.fire({
					icon: 'error',
					title: 'เกิดข้อผิดพลาด!',
					text: 'บันทึกบัญชีไม่สำเร็จ!'
				});
			}else if(rs==1){
				Swal.fire({
					icon: 'success',
					title: 'ลบบัญชีสำเร็จแล้ว'
				}).then((result) => {

					location.reload();
				})

			}
		} 
	});

});
}

function edit_bank_account() {

	let bank_account_id = $('#account_myid').val();
	let account_id = $('#account_id').val();
	let account_name = $('#account_name').val();
	let account_type = $('#account_type').val();
	let account_bank = $('#account_bank').val();
	let account_status = $('#account_status').val();
	//console.log('bank_account_id :'+bank_account_id+',account_id:'+account_id+',account_name:'+account_name+",account_type:"+account_type+",account_bank:"+account_bank+",account_status:"+account_status);
	
	Swal.fire({
		title: 'คุณต้องการแก้ใช่หรือไม่?',
		text: 'กดปุ่ม "แก้ไข" เพื่อแก้ไขบัญชีนี้',
		showDenyButton: true,
		showCancelButton: true,
		confirmButtonText: `แก้ไข`,
		denyButtonText: `ยกเลิก`,
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				method:"POST",
				url:projectPath+"/resource/controller/bank_account_controller.php",
				contentType:"application/x-www-form-urlencoded; charset=utf-8",
				data:{"bank_account_id":bank_account_id,"account_id":account_id,"account_type":account_type,"account_name":account_name,"account_status":account_status,"account_bank":account_bank,"func":"edit_bank_account"}
			}
			).done((rs)=>{
				//console.log('rs > '+rs);
				if(rs==0){
					Swal.fire({
						icon: 'error',
						title: 'เกิดข้อผิดพลาด!',
						text: 'แก้ไขบัญชีไม่สำเร็จ!'
					});
					console.log('rs > '+rs);
				}else if(rs==1){
					Swal.fire({
						icon: 'success',
						title: 'แก้ไขบัญชีสำเร็จแล้ว'
					}).then((result) => {

						location.reload();
					})

				}

			});

		} 
	});


}

$(document).on("click", ".open-edit_account", function () {
	new Promise((resolve,reject)=>{
		let account_myid = $(this).data('account_myid');
		let account_name = $(this).data('account_name');
		let account_id = $(this).data('account_id');
		let account_type = $(this).data('account_type');
		let account_bank = $(this).data('account_bank');
		let account_status = $(this).data('account_status');

		//console.log('account_status -> '+account_status);

		if(account_type == 'PromtPay'){
			$('#account_type')[0].selectedIndex = 0;
		}else{
			$('#account_type')[0].selectedIndex = 1;	
		}
		$('#account_bank')[0].selectedIndex = parseInt(account_bank)-1;

		if(account_status == 1){
			$('#account_status')[0].selectedIndex = 1;	
		}else{
			$('#account_status')[0].selectedIndex = 0;	
		}

		$("#account_id").val($(this).data("account_id"));
		$("#account_name").val($(this).data("account_name"));
		$("#account_myid").val($(this).data("account_myid"));
	});
});
