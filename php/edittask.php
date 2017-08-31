<?php
	include_once "dbconfig.php";

		if(($_POST['groupid'] == NULL) && isset($_POST['taskid']) && isset($_POST['newTask'])){

		$id = $_POST['taskid'];
		$newTask = $_POST['newTask'];
		
		$update = "UPDATE tasks SET task_desc = :newTask WHERE taskid = :taskid" ;
		$stmt = $DB_con->prepare($update);
		$stmt->execute(['taskid'=>$id , 'newTask'=>$newTask]); 

	}

	if(($_POST['groupid'] != NULL) && isset($_POST['taskid']) && isset($_POST['newTask'])){

		$groupid = $_POST['groupid'];
		$newTask = $_POST['newTask'];
		
		$update = "UPDATE tasks SET task_desc = :newTask WHERE groupid = :groupid" ;
		$stmt = $DB_con->prepare($update);
		$stmt->execute(['groupid'=>$groupid , 'newTask'=>$newTask]); 

	}
	
?>