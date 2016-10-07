<?php

require('../menu.php');
$page = $_GET['page'];

if(empty($page)) {
	header("Location: {$_SERVER['PHP_SELF']}?page=pages/data.html");
	exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>LFI</title>
	<link rel="stylesheet" href="/bootstrap.min.css" media="all">
</head>
<body>
	<div class="jumbotron">
		<div class="container">
			<h1>LFI</h1>
		</div>
	</div>
<?php menu(); ?>

	<div class="container">
		<ul>
<?php foreach(scandir('pages') as $f) { if($f[0] != '.') { ?>
			<li><a href="?page=pages/<?=$f?>"><?=$f?></a></li>
<?php }} ?>
		</ul>
	</div>

	<div class="container">
		<?php require($page); ?>
	</div>
</body>
</html>
