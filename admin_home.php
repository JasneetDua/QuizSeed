<?php

session_start();
require 'include/functions.php';
require 'include/variables.php';

check_user("admin");

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
						<a class="navbar-brand logo" href="admin_home.php">
							<i>Admin Home</i>
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
								<li><a href="admin_user.php">Users</a></li>
								<li><a href="admin_ranking.php">Ranking</a></li>
								<li><a href="admin_feedback.php">Feedback</a></li>
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
											<li><a href="./admin_faq.php"> FAQ </a></li>
											<li><a href="./admin_feedback.php"> Feedbacks </a></li>
											<li><a href="./admin_editExaminer.php"> Edit Examiner </a></li>
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
		  
$result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');

echo  '
<div class="panel">
<div class="table-responsive">
<table class="table table-striped title1">
<tr>
	<td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td>
	
</tr>';
		  
$c=1;
		  
while($row = mysqli_fetch_array($result)) 
{
	$title = $row['title'];
	$total = $row['total'];
	$correct = $row['correct'];
    $time = $row['time'];
	$eid = $row['eid'];
		
	echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$correct*$total.'</td><td>'.$time.'&nbsp;min</td>
	</tr>';
}
		  
echo '</table></div></div>';

?>
		  
		  

      </div>
    </div>				
			</main>

			<footer class="navbar navbar-fixed-bottom mainFooter blackFooter">Copyright &copy; <?php echo date('Y')?> QuizSeed. All Rights Reserved.</footer>
		</div>
	</body>
</html>
