<?php include(__DIR__.'/../resource/controller/login.php');?>
<!DOCTYPE html>
<html>
<head>
<?php include(__DIR__.'/../resource/include/menu.php');?>
<title>หวย</title>
</head>
<body>
	<br><br><br>
	<div class="container" style="text-align:center;">
	
		<div class="alert alert-info text-dark" style="width:100%">
			<div class="alert-body">
				<h2>รายการทั้งหมด</h2>
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_debtor_modal"><i class="fa fa-plus"></i> เพิ่มผู้ติดหนี้</button>
			</div>
		</div>
	   	   <input type="search" class="form-control" placeholder="ค้นหา" onKeyup="findDebtor(this.value)">
		<br>
		<center>
		<div id="deb_component">
			<div class="row" id='all_debtor'>
					<div class="col col-6">
									       <div class="card border-info" style="text-align:center;">
									       		<div class="card-header bg-white" style="height:40px;">
									       		   <p  style="font-size:14px" class="badge badge-light">ทดสอบ</p><br>
									       		</div>
												<div class="card-body" style="overflow:auto;">
													<img style="width:80px;height:80px" class="img-thumbnail" src="../images/lot/test.jpg"><br><br>
												</div>
										  </div>
						</div>
						<div class="col col-6">
									       <div class="card border-info" style="text-align:center;">
									       		<div class="card-header bg-white" style="height:40px;">
									       		   <p  style="font-size:14px" class="badge badge-light">ทดสอบ</p><br>
									       		</div>
												<div class="card-body" style="overflow:auto;">
													<img style="width:80px;height:80px" class="img-thumbnail" src="../images/lot/test.jpg"><br><br>
												</div>
										  </div>
						</div>
					<div class="w-100"></div><br>;

			</div>
	</div>
	</div>

<!-- Modal -->
<div class="modal fade" id="add_debtor_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title">เพิ่มผู้ติดหนี้รายใหม่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	  <label for="img_profile">รูปโปรไฟล์</label><br>
      	<input type="file" id="img_profile"><br>
      	 <label for='name'>ชื่อ-นามสกุล</label>
        <input type="text" id="name" class="form-control" placeholder="ขื่อ-นามสกุล">
         <label for='total'>ยอดเงิน</label>
        <input type="number" id="total" class="form-control" placeholder="ยอดเงิน(บาท)">
          <label for='tel'>เบอร์ติดต่อ</label>
        <input type="text" id="tel" class="form-control" placeholder="เบอร์">
          <label for='addr'>ที่อยู่</label>
        <input type="text" id="addr" class="form-control" placeholder="ที่อยู่">
          <label for='deb_desc'>คำอธิบาย</label>
        <textarea id="deb_desc" style="height:200px" class="form-control" placeholder="ช้อมูลต่างๆ"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" onClick="addDebtor()">ยืนยัน</button>
      </div>
    </div>
  </div>
</div>
<script src='../resource/script.js'></script>
</body>
</html>