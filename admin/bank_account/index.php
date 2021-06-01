<?php 
include(__DIR__."/../../resource/controller/bank_account_controller.php");
include(__DIR__.'/../../resource/include/script.html');
$data = GetData::bank_account_list();
$bank_list = GetData::all_bank();
$bank_list_edit = GetData::all_bank();
?>
<!DOCTYPE html>
<html>
<head>
    <?php 
    include(__DIR__."/../include_admin/menu.php");	
    ?>
    <title>admin</title>
    <style>
    .scrollmenu {

        background-color: white;
        overflow: auto;
        white-space: nowrap;
    }

</style>
</head>
<body class="bg-dark">
	<br><br><br>
	<div class="container" style="text-align:center;">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                     <i class="fas fa-cogs"></i> จัดการเลขบัญชีของฉัน
                 </div>
                 <div class="card-body" id="sales_all">
                    <button class="btn btn-success"  data-toggle="modal" data-target=".bd-bank_acct-modal-sm"><i class="fas fa-plus-circle"></i> เพิ่มหมายเลขบัญชี</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body" >
                    <div class="scrollmenu">
                        <table class="table" style="width:100%;">
                            <thead class="bg-info text-white" style="text-align:center">
                                <tr>
                                    <th>ธนาคาร</th>
                                    <th>ประเภทบัญชี</th>
                                    <th>เลขบัญชี</th>
                                    <th>ชื่อบัญชี</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody style="font-size:16px;text-align: center;">
                              <tr>
                                <?php  
                                if($data == null){ ?>

                                <?php } else{
                                 while(($row=$data->fetch_array())!=Null){ ?>
                                    <input type="hidden" name="" id="bank_account_id" value="<?php echo $row["id"]; ?>">
                                    <td><img  class="responsive_img" src="/images/bank_ico/<?php echo $row['img']?>" style="width:30px;height: 30px;text-align: center;"></td>                                
                                    <td><?php echo $row["bank_type"]; ?></td>
                                    <td><?php echo $row["bank_account_id"]; ?></td>
                                    <td><?php echo $row["bank_account_name"]; ?></td>
                                    <?php if($row['status'] == '0'){?>
                                        <td><p class="badge badge-pill badge-danger text-light" >ปิดใช้งาน</p></td>
                                    <?php }else{ ?>
                                        <td><p class="badge badge-pill badge-success text-light" >เปิดใช้งานอยู่</p></td>
                                    <?php } ?>
                                    <td><button data-toggle="modal" 
                                        data-account_myid="<?php echo $row["id"]; ?>"
                                        data-account_id="<?php echo $row["bank_account_id"]; ?>"
                                        data-account_name="<?php echo $row["bank_account_name"]; ?>" 
                                        data-account_type="<?php echo $row["bank_type"]; ?>"  
                                        data-account_bank="<?php echo $row["bank_id"]; ?>" 
                                        data-account_status="<?php echo $row["status"]; ?>" 
                                        class="open-edit_account btn btn-warning text-dark" 
                                        href="#DetailModal"
                                        >
                                        แก้ไข
                                    </button></td>
                                    <td><a  class="btn btn-danger text-white" onclick="del_bank_account(<?php echo $row["id"]; ?>)"  style="color:black;">ลบ</a></td>
                                    <tr>
                                    <?php }} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade bd-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="DetailModal">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">แก้ไขบัญชี</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 10%;">
                   <div class="form-group">
                    <label>หมายเลขบัญชีหรือพร้อมเพย์</label>
                    <input type="hidden" id="account_myid" class="form-control" >
                    <input type="number" id="account_id" class="form-control">
                    <label>ประเภทบัญชี</label>
                    <select class="form-control" id="account_type">
                      <option >PromtPay</option>
                      <option >บัญชีธนาคาร</option>
                  </select>
              </div>
              <label>เลือกธนาคาร</label>
              <select  class="form-control" id="account_bank">
                <?php  while(($bank=$bank_list->fetch_array())!=Null){ ?>
                    <option value="<?php echo $bank['id'];?>"><?php echo $bank['name'];?></option>
                <?php } ?>
            </select><br>
            <label>ชื่อบัญชี</label>
            <input type="text" id="account_name" class="form-control"><br>
            <select class="form-control" id="account_status">
              <option value="0">ปิดใช้งาน</option>
              <option value="1">เปิดใช้งาน</option>
          </select>
      </div>
      <div class="modal-footer">
         <a class="btn btn-outline-warning" id="btn_add_bank_account" onclick="edit_bank_account();" style="width:100%">แก้ไข</a>
     </div>
 </div>
</div>
</div>
<!-- modal add bank_acct -->
<div class="modal fade bd-bank_acct-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus-circle"></i> เพิ่มบัญชี</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 10%;">
               <div class="form-group">
                <label>หมายเลขบัญชีหรือPromtPay</label>
                <input type="number" id="bank_id" class="form-control">
                <label>ประเภทบัญชี</label>
                <select class="form-control" id="bank_type_add">
                  <option>PromtPay</option>
                  <option>บัญชีธนาคาร</option>
              </select>
          </div>
          <label>เลือกธนาคาร</label>
          <select  class="form-control" id="bank_name">
           <?php  while(($banks=$bank_list_edit->fetch_array())!=Null){ ?>
            <option value="<?php echo $banks['id'];?>"><?php echo $banks['name'];?></option>
        <?php } ?>
    </select><br>
    <label>ชื่อบัญชี</label>
    <input type="text" id="bank_user_name" class="form-control">
</div>
<div class="modal-footer">
    <a class="btn btn-outline-success" id="btn_add_bank_account" onclick="add_bank_account();" style="width:100%">บันทึก</a>
</div>
</div>
</div>
</div>


<script src='../../resource/include/bank_account_script.js'></script>

</body>
</html>