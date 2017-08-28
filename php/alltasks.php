<?php
	include_once 'dbconfig.php';
	if(!$user->is_loggedin())
	{
	 	$user->redirect('../index.php');
	}
	$user_id = $_SESSION['user_session'];
	$userRow = $user -> getUserInfo($user_id);
	$allTasks = json_encode($task -> getAllTasks());
	$userlist = json_encode($task -> getUserList());
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" href="../css/alltasks.css">
    
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>All Tasks - <?=$userRow['user_fname']?></title>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/materialize.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var allTasks = JSON.parse('<?=$allTasks?>');
			var usertable = JSON.parse('<?=$userlist?>');
			var userlist = [];
			console.log(usertable.length);
			for(i = 0; i < usertable.length; i++) {
				console.log(usertable[i]['user_id']);
				userlist[usertable[i]['user_id']] = usertable[i]['user_fname'] + " " + usertable[i]['user_lname'];
			}
			console.log(userlist);
			function makeTable() {
				var table = "<table class='section bordered'><thead><tr><th>Sl. No.</th><th>Task</th><th>Professor</th><th>Student</th><th>Time</th><th>Status</th><tr></thead>";
				for(var i = 0; i < allTasks.length; i++) {
					var row = allTasks[i];
					var rowstr = "<tr";
					if(row['status'] == '0')
					{
						var status = 'Incomplete';
						rowstr += ' class="red lighten-4">';
					}
					else
					{
						var status = 'Complete';
						rowstr += '>';
					} 
					rowstr += "<td>" + (i+1) + "</td><td>" + row['task_desc'] + "</td><td>" + userlist[row['prof_id']] + "</td><td>" + userlist[row['stud_id']] + "</td><td>" + row['time'] + "</td><td>" + status + "</td></tr>";
					table += rowstr;
				}
				table += "</table>";
				$(".table-container").html(table);
			}
			makeTable();
		});
	</script>
</head>
	<body>
		<div class="container">
			<h1>All Tasks</h1>
			<hr>
			<div class="table-container">
			</div>
		</div>

	</body>
</html>