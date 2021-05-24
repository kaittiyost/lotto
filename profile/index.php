<?php 
include(__DIR__."/../resource/controller/profile_controller.php");
$profileGetData = new GetData();
$profile = $profileGetData->profile(); 
?>
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
	<div class="container" style="text-align:center;">

		<div class="alert alert-info text-dark" >
			<h4>Profile</h4>
		</div>
		<div class="shadow-sm p-3 mb-5 bg-body rounded">
			<i class="fas fa-user-circle" style="font-size: 30px"></i><br>
			<p ><?php echo $profile["user_name"].'  '.$profile["user_lastname"]; ?> </p><hr>
			<p style="text-align:left"><i class="fas fa-user"></i>  <?php echo $profile["user_username"]; ?> </p><hr>
			<?php if($profile["user_tel"] == ""){?>
				<div class="row">
					<div class="col-8">
						<p style="text-align:left ;"><i class="fas fa-phone-alt"></i> ยังไม่ได้บันทึกหมายเลข <i class="fas fa-exclamation-circle" style="color:gold"></i></p> 
					</div>
					<div class="col-4">
						<a href=""  data-toggle="modal" data-target=".bd-tel-modal-sm">เพิ่ม <i class="fas fa-plus-circle"></i></a>
					</div>
				</div>
				<hr>
			<?php }else{ ?>
				<p style="text-align:left"><i class="fas fa-phone-alt"></i>  <?php echo $profile["user_tel"]; ?></p><hr>
			<?php } ?>
			<?php if($profile["user_email"] == ""){?>
				<div class="row">
					<div class="col-8">
						<p style="text-align:left ;"><i class="fas fa-envelope"></i> ยังไม่ได้บันทึก Email <i class="fas fa-exclamation-circle" style="color:gold"></i></p> 
					</div>
					<div class="col-4">
						<a href="" data-toggle="modal" data-target=".bd-email-modal-sm">เพิ่ม <i class="fas fa-plus-circle"></i></a>
					</div>
				</div>

			<?php }else{ ?>
				<p style="text-align:left"><i class="fas fa-phone-alt">  <?php echo $profile["user_tel"]; ?></i></p><hr>
			<?php } ?>
		</div>
		<div class="row">
		<div class="col">
			<a href="#edit_password" class="btn btn-outline-danger" style="width :100%" data-toggle="modal" data-target=".bd-password-modal-sm"><i class="far fa-edit"></i> เปลี่ยนรหัสผ่าน</a>
		</div>
	</div>
	<br>
	<center>
		<div id="lotery_all">
			<div class="row" id='lotery_rows'>

			</div>
		</div>
	</div>

	<!-- modal add email -->
	<div class="modal fade bd-email-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus-circle"></i> เพิ่ม Email</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="alert_email"></div>
					<input type="email" name="email" class="form-control" placeholder="กรอก Email ของคุณ">
				</div>
				<div class="modal-footer">
					<a  class="btn btn-outline-success" id="btn_add_email">บันทึก</a>
				</div>
			</div>
		</div>
	</div>
	<!-- modal add tel -->
	<div class="modal fade bd-tel-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus-circle"></i> เพิ่มหมายเลขโทรศัพท์</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="alert_tel"></div>
					<input type="number" id="tel" class="form-control" placeholder="กรอกหมายเลขโทรศัพท์ของคุณ">
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-outline-success" id="btn_add_tel">บันทึก</a>
				</div>
			</div>
		</div>
	</div>
	<!-- modal change password -->
	<div class="modal fade bd-password-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><i class="far fa-edit"></i> เปลี่ยนรหัสผ่าน</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="alert_tel"></div>
					<input type="text" id="old_password" class="form-control" placeholder="รหัสผ่านเดิม"><br>
					<input type="text" id="new_password" class="form-control" placeholder="รหัสผ่านใหม่"><br>
					<input type="text" id="confirm_new_password" class="form-control" placeholder="ยืนยันรหัสผ่านใหม่">
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-outline-success" id="btn_add_tel">บันทึก</a>
				</div>
			</div>
		</div>
	</div>

	<script src='../resource/script.js'></script>
	<script src='../resource/include/profile_script.js'></script>
</body>
</html>