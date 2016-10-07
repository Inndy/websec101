<?php
require('../menu.php');

setcookie('single_cookie', 'data of single cookie');
setcookie('single_cookie_limited', 'data of single cookie with limited time', time() + 3600);

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Cookie</title>
    <link rel="stylesheet" href="/bootstrap.min.css" media="all">
  </head>
  <body>
    <div class="jumbotron">
      <div class="container">
        <h1>Cookie</h1>
      </div>
    </div>

<?php menu(); ?>

	<div class="container">
		<h2>Cookie Dump from Server</h2>
		<pre>$_COOKIE = <?=json_encode($_COOKIE, JSON_PRETTY_PRINT | JSON_PARTIAL_OUTPUT_ON_ERROR);?></pre>
		<pre>$_COOKIE = <?php print_r($_COOKIE); ?></pre>
		<h2>Cookie Dump from JavaScript</h2>
		<pre><script>document.write(document.cookie.replace(/; /g, '\n'));</script></pre>
	</div>

	<div class="container">
		<pre><?php highlight_file(__FILE__); ?></pre>
	</div>
</body>
</html>
