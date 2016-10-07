<?php
require('../menu.php');
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Headers</title>
    <link rel="stylesheet" href="/bootstrap.min.css" media="all">
  </head>
  <body>
    <div class="jumbotron">
      <div class="container">
        <h1>Headers</h1>
      </div>
    </div>

<?php menu(); ?>

	<div class="container">
		<pre><?php
			unset($_SERVER['SERVER_ADDR']);
			echo htmlentities(print_r($_SERVER, true));
		?></pre>
	</div>

	<div class="container">
		<pre><?php highlight_file(__FILE__); ?></pre>
	</div>
</body>
</html>
