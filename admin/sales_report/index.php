<?php 
	include(__DIR__."/../../resource/controller/sales_report_controller.php");
	include(__DIR__.'/../../resource/include/script.html');
    $data = new GetData();
    $data->sales(0);
?>
<!DOCTYPE html>
<html>
<head>
<?php 
	include(__DIR__."/../include_admin/menu.php");	
?>
	<title>admin</title>
</head>
<body class="bg-dark">
	<br><br><br>
	<div class="container" style="text-align:center;">
		<div class="alert alert-info text-dark" style="width:100%">
			<div class="alert-body">
				<h2>รายการขาย</h2>
			</div>
		</div>
        <div class="row">
            <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col col-6" style="padding-right:0px;">
                                    <button class="btn btn-primary float-right" id="btn_sw_not_con" onClick="switchSalesTb(0)">รายการยังไม่ชำระ</button>
                                </div>
                                <div class="col  col-6" style="padding-left:0px;">
                                    <button class="btn btn-outline-primary float-left" id="btn_sw_con" onClick="switchSalesTb(1)">รายการยังไม่ชำระ</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="lottery_all">
                            <table class="table table-striped" style="width:100%;" id="non_confirm_tb">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>รหัส</th>
                                        <th>ผู้ซื้อ</th>
                                        <th>ราคารวม</th>
                                        <th>วันที่</th>
                                        <th>เวลา</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody id="not_confirm_tb" style="font-size:16px;">
                                        <?php 
                                            $sales_non_confirm = GetData::sales(0);
                                            if(is_null($sales_non_confirm)){ ?>
                                                <!-- <h1 style="margin:auto;width:50%;">ไม่มีสินค้า</h1> -->
                                    <?php }else{ while(($row=$sales_non_confirm->fetch_array())!=Null) { ?>
                                                                <tr>
                                                                    <td><?php echo $row["id"]; ?></td>
                                                                    <td><?php echo $row["USER_USERNAME"]; ?></td>
                                                                    <td><?php echo $row["sum"]; ?></td>
                                                                    <td><div class="badge"><?php echo explode(" ",$row["reg_date"])[0]; ?></div></td>
                                                                    <td><?php echo explode(" ",$row["reg_date"])[1]; ?></td>
                                                                    <td><button class="btn btn-dark"><i class="fas fa-search-plus"></i> ดู</button></td>
                                                                </tr>
                                            <?php   }
                                        
                                            } ?>
                                </tbody>
                            </table>
                            <table class="table table-striped" style="width:100%;display:none;"  id="confirm_tb">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>รหัส</th>
                                        <th>ผู้ซื้อ</th>
                                        <th>ราคารวม</th>
                                        <th>วันที่</th>
                                        <th>เวลา</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody style="font-size:16px;">
                                        <?php 
                                            $sales_non_confirm = GetData::sales(1);
                                            if(is_null($sales_non_confirm)){ ?>
                                                <!-- <h1 style="margin:auto;width:50%;">ไม่มีสินค้า</h1> -->
                                    <?php }else{ while(($row=$sales_non_confirm->fetch_array())!=Null) { ?>
                                                                <tr>
                                                                    <td><?php echo $row["id"]; ?></td>
                                                                    <td><?php echo $row["USER_USERNAME"]; ?></td>
                                                                    <td><?php echo $row["sum"]; ?></td>
                                                                    <td><div class="badge"><?php echo explode(" ",$row["reg_date"])[0]; ?></div></td>
                                                                    <td><?php echo explode(" ",$row["reg_date"])[1]; ?></td>
                                                                    <td><button class="btn btn-dark"><i class="fas fa-search-plus"></i> ดู</button></td>
                                                                </tr>
                                            <?php   }
                                        
                                            } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
		<br>
		</div>
		<style>
			td{
				border-right : 0.1px solid #A4A4A4;
				border-left : 0.1px solid #A4A4A4;
			}
		</style>
		<script src='../../resource/script.js'></script>
        <script>
            window.onload = ()=>{
                loadDatableSales();
            }
        </script>
	</body>
	</html>