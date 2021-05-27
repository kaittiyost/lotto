<?php 
	include(__DIR__."/../resource/controller/admin_controller.php");
	include(__DIR__.'/../resource/include/script.html');
    $data = new GetData();
?>
<!DOCTYPE html>
<html>
<head>
<?php 
	include(__DIR__."/include_admin/menu.php");	
?>
	<title>admin</title>
</head>
<body class="bg-dark">
	<br><br><br>
	<div class="container" style="text-align:center;">
			<div class="card" style="margin-bottom:10px;">
			<div class="card-header">
				<h5 class="float-left"><i class="fas fa-cogs"></i> จัดการ</h5>
			</div>
			<div class="card-body">
					<div class="row">
						<div class="col">
							<button onClick="switchModal('add',{})" type="button" class="btn btn-sm btn-success"  data-toggle="modal" data-target="#lottery_modal">
								<i class="fas fa-folder-plus"></i> เพิ่มล๊อตเตอรี
							</button>
							<button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#option_date_modal"><i class="fas fa-calendar-week"></i> งวดเปิดขาย</button>
							
						</div>
					</div>
			</div>
		</div>
		<div class="alert alert-info text-dark" style="width:100%">
			<div class="alert-body">
				<h2>รายการทั้งหมด</h2>
				<div class="prompt text-secondary">ค้นหาหมายเลข</div>
				<form method="get" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
					<input type="number" id="digit-1" name="digit-1" data-next="digit-2" />
					<input type="number" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
					<input type="number" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
					<span class="splitter">&ndash;</span>
					<input type="number" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
					<input type="number" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
					<input type="number" id="digit-6" name="digit-6" data-previous="digit-5" />
				</form>
				<br>
				<button id="search_admin_btn" class="btn btn-dark btn-md-width">ค้นหา</button>
			</div>
		</div>

		<div class="card">
			<div class="card-body" id="lottery_all">
				<table class="table" style="width:100%;" id="lottery_rows">
					<thead class="bg-primary text-white">
						<tr>
							<th>หมายเลข</th>
							<th>งวด</th>
							<th>ราคา</th>
							<th>ขายไปแล้ว</th>
							<th>คงเหลือ</th>
							<th>สถานะ</th>
							<th></th>
							<th></th>

						</tr>
					</thead>
					<tbody>
					<?php 
						$key = Null;
						if(isset($_GET["s"])){
							$key = $_GET["s"];
						}
						$lotterySet = GetData::lottery($key);
						if(is_null($lotterySet)){ ?>
							<h1 style="margin:auto;width:50%;">ไม่มีสินค้า</h1>
						<?php }else{ 
							while(($row=$lotterySet->fetch_array())!=Null){ ?>
								<tr>
									<td><?php echo $row["number"]; ?></td>
									<td><div class="badge"><?php echo $row["date"]; ?></div></td>
									<td><?php echo $row["price"]; ?></td>
									<td><?php echo $row["quan"]; ?></td>
									<td><?php echo $row["stock"]; ?></td>
									<td style="font-size:20px;"><?php echo (intval( $row["status"])==1)?"<i class='far fa-check-circle text-success'></i>"
																				:"<i class='fas fa-lock text-danger'></i>";
													?></td>
									<th>
										<button type="button" style="width:100%;" onClick="switchModal('edit',{id:<?php echo $row["id"]; ?>
																							,number:'<?php echo $row["number"]; ?>'
																							,date:'<?php echo $row["date"]; ?>'
																							,stock:<?php echo $row["stock"]; ?>
																							,price:<?php echo $row["price"]; ?>
																							,status:<?php echo $row["status"]; ?>})" 
										class="btn btn-outline-primary"  data-toggle="modal" data-target="#lottery_modal"><i class="fas fa-pen-square"></i></button>
									</th>
									<th>
										<button type="button" onClick="del_lottery(<?php echo $row["id"]; ?>)" style="width:100%;" class="btn btn-outline-danger"><i class="fas fa-minus-circle"></i></button>
									</th>
								</tr>
								<?php
							}  
						} ?>
					</tbody>
				</table>
			</div>
		</div>
		<br>
		</div>
	    <!-- ADD LOTTERY  MODAL -->
		<div class="modal fade" id="lottery_modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-success">
						<h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-folder-plus"></i> เพิ่มล๊อตเตอรี</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="font-size:15px;">
						<input type="hidden" id="id_lotto" value="">
						<button id="edit_img_check" class="btn btn-sm btn-outline-primary"><i class="fas fa-image"></i> แก้ไขรูป</button>
						<br>
						<div id="img_lotto_g">
							<label for="img_lotto"><i class="fas fa-image"></i> ภาพ : </label>
							<input id="img_lotto" type="file" class="form-control" value="เลือกรูปภาพ">
						</div>
						<br>
						<label for="number_lotto"><i class="far fa-credit-card"></i> หมายเลข : </label>
						<input id="number_lotto" type="text" class="form-control bg-dark text-light" maxlength="6" placeholder="123456">
						<br>
						<label for="stock_lotto"><i class="fas fa-box"></i> จำนวน : </label>
						<input id="stock_lotto" type="number" class="form-control bg-dark text-light" placeholder="10,20,30">
						<br>
						<label for="price_lotto"><i class="fas fa-calendar-week"></i> ราคา : </label>
						<input id="price_lotto" type="number" class="form-control bg-dark text-light" placeholder="80฿">
						<br>
						<label for="date_lotto"><i class="fas fa-calendar-week"></i> งวด : </label>
						<input id="date_lotto" type="date" class="form-control bg-primary text-light" placeholder="วว/ดด/ปปปป">
						<br>
						<label for="status_lotto"><i class="fas fa-lock-open"></i> สถานะ : </label>
						<select class="form-control" id="status_lotto">
							<option value="1">เปิดขาย</option>
							<option value="0">ยังไม่เปิดขาย</option>
						</select>
						<br>
					<div class="modal-footer">
						<button type="button" id="btn_add_lotto" class="btn btn-outline-primary" style="padding-left:15px;padding-right:15px;">
							<i class="fas fa-plus-circle"></i> เพิ่ม
						</button>
						<button type="button" id="btn_edit_lotto" class="btn btn-outline-dark" style="padding-left:15px;padding-right:15px;">
							<i class="fas fa-minus-circle"></i> แก้ไข
						</button>
					</div>
					</div>
				</div>
			</div>
		</div>
		<!--  ADD LOTTERY  MODA(end) -->
	    <!-- ADD LOTTERY  MODAL -->
		<div class="modal fade" id="option_date_modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header text-secondary">
						<h5 class="modal-title"><i class="fas fa-cogs"></i> ตั้งค่าวันที่เปิดขาย</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col">
								<label for="start_date">จาก</label>
								<input type="date" id="start_date" class="form-control">
							</div>
							<div class="col">
								<label for="end_date">ถึง</label>
								<input type="date" id="end_date" class="form-control">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" onClick="edit_date_option()" class="btn btn-outline-primary" style="padding-left:15px;padding-right:15px;">
							<i class="fas fa-plus-circle"></i> บันทึก
						</button>
					</div>
				</div>
			</div>
		</div>
		<!--  ADD LOTTERY  MODA(end) -->
		

		<style>
			td{
				border-right : 0.1px solid #A4A4A4;
				border-left : 0.1px solid #A4A4A4;
			}
		</style>
		<script src='../resource/script.js'></script>
		<script>
			window.onload =()=>{
				loadDataTable();
			}
		</script>
	</body>
	</html>