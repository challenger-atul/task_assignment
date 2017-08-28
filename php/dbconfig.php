<?php
	
	session_start();

	$DB_host = "localhost";
	$DB_user = "akash";
	$DB_pass = "akash@CM16";
	$DB_name = "pdo";

	try
	{
		$DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
		$DB_con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
		echo $e -> getMessage();
	}

	include_once 'class.user.php';
	$user = new USER($DB_con);
	include_once 'class.task.php';
	$task = new Task($DB_con);
?>