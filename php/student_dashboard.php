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
	$task -> completeTask(11);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome - <?=$studRow['user_fname']?></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			function completeAjax()
			{
				$.ajax({
					url: './completetask.php',
					type: 'POST',
					dataType: 'json',
					data: {complete: 'true', taskid: <?=$currTask['taskid']?>},
				})
				.done(function() {
					taskComplete();
				})
			}
			$("#complete-cont").on('click', function() {
				completeAjax();
			});
		});
	</script>
</head>
<body>
	<div class="container">
		<h1>Dashboard</h1>
		<h2>My task</h2>
		<div id="task-container">
			<div id="desc-container">
			<div id="description">
				<?=$currTask['task_desc']?>
			</div>
			</div>
			<div id="prof-complete-cont">
				<div id="prof-cont">
					Assigned by - Prof. <?=$profRow['user_fname'].' '.$profRow['user_lname']?>
				</div>
				<div id="date-time">
					<?=$currTask['time'];?>
				</div>
				<div id="complete-cont">
					Mark As Completed
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<label>