<div style="background-color:#E3E3E3;height:50px;position:fixed;width:100%;z-index:1000;font-size:20px;opacity:1;">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Sangtian lotto</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/home/"><i class="fas fa-store"></i> ร้านค้าลอตเตอรี่ <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/profile/"><i class="fas fa-user"></i> โปรไฟล์</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/cart/"><i class="fas fa-shopping-basket"></i> ตะกร้าของฉัน <span class="badge badge-info" id="cart_count">0</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/purchase_list/"><i class="fas fa-bars"></i> การซื้อของฉัน</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" id="logout_btn"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
      </li>
    </ul>
    <span class="navbar-text">
      
    </span>
  </div>
</nav>
</div>
<script>
  window.onload = ()=>{
    $.ajax({
			method:"POST",
			url:projectPath+"/resource/controller/cart_controller.php",
			contentType:"application/x-www-form-urlencoded; charset=utf-8",
			data:{"func":"cart_count"}
		})
    .done((response)=>{
      response = JSON.parse(response);
      if(parseInt(response.status)==1){
          $("#cart_count").html(response.result.quan);
      }
    });
  }

  $("#logout_btn").click(()=>{
		$.ajax({
			method:"POST",
			url:projectPath+"/resource/controller/login.php",
			contentType:"application/x-www-form-urlencoded; charset=utf-8",
			data:{"func":"logout"}
		}
		).done((rs)=>{
			console.log(rs)
			if(rs==0){
				Swal.fire({
					icon: 'error',
					title: 'เกิดข้อผิดพลาด!',
					text: ''
				});
			}else if(rs==1){
				location.href = projectPath;
			}
		});
  });
</script>