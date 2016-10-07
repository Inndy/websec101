<?php
	set_time_limit(3);
	require('../menu.php');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Command Injection</title>
	<link rel="stylesheet" href="/bootstrap.min.css" media="all">
</head>
<body onload="ip.focus(); ip.selectionStart = ip.selectionEnd = ip.value.length">
	<div class="jumbotron">
		<div class="container">
			<h1>Command Injection</h1>
		</div>
	</div>
<?php menu(); ?>
	<div class="container">
		<form action="." method="POST">
			<div class="input-group">
				<input type="text" id="ip" name="IP" class="form-control" value="<?=htmlentities($_POST['IP'] ?: '127.0.0.1')?>">
				<div class="input-group-btn">
					<input type="submit" value="Ping" class="btn btn-primary">
				</div>
			</div>
		</form>
		<p></p>
		<pre><?php
			$black_list = [
				';', // '&&', '||', '$', '`', "\n"
			];

			foreach($black_list as $s) {
				if(strstr($_POST['IP'], $s)) {
					printf("'%s' not allowed!\n\n", htmlentities($s));
					$_POST['IP'] = '127.0.0.1';
				}
			}

			if(isset($_POST['IP'])) {
				echo htmlentities(`ping -c1 {$_POST['IP']}`);
			}
		?></pre>
	</div>
</body>
</html>
