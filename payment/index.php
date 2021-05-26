<?php
include(__DIR__ . "/../resource/controller/purchase_list_controller.php");
$payment_GetData = new GetData();
$payment = $payment_GetData->payment_list($_POST["sale_id"]);
?>
<!DOCTYPE html>
<html>

<head>
	<?php
	include(__DIR__ . '/../resource/include/script.html');
	include(__DIR__ . '/../resource/include/menu.php');
	?>
	<title>หวย</title>
</head>

<body>
	<br><br><br>
	<div class="container">
		<a href="/purchase_list/" class="btn btn-outline-info" style="width: 100%;text-align: left"><i class="fas fa-arrow-left"></i> ย้อนกลับ</a><br><br>

		<div class="alert alert-info text-dark" style="width:100%">
			<div class="alert-body">
				<h2>ช่องทางการชำระเงิน</h2>
				<label>ธนาคารกรุงสุโขทัย</label><br>
				<label>เลขบัญชี 675 346 33452</label><br>
				<label>นาย อิอิ คริคริ</label>
			</div>
		</div>
		<div class="shadow-sm p-3 mb-5 bg-body rounded">
			<div class="row">
				<div class="col-6">
					<label id="sale_id">หมายเลขสั่งซื้อ <?php echo $payment['s_id'] ?></label><br>
				</div>
				<div class="col-6">
					<p class="badge badge-pill badge-secondary text-light">รอส่งหลักฐานชำระเงิน</p>
				</div>
			</div>
			<label>ยอด ฿<?php echo $payment['price'] ?></label><br>
			<label>ค่าธรมเนียม ฿<?php echo intval($payment['quan']) * 20 ?></label> <br>
			<label class="text text-danger">รวม ฿<?php echo intval($payment['price']) + (intval($payment['quan']) * 20) ?></label>

		</div>

		<center>
			<div id="deb_component">
				<div class="row">

					<div class="col col-12">
						<select id="" class="form-control">
							<option selected>เลือกธนาคารของท่าน</option>
							<option>ธนาคารกรุงไทย</option>
							<option>ธนาคารออมสิน</option>
							<option>ธนาคารธกส</option>
							<option>ธนาคารกรุงเทพ</option>
							<option>ธนาคารกรุงศรี</option>
							<option>ธนาคารTMB</option>
						</select>
					</div>
					<br>
					<div class="col col-12">
						<br>
						<div class="form-group row">
							<label for="example-date-input" class="col-4 col-form-label">วันที่โอน</label>
							<div class="col-8">
								<input class="form-control" type="date" value="" id="example-date-input">
							</div>
						</div>
						<br>
						<div class="form-group row">
							<label for="example-time-input" class="col-4 col-form-label">เวลาที่โอน</label>
							<div class="col-8">
								<input class="form-control" type="time" value="00:00:00" id="example-time-input">
							</div>
						</div>
					</div>
				</div>

				<div class="row" style="margin:20px">
					<label style="text-align: left">แนบในเสร็จ</label>
					<div class="form-group">
						<input id="img_slip" type="file" class="form-control-file">
						<br>

					</div>
				</div>
				<button class="btn btn-info" style="width: 100% ; margin-bottom: 20%" onclick="upload_slip()">ส่ง</button>

			</div>
	</div>

	<script src='../resource/script.js'></script>
	<script src='../resource/include/purchase_script.js'></script>

</body>

</html>