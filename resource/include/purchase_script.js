var projectPath = location.origin;

function upload_slip(sale_id) {
  let form_data = new FormData();
  new Promise((resolve,reject)=>{
        form_data.append("img", $("#img_slip").prop("files")[0]);
        form_data.append("sale_id", sale_id);
        form_data.append("bank",  $("#bank").val());
        form_data.append("date_upload",  $("#date_upload").val());
        form_data.append("time_upload",  $("#time_upload").val());
        form_data.append("func", "add_slip");
        resolve(form_data);
  })
  .then((form)=>{
        let nullVal;
        form.forEach((val)=>{
          if(val=="undefined"||val==""){
            nullVal = true;
          }
        });
        return(nullVal);
	})
  .then((nullVal)=>{
      if(nullVal){
            Swal.fire({
              icon: 'error',
              title: 'ข้อมูลว่าง',
              text: 'โปรดกรอกข้อมูลให้ครบ!'
            });
      }else if(!nullVal){
            $('#uploading').html('<p id="uploading" class="text-warning">กำลังอัปโหลด</p>');
            $.ajax({
              method: "POST",
              url:projectPath+"/resource/controller/purchase_list_controller.php",
              contentType: false,
              processData: false,
              data: form_data,
            }).done((rs)=>{
              if(String(rs)==="ok"){
                  Swal.fire({
                    icon: 'success',
                    title: 'อัปโหลดหลักฐานการชำระเงินแล้ว',
                    text: 'หมายเลขสั่งซื้อที่ '+sale_id+' รอตรวจสอบภายใน 24 ชั่วโมง',
                    confirmButtonText: `ตกลง`
                  });
                  setTimeout(()=>{
                    location.reload();
                  },1000);
              }else if(String(rs)==="time_out"){
                    Swal.fire({
                      icon: 'error',
                      title: 'เลยกำหนดเวลา',
                      text: 'ท่านอัปโหลดหลักฐานการชำระเงินไม่ทันเวลากำหนดระบบจะลบรายการนี้โดยอัตโนมัติ โปรดสั่งซื้อใหม่อีกครั้ง!',
                      confirmButtonText:'ตกลง'
                    });
                    setTimeout(()=>{
                      location.href=projectPath+"/purchase_list/";
                    },1000);
              }else if(String(rs)==="file_not_jpg"){
                  Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'โปรดอัปโหลดรูปภาพ jpg และ png เท่านั้น!'
                  });
                  $('#uploading').hide();
              }
            });
      }
    });
}
