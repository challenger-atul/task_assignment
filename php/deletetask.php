<?php
	include_once "dbconfig.php";
	if(!$user->is_loggedin())
	{
	 	$user->redirect('../index.php');
	}
	if(isset($_POST['taskid']))
	{
		$taskid = $_POST['taskid'];
		$task -> deleteTask($taskid);
	}
	echo $_POST['taskid'];
?>
