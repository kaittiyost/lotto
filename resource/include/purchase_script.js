var projectPath = location.origin;

function upload_slip() {
  var form_data = new FormData();
  form_data.append("img", $("#img_slip").prop("files")[0]);
  form_data.append("func", "add_slip");
  $.ajax({
    method: "POST",
    url: projectPath + "/resource/controller/purchase_list_controller.php",
    contentType: false,
    processData: false,
    data: form_data,
  }).done((rs) => {
    console.log(">>" + rs);
  });
}
