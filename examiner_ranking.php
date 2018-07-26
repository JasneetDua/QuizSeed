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
								<li><a href="admin_home.php">Home</a></li>
								<li><a href="examiner_user.php">User</a></li>
								<li  class="active"><a href="#">Ranking</a></li>

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
		  <h2>Students Ranking</h2>
		  <br>

<?php
		  
$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

$q = mysqli_query($con,"SELECT * FROM rank  ORDER BY score DESC " )or die('Error223');
		  
echo  '<div class="panel title"><div class="table-responsive">
<table class="table table-striped title1" >
	<tr style="color:red">
		<td><b>Rank</b></td>
		<td><b>User Name</b></td>
		<td><b>Name</b></td>
		<td><b>Gender</b></td>
		<td><b>Email</b></td>
		<td><b>Score</b></td>
	</tr>';
		  
$c=0;
while($row=mysqli_fetch_array($q))
{
	$e=$row['uname'];
	$s=$row['score'];
				
	$name=
	$gender=
	$email="n/a";


	
	$q12=mysqli_query($con,"SELECT * FROM user WHERE uname='$e' " )or die('Error231');

	while($row = mysqli_fetch_array($q12))
	{
		
		if(!$row['fname']=="") $name = $row['fname']." ".$row['lname'];
			else	$name ="n/a";

		if(!$row['email']=="") $email = $row['email'];
			else	$email ="n/a";

		if(!$row['gender']=="") $gender = $row['gender'];
			else	$gender ="n/a";
	}
	
	$c++;

	echo '<tr>
			<td style="color:#99cc32"><b>'.$c.'</b></td>
			<td>'.$e.'</td>
			<td>'.$name.'</td>
			<td>'.$gender.'</td>
			<td>'.$email.'</td>
			<td>'.$s.'</td>
			</tr>';
}
echo '</table></div></div>';
mysqli_close($con);		  
?>
		  
		  <br>
		  <br>
		  <br>
		  <br>

      </div>
    </div>				
			</main>

			<footer class="navbar navbar-fixed-bottom mainFooter blackFooter">Copyright &copy; <?php echo date('Y')?> QuizSeed. All Rights Reserved.</footer>
		</div>
	</body>
</html>
