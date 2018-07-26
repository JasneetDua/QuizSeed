<?php
	session_start();
	require 'include/variables.php';
	require 'include/functions.php';
	check_user("admin");

	$uname = $_SESSION['uname'];
	$pic = "ProfilePic/";

	$examiner = array();
	$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

	if (!$con) 
	{
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM user WHERE cat='examiner'";

	$result = mysqli_query($con, $sql);

	if (mysqli_num_rows($result) > 0) 
	{
		while($row = mysqli_fetch_assoc($result)) 
		{
			$examiner[] = $row;
		}
	}


	$msg="";				//overide msg to display after operation
	
	if(isset($_GET['msg']))
	{
		if($_GET['msg'] == "deleted")
			$msg=$alert_success."Examiner Account Succesfully Deleted".$alert_end;
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
										
					<h1>Examiners</h1>
					<hr>
					<div class="row">
						<div class="col-md-12">
							
								<?php
								if(!isset($_GET['mode']))
								{

											echo $msg;
											echo "<div class='row'> <a href='admin_editExaminer.php?mode=add' class='btn btn-success'>Add Examiner </a> </div><br>";
											echo  '<div class="row">
													<div class="table-responsive">
														<table class="table">
														    <thead>
															<tr class="active">
																<th>S.N.</th>
																<th>User Name</th>
																<th>Name</th>
																<th>Email</th>
																<th>Gender</th>
																<th></th>
																<th></th>
															</tr>
															</thead>';
											$count = 0;
											foreach($examiner as $loop)
											{
												echo '<tr><td>'.++$count.'</td>';
												echo '<td>'.$loop['uname'].'</td>';
												
												echo '<td class="text-capitalize">'. ($loop['fname']==""?"N/A":$loop['fname']." ".$loop['lname']). '</td>';

												echo '<td>'. ($loop['email']==""?"N/A":$loop['email']).'</td>';
												echo '<td>'. ($loop['gender']==""?"N/A":$loop['gender']).'</td>';
												

												
												echo '<td>
													<a title="Open Profile" href="admin_editExaminer.php?mode=view&uname='.$loop['uname'].'"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>';
												echo '<td>
												<a title="Delete Profile" href="admin_editExaminer.php?mode=del&uname='.$loop['uname'].'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td></tr>';
											}
								
											echo '</table></div></div>';
								}
								else
								{
									if($_GET['mode']=="add")
									{
										if(!( isset($_POST['uname']) && isset($_POST['pass']) ))
										{
										?>
										<div class="col-md-6 col-md-offset-3">
										<div class="jumbotron">
										  <h2>Add New Examiner</h2>
										  <form action="admin_editExaminer.php?mode=add" method="post">
											<div class="form-group">
											  <label for="uname">User Name:</label>
											  <input type="uname" class="form-control" id="uname" placeholder="Enter User Name" name="uname">
											</div>
											<div class="form-group">
											  <label for="pwd">Password:</label>
											  <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pass">
											</div>
											  <br>
											  <a href="admin_editExaminer.php" class="btn btn-default">Cancel</a>
											<input type="submit" class="btn btn-primary" value="Add New Examiner">
										  </form>
										</div>
										</div>
										<?php
										}
										else
										{
												$name = $nameErr = "";
												$pass = $passErr = "";

												if (empty($_POST["uname"])) 
												{
													$nameErr = $alert_warning."User Name is required".$alert_end;
												}
												else 
												{
													$name = test_input($_POST["uname"]);

													if (!preg_match("/^[a-zA-Z0-9]{4,}+$/",$name)) 
													{
														$nameErr = $alert_danger."Only letters are allowed".$alert_end; 
													}
												}

												if (empty($_POST["pass"])) 
												{
													$passErr = $alert_warning."Password is required".$alert_end;
												}
												else 
												{
													$pass = test_input($_POST["pass"]);

													if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,}$/', $pass)) 
													{
														$passErr = $alert_danger."Password does not meet the requirements!".$alert_end; 
													}
												}
											
											
											echo $nameErr;
											echo $passErr;
											
											if(empty($nameErr) && empty($passErr))
											{
												$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

												if (!$con) 
												{
													die("Connection failed: " . mysqli_connect_error());
												}


												$sql = "INSERT INTO user (uname,pass,cat)
														VALUES ('$name', '$pass','examiner')";

												if (mysqli_query($con, $sql)) 
												{
													echo $alert_success,"Account Created",$alert_end;
													echo "<a href='admin_editExaminer.php?mode=add' class='btn btn-success'>Continue....</a><br>";
												}
												else 
												{
													echo $alert_danger,"Username Already Exist",$alert_end;
													echo "<a href='admin_editExaminer.php?mode=add' class='btn btn-success'>Please Try Again</a><br>";
												}

												mysqli_close($con);

											}
											else
											{
												echo "<a href='admin_editExaminer.php?mode=add' class='btn btn-success'>Please Try Again</a><br>";
											}
											
											
										}
									}
									
									else if($_GET['mode']=="view" && isset($_GET['uname'])){
																		
										foreach($examiner as $loop)
										{
											if($loop['uname'] == $_GET['uname'])
											{
												
														if(!empty($loop["pic"]))
														{
															
															$pic = $pic."".$loop["uname"].".".$loop["pic"];
															if(!file_exists($pic))
															{
																	$pic = "./images/default.png"; //default if img not exist		
															}
															else 
															{
																	$pic = $pic."?".mt_rand(1,100);	
															}

														}
														else
														{
															$pic = "./images/default.png"; //default if img not exist		
														}
												
							?>

						<div class="row">
						  <!-- left column -->
						  <div class="col-md-3">
							<div class="text-center">
							  <img src="<?php echo $pic; ?>" width="150" height="150" class="avatar img-circle" alt="avatar">
							  <h4><?php echo $loop['fname']," ",$loop['lname']; ?></h4>
							  
								<h4>												
									<a title="Delete Profile" href="admin_editExaminer.php?mode=del&uname=
									<?php echo $loop['uname'];?>" class="btn btn-primary"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete Profile</b></a>
								</h4>
								<h4>
									<a href="admin_editExaminer.php" class="btn btn-default">Back</a>
								</h4>

							</div>
						  </div>

						  <!-- edit form column -->
						  <div class="col-md-9">
							<h3>Personal info</h3>
							<br>
							<form class="form-horizontal" role="form">
								<div class="form-group">
								<label class="col-md-3 control-label">Username:</label>
								<div class="col-md-8">
								  <input class="form-control" type="text" value="<?php echo $loop['uname']; ?>" disabled>
								</div>
							  </div>
								<div class="form-group">
								<label class="col-md-3 control-label">Category:</label>
								<div class="col-md-8">
								  <input class="form-control" type="text" value="<?php echo $loop['cat']; ?>" disabled>
								</div>
							  </div>

								<div class="form-group">
								<label class="col-lg-3 control-label">First name:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" value="<?php echo $loop['fname']; ?>" disabled>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Last name:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" value="<?php echo $loop['lname']; ?>"  disabled>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Email:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="email" value="<?php echo $loop['email']; ?>"  disabled>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Phone:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" value="<?php echo $loop['phn']; ?>"  disabled>
								</div>
							  </div>

								<!-- Multiple Radios (inline) -->
								<div class="form-group">
								  <label class="col-lg-3 control-label" for="gender">Gender:</label>
							<?php		
							if($loop['gender']=='M')
							{
							?>		
								  <div class="col-lg-4">
									<label class="radio-inline" for="male">
									  <input id="male" checked="checked" type="radio" disabled>
									  Male
									</label>
									<label class="radio-inline" for="female">
									  <input id="female" type="radio" disabled>
									  Female
									</label>
								  </div>
							<?php
							}
							elseif($loop['gender']=='F')
							{
							?>		
								  <div class="col-lg-4">
									<label class="radio-inline" for="male">
									  <input id="male" type="radio" disabled>
									  Male
									</label>
									<label class="radio-inline" for="female">
									  <input id="female" checked="checked" type="radio" disabled>
									  Female
									</label>
								  </div>
							<?php		
							}
							else
							{
							?>		
								  <div class="col-lg-4">
									<label class="radio-inline" for="male">
									  <input id="male" type="radio" disabled>
									  Male
									</label>
									<label class="radio-inline" for="female">
									  <input id="female" type="radio" disabled>
									  Female
									</label>
								  </div>
							<?php		
							}
							?>		

								</div>
								<!-- Appended Input-->
								<div class="form-group">
								  <label class="col-md-3 control-label" for="dob">Date of Birth</label>
								  <div class="col-md-4">
									<div class="input-group">
									  <input id="dob" name="dob" class="form-control" value="<?php echo $loop['dob']; ?>" type="date"  disabled>
									  <span class="input-group-addon">DOB</span>
									</div>
								  </div>
								</div>

							  <div class="form-group">
								<label class="col-md-3 control-label">Password:</label>
								<div class="col-md-8">
								  <input class="form-control" type="password" value="xxxxxxxx"  disabled>
								</div>
							  </div>
							</form>
						  </div>
					  </div>
							<br>
							<br>
							<br>
							<br>

							
							<?php
											}
										}

									}
									
									elseif($_GET['mode']=="del" && isset($_GET['uname'])){
										
										$uname = $_GET['uname'];

										$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

										if (!$con) 
										{
											die("Connection failed: " . mysqli_connect_error());
										}
										
										$sql = "DELETE FROM user WHERE uname='$uname'";
										
										if (mysqli_query($con, $sql)) 
										{
											header('Location:admin_editExaminer.php?msg=deleted');;
										}
										else 
										{
											header('Location:admin_editExaminer.php?msg=notDeleted');;
										}

										mysqli_close($con);
									}
									else
									{
										header('Location:admin_editExaminer.php');
									}
								}
								?>								

						</div>
					</div>					
					
					
				</div>
			</main>
			<footer class="navbar navbar-fixed-bottom mainFooter blackFooter">Copyright &copy; <?php echo date('Y')?> QuizSeed. All Rights Reserved.</footer>
		</div>
	</body>
</html>
