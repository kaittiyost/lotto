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
				 <input type="search" class="form-control" placeholder="ค้นหาเลขเด็ด" onKeyup="findDebtor(this.value)">
			</div>
		</div>
	   	  
		<br>
		<center>
		<div id="deb_component">
			<div class="row" id='all_debtor'>
					<div class="col col-6">
									       <div class="card border-info" style="text-align:center;">
									       		<div class="card-header bg-white" style="height:40px;">
									       		   <p  style="font-size:14px" class="badge badge-light">779 998</p><br>
									       		</div>
												<div class="card-body" style="overflow:auto;">
													<img  class="responsive_img" src="../images/item/lotto_excemple.jpeg"><br><br>
													<button type="button" class="btn btn-info" style="width: 100%"><i class="fas fa-search-plus"></i></button>
												</div>
										  </div>
						</div>
						<div class="col col-6">
									       <div class="card border-info" style="text-align:center;">
									       		<div class="card-header bg-white" style="height:40px;">
									       		   <p  style="font-size:14px" class="badge badge-light">666 099</p><br>
									       		</div>
												<div class="card-body" style="overflow:auto;">
													<img  class="responsive_img" src="../images/item/lotto_excemple.jpeg"><br><br>
													<button type="button" class="btn btn-info" style="width: 100%"><i class="fas fa-search-plus"></i></button>

												</div>
										  </div>
						</div>

					<div class="w-100"></div><br>;

			</div>
	</div>
	</div>

<script src='../resource/script.js'></script>
</body>
</html>