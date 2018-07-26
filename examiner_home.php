<?php

session_start();
require 'include/functions.php';
require 'include/variables.php';
check_user("examiner");

?> 


<html>
	<head>
		<title>QuizSeed</title>
		<?php require 'include/head.php'; ?>

	</head>
	
	<body>
		<div class="container-fluid">
			<header class="navbar navbar-inverse navbar-fixed-top">
				<div class="container">					
					<nav class="navbar-header">
						<a class="navbar-brand logo" href="examiner_home.php">
							<i>Examiner Home</i>
						</a>

						<button class="collapsed navbar-toggle x" data-toggle="collapse" data-target="#ShowNav">
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
						</button>
					</nav>
					
					<nav class="collapse navbar-collapse" id="ShowNav">
							<ul class="nav navbar-nav navbar-right">
								<li class="active"><a href="#">Home</a></li>
								<li><a href="examiner_user.php">User</a></li>
								<li><a href="examiner_ranking.php">Ranking</a></li>
								<li class="dropdown">	
									<a href="#"  class="dropdown-toggle" data-toggle="dropdown">
											<b class="text-capitalize">Hi, <?php echo $_SESSION["uname"]; ?> </b> <i class="caret"></i>
									</a>
										<ul class="dropdown-menu" id="drop">
											<li>
												<a href="./logout.php">
													<span class="glyphicon glyphicon-log-out"></span> Logout 
												</a>
											</li>
											<li class="divider"></li>
											<li><a href="./profile.php"> Profile </a></li>
										</ul>
								</li>
							</ul>
					</nav>
				</div>
			</header>
			
			<main class="row">
	<div class="container">
      <div class="row">
		  <h2>Available Test</h2>
		  <br>

<?php
		  
$uname = $_SESSION['uname'];
		  
$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
		  
if(@$_GET['q']== 'rmquiz') 
{
	$eid=@$_GET['eid'];
	
	$result = mysqli_query($con,"SELECT * FROM questions WHERE eid='$eid' ") or die('Error');
	
	while($row = mysqli_fetch_array($result)) 
	{
		$qid = $row['qid'];
		$r1 = mysqli_query($con,"DELETE FROM options WHERE qid='$qid'") or die('Error');
		$r2 = mysqli_query($con,"DELETE FROM answer WHERE qid='$qid' ") or die('Error');
	}
		$r3 = mysqli_query($con,"DELETE FROM questions WHERE eid='$eid' ") or die('Error');
		$r4 = mysqli_query($con,"DELETE FROM quiz WHERE eid='$eid' ") or die('Error');
		$r4 = mysqli_query($con,"DELETE FROM history WHERE eid='$eid' ") or die('Error');

	header("location:examiner_home.php");
}

// $result = mysqli_query($con,"SELECT * FROM quiz WHERE examiner='$uname' ORDER BY date DESC  ") or die('Error');
		  

$result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
echo  '

<a class="btn btn-primary" href="examiner_addQuiz.php">Add Quiz</a>

<div class="panel">

<br>

<div class="table-responsive">
<table class="table table-striped title1">
<tr>
	<td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td>
	<td></td>
</tr>';
		  
$c=1;
		  
while($row = mysqli_fetch_array($result)) 
{
	$title = $row['title'];
	$total = $row['total'];
	$correct = $row['correct'];
    $time = $row['time'];
	$eid = $row['eid'];
	$examiner = $row['examiner'];
	
	if($examiner == $uname){
	echo '<tr>
			<td>'.$c++.'</td>
			<td>'.$title.'</td>
			<td>'.$total.'</td>
			<td>'.$correct*$total.'</td>
			<td>'.$time.'&nbsp;min</td>
			
			 <td>
				<b><a href="examiner_home.php?q=rmquiz&eid='.$eid.'" class="pull-right btn sub1" style="margin:0px;background:#99cc32">
				<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Delete</b></span></a></b>
			 </td>
			</tr>';
	}
	else
	{
		
			echo '<tr>
			<td>'.$c++.'</td>
			<td>'.$title.'</td>
			<td>'.$total.'</td>
			<td>'.$correct*$total.'</td>
			<td>'.$time.'&nbsp;min</td>
			
			 <td>
				<b><a href="#" class="pull-right btn sub1 disabled" style="margin:0px;background:#ccc">
				<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Delete</b></span></a></b>
			 </td>
			</tr>';

		
	}
}
		  
echo '</table></div></div>';
mysqli_close($con);		  
?>
		  
		  

      </div>
    </div>		
				<br>		
				<br>		
				<br>		
				<br>		
				<br>		
			</main>

			<footer class="navbar navbar-fixed-bottom mainFooter blackFooter">Copyright &copy; <?php echo date('Y')?> QuizSeed. All Rights Reserved.</footer>
		</div>
	</body>
</html>
