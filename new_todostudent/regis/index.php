<?php 
include __DIR__.'/../package/content/include/include.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <meta charset="UTF-8">
      <title>การบ้าน</title>
  </head>
  <body>
    <div class="container" style='align:center'>
      <br>
      <div class="row">
        <div class="col col-md-4 mx-auto">
              <div class="alert alert-secondary text-primary">
                              <div class="alert-body text-dark" style="text-align:center;">
                                  <h5 style="font-size:20px">สมัครสมาชิก</h5>
                                  <p class="badge badge-warning text-white">โปรดสมัครสมาชิก</p>
                              </div>
            </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-4 mx-auto">
            <div class="card">
              <div class='card-body'>
              <label for="user_name" class='float-left'>ชื่อผู้ใช้</label>
                <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                      </div>
                      <input type="text" class="form-control" id="user_name" placeholder="ชื่อผู้ใช้">
                </div>
                <label  class='float-left'>ชื่อเล่น</label>
                <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-gamepad"></i></div>
                      </div>
                      <input type="text" id="user_nickname" class='form-control' placeholder="ชื่อเล่น">
                </div>
                <label  class='float-left'>รหัสผ่าน</label>
                <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-key"></i></div>
                      </div>
                      <input type="password" id="user_password" onKeyUp='checkKey()' class='form-control' placeholder="รหัสผ่าน"><br>
                </div>
                <label  class='float-left'>ยืนยันรหัสผ่าน</label>
                <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-check"></i></div>
                      </div>
                      <input type="password" id="confirm_user_password" class='form-control'  onKeyUp='checkKey()' placeholder="ยืนยันรหัสผ่าน"><br>
                      <p class="invalid-feedback">*รหัสผ่านไม่ตรงกัน!</p>
                </div>
                    <br><br>
                   <button type="button"type="button" id="check_regis" class="btn btn-dark w-100">สมัครสมาชิก</button>

              </div>
          </div>
      </div>
    </div>
  </div>
    <script>
//++++++++++++++++++++++++++++++++++++++++alertBLock++++++++++++++++++++++++++++++++++++++
        let pathController = location.origin+"/package/controller/controller.php";
        let projectPath = location.origin;

        function callSuccessAlertBox(element){
            Swal.fire(
                  element.successMessage,
                  element.successDesc,
                  'success'
            );
        }

        function callWarningAlertBox(element){
              Swal.fire({
                title: element.message,
                text: element.desc,
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ตกลง'
              });
        }
        
        function callLoading(label){
              let timerInterval
                    Swal.fire({
                      title: label,
                      timer: 10000,
                      timerProgressBar: true,
                      didOpen: () => {
                        Swal.showLoading()
                      },
                      willClose: () => {
                        clearInterval(timerInterval)
                      }
                    })
        }
        function stringToBool(str){
            return (String(str)==='true')?true:false;
        }
//++++++++++++++++++++++++++++++++++++++++alertBLock++++++++++++++++++++++++++++++++++++++
          let password_regis_status = false;
          $('#check_regis').click(()=>{
            const user_name = $('#user_name').val();
            const user_nickname = $('#user_nickname').val();
            const pass = $('#user_password').val();
            const con_pass = $('#confirm_user_password').val();
            if(user_name===''||pass===''||con_pass===''||user_nickname===''){
              callWarningAlertBox({'message':'ข้อมูลว่าง!','desc':'โปรดกรอกข้อมูลให้ครบ'});
            }else if(pass!=con_pass){
              callWarningAlertBox({'message':'รหัสผ่านไม่ตรงกัน!','desc':'โปรดกรอกข้อมูลให้ถูกต้อง'});
            }else{
              $.ajax({
                type:"POST",
                contentType:'application/x-www-form-urlencoded;charset=utf-8;',
                url:pathController,
                data:{'user_name':user_name,'user_password':pass,'user_nickname':user_nickname,'func':'regis'}
              }).done((rs)=>{
                  rs = parseInt(rs);
                  if(rs===0){
                    callWarningAlertBox({'message':'เกิดข้อผิดพลาด!','desc':'ขออภัยโปรดลองอีกครั้ง'});
                  }else if(rs===-1){
                    callWarningAlertBox({'message':'มีผู้ใช้ชื่อนี้แล้ว!','desc':'ขออภัยมีผู้ใช้ชื่อนี้แล้ว'});
                  }else if(rs===1){
                    callSuccessAlertBox({"successMessage":"สมัครสมาชิคสำเร็จ!","successDesc":""});
                    setTimeout(()=>{location.href=projectPath+'/login'},1000);
                  }
              });
            }
          });
        function checkKey(thisKey){
          const pass = $('#user_password').val();
          const con_pass = $('#confirm_user_password').val();
          if(pass!=con_pass){
            $('#confirm_user_password').attr('class','is-invalid form-control');
            $('.invalid-feedback').attr('style','display:block;');
            password_regis_status =false;
          }else{
            $('#confirm_user_password').attr('class','is-valid form-control');
            $('.invalid-feedback').attr('style','display:none;');
            password_regis_status = true;
          }
        }
    </script>
    <footer style="background-color:#232324;width:100%;text-align:center;bottom:0;position:absolute;height:35px;color:white;font-size:8px">
        <div style="height:10px"></div>
        <div class='text-muted'><i class="fa fa-cogs"></i> Made by<strong> Thewin</strong>, thank you.</div>
    </footer>
  </body>
</html>
