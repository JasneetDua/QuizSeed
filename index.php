<?php 
	session_start();
	require 'include/variables.php';
	require 'include/functions.php';
	$name = $nameErr = "";
	$pass = $passErr = "";
?>


<html>
	<head>
		<?php require 'include/head.php'; ?>
		
		<title>QuizSeed</title>
		<link href="./css/login-box-style.css" rel="stylesheet">

		<script language="JavaScript" type="text/javascript">	
			var seconds = 3;
			var url="./controller.php";

			function redirect()
			{
				if (seconds <=0) {
					window.location = url; 
				}
				else {
			  		seconds--;
			  		document.getElementById("count_down").innerHTML = seconds;
			  		setTimeout("redirect()", 1000);
			 	}
			}
		</script>


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
								<li class="active"><a href="#"> Home </a></li>
								<li><a href="notification.php"> Notifications </a></li>
								<li><a href="faq.php"> FAQ's </a></li>
								<li><a href="contact.php"> Contact Us </a></li>
							</ul>
					</nav>
				</div>
			</header>

			<main class="row">
				<section class="col-md-6 left">
							<p class="title fadeInDown animated">Welcome to QuizSeed</p>
                            <p class="description fadeInUp animated"><i></i>Online Examination Portal<em></em></p>
							<div class="container col-md-12">
					
								<?php
								
									if ($_SERVER["REQUEST_METHOD"] == "POST") 
									{
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

											$sql = "SELECT * FROM user WHERE uname='$name' and pass='$pass'";
											
											$result = mysqli_query($con, $sql);
											
											if (mysqli_num_rows($result) > 0) 
											{
												$row = mysqli_fetch_assoc($result);							
												
												if(isset($_POST['remember']))
												{
													setcookie("uname", $row["uname"], time() + (86400 /24), "/");
													setcookie("pass", $row["pass"], time() + (86400 /24), "/");
													setcookie("cat", $row["cat"], time() + (86400 /24), "/");
												}
												
												$_SESSION["uname"] = $row["uname"];
												$_SESSION["cat"] = $row["cat"];
												
											}
											else 
											{
												echo $alert_danger,"Account Not Found",$alert_end;
											}

											mysqli_close($con);
											
										}
									}
								
									if( isset($_SESSION["uname"]) && isset($_SESSION["cat"]) )
									{
										echo $alert_success,"Authenticated",$alert_end;	
								?>
										<p class="description">Redirecting in <span id='count_down'><script>redirect();</script></span> sec.</p>
								
								<?php
										
									}
								
								?>
					</div>
				</section>
				
				<section class="col-md-6 right">
				
						<div class="login-box">
							<img src="./images/login-box-avatar.png" class="avatar">
							<h1>Login Here</h1>

							<form action="#" method="post">	
								<i class="glyphicon glyphicon-user" style="font-size:30px;"></i>
								<input type="text" placeholder="Enter Username" name="uname">

								<i class="glyphicon glyphicon-lock" style="font-size:30px;"></i>
								<input type="password" name="pass" placeholder="Enter Password">
								
								<p>Remember me</p>
								<input type="checkbox" name="remember">

								<input type="submit" name="submit" value="Log in">
								<a href="./register.php" style="display:inline-block">Register Now</a>
								<a href="./forgot_pass.php" style="display:inline-block; float:right ">Forget Password</a>
							</form>
						</div>				
				<div class="clearfix"></div>
				</section>
			</main>
			
			<?php require 'include/footer.php'; ?>
			
		</div>
	
	</body>
</html>
