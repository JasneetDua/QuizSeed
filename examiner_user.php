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
								<li class="active"><a href="#">User</a></li>
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
		  <h2>Students Enrolled </h2>
		  <br>

<?php
		  
$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

$msg = "";
		  
if(isset($_GET['uname']))
{

		$delete = $_GET['uname'];
		if (!$con) 
		{
			die("Connection failed: " . mysqli_connect_error());
		}

		$sql = "DELETE FROM user WHERE uname='$delete'";

		if (mysqli_query($con, $sql)) 
		{
			$msg = $alert_success."Student Account Succesfully Deleted".$alert_end;
		}
		else 
		{
			$msg=$alert_danger."Something went Wrong while deleting !!!".$alert_end;
		}
}
	  
$result = mysqli_query($con,"SELECT * FROM user WHERE cat='student'") or die('Error');

echo $msg;		  
echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
<tr>
	<td><b>S.N.</b></td>
	<td><b>User Name</b></td>
	<td><b>Name</b></td>
	<td><b>Email</b></td>
	<td><b>Mobile</b></td>
	<td><b>Gender</b></td>
	<td></td>
</tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	
	$userName = $row['uname'];
	
	if(!$row['fname']=="") $name = $row['fname']." ".$row['lname'];
	else	$name ="n/a";
	
    if(!$row['email']=="") $email = $row['email'];
		else	$email ="n/a";
	
	if(!$row['phn']=="") $mob = $row['phn'];
		else	$mob ="n/a";
	
	if(!$row['gender']=="") $gender = $row['gender'];
		else	$gender ="n/a";
	echo '<tr>
			<td>'.$c++.'</td>
			<td>'.$userName.'</td>
			<td>'.$name.'</td>
			<td>'.$email.'</td>
			<td>'.$mob.'</td>
			<td>'.$gender.'</td>
			
		<td><a title="Delete Student" href="admin_user.php?uname='.$userName.'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td></tr>';
}
		  
echo '</table></div></div>'; 
		  
mysqli_close($con);		  
?>
		  
		  

      </div>
    </div>				
			</main>

			<footer class="navbar navbar-fixed-bottom mainFooter blackFooter">Copyright &copy; <?php echo date('Y')?> QuizSeed. All Rights Reserved.</footer>
		</div>
	</body>
</html>
