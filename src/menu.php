<?php
function menu($with_bs = true) {
	$dirs = array_filter(scandir(dirname(__FILE__)), function($s) {
		return basename($s)[0] != '.' && is_dir(dirname(__FILE__) . "/$s");
	});
	if($with_bs) {
		echo '
<div class="container">
  <div class="navbar">
	<div class="container-fluid">
	  <ul class="nav navbar-nav">
';
	}
	echo "<li><a href=\"/\">Home</a></li>\n";
	foreach($dirs as $dir) {
		printf("<li><a href=\"/%s/\">%1\$s</a></li>\n", $dir);
	}
	if($with_bs) {
		echo '
	  </ul>
	</div>
  </div>
</div>
';
	}
}
?>
