<?php
	include_once 'dbconfig.php';
	if(!$user->is_loggedin())
	{
	 	$user->redirect('../index.php');
	}
	$user_id = $_SESSION['user_session'];
	$studRow = $user -> getUserInfo($user_id);
	$currTask = $task -> getCurrentTask($user_id);
	if($currTask)
		$profRow = $user -> getUserInfo($currTask['prof_id']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" href="../css/student.css">
    
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome - <?=$studRow['user_fname']?></title>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/materialize.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var currTask;
			function completeAjax()
			{
				$.ajax({
					url: './completetask.php',
					type: 'POST',
					dataType: 'json',
					data: {complete: 'true', taskid: currTask['taskid']},
				})
				.done(function() {
					currentTaskAjax();
				})
			}
			function currentTaskAjax()
			{
				$.ajax({
					url: './currenttask.php',
					type: 'POST',
				})
				.done(function(data) {
					data = JSON.parse(data);
					handleCurrentTask(data);
				})
			}
			currentTaskAjax();
			setInterval(currentTaskAjax, 2000);
			function handleCurrentTask (data) {
				console.log(data);
				currTask = data['task'];
				if(data['isnew'] == 'true')
				{
					$(".task-content").slideDown();
					$(".completed").slideUp();
					if(data['task']['taskid'] != $(".task-content").data('taskid')){
						$(".task-content").data('taskid',data['task']['taskid']);
						$("#task-description").text(data['task']['task_desc']);
						var profname = data['prof']['user_fname'] + " " + data['prof']['user_lname'];
						$("#prof-cont").text(profname);
						$("#date-time").text(data['task']['time']);
						$(".task-content").css('visibility','visible');
					}
				}
				else
				{
					$(".task-content").slideUp();
					$(".completed").slideDown();
				}

			}
			$("#complete-cont div").on('click', function() {
				completeAjax();
			});
		});
	</script>
</head>
<body>
	<div class="container">
		<h1>Dashboard</h1>
		
		<div id="task-container" class="card-panel">
			<div class="white-text indigo darken-4 center-align card-heading">
				My task
			</div>
			<div class="completed section center-align" style="display:none">
					You have no incomplete task.
			</div>
			<div class="task-content row gray-text" style="display:none">
				<div id="desc-container" class="col s6 ">
					<div id="task-description" class="section">
					</div>
				</div>
				<div id="prof--cont" class="col s6 center-align">
				<div id="prof-cont" class="section valign-wrapper">
						Assigned by - Prof. 
					</div><hr>
					<div id="date-time" class="section valign-wrapper">
					</div><hr>
					<div id="complete-cont" class="section valign-wrapper">
						<div class="waves-effect waves-light btn indigo darken-4">
						Completed
						</div>
					</div>
				</div>	
			</div>
		</div>
		<a href="logout.php?logout=true">logout</a>
		<div class="row">
			<div class="col-6 center-align">
				<a class="waves-effect waves-light btn indigo darken-4" href="alltasks.php">All Tasks</a>
			</div>
		</div>
	</div>
</body>
</html>
<label>