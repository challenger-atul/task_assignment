<?php
	require_once('dbconfig.php');
	$user_logout = new USER();
	
	if($user_logout->is_loggedin()!="")
	{
		$user_logout->redirect('fork.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->logout();
		$user_logout->redirect('../index.php');
	}
?>

<!--<a href="logout.php?logout=true">logout</a></label>-->
