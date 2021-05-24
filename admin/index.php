<?php 
	include(__DIR__."/../resource/controller/admin_controller.php");
	include(__DIR__.'/../resource/include/script.html');
    $data = new GetData();
?>
<!DOCTYPE html>
<html>
<head>
	<title>admin</title>
</head>
<body class="bg-dark">
	<br><br><br>
	<div class="container" style="text-align:center;">

		<div class="alert alert-info text-dark" style="width:100%">
			<div class="alert-body">
				<h2>รายการทั้งหมด</h2>
				<label>งวดวันที่ 32 มกราคม 2555</label>

				<div class="prompt text-secondary">ค้นหาเลขเด็ด</div>
				<form method="get" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
					<input type="number" id="digit-1" name="digit-1" data-next="digit-2" />
					<input type="number" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
					<input type="number" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
					<span class="splitter">&ndash;</span>
					<input type="number" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
					<input type="number" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
					<input type="number" id="digit-6" name="digit-6" data-previous="digit-5" />
				</form>
				<br>
				<button id="search_btn" class="btn btn-dark btn-md-width">ค้นหา</button>
			</div>
            <pre><?php print_r($_SESSION["adminData"]) ?></pre>
		</div>
		<br>
		</div>
		<script src='../resource/script.js'></script>
	</body>
	</html>