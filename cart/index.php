<!DOCTYPE html>
<html>
<head>
	<?php 
	include(__DIR__.'/../resource/include/script.html');
	include(__DIR__.'/../resource/include/menu.php');
	?>
	<style type="text/css">
		.total {
			overflow: hidden;
			background-color: #f8f9fa!important;
			position: fixed;
			bottom: 0;
			width: 100%;

		}

		.total a {
			float: left;
			display: block;
			color: black;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
			font-size: 17px;
		}
	</style>

	<title>ตระกร้าสินค้า</title>
</head>
<body>
	<br><br><br>
	<div class="container" style="text-align: center">
		<a href="/home/" class="btn btn-outline-info" style="width: 100%;text-align: left"><i class="fas fa-arrow-left"></i> ย้อนกลับ</a>
		<br>
		<br>
		
		<div class="alert alert-info text-dark" style="width:100%">
			<div class="alert-body">
				<h2><i class="fas fa-shopping-bag"></i> ตระกร้าของฉัน</h2>
				
			</div>
		</div>
		<div style="margin-bottom: 30% ; margin-top: 15px">
			<div class="shadow-sm p-3 mb-1 bg-body rounded" style="width:100% ; text-align: left">
				<div class="alert-body">
					<div class="row">

						<div class="col-8" style="text-align: center">
							<h5>หมายเลข 955 776</h5>
							<img  class="responsive_img" src="../images/item/lotto_excemple.jpeg">

						</div>
						<div class="col-4">
							<label>80 ฿</label>
							<br>
							<label>จำนวน 1 ใบ</label>
							<button class="btn btn-outline-danger" style="width: 100%" onclick="del()">ลบ</button>
						</div>

					</div>
				</div>
			</div>	   	  
			<div class="shadow-sm p-3 mb-1 bg-body rounded" style="width:100% ;text-align: left">
				<div class="alert-body">
					<div class="row">

						<div class="col-8"  style="text-align: center">
							<h5>หมายเลข 955 776</h5>
							<img  class="responsive_img" src="../images/item/lotto_excemple.jpeg">

						</div>
						<div class="col-4">
							<label>80 ฿</label>
							<br>
							<label>จำนวน 1 ใบ</label>
							<button class="btn btn-outline-danger" style="width: 100%">ลบ</button>
						</div>

					</div>
				</div>
			</div>
			<div class="shadow-sm p-3 mb-1 bg-body rounded" style="width:100% ; text-align: left">
				<div class="alert-body">
					<div class="row">

						<div class="col-8"  style="text-align: center">
							<h5>หมายเลข 955 776</h5>
							<img  class="responsive_img" src="../images/item/lotto_excemple.jpeg">

						</div>
						<div class="col-4">
							<label>80 บาท</label>
							<br>
							<label>จำนวน 1 ใบ</label>
							<button class="btn btn-outline-danger" style="width: 100%">ลบ</button>
						</div>

					</div>
				</div>
			</div>
			<div class="shadow-sm p-3 mb-1 bg-body rounded" style="width:100% ;text-align: left ;">
				<div class="alert-body">
					<div class="row">

						<div class="col-8"  style="text-align: center">
							<h5>หมายเลข 955 776</h5>
							<img  class="responsive_img" src="../images/item/lotto_excemple.jpeg">

						</div>
						<div class="col-4">
							<label>80 บาท</label>
							<br>
							<label>จำนวน 1 ใบ</label>
							<button class="btn btn-outline-danger" style="width: 100%">ลบ</button>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="total">
	<div class="row" style="padding: 10px">
		<div class="col-8">
			<p class="text text-dark" style="margin-left: 10px;margin-top: 15px; font-size: 20px;">ทั้งหมด <b>฿99</b> </p>
		</div>
		<div class="col-4" style="">
			<a class="btn btn-info text-light" href="transfer_money.php">ชำระเงิน</a>
		</div>
	</div>
</div>

<script src='../resource/script.js'></script>
<script type="text/javascript">
	function go_home(){
		window.location = "index.php";
	}

	function del(){
		// Swal.fire({
		// 	title: 'ยืนยันการลบรายการ',
		// 	text: "ข้อมูลจะถูกลบออกจากตระกร้าสินค้าของคุณ",
		// 	icon: 'warning',
		// 	showCancelButton: true,
		// 	confirmButtonColor: '#3085d6',
		// 	cancelButtonColor: '#d33',
		// 	confirmButtonText: 'ลบ'
		// }).then((result) => {
		// 	if (result.isConfirmed) {


		// 	}
		// });
	}
</script>
</body>
</html>