		
<html>
	<head>
		<style>
			tr,td	
				{
					text-align: center;
					padding:10px;
					width:150px;

				}


		</style>
	</head>
	<body>
		<button id="my_task" onclick="myTask()">MY TASKS</button>

		<button id="all_task" >ALL TASKS</button>

		<button id="assign_task" onclick="redirect()">ASSIGN TASKS</button>

		<div id="data"></div>

		<script src="../js/jquery-3.2.1.min.js"></script>

		<hr/>

	</body>	
	<script>
		
		function redirect(){
			window.location = "assignTask.php";
		}

		function myTask(){
			window.location = "professor_dashboard.php";
		}

		$(document).on('click','.delete',function(){
			var del = $(this).attr('id');
			console.log(del);
			


			
		})

		$(document).on('click','.completed',function(){
			console.log($(this).attr('id'));
		})

		$(document).on('click','.edit',function(){
			console.log($(this).attr('id'));
		})
	</script>
</html>		


<?php
	
	include "dbconfig.php";
	
	$query = $DB_con->prepare('SELECT * FROM tasks WHERE prof_id=:id  ORDER BY taskid ASC');
	$query->execute(['id'=> $_SESSION['user_session']]);
	$task = $query->fetchAll();	
	$row = $query->rowCount();

	echo "<table><th>STUDENT</th><th>TASK</th>";

	foreach ($task as $value) {
		
		echo "<tr><td>".$value['stud_name']."</td><td>".$value['task_desc']."</td>";
		echo "<td><form action='delete_task.php' method='POST'><button type='submit' id='".$value['taskid']."' class='completed' name='delete'>Mark completed</button></form></td>";
		echo "<td><button id='".$value['taskid']."' class='delete'>Delete</button></td>";
		echo "<td><button id='".$value['taskid']."' class='edit'>Edit task</button></td></tr>";
	
	}
		
	echo '</table>';


?>


