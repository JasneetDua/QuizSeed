<?php
session_start();
require 'include/variables.php';

$view = 0; 

$msg="";

if(isset($_POST['secure']) && isset($_POST['email']) && isset($_POST['uname'])){
	
		if($_POST['secure'] == $_SESSION['secure'])
		{			
			$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
			if (!$con) {
				die("Connection failed: " . mysqli_connect_error());
			}
			
			$uname = $_POST['uname'];
			$email = $_POST['email'];
			$sql = "SELECT * FROM user WHERE uname='$uname' and email='$email'";
			
			$result = mysqli_query($con, $sql);
			if (mysqli_num_rows($result) > 0) 
			{
				$row = mysqli_fetch_assoc($result);							
				
				$to=$row['email'];
				$subject = "Password Recovery Mail";
				$body="Dear ".$row['fname']." , \n\n Your Username : ".$row['fname']." \n and  Password : ".$row['pass'];
				$body=$body."\n\n\n\n--------------------------------------------\n";
				$body=$body."Regards \n Admin (QuizSeed)";
				$headers = "From:QuizSeed <admin@quizseed.org>";
				
				if(mail($to,$subject,$body,$headers))					
					$msg = $alert_success."Password has been sent via email !!!".$alert_end;
					
				else
					$msg = $alert_danger."Error while sending password via email....... Please Try Again Later !!!".$alert_end;
				
				$view = 2;
			}
			else
			{
				
				$msg = $alert_danger."Invalid Email....... Please Try Again Later !!! ".$alert_end;
				$view = 0;
				
			}
			mysqli_close($con);

		}
		else
		{	
			$view = 0;
			$msg = $alert_danger."Invalid Captcha Code.... Please Try Again !!! ".$alert_end;
		}
}

elseif(isset($_POST['uname'])){
	
			$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
			if (!$con) {
				die("Connection failed: " . mysqli_connect_error());
			}
			
			$uname = $_POST['uname'];
			$sql = "SELECT * FROM user WHERE uname='$uname'";
			$result = mysqli_query($con, $sql);

			if (mysqli_num_rows($result) > 0) 
			{
				$row = mysqli_fetch_assoc($result);
				$email = $row['email'];
				if($email=="")
				{
					$msg = $alert_info."System Can't Recover Your Account! Please Contact with Admin.... <br>";
					$msg = $msg."<a href='contact.php' class='btn' >Contact US</a>".$alert_end;
					$view = 2;
				}
				else{
					
					preg_match('/^.\K[a-zA-Z\.0-9]+(?=.@)/',$email,$matches);
					$replacement= implode("",array_fill(0,strlen($matches[0]),"*"));//creating no. of *'s
					$email = preg_replace('/^(.)'.preg_quote($matches[0])."/", '$1'.$replacement, $email);
					$view = 1;
				} 
			}
			else
			{
				$msg = $alert_danger."Account with this Username Doesn't Exist ".$alert_end;				
			}
	mysqli_close($con);
}

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
				
				<div class="col-md-12 text-center">
					<p class="title">Password Recovery</p>
					<p class="description">We will help to Recover Your Password</p>
					<br><br><br>
				</div>
				
				<?php
				if($view == 0){
				?>
					<div class="jumbotron text-center col-md-12">
						<?php echo $msg; 
						if(isset($_SESSION['secure']))
							unset($_SESSION['secure']);
						
						?>
						<h3>Please Provide Username of your Account</h3>
						<br>
							<form action="./forgot_pass.php" method="post" class="col-md-4 col-md-offset-4">
								<input class="form-control" type="text" name="uname">
								<br>
								<input type="submit" value="Search" class="btn btn-primary">
							</form>
					</div>

				<?php
				}
				elseif($view == 1){
				?>
					<div class="jumbotron text-center col-md-12">
						<?php echo $msg; ?>
						<h3>Hi <?php echo $_POST['uname']; ?>, Please Verify if its You</h3>
						<br>
						
							<form action="./forgot_pass.php" method="post" class="col-md-4 col-md-offset-4">
								
								<input type="hidden" name="uname" value="<?php echo $_POST['uname']; ?>">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">@</span>
									<input class="form-control " type="text" name="email" placeholder="<?php echo $email; ?>">
								</div>
								<br>
								<div class="form-group">
									<?php $_SESSION['secure']= rand(1000,9999); ?>
									<img src="include/generateCaptcha.php" class="col-md-4">
									
									<div class="col-md-8 input-group">
										<span class="input-group-addon" id="basic-addon1">Captcha</span>
										<input type="text" name="secure" class="form-control">
									</div>
								</div>
								
								<br>
								
								<input type="submit" value="Verify" class="btn btn-primary">
							</form>
					</div>
				<?php
				}				
				elseif($view == 2){
				
				?>
					<div class="jumbotron text-center col-md-12">
						
						<?php 
							echo $msg;
							if(isset($_SESSION['secure']))
							unset($_SESSION['secure']);
						?>
						
					</div>				
				<?php
				}
				?>
				
			</main>

			<?php require 'include/footer.php'; ?>
		</div>
	</body>
</html>
