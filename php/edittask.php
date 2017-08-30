<?php
	include_once "dbconfig.php";

		if(isset($_POST['taskid']) && isset($_POST['newTask'])){

		$id = $_POST['taskid'];
		$newTask = $_POST['newTask'];
		
		$update = "UPDATE tasks SET task_desc = :newTask WHERE taskid = :taskid" ;
		$stmt = $DB_con->prepare($update);
		$stmt->execute(['taskid'=>$id , 'newTask'=>$newTask]); 

	}
	
?>