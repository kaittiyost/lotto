<?php 
include(__DIR__."/../resource/controller/purchase_list_controller.php");
$getData = new GetData();
$purchase_list = $getData->purchase_list(); 
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
<style type="text/css">
.stack-3 { position: relative; z-index: 10; }

/* Image styles */
.stack-3 img { max-width: 100%; height: auto; vertical-align: bottom; border: 0px solid #fff; border-radius: 3px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	-webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
	-moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
}

/* Stacks creted by the use of generated content */
.stack-3:before, .stack-3:after { content: ""; border-radius: 3px; width: 100%; height: 100%; position: absolute; border: 2px solid #fff; left: 0; 
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
-webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
-moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
-webkit-transition: 0.3s all ease-out;
-moz-transition: 0.3s all ease-out;
transition: 0.3s all ease-out;
}
.stack-3:before { top: 4px; z-index: -10; } /* 1st element in stack (behind image) */
.stack-3:after { top: 8px; z-index: -20; } /* 2nd element in stack (behind image) */

.stack-2 { position: relative; z-index: 10; }

/* Image styles */
.stack-2 img { max-width: 100%; height: auto; vertical-align: bottom; border: 0px solid #fff; border-radius: 3px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	-webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
	-moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
}

/* Stacks creted by the use of generated content */
.stack-2:before, .stack-2:after { content: ""; border-radius: 3px; width: 100%; height: 100%; position: absolute; border: 2px solid #fff; left: 0; 
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
-webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
-moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
-webkit-transition: 0.3s all ease-out;
-moz-transition: 0.3s all ease-out;
transition: 0.3s all ease-out;
}
.stack-2:before { top: 4px; z-index: -10; } /* 1st element in stack (behind image) */

</style>
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
						<div class="col-5"  style="text-align: center">
							<?php if($row['quan'] == '2'){?>
								<div class="stack-2">
									<img  class="responsive_img " src="../images/item/lotto_excemple.jpeg">
								</div>
							<?php }else if($row['quan'] > '1'){?>
								<div class="stack-3">
									<img  class="responsive_img " src="../images/item/lotto_excemple.jpeg"></div>
								<?php }else{?>
									<img  class="responsive_img shadow-sm p-0 mb-5 bg-white rounded border" src="../images/item/lotto_excemple.jpeg">
								<?php }?>
								<label><?php echo 'x'.$row['quan'];?></label><br>
							</div>
							<div class="col-7" style="text-align: right;">
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
									<label style="color: gray"> <?php echo '#หมายเลขสั่งซื้อ '.$row['id'];?> </label><br>
									<label><?php echo 'งวดวันที่ '.$row['lot_date'];?></label><br>			
									<label style="color:red"><?php echo 'รวม ฿'.$row['price'];?></label><br>
								</div>
							</div>
							<div class="row">
								<div class="col-6" style="text-align:center;width: 100%;">	
									<p class="text-info" style="font-size:13px">วันสั่งซื้อ <?php echo $row['date'];?></p>
								</div>
								<div class="col-6" style="text-align:right;">
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
				<?php 
					include(__DIR__.'/../resource/include/footer_menu.php');
				?>
			</body>
			</html>