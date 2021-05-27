<?php 
	include(__DIR__."/../resource/controller/home_controller.php");
	include(__DIR__.'/../resource/include/script.html');
?>
<!DOCTYPE html>
<html>
<head>
	<?php 
		include(__DIR__.'/../resource/include/menu.php');
	?>
	<title>หวย</title>
</head>
<body>
	<br><br><br>
	<div class="container" style="text-align:center;">
		<div class="alert alert-info text-dark" style="width:100%">
			<div class="alert-body">
				<h2>รายการทั้งหมด</h2>
				<label>งวดวันที่ 32 มกราคม 2555</label>
				<div class="prompt text-secondary">ค้นหาเลขเด็ด</div>
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
				<button id="search_btn" class="btn btn-dark btn-md-width">ค้นหา</button>
			</div>
		</div>
		<br>
			<div class="row" id="lotery_all">
				<div class="col" id='lotery_rows'>
					<?php 
					$key = Null;
					if(isset($_GET["s"])){
						$key = $_GET["s"];
					}
					$lotterySet = GetData::lottery($key);
					$i = 0;
					if(is_null($lotterySet)){ ?>
						<h1 style="margin:auto;width:50%;">ไม่มีสินค้า</h1>
					<?php }else{ 
						echo "<div class='card-deck'>";
						while(($row=$lotterySet->fetch_array())!=Null){ ?>
							<div class="card" style="box-shadow: 5px 10px 8px #B9B9B9;">
								<img class="card-img-top" style="height:200px;" src="../images/item/<?php echo $row["img"]; ?>">
								<div class="card-body" style="text-align:left;">
									<h5 class="card-title" style="color:orange;font-size:25px;letter-spacing: 3px;"><?php echo $row["number"]; ?></h5>
									<p class="card-text">ใบละ <?php echo $row["price"]; ?> ฿</p>
									<p class="card-text text-secondary">คงเหลือ <?php echo $row["stock"]; ?> ใบ</p>
								</div>
								<div class="card-footer">
										<a data-toggle="modal" 
												data-id="<?php echo $row["id"]; ?>"
												data-quantity="<?php echo $row["stock"]; ?>" 
												data-number="<?php echo $row["number"]; ?>"  
												data-img="<?php echo $row["img"]; ?>" 
												class="open-quan btn btn-primary" 
												href="#DetailModal"
												style="width: 70%;padding-top:10px;padding-bottom:10px;">
												<i class="fas fa-shopping-cart"></i>
										</a>
								</div>
							</div>
							<?php }  
							} ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->

		<div class="modal fade" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" id="detailDialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="lottoly_number"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<input type="hidden" id="lottoly_id" value="">
						<div id="lottoly_img"></div>
					</div>
					<div class="modal-footer">
						<form style="width:50%;margin:auto;text-align:center;">
							<div class="row">
								<div class="col">
									<p>ใบละ 80 บาท</p>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div id="lottoly_quantity" style="margin-top:10px;"></div>
								</div>
							</div>
							<div class="row">
								<div  class="col">
									<select id="quan_select" class="form-control"  style="width:60%;margin:auto;margin-top:10px;">
										<option selected>เลือกจำนวน</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<button type="button" id="add_to_card_btn" class="btn btn-warning" style="margin-top:20px;">เพิ่มในตระกร้า</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script src='../resource/script.js'></script>
	</body>
	</html>