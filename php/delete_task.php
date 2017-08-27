<?php
	require "dbconfig.php";

	$c = $_POST['delete'];
	echo $c;

	$query = $DB_con->prepare('SELECT * FROM users WHERE status=0 && type="student" ORDER BY user_fname ASC');
	$query->execute();
	$task = $query->fetchAll();
?>
