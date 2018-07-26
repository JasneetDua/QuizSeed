<?php
	session_start();
	require 'include/variables.php';
	require 'include/functions.php';
	check_user("admin");

	$fback = array();
	$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

	if (!$con) 
	{
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM feedback ORDER BY id";

	$result = mysqli_query($con, $sql);

	if (mysqli_num_rows($result) > 0) 
	{
		while($row = mysqli_fetch_assoc($result)) 
		{
			$fback[] = $row;
		}
	}


	$msg="";				//overide msg to display after operation
	
	if(isset($_GET['msg']))
	{
		if($_GET['msg'] == "deleted")
			$msg=$alert_success."Feedback Succesfully Deleted".$alert_end;
		else
			$msg=$alert_danger."Something went Wrong while deleting !!!".$alert_end;
	}


mysqli_close($con);
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
							<span> <span class="glyphicon glyphicon-arrow-left"></span> Back </span>
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
								<li><a href="admin_user.php">Users</a></li>
								<li><a href="admin_ranking.php">Ranking</a></li>
								<li class="active"><a href="admin_feedback.php">Feedback</a></li>
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
										</ul>
								</li>
							</ul>
					</nav>
				</div>
			</header>
			
			<main class="row">
				<div class="container">
										
					<h1>Feedback</h1>
						<hr>
						<div class="row">
							<div class="col-md-12">
								
							<?php
								
								if(!isset($_GET['mode']))
								{

											echo $msg;
											echo  '<div class="panel">
													<div class="table-responsive">
														<table class="table">
														    <thead>
															<tr class="active">
																<th>S.N.</th>
																<th>Sender\'s Name</th>
																<th>Sender\'s Email</th>
																<th>Subject</th>
																<th></th>
																<th></th>
															</tr>
															</thead>';
											$count = 0;
											foreach($fback as $feedback)
											{
												echo '<tr><td>'.++$count.'</td>';
												echo '<td class="text-capitalize">'.$feedback['name'].'</td>';
												echo '<td class="text-lowercase">'.$feedback['email'].'</td>';
												echo '<td >'.$feedback['subject'].'</td>';
												
												echo '<td>
													<a title="Open Feedback" href="admin_feedback.php?mode=view&fid='.$feedback['id'].'"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>';
												echo '<td>
												<a title="Delete Feedback" href="admin_feedback.php?mode=del&fid='.$feedback['id'].'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td></tr>';

												
											}
								
											echo '</table></div></div>';
								}
								else
								{
									if($_GET['mode']=="view" && isset($_GET['fid'])){
																		
										foreach($fback as $feedback)
										{
											if($feedback['id'] == $_GET['fid'])
											{
											
											echo '<div class="col-md-6 col-md-offset-3">
													  <table class="table table-striped">';
												
											echo '<tr>
													<td><label>Name  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													</label></td>
													<td class="text-capitalize">'.$feedback['name'].'</td></tr>';
											echo '<tr>
													<td><label class="text-capitalize">E-Mail  </label></td>
													<td class="text-lowercase">'.$feedback['email'].'</td></tr>';
											echo '<tr>
													<td><label>Mob No.  </label></td>
													<td> '.$feedback['mobile'].'</td></tr>';
											echo '<tr>
													<td><label>Subject  </label></td>
													<td> '.$feedback['subject'].'</td></tr>';
											echo '<tr>
													<td><label>Message  </label></td>
													<td>'.$feedback['msg'].'</td></tr>';
												
												
											echo '<tr><td><br>
											<a title="Back to Feedback Page" href="admin_feedback.php" class="btn btn-default"> Cancel </a>
											</td>
											';
											echo '<td><br>
											<a title="Delete Feedback" class="btn btn-primary" href="admin_feedback.php?mode=del&fid='.$feedback['id'].'"> Delete</a>
												</td></tr>';
												
											echo '</table></div>';												
											}
										}

									}
									
									elseif($_GET['mode']=="del" && isset($_GET['fid'])){
										
										$fid = $_GET['fid'];

										$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

										if (!$con) 
										{
											die("Connection failed: " . mysqli_connect_error());
										}
										
										$sql = "DELETE FROM feedback WHERE id=$fid";
										
										if (mysqli_query($con, $sql)) 
										{
											header('Location:admin_feedback.php?msg=deleted');;
										}
										
										else 
										{
											header('Location:admin_feedback.php?msg=notDeleted');;
										}

										mysqli_close($con);
									
									}
									else{
										header('Location:admin_feedback.php');
									}
								}
								?>								
								<br>
								<br>
								<br>
								<br>
								<br>
							</div>
					  	</div>					
					
					
				</div>
			</main>
			<footer class="navbar navbar-fixed-bottom mainFooter blackFooter">Copyright &copy; <?php echo date('Y')?> QuizSeed. All Rights Reserved.</footer>
		</div>
	</body>
</html>
