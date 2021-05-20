<?php include(__DIR__."/../resource/controller/profile_controller.php"); ?>
<?php $profile = GetData::profile(); ?>
<!DOCTYPE html>
<html>
<head>
<?php 
	include(__DIR__.'/../resource/include/script.html');
	include(__DIR__.'/../resource/include/menu.php');
?>
<title>หวย</title>
</head>
<body>
	<br><br><br>
	<div class="container" style="text-align:center;">
	
		<div class="alert alert-info text-dark" style="width:100%">
			<div class="alert-body">
				<h2>โปรไฟล์</h2>
				<br>
                <table class="table" style="width:50%;margin:auto;">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="bg-secondary text-white">ชื่อ</th>
                            <td class="bg-white"> <?php echo $profile["user_username"]; ?></td>
                        </tr>
                    </tbody>
                </table>
			</div>
		</div>
	   	  
		<br>
		<center>
		<div id="lotery_all">
			<div class="row" id='lotery_rows'>
					
			</div>
	</div>
	</div>
<script src='../resource/script.js'></script>
</body>
</html>