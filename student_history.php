<?php

session_start();
require 'include/functions.php';
require 'include/variables.php';
check_user("student");
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
						<a class="navbar-brand logo" href="student_home.php">
							<i>Student Home</i>
						</a>

						<button class="collapsed navbar-toggle x" data-toggle="collapse" data-target="#ShowNav">
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
						</button>
					</nav>
					
					<nav class="collapse navbar-collapse" id="ShowNav">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="student_home.php">Home</a></li>
								<li class="active"><a href="#">History</a></li>
								<li><a href="student_ranking.php">Ranking</a></li>
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
					  <h2> Test History</h2>
					  <hr>
<?php
						
$uname = $_SESSION['uname'];						
$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

	$q=mysqli_query($con,"SELECT * FROM history WHERE uname='$uname' ORDER BY date DESC " )or die('Error197');
	echo  '<div class="panel title">
	<table class="table table-striped title1" >
	<tr style="color:red"><td><b>S.N.</b></td><td><b>Quiz</b></td><td><b>Question Solved</b></td><td><b>Right</b></td><td><b>Wrong<b></td><td><b>Score</b></td>';
	$c=0;
	while($row=mysqli_fetch_array($q) )
	{
	$eid=$row['eid'];
	$s=$row['score'];
	$w=$row['wrong'];
	$r=$row['correct'];
	$qa=$row['level'];
	$q23=mysqli_query($con,"SELECT title FROM quiz WHERE  eid='$eid' " )or die('Error208');
	while($row=mysqli_fetch_array($q23) )
	{
		$title=$row['title'];
	}
	$c++;
	echo '<tr><td>'.$c.'</td><td>'.$title.'</td><td>'.$qa.'</td><td>'.$r.'</td><td>'.$w.'</td><td>'.$s.'</td></tr>';
	}
	echo'</table></div>';

						
mysqli_close($con);		  
?>
				
					</div>
				</div>
		  	</main>
			<footer class="navbar navbar-fixed-bottom mainFooter blackFooter">Copyright &copy; <?php echo date('Y')?> QuizSeed. All Rights Reserved.</footer>
		</div>
	</body>
</html>
