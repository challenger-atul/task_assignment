<?php 
	include_once 'dbconfig.php';
	if(!$user->is_loggedin())
	{
	 	$user->redirect('../index.php');
	}
	$user_id = $_SESSION['user_session'];
	if(isset($_POST['complete']))
	{
		$taskid = $_POST['taskid'];
		$task -> completeTask($taskid);
	}
?>
