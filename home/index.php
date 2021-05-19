<?php include(__DIR__."/../resource/controller/home_controller.php"); ?>
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
				<h2>รายการทั้งหมด</h2>
				<label>งวดวันที่ 32 มกราคม 2555</label>

				<div class="prompt text-secondary">ค้นหลาเลขเด็ด</div>
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
				<button id="search_btn" class="btn btn-dark" style="padding-left:80px;padding-right:80px;">ค้นหา</button>
			</div>
		</div>
	   	  
		<br>
		<center>
		<div id="lotery_all">
			<div class="row" id='lotery_rows'>
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
							while(($row=$lotterySet->fetch_array())!=Null){ ?>
								<div class="col col-6">
									       <div class="card border-info" style="text-align:center;">
									       		<div class="card-header bg-white" style="height:40px;">
									       		   <p  style="font-size:14px" class="badge badge-light"><?php echo $row["number"]; ?></p><br>
									       		</div>
												<div class="card-body" style="overflow:auto;">
													<img  class="responsive_img" src="../images/item/<?php echo $row["img"]; ?>"><br><br>
													<h5 class="text-secondary"><i class="fas fa-box"></i> คงเหลือ <?php echo $row["stock"]; ?></h5>
													<buttcon type="button" class="btn btn-info" style="width: 100%"><i class="fas fa-search-plus"></i></button>
												</div>
										  </div>
								</div>
					<?php
								$i+=1;
								if($i%2==0){
									echo "<div class='w-100'></div><br>";
								}
							}  
						} ?>
			</div>
	</div>
	</div>
<script src='../resource/script.js'></script>
</body>
</html>