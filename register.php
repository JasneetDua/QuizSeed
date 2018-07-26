<?php
	require 'include/variables.php';
	require 'include/functions.php';


?>

<html>
	<head>
		<title>QuizSeed</title>
		<?php require 'include/head.php'; ?>
		
	</head>
	
	<body>
		<div class="container-fluid mainContainer">
			<header class="navbar navbar-inverse navbar-fixed-top mainHeader">
				<div class="container">					
					<nav class="navbar-header">
						<a class="navbar-brand logo" href="#">
								<img src="images/logo.png" class="desktop">
								<i class="mobile">QuizSeed</i>
						</a>

						<button class="collapsed navbar-toggle x" data-toggle="collapse" data-target="#ShowNav">
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
						</button>
					</nav>
					
					<nav class="collapse navbar-collapse" id="ShowNav">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="index.php"> Home </a></li>
								<li><a href="notification.php"> Notifications </a></li>
								<li><a href="faq.php"> FAQ's </a></li>
								<li><a href="contact.php"> Contact Us </a></li>
							</ul>
					</nav>
				</div>
			</header>
			
			<main class="row">
				<div class="conatiner">
					<div class="col-md-8 col-md-offset-2">
					<?php
						
					if(@$_POST['uname']==null)
					{
					?>	
						<h1 class="title text-center">Register Now</h1>
						<hr>
						<div class="well">
						<div class="row">
						<form method="post" action="register.php" class="form-horizontal" role="form">
						  <div class="col-md-12">
								<div class="form-group">
								<label class="col-md-3 control-label">* Username :</label>
								<div class="col-md-8">
								  <input class="form-control" type="text" name="uname" placeholder="Enter Username" required>
								</div>
							  </div>
								<div class="form-group">
								<label class="col-md-3 control-label">Category:</label>
								<div class="col-md-8">
								  <input class="form-control" type="text" value="student" disabled>
								</div>
							  </div>

								<div class="form-group">
								<label class="col-lg-3 control-label">First name:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" name="fname" placeholder="Enter First Name">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Last name:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" name="lname" placeholder="Enter Last Name">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Email:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="email" name="email" placeholder="Enter Email">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Phone:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="number" name="phn" placeholder="Enter Mobile Number">
								</div>
							  </div>

								<!-- Gender -->
								<div class="form-group">
								  <label class="col-lg-3 control-label" for="gender">Gender:</label>
											  <div class="col-lg-4">
												<label class="radio-inline" for="male">
												  <input id="male" type="radio" name="gender" value="M">
												  Male
												</label>
												<label class="radio-inline" for="female">
												  <input id="female" type="radio" name="gender" value="F">
												  Female
												</label>
											  </div>
									
									
								</div>
								<!-- Appended Input-->
								<div class="form-group">
								  <label class="col-md-3 control-label" for="dob">Date of Birth</label>
								  <div class="col-md-4">
									<div class="input-group">
									  <input id="dob" class="form-control" name="dob" type="date">
									  <span class="input-group-addon">DOB</span>
									</div>
								  </div>
								</div>

							  <div class="form-group">
								<label class="col-md-3 control-label">* Password:</label>
								<div class="col-md-8">
								  <input class="form-control" type="password" name="pass" placeholder="Enter Password" required>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-md-3 control-label">* Confirm password:</label>
								<div class="col-md-8">
								  <input class="form-control" type="password" name="cpass" placeholder="Confirm Password" required>
								</div>
							  </div>
							  <div class="form-group"><br>
								<label class="col-md-3 control-label"></label>
								<div class="col-md-2 col-md-offset-4">
								  <input type="submit" class="btn btn-primary" name="save" value="Register">
								  </div>
								<div class="col-md-2">
									<a class="btn btn-default" href="index.php">Cancel</a>
								</div>
							  </div>
						  </div>
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
													$fname = 
													$lname = 
													$email = 
													$phn = 
													$gender = 
													$dob = "";
												
												
													$fname = $_POST["fname"];
													$lname = $_POST["lname"];
													$email = $_POST["email"];
													$phn = $_POST["phn"];
													if(isset($_POST["gender"]))
													$gender = $_POST["gender"];
													$dob = $_POST["dob"];

												$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

												if (!$con) 
												{
													die("Connection failed: " . mysqli_connect_error());
												}


												$sql = "INSERT INTO user (uname,pass,cat,fname,lname,email,phn,gender,dob)
														VALUES ('$name', '$pass','student','$fname','$lname','$email','$phn','$gender','$dob')";

												if (mysqli_query($con, $sql)) 
												{
													echo $alert_success,"Account Created",$alert_end;
													echo "<a href='index.php' class='btn btn-success' style='float:right'>Continue....</a><br>";
												}
												else 
												{
													echo $alert_danger,"Username Already Exist",$alert_end;
													echo "<a href='register.php' class='btn btn-success' style='float:right'>Please Try Again</a><br>";
												}

												mysqli_close($con);
											}
											else
											{
												echo "<a href='register.php' class='btn btn-success' style='float:right'>Please Try Again</a><br>";
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
			</main>
			<?php require 'include/footer.php'; ?>
		</div>
	</body>
</html>
