<?php 
include(__DIR__."/../resource/controller/purchase_list_controller.php");
$purchase_list_GetData = new GetData();
$purchase_list = $purchase_list_GetData->purchase_list(); 
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
		<div class="alert alert-info text-dark" style="width:100%">
			<div class="alert-body">
				<h2><i class="fas fa-list-ul"></i> รายการซื้อของฉัน</h2>			
			</div>
		</div>
		<hr>
		<?php 
		if(is_null($purchase_list)){?>
			<h3 style="margin:auto;width:50%;">ไม่มีรายการซื้อ</h3>
		<?php }else{ 
			while(($row=$purchase_list->fetch_array())!=Null){
				?>
				<div class="shadow-sm p-3 mb-1 bg-body rounded" style="margin-top: 20px">
					<div class="row">
						<div class="col-6"  style="text-align: center">
							<img  class="responsive_img" src="../images/item/lotto_excemple.jpeg">
							<label><?php echo 'x'.$row['quan'];?></label><br>
						</div>
						<div class="col-6" style="text-align: right;">
							<?php if($row['slip'] == "0"){?>
								<span class="badge badge-secondary">รอส่งหลักฐาน</span>
							<?php }else{
								if($row['status'] == '0'){?>
									<span class="badge badge-warning">กำลังตรวจสอบ</span>
								<?php }else if($row['status'] == '1'){?>
									<span class="badge badge-success">ซื้อสำเร็จแล้ว</span>
								<?php }else{ ?>
									<span class="badge badge-danger">ถูกยกเลิก</span>
							<?php }} ?>
							<h5>หมายเลข <?php echo $row['number'];?></h5>
							<label><?php echo 'งวดวันที่ '.$row['lot_date'];?></label><br>			
							<label style="color:red"><?php echo 'รวม ฿'.$row['price'];?></label><br>
						</div>
					</div>
					<div class="row">
						<div class="col-8">	
							<label style="color: gray"> <?php echo '#หมายเลขสั่งซื้อ '.$row['id'];?> </label>
						</div>
						<div class="col-4" style="text-align:right;">
							<form action="../payment/" method="POST">
								<input type="hidden" name="sale_id" id="sale_id" value="<?php echo $row['id'] ?>"></input>
								<button class="btn btn-ligth" type="submit"><i class="fas fa-chevron-right"></i></button>
							</form>
							
						</div>
					</div>
				</div>

			<?php }} ?>
			<br>
		</div>


		<script src='../resource/script.js'></script>
	</body>
	</html>