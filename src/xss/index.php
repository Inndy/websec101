<?php
	header('X-XSS-Protection: 0');
	require('../menu.php');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Text Search</title>
	<link rel="stylesheet" href="/bootstrap.min.css" media="all">
	<style>pre > code { background-color: #ff8; color: red; }</style>
</head>
<body>
	<div class="jumbotron">
		<div class="container">
			<h1>Reflection XSS</h1>
		</div>
	</div>

<?php menu(); ?>

	<div class="container">
		<form action=".">
			<div class="input-group">
				<input type="text" name="keyword" class="form-control" value="<?=$_GET['keyword']?>">
				<div class="input-group-btn">
					<input type="submit" value="Search" class="btn btn-primary">
				</div>
			</div>
		</form>

		<p></p>

		<pre><?php
			if(strlen($_GET['keyword']) > 0) {
				$k = escapeshellarg($_GET['keyword']);
				echo preg_replace_callback("/{$_GET['keyword']}/", function ($m) { return "<code>{$m[0]}</code>"; }, `grep '$k' the-hunger-games-short.txt`);
			}
		?></pre>
	</div>
</body>
</html>
