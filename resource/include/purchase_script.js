var projectPath = location.origin;

function upload_slip(sale_id) {
  const bank = $("#bank").val();
  const date_upload = $("#date_upload").val();
  const time_upload = $("#time_upload").val();
  const time_deadline = $("#deadline").val();
  const img = $("#img_slip").val();

  var currentdate = new Date(); 
  var time =  currentdate.getHours() + ":"  
  + currentdate.getMinutes() + ":" 
  + currentdate.getSeconds();

 console.log('time =>'+time+' , time_deadline =>'+time_deadline);

 if(bank == "" || date_upload == "" || time_upload =="" || img == ""){
  Swal.fire({
    icon: 'error',
    title: 'ข้อมูลว่าง',
    text: 'โปรดกรอกข้อมูลให้ครบ!'
  });
}else{
  if(time > time_deadline){
    Swal.fire({
      icon: 'error',
      title: 'เลยกำหนดเวลา',
      text: 'ท่านอัปโหลดหลักฐานการชำระเงินไม่ทันเวลา โปรดสั่งซื้อใหม่อีกครั้ง!'
    });
    //console.log('ไม่ทันเวลา');
    $.ajax({
      method: "POST",
      url: projectPath + "/resource/controller/purchase_list_controller.php",
      contentType:"application/x-www-form-urlencoded; charset=utf-8",
      data:{"sale_id":sale_id,"func":"del_order"}
    }).done((rs) => {
      console.log(">>" + rs);
     if(rs == 1){
      setTimeout(()=>{
         location.href ="/home/";
      },1000);
     
     }else{

     }
   });
  }else{

    var form_data = new FormData();
    form_data.append("img", $("#img_slip").prop("files")[0]);
    form_data.append("sale_id", sale_id);
    form_data.append("bank",  $("#bank").val());
    form_data.append("date_upload",  $("#date_upload").val());
    form_data.append("time_upload",  $("#time_upload").val());
    form_data.append("func", "add_slip");
    $('#uploading').html('<p id="uploading" class="text-warning">กำลังอัปโหลด</p>');
    $.ajax({
      method: "POST",
      url: projectPath + "/resource/controller/purchase_list_controller.php",
      contentType: false,
      processData: false,
      data: form_data,
    }).done((rs) => {
     // console.log(">>" + rs);
     if(rs == 1){
      Swal.fire({
        icon: 'success',
        title: 'อัปโหลดหลักฐานการชำระเงินแล้ว',
        text: 'หมายเลขสั่งซื้อที่ '+sale_id+' รอตรวจสอบภายใน 24 ชั่วโมง',
        confirmButtonText: `ตกลง`
      });
      setTimeout(()=>{
        location.reload();
      },1000);

    }else{
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'โปรดอัปโหลดรูปภาพ jpg เท่านั้น!'
      })
    }
  });
  }
}}
