<?php
require('../menu.php');

setcookie('inndy', 'guest');

setcookie('cookie1', 'v1');
setcookie('cookie2', 'v2!@#$%^', time() + 60*60*24);
setcookie('cookie3', 'v3456-=+', time() + 60*60*24, '/cookie');
setcookie('cookie4', 'v4jwegis', time() + 60*60*24, '/cookie', 'vul.security.ntu.st');
setcookie('cookie5', 'v5zZZzzZ', time() + 60*60*24, '/cookie', 'vul.security.ntu.st', true);
setcookie('cookie6', 'v6_AARRR', time() + 60*60*24, '/cookie', 'vul.security.ntu.st', true, true);
setcookie('cookie7', 'v7_QAQAQ', time() + 60*60*24, '/cookie', 'vul.security.ntu.st', false, true);
setcookie('cookie8', 'v8_OwOwO', time() + 60*60*24, '/', 'vul.security.ntu.st');
setcookie('cookie9', "\x00\x01\x02\x03\xfe\xfd\xfc", time() + 60*60*24, '/cookie', 'vul.security.ntu.st', true, false);

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
