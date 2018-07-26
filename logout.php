<?php

# Destroying Session 

session_start();
session_unset();
session_destroy();

# Destroying Cookies 

setcookie("uname","", time() - (86400 /24), "/");
setcookie("pass", "", time() - (86400 /24), "/");
setcookie("cat","", time() - (86400 /24), "/");

?>


<html>
	<head>
		<title>QuizSeed</title>
		<?php require 'include/head.php'; ?>		
		<script language="JavaScript" type="text/javascript">	
			var seconds =6;
			var url="./index.php";

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
								<li><a href="#"> Home </a></li>
								<li><a href="#"> Notifications </a></li>
								<li><a href="#"> FAQ's </a></li>
								<li><a href="#"> Contact Us </a></li>
							</ul>
					</nav>
				</div>
			</header>
			
			<main class="row text-center">
				<br><br><br><br><br><br><br>
				
				<div class="alert alert-info col-md-6 col-md-offset-3">
					<p>Successfully Logged Out...</p>
				</div>
				<div class="col-md-6 col-md-offset-3">				
					<p class="description">
						Redirecting to Home in <span id='count_down'><script>redirect();</script></span> sec.
					</p>
				</div>
			</main>

			<?php require 'include/footer.php'; ?>
		</div>
	</body>
</html>
