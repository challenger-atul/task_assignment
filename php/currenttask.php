<?php 
	include_once 'dbconfig.php';
	if(!$user->is_loggedin())
	{
	 	$user->redirect('../index.php');
	}
	$user_id = $_SESSION['user_session'];
	$currTask = $task -> getCurrentTask($user_id);
	$obj = new \stdClass();
	$obj->isnew = 'false';
	if($currTask != null)
	{
		$obj->isnew = 'true';
		$profRow = $user -> getUserInfo($currTask['prof_id']);
		$obj->prof = $profRow;
	}
	$obj->task = $currTask;
	
	$myJSON = json_encode($obj);
	echo $myJSON;
?>