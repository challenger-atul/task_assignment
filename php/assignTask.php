<html>
	<head>
		<style>
			tr,td	
				{
					text-align: center;
					padding:10px;
					width:150px;

				}

			.description_container
				{
					float: right;
				}	


		</style>
	</head>
	<body>
		<button id="my_task" onclick="myTask()">MY TASKS</button>

		<button id="all_task" onclick="">ALL TASKS</button>

		<button id="assign_task" onclick="redirect()">ASSIGN TASKS</button>

		<div id="data"></div>

		<script src="../js/jquery-3.2.1.min.js"></script>

		<hr/>

		<div class="description_container">
		<textarea id="taskDescription" maxlength="500" rows="10" cols="50"></textarea>
		<br/>
		<button type="button" id="assign" onclick="">ASSIGN TASK</button>
		</div>
	</body>	
	<script>
		
		function redirect(){
			window.location = "assignTask.php";
		}

		function myTask(){
			window.location = "professor_dashboard.php";
		}
	</script>
</html>		


<?php
	require "dbconfig.php";

	$query = $DB_con->prepare('SELECT * FROM users WHERE status=0 && type="student" ORDER BY user_fname ASC');
	$query->execute();
	$task = $query->fetchAll();	
	$row = $query->rowCount();

	foreach($task as $available){
		echo "<input type='radio' class='' name='' value='--' />".$available['user_fname']."<br />";
	}
?>