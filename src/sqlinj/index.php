<?php
require('../menu.php');
require('config.inc');

$connection_string = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
$db = new PDO($connection_string, DB_USER, DB_PASS);

// user -> id, name, password
// msg -> id, title, msg

if($_GET['logout'] == '1') {
	setcookie('user', '', 0);
	header('Location: ./');
}

$id = $_GET['id'] ?: null;

if($id) {
	$act = 'show';
}

if(isset($_POST['title']) && isset($_POST['msg'])) {
	$db->query(sprintf(
		"INSERT INTO msg VALUES(NULL, '%s', '%s')",
		$_POST['title'], $_POST['msg']
	));
	$act = 'new';
}

if(isset($_POST['truncate'])) {
	$act = 'truncate';
}

if(isset($_POST['truncate_confirm']) && $_POST['truncate_confirm'] == '1') {
	$act = 'truncate_confirm';
	$db->query('TRUNCATE TABLE msg');
}

if(isset($_POST['del_id'])) {
	$act = 'delete_post';
	$db->query(sprintf("DELETE FROM msg WHERE id = '%s'", $_POST['del_id']));
}

$username = $_COOKIE['user'] ?: null;
if(isset($_POST['username']) && isset($_POST['password'])) {
	$act = 'login';
	$user = $db->query(sprintf(
		"SELECT * FROM user WHERE name = '%s' AND password = '%s'",
		$_POST['username'], $_POST['password']
	), PDO::FETCH_CLASS, 'stdClass')->fetchObject();

	if($user) {
		setcookie('user', $user->name);
		$username = $user->name;
	}
}

if($_GET['show_src'] == '1') {
	$act = 'show_src';
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Guestbook</title>
	<link rel="stylesheet" href="/bootstrap.min.css" media="all">
</head>
<body>
<div class="jumbotron">
	<div class="container">
		<h1>SQL Injection &amp; Stored XSS</h1>
	</div>
</div>

<?php menu(); ?>

<div class="container">
<?php
if($username) {
	printf('<p>Hello, %s (<a href="?logout=1">Logout</a>)</p>', $username);
}
?>
</div>

<?php
if($act == 'show_src') {
	echo '<div class="container">';
	echo '<p><a href="." class="btn btn-info">Back</a></p>';
	echo '<pre>';
	highlight_file(__FILE__);
	echo '</pre></div>';
} elseif($act == 'show' && $id != null) { // show single message
	$post = $db->query(sprintf(
		'SELECT * FROM msg WHERE id = %s', $id
	), PDO::FETCH_CLASS, 'stdClass')->fetchObject();
?>
	<div class="container">
		<div class="col-xs-12">
			<a href="." class="btn btn-info">Back</a>
			<div class="post">
				<h2 class="title"><?=$post->title?></h2>
				<p><?=$post->msg?></p>
			</div>
		</div>
	</div>
<?php
} elseif ($act == 'truncate') { // confirm to truncate table
?>
	<div class="container">
		<div class="col-sm-12">
			<h2>Do you really want to clear all data?</h2>
			<form action="." method="POST">
				<legend>Clear Data</legend>
				<div class="form-group">
					<label for="truncate_confirm">
						<input type="checkbox" id="truncate_confirm" name="truncate_confirm" value="1">
						Yes, I really want to do this
					</label>
				</div>
				<input type="submit" value="Confirm" class="btn btn-danger">
			</form>
		</div>
	</div>
<?php
} else { // last act: list message
?>
	<div class="container">
		<div class="col-sm-8 col-md-6">
			<form action="." method="POST">
				<legend>New Post</legend>
				<div class="form-group">
					<label for="title">Title: </label>
					<input id="title" type="text" name="title" class="form-control">
				</div>
				<div class="form-group">
					<label for="msg">Message:</label>
					<textarea id="msg" name="msg" class="form-control" rows="10"></textarea>
				</div>
				<input type="submit" value="Post" class="btn btn-primary">
			</form>
		</div>

		<div class="col-sm-4 col-md-6">

<?php if($username == 'admin') { ?>
			<form action="." method="POST">
				<legend>Clear Data</legend>
				<input type="hidden" name="truncate" value="1">
				<input type="submit" value="Clear All" class="btn btn-danger">
			</form>

			<p></p>

			<legend>Show Source Code</legend>
			<a href="?show_src=1" class="btn btn-info">Show me the source code!</a>

			<p></p>
<?php } ?>

			<form action="." method="POST">
				<legend>User Login</legend>
				<div class="form-group">
					<label for="username">Username: </label>
					<input id="username" type="text" name="username" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Password: </label>
					<input id="password" type="password" name="password" class="form-control">
				</div>
				<input type="submit" value="Login" class="btn btn-primary">
			</form>
		</div>
	</div>

	<div class="container">
		<div class="col-xs-12">
			<h2>Posts</h2>

			<ul>
<?php
	foreach($db->query('SELECT * FROM msg', PDO::FETCH_CLASS, 'stdClass') as $msg) {
		printf('<li>%-3d. <a href="?id=%1$d">%s</a></li>', $msg->id, htmlentities($msg->title));
	}
} // end of if
?>
			</ul>
		</div>
	</div>

	<footer class="ending">
		<div class="container">
			<small>Copyright &copy; 2016 Inndy</small>
		</div>
	</footer>
</body>
</html>
