<?php include __DIR__.'/../package/content/include/include.php';?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>การบ้าน</title>
  </head>
  <body>
    <div class="container" style='align:center'>
      <br>
        <div class="row">
          <div class="col-md-4 mx-auto">
                <div class="alert alert-secondary text-dark">
                                <div class="alert-body" style="text-align:center;">
                                    <h5 style="font-size:20px">เข้าสู่ระบบ</h5>
                                    <p class="badge badge-primary text-white">โปรดสมัครสมาชิก</p>
                                </div>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4 mx-auto">
            <div class="card">
              <div class='card-body' style="text-align:center;">
              <label for="user_name" class='float-left'>ชื่อผู้ใช้</label>
                <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                      </div>
                      <input type="text" class="form-control" id="user_name" placeholder="ชื่อผู้ใช้">
                  </div>
                <label for="user_password" class='float-left'>รหัสผ่าน</label>
                  <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text"><i class="fa fa-key"></i></div>
                        </div>
                        <input type="password" class="form-control" id="user_password" placeholder="รหัสผ่าน">
                  </div>
                  <br>
                  <button type="button" id="login_buuton" style="width:100%;" class="btn btn-dark">เข้าสู่ระบบ</button>
                  <br><br>
                  <button type="button" id="inSystemCheck" class="btn btn-sm btn-outline-info">
                      <i class="far fa-check-circle" id="checkIcon" ></i><span> อยู่ในระบบ</span>
                  </button>
                  <br>
                  <br><br>
                 <a href="/regis">สมัครสมาชิก</a>
          </div>
      </div>
    </div>
  </div>
</div>
<footer style="background-color:#232324;width:100%;text-align:center;bottom:0;position:absolute;height:35px;color:white;font-size:8px">
    <div style="height:10px"></div>
<div class='text-muted'><i class="fa fa-cogs"></i> Made by<strong> Thewin</strong>, thank you.</div>
</footer>
 <script src="/../package/content/js/script.js"></script> 
 <script>
    let i = false;
    $('#login_buuton').click(()=>{
              const user_name = String($('#user_name').val());
              const user_password = String($('#user_password').val());
              if(user_name===''||user_password===''){
                  callWarningAlertBox({'message':'ข้อมูลว่าง!','desc':'โปรดกรอกข้อมูลให้ครบ'});
              }else{
                  callLoading('กำลังตรวจสอบ!');
                  $.ajax({
                    type:'POST',
                    contentType:'application/x-www-form-urlencoded;charset=utf-8',
                    url:pathController,
                    data: {'username':user_name,'password':user_password,'inSystem':(i)?1:0,'func':'authen'}
                  }).done((rs)=>{
                     switch(rs){
                       case '0':
                          callWarningAlertBox({'message':'ไม่พบผู้ใข้นี้!','desc':'โปรดตรวจสอบข้อมูล'});
                          break;
                        case'1':
                          callWarningAlertBox({'message':'รหัสผ่านไม่ถูกต้อง!','desc':'โปรดตรวจสอบข้อมูล'});
                          break;
                        case'2':
                          location.href = projectPath+'/home';
                          break;
                     }
                  });
              }
          });
         $('#inSystemCheck').click(()=>{
                new Promise((resolve,reject)=>{
                    i = (i)?false:true;
                    resolve(i);
                }).then((thisI)=>{
                    if(thisI){
                        $('#checkIcon').attr('class','fas fa-check-circle');
                        $('#inSystemCheck').attr('class','btn btn-sm btn-success');
                    }else{
                      $('#checkIcon').attr('class','far fa-check-circle');
                      $('#inSystemCheck').attr('class','btn btn-sm btn-outline-secondary');
                    }
                });
          });
 </script>
</body>
</html>
