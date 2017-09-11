<?php

$string = 'To set "Network" please go to [Start -> Control panel -> Network and sharing center], also if we need to "Remove applications" Use [Start -> Control panel -> Uninstall a program].';


$taskMatch_status = preg_match_all('/"([^"]+)"/', $string, $task_matches);
$stepMatch_status = preg_match_all("/\[([^\]]*)\]/", $string, $step_matches);

if($taskMatch_status && $stepMatch_status){
	$task_matches = end($task_matches);
	$step_matches = end($step_matches);

	$task_matches_count = count($task_matches);
	$step_matches_count = count($step_matches);

	if($task_matches_count && $step_matches_count){
		$output = "<table class='table table-bordered table-striped'>
					<tr>
						<th>Task</th>
						<th>Steps</th>
					</tr>";

		foreach ($task_matches as $task_key => $task){
			$step = $step_matches[$task_key];
			$steps_html = "";
			$steps_array = explode("->", $step);
			
			foreach ($steps_array as $step_key => $step){
				if($step_key == 0){
					$output .= "<tr>
									<td rowspan='".count($steps_array)."' class='task' data-taskkey='".$task_key."'>".$task."</td>
									<td>".($step_key+1)."- <span class='step' data-taskkey='".$task_key."'>".trim($step)."</span></td>
								</tr>";
				}else{
					$output .= "<tr><td>".($step_key+1)."- <span class='step' data-taskkey='".$task_key."'>".trim($step)."</span></td></tr>";
				}
				
			}
			
		}

		$output .= "</table>";
	}
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GitSircles Technical Task</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1>GitSircles Technical Task</h1>
		<hr>
		<div id="string"><?php echo $string; ?></div>
		<hr>
	    <?php echo $output; ?>
    </div>
    
    <script src="js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/libs/knockout.js"></script>
    <script src="js/script.js"></script>
</body>
</html>