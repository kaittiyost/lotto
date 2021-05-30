<div class="menu">
  <div class="title" onclick="openDropDownMenu()">แสงทองขายเลข<span class="menu-span fa fa-bars"></span>
    <div class="arrow"></div>
  </div>
  <div class="dropdown">
    <a href="/home/"><p class="p-menu">ร้านค้าลอตเตอรี่ <span class="menu-span fas fa-store"></span></p></a>
    <a  href="/cart/"><p class="p-menu">ตระกร้าสินค้า <span class="menu-span fas fa-shopping-basket"></span> <span class="badge badge-pill badge-danger" id="cart_count">0</span></p></a>
    <a  href="/purchase_list/"><p class="p-menu">การสั่งซื้อ <span class="menu-span fab fa-bitcoin"></span></p></a>
    <a  href="/profile/"><p class="p-menu">โปรไฟล์ <span class="menu-span fas fa-user"></span></p></a>
    <p class="p-menu" id="logout_btn">ออกจากระบบ <span class="menu-span fa fa-sign-out"></span></p>
  </div>
</div>
<br>
<!-- MENU STYLE -->
<style>
    .menu{width:80%;cursor:pointer;z-index:3000;position:fixed;left:10%;}
    .title{width:100%;box-sizing:border-box;background:#fff;padding:14px;border-radius:4px;position:relative;box-shadow:0 0 40px -10px #000;color:#505050}
    .menu-span{float:right;font-size:18px!important}
    .dropdown{width:100%;background:#fff;border-radius:4px;box-shadow:0 0 40px -10px #000;color:#505050;margin-top:24px;max-height:0;h;overflow:hidden;transition:all .5s}
    .down{max-height:250px}
    .arrow{border-left:10px solid transparent;border-right:10px solid transparent;border-bottom:10px solid #fff;position:absolute;right:20px;bottom:-24px;display:none}
    .arrow.gone{display:block}
    .p-menu{padding:15px 14px;margin:0;transition:all .1s}
    .p-menu:hover{background:coral;-webkit-transform:scale(1.05);color:rgba(255,255,255,0.8);box-shadow:0 0 30px -10px #000}
    a{color:#505050}
</style>
<script>
  function openDropDownMenu() {
  document.getElementsByClassName('dropdown')[0].classList.toggle('down');
  document.getElementsByClassName('arrow')[0].classList.toggle('gone');
  if (document.getElementsByClassName('dropdown')[0].classList.contains('down')) {
    setTimeout(function() {
      document.getElementsByClassName('dropdown')[0].style.overflow = 'visible'
    }, 500)
  } else {
    document.getElementsByClassName('dropdown')[0].style.overflow = 'hidden'
  }
}
  window.onload =()=>{

  }

  $("#logout_btn").click(()=>{
		$.ajax({
			method:"POST",
			url:projectPath+"/resource/controller/login.php",
			contentType:"application/x-www-form-urlencoded; charset=utf-8",
			data:{"func":"logout"}
		}
		).done((rs)=>{
			console.log(rs)
			if(rs==0){
				Swal.fire({
					icon: 'error',
					title: 'เกิดข้อผิดพลาด!',
					text: ''
				});
			}else if(rs==1){
				location.href = projectPath;
			}
		});
  });
  $("a").click((e)=>{
        Swal.fire({title:'โปรดรอซักครู่...',background:"#D2D2D2"});
        Swal.showLoading();
   });
</script>
