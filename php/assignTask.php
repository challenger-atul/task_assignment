<?php 
	include_once 'dbconfig.php';
	if(!$user->is_loggedin())
	{
	 	$user->redirect('../index.php');
	}
	$user_id = $_SESSION['user_session'];
	$desc = $_POST['desc'];
	$id = $_POST['id'];
	if(count($id) == 1)
		$task -> addTask($id[0], $user_id, $desc);
	else
		$task -> addgroupTask($id, $user_id, $desc);
	echo $user_id;
?>