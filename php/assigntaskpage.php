<?php	
	include "dbconfig.php";
	if(!$user->is_loggedin())
	{
	 	$user->redirect('../index.php');
	}
	$user_id = $_SESSION['user_session'];
	$profRow = $user -> getUserInfo($user_id);
	$userlist = json_encode($user -> getStudentList());
	$incompleteid = json_encode($task -> getIncompleteIds());
?>	
<html>
	<head>
		<meta charset="UTF-8">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
	    <link rel="stylesheet" href="../css/professor.css">	    
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Welcome - <?=$profRow['user_fname']?></title>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	    <script type="text/javascript" src="../js/materialize.min.js"></script>
	    <script>
			$(document).ready(function() {	
				
				var usertable = JSON.parse('<?=$userlist?>');
				var incompleteid = JSON.parse('<?=$incompleteid?>');
				var userlist = [];
				for(var i = 0; i < usertable.length; i++) {
					userlist[usertable[i]['user_id']] = usertable[i]['user_fname'] + " " + usertable[i]['user_lname'];
				}
				console.log(userlist);
				for(var i = 0; i < incompleteid.length; i++){
					userlist[incompleteid[i]['stud_id']] = null;
				}
				for(key in userlist)
				{
					if(userlist[key] != null){
						var str = "<p><input type='checkbox' id='" + key + "'/><label for='" + key + "'>" + userlist[key] + "</label></p>";
						console.log(str);
						$("#taskform .student-list").append(str);
					}
				}

				function assignTaskAjax (desc, id) {
					console.log(desc, id)
					$.ajax({
						url: './assigntask.php',
						type: 'POST',
						dataType: 'json',
						data: {id: id, desc: desc},
					})
					.done(function() {
						console.log("success");
					})
				}

				$("#submit").click(function() {
					var task_desc = $("#taskform textarea").val();
					var id = [];
					$("#taskform textarea").val('');
					$("#taskform textarea").trigger('resize');
					$("#taskform .student-list input").each(function() {
						if($(this).is(':checked')){
							id.push($(this).attr('id'));
							$(this).parent('p').remove();
						}
					});
					assignTaskAjax(task_desc, id);
				});
			});
	</script>
	</head>
	<body>
		<div class="container">
			<h2>Assign Task</h2>
			<div class="row assign-container card-panel">
				<h3 class="center-align">New Task</h3>
				<form id="taskform">
					<div class="input-field col s12">
						<textarea id="task_desc" class="materialize-textarea"></textarea>
						<label for="task_desc">Task description</label>
		       		</div>
		       		<div class="section student-list">
					</div>
					<div id="submit" class="waves-effect waves-light btn col s12 indigo darken-4"><i class="large material-icons">add</i></div>
				</form>
			</div>
			<a class="section waves-effect waves-light btn indigo darken-4" href="professor_dashboard.php">My Tasks</a>
			<a class="section waves-effect waves-light btn indigo darken-4" href="alltasks.php">All Tasks</a>
		</div>
	</body>		
</html>	