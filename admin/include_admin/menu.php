<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Lotto Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="/admin/">หน้าแรก<span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="/admin/sales_report/">ยอดขาย</a>
      <a class="nav-item nav-link" id="logout_btn">ออกจากระบบ</a>
    </div>
  </div>
</nav>
<script>
  $("#logout_btn").click(()=>{
		$.ajax({
			method:"POST",
			url:projectPath+"/resource/controller/admin_controller.php",
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
				location.href = projectPath+"/admin/login_admin.php";
			}
		});
  });
</script>