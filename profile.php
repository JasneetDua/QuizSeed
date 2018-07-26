<?php
	session_start();
	require 'include/variables.php';
	require 'include/functions.php';
	check_session();

	// Declaration

	$uname = $_SESSION['uname'];

	$pass = 
	$cat = 
	$fname = 
	$lname = 
	$email = 
	$phn = 
	$gender = 
	$dob = "";


	$pic = "./ProfilePic/"; //default if img not exist
	$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);


	if (!$con) 
	{
		die("Connection failed: " . mysqli_connect_error());
	}


	$msg = "";
	if(isset($_POST['save']))   // if edit attempts
	{
		$flag = false; 	// Change to true if error

		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$email = $_POST["email"];
		$phn = $_POST["phn"];
		if(isset($_POST["gender"]))
		$gender = $_POST["gender"];
		$dob = $_POST["dob"];
		$pass = $_POST["pass"];
		$cpass = $_POST["cpass"];
		
		//Server Side Validations
	
		if(!($pass == $cpass))	// cpass and pass check
		{	
			$flag = true;
		}
		
		$check = getimagesize($_FILES["pic"]["tmp_name"]);
	
		if($check !== false && !$flag)  // Picture Check and Upload
		{
			$target_dir = "ProfilePic/";
			$name = basename($_FILES["pic"]["name"]);
			$ext = strtolower(pathinfo($name,PATHINFO_EXTENSION));
			$extensions_arr = array("jpg","jpeg","png","gif");
			
			if( in_array($ext,$extensions_arr) )
			{
						$sql = "UPDATE user SET pic = '$ext' WHERE uname = '$uname'";

						if (mysqli_query($con, $sql))
						{
							move_uploaded_file($_FILES['pic']['tmp_name'],$target_dir.$uname.".".$ext);
						}
						else
						{
							$flag = true;
							$msg = $msg. mysqli_error($con);							
						}
			}
			else 
			{
				$flag = true;
				$msg = $msg." 'Error : Supported Image Formats are : jpg,jpeg,png,gif only' ";
			}
		}		
	
		if(!$flag)	// Storing Data if Server Side validation Passed
		{
				$sql = "UPDATE user SET  

							pass = '$pass',
							fname = '$fname',
							lname = '$lname',
							email = '$email',
							phn = '$phn',
							gender = '$gender',
							dob = '$dob'
							
						WHERE uname = '$uname'";


					if (!mysqli_query($con, $sql))
					{
						$flag = true;
						$msg = $msg. mysqli_error($con);
					}
		}


	if($flag)
	{
		$msg = $msg.$alert_danger."Profile Updation Faild !!!".$alert_end;
	}
	else
	{
		$msg = $alert_success."Profile Successfully Updated !!!".$alert_end;
	}
}


	$sql = "SELECT * FROM user WHERE uname='$uname'";
	$result = mysqli_query($con, $sql);

	if (mysqli_num_rows($result) > 0) // fetching data to display
	{
		$row = mysqli_fetch_assoc($result);
		
		
		$pass = $row["pass"];
		$cat = $row["cat"];
		$fname = $row["fname"];
		$lname = $row["lname"];
		$email = $row["email"];
		$phn = $row["phn"];
		$gender = $row["gender"];
		$dob = $row["dob"];
		
		if(!empty($row["pic"]))
		{
			$pic = $pic."$uname.".$row["pic"];
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
						<a class="navbar-brand logo" href="controller.php">
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
				<?php
					
					if(!isset($_GET['edit'])){
					
					?>
					
						<h1>Profile <a class="badge button" href="profile.php?edit=true">Edit</a></h1>
						<hr>
						<div class="row">
						  <!-- left column -->
						  <div class="col-md-3">
							<div class="text-center">
							  <img src="<?php echo $pic; ?>" width="150" height="150" class="avatar img-circle" alt="avatar">
							  <h4><?php echo $fname," ",$lname; ?></h4>

							</div>
						  </div>

						  <!-- edit form column -->
						  <div class="col-md-9">
							<h3>Personal info</h3>
								<div class="col-md-11">
									<?php echo $msg; ?>
								<br>
							  	</div>
							  
							<form class="form-horizontal" role="form">
								<div class="form-group">
								<label class="col-md-3 control-label">Username:</label>
								<div class="col-md-8">
								  <input class="form-control" type="text" value="<?php echo $uname; ?>" disabled>
								</div>
							  </div>
								<div class="form-group">
								<label class="col-md-3 control-label">Category:</label>
								<div class="col-md-8">
								  <input class="form-control" type="text" value="<?php echo $cat; ?>" disabled>
								</div>
							  </div>

								<div class="form-group">
								<label class="col-lg-3 control-label">First name:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" value="<?php echo $fname; ?>" disabled>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Last name:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" value="<?php echo $lname; ?>"  disabled>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Email:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="email" value="<?php echo $email; ?>"  disabled>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Phone:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" value="<?php echo $phn; ?>"  disabled>
								</div>
							  </div>

								<!-- Multiple Radios (inline) -->
								<div class="form-group">
								  <label class="col-lg-3 control-label" for="gender">Gender:</label>
							<?php		
							if($gender=='M')
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
							elseif($gender=='F')
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
									  <input id="dob" name="dob" class="form-control" value="<?php echo $dob; ?>" type="date"  disabled>
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
					
					<?php
						}
						else 
						{
							
					?>
					
						<h1>Edit Profile</h1>
						<hr>
						<div class="row">
							<form method="post" action="profile.php" enctype="multipart/form-data" class="form-horizontal" role="form">
						  <!-- left column -->
						  <div class="col-md-3">
							<div class="text-center">
							  <img src="<?php echo $pic; ?>" width="150" height="150" class="avatar img-circle" alt="avatar">
							  <h6>Upload a different photo...</h6>

							  <input name="pic" type="file" class="form-control">
							</div>
						  </div>

						  <!-- edit form column -->
						  <div class="col-md-9">
							<h3>Personal info</h3>
							  

								<div class="form-group">
								<label class="col-md-3 control-label">Username:</label>
								<div class="col-md-8">
								  <input class="form-control" type="text" value="<?php echo $uname; ?>" disabled>
								</div>
							  </div>
								<div class="form-group">
								<label class="col-md-3 control-label">Category:</label>
								<div class="col-md-8">
								  <input class="form-control" type="text" value="<?php echo $cat; ?>" disabled>
								</div>
							  </div>

								<div class="form-group">
								<label class="col-lg-3 control-label">First name:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" name="fname" value="<?php echo $fname; ?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Last name:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" name="lname" value="<?php echo $lname; ?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Email:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="email" name="email" value="<?php echo $email; ?> ">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label">Phone:</label>
								<div class="col-lg-8">
								  <input class="form-control" type="text" name="phn" value="<?php echo $phn; ?>">
								</div>
							  </div>

								<!-- Gender -->
								<div class="form-group">
								  <label class="col-lg-3 control-label" for="gender">Gender:</label>
									
									
										<?php		
										if($gender=='M')
										{
										?>		
											  <div class="col-lg-4">
												<label class="radio-inline" for="male">
												  <input id="male" checked="checked" type="radio" name="gender" value="M">
												  Male
												</label>
												<label class="radio-inline" for="female">
												  <input id="female" type="radio" name="gender" value="F">
												  Female
												</label>
											  </div>
										<?php
										}
										else if($gender=='F')
										{
										?>		
											  <div class="col-lg-4">
												<label class="radio-inline" for="male">
												  <input id="male" type="radio" name="gender" value="M">
												  Male
												</label>
												<label class="radio-inline" for="female">
												  <input id="female" checked="checked" type="radio" name="gender" value="F">
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
												  <input id="male" type="radio" name="gender" value="M">
												  Male
												</label>
												<label class="radio-inline" for="female">
												  <input id="female" type="radio" name="gender" value="F">
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
									  <input id="dob" class="form-control" name="dob" value="<?php echo $dob; ?>" type="date">
									  <span class="input-group-addon">DOB</span>
									</div>
								  </div>
								</div>

							  <div class="form-group">
								<label class="col-md-3 control-label">Password:</label>
								<div class="col-md-8">
								  <input class="form-control" type="password" name="pass" value="<?php echo $pass; ?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-md-3 control-label">Confirm password:</label>
								<div class="col-md-8">
								  <input class="form-control" type="password" name="cpass" value="<?php echo $pass; ?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-md-3 control-label"></label>
								<div class="col-md-8">
								  <input type="submit" class="btn btn-primary" name="save" value="Save Changes">
								  <span></span>
									<a class="btn btn-default" href="profile.php">Cancel</a>
								</div>
							  </div>
						  </div>
						</form>
					  </div>
					<?php
						
						
						}
					?>
					
					
					
					
					
					
					</div>
					<br>
					<br>
					<br>
					<br>

			</main>

			<footer class="navbar navbar-fixed-bottom mainFooter blackFooter">Copyright &copy; <?php echo date('Y')?> QuizSeed. All Rights Reserved.</footer>
		</div>
	</body>
</html>
