<?php include(__DIR__.'/../resource/controller/login.php');?>
<!DOCTYPE html>
<html>
<head>
<?php 
include(__DIR__.'/../resource/include/script.html');
include(__DIR__.'/../resource/include/menu.php');
?>
<title>หวย</title>
</head>
<body>
	<br><br><br>
	<div class="container">
	 <button class="btn btn-outline-info" style="width: 100%;text-align: left"><i class="fas fa-arrow-left"></i> ย้อนกลับ</button><br><br>

		<div class="alert alert-info text-dark" style="width:100%">
			<div class="alert-body">
				<h2>ช่องทางการชำระเงิน</h2>
				<label>ธนาคารกรุงสุโขทัย</label><br>
				<label>เลขบัญชี 675 346 33452</label><br>
				<label>นาย อิอิ คริคริ</label>
			</div>
		</div>
	   	  
		<br>
		<center>
		<div id="deb_component">
			<div class="row">
				<div class="col col-12">
					<select id="inputState" class="form-control">
			        <option selected>เลือกธนาคารของท่าน</option>
			        <option>...</option>
			      </select>
				</div>
			</div>

			<div class="row" style="margin:20px">	
				<label style="text-align: left">แนบในเสร็จ</label>
				  <div class="form-group"> 
				    <input type="file" class="form-control-file">
				    <br><br>
				   
				  </div>
			</div>
			 <button class="btn btn-info" style="width: 100%" onclick="go_comfirm()">ส่ง</button>

	</div>
	</div>

<script src='../resource/script.js'></script>
<script type="text/javascript">
			function go_comfirm(){
			window.location = "wait_for_confirm.php";
		}
</script>
</body>
</html>