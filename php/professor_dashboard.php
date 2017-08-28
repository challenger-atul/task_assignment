<?php	
	include "dbconfig.php";
	if(!$user->is_loggedin())
	{
	 	$user->redirect('../index.php');
	}
	$user_id = $_SESSION['user_session'];
	$profRow = $user -> getUserInfo($user_id);
	$taskRow = json_encode($task -> getMyTasks($user_id));
	$userlist = json_encode($task -> getUserList());
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
				var tasklist = JSON.parse('<?=$taskRow?>');
				var userlist = [];
				for(i = 0; i < usertable.length; i++) {
					userlist[usertable[i]['user_id']] = usertable[i]['user_fname'] + " " + usertable[i]['user_lname'];
				}
				function makeTable() {
					var table = "<table class='section bordered'><thead><tr><th>Sl. No.</th><th>Task</th><th>Student</th><th>Time</th><th>Status</th><th>Action</th><tr></thead></table>";
					$(".table-container").html(table);
					for(var i = 0; i < tasklist.length; i++) {
						var row = tasklist[i];
						var complete = '';
						var rowstr = "<tr";
						if(row['status'] == '0')
						{
							var status = 'Incomplete';
							complete += '<li><a class="complete btn-floating white actions"><i class="material-icons">done</i></a></li>';
							rowstr += ' class="red lighten-4">';
						}
						else
						{
							var status = 'Complete';
							rowstr += '>';
						} 
						rowstr += "<td>" + (i+1) + "</td><td>" + row['task_desc'] + "</td><td>" + userlist[row['stud_id']] + "</td><td>" + row['time'] + "</td><td class='status'>" + status + "</td><td>";
						rowstr += '<div id="' + row['taskid'] + '" class="fixed-action-btn horizontal">'+
						    '<a class="btn-floating indigo darken-4">'+
						      '<i class="material-icons">menu</i>'+
						    '</a>'+
						    '<ul>' +
						      '<li><a class="edittask btn-floating white actions"><i class="large material-icons">mode_edit</i></a></li>'+
						      '<li><a class="deletetask btn-floating white actions"><i class="material-icons">delete</i></a></li>'+
						      complete +
						    '</ul>'+
						  '</div></td></tr>';
						$(".table-container table").append(rowstr);
						$("#" + row['taskid']).data('groupid', row['groupid']);
					}					
				}
				makeTable();
				$('.deletetask').on('click', function() {
					var fab = $(this).parents('.fixed-action-btn');
					var id = fab.attr('id');
					var groupid = fab.data('groupid');
					$.ajax({
						url: 'deletetask.php',
						type: 'POST',
						dataType: 'json',
						data: {'taskid': id},
						success: function(data) {
							if(groupid != null)
								$(".fixed-action-btn").each(function() {
									if($(this).data('groupid') == groupid)
										$(this).parents('tr').fadeOut();
								});
							else
								$("#" + id).parents('tr').fadeOut();
						}
					});			
				});
				$('.complete').on('click', function() {
					var fab = $(this).parents('.fixed-action-btn');
					var id = fab.attr('id');
					var groupid = fab.data('groupid');
					$.ajax({
						url: './completetask.php',
						type: 'POST',
						dataType: 'json',
						data: {complete: 'true', taskid: id},
					})
					.done(function() {
						console.log('yeah');
							if(groupid != null)
								$(".fixed-action-btn").each(function() {
									if($(this).data('groupid') == groupid){
										$(this).parents('tr').removeClass('red lighten-4').children('.status').text('Complete');
									}
								});
							else
								$("#" + id).parents('tr').removeClass('red lighten-4').children('.status').text('Complete');
					})
				});
			});
	</script>
	</head>
	<body>
		<div class="container">
			<h1>My Tasks</h1>
			<a class="section waves-effect waves-light btn indigo darken-4" href="alltasks.php">All Tasks</a>
			<a class="section waves-effect waves-light btn indigo darken-4" href="assigntask.php">Assign Tasks</a>
			<div class="table-container">
			</div>
		</div>
	</body>	
	
</html>		





