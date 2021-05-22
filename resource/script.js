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

			
$(document).on("click", ".open-quan", function () {
	new Promise((resolve,reject)=>{
		let lotto_quan = $(this).data('quantity');
		let lotto_number = $(this).data('number');
		let lotto_img = $(this).data('img');

		$("#lottoly_id").val($(this).data("id"));
		$("#lottoly_number").html('หมายเลข '+lotto_number);
		$("#lottoly_quantity").html('<i class="fas fa-box"></i> คงเหลือ '+lotto_quan+' ใบ');
		$("#lottoly_img").html('<img  class="responsive_img" src="../images/item/'+lotto_img+'"><br><br>');
		$("#quan_select").empty();
		resolve(parseInt(lotto_quan));
	}).then((lotto_quan)=>{
		$("#quan_select").append("<option selected>เลือกจำนวน</option>");
		for(let i=0;i<lotto_quan;i++){
			$("#quan_select").append("<option value='"+(i+1)+"'>"+(i+1)+"</option>");
		}
	})
});

$("#add_to_card_btn").click(()=>{
		let lot_id = $("#lottoly_id").val();
		let lot_quan = $("#quan_select").val();
		if(String(lot_quan)==="เลือกจำนวน"){
			Swal.fire({
				icon: 'warning',
				title: 'โปรดเลือกจำนวน'
			  })
		}else{
			$.ajax({
				method:"POST",
				url:projectPath+"/resource/controller/home_controller.php",
				contentType:"application/x-www-form-urlencoded; charset=utf-8",
				data:{"lotId":lot_id,"quan":lot_quan,"func":"toCart"}
			})
			.done((response)=>{
				response = JSON.parse(response);
				switch(String(response.status)){
					case "1":
						Swal.fire({
							icon: 'success',
							title: 'เพิ่มในตระกร้าแล้ว'
						  })
						
						break;
					case "0":
						Swal.fire({
							icon: 'error',
							title: 'เกิดข้อผิดพลาด!'
						  })
						break;
					case "non_login":
						location.href = projectPath;
						break;
				}
			});
		}
});
//----------------------------------HOME(END)----------------------------------
//----------------------------------CART---------------------------------------
function delBucket(lot_id){
	Swal.fire({
		title: 'ต้องการลบ?',
		text: "คุณต้องการลบรายการออกจากตระกร้าหรือไม่!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ใช่'
	  }).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				method:"POST",
				url:projectPath+"/resource/controller/cart_controller.php",
				contentType:"application/x-www-form-urlencoded; charset=utf-8",
				data:{"lotId":lot_id,"func":"del"}
			}).done((respones)=>{
				respones = JSON.parse(respones);
				if(String(respones.status)==0){
					Swal.fire({
						title:"เกิดข้อผิดพลาด!",
						icon:"error"
					});
				}else{
					Swal.fire({
						title:"ลบสำเร็จ",
						icon:"success"
					});
					$("#lottery_list").load(location.href+" #lottery_list_in");
				}
			})
	
		}
	  })
}
$("#pay_order").click(()=>{
	Swal.fire({
		title: 'ยืนยันการซื้อสินค้า?',
		text: "คุณต้องการยืนยันการหรือไม่!",
		icon: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ใช่'
	  }).then((result)=>{
		if(result.isConfirmed){
			$.ajax({
				method:"POST",
				url:projectPath+"/resource/controller/cart_controller.php",
				contentType:"application/x-www-form-urlencoded; charset=utf-8",
				data:{"func":"confirm_cart"}
			}).done((response)=>{
				console.log(response);
				response = JSON.parse(response);
				if(parseInt(response.status)==1){
					Swal.fire({
						icon:"success",
						title:"ยืนยันการซื้อแล้ว",
						text:"โปรดส่งหลักฐานการโอนเงินภายในเวลา30นาที"
					});
					setTimeout(()=>{
						location.reload();
					},1000);
				}else if(String(response.status)=="out_stock"){
					Swal.fire({
						icon:"warning",
						title:"ยืนยันการซื้อแล้ว",
						text:"สินค้าบางรายหมดโปรดส่งหลักฐานการโอนเงินภายในเวลา30นาที"
					});
					setTimeout(()=>{
						location.reload();
					},1000);
				}else{
					Swal.fire({
						icon:"error",
						title:"เกิดข้อผิดพลาด!",
						text:"เกิดข้อผิดพลาดไม่สราบสาเหตุโปรดลองอีกครั้งในภายหลัง"
					});
				}
			})

		}
	  })
});
//----------------------------------CART(END)---------------------------------------



