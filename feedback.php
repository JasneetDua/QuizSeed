<?php
require 'include/variables.php';
$msg_display="";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if( empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["mobile"]) || empty($_POST["subject"]) || empty($_POST["msg"]) )
	{
			$msg_display = $alert_danger."Please Fill All Entities".$alert_end;
	}
	
	else
	{
			$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

			if (!$con) 
			{
				die("Connection failed: " . mysqli_connect_error());
			}
		
			$name = $_POST["name"];
			$email = $_POST["email"];
			$mobile = $_POST["mobile"];
			$subject = $_POST["subject"];
			$msg = $_POST["msg"];

			$sql = "INSERT INTO `feedback` (`id`, `name`, `email`, `mobile`, `subject`, `msg`) VALUES (NULL, '$name', '$email', '$mobile', '$subject', '$msg')";
		
			if (mysqli_query($con, $sql)) 
			{
					$msg_display = $alert_success."Thanks For Your Feedback ".$alert_end;
			}
			else 
			{
				$msg_display = $alert_danger."Error : In Communicating with the Server".$alert_end;
			}	
	}
} 

# if this page directly open by url

if(empty($msg_display))
{
	header('Location:contact.php');
	
}

?>

<html>
	<head>
		<title>QuizSeed</title>
		<?php require 'include/head.php'; ?>
		<script language="JavaScript" type="text/javascript">	
			var seconds =6;
			var url="./contact.php";

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
				<div class="col-md-6 col-md-offset-3">
					<?php echo $msg_display; ?>
				</div>
				<div class="col-md-6 col-md-offset-3">
					<p class="description">Redirecting in <span id='count_down'><script>redirect();</script></span> sec.</p>
				</div>
			</main>
				<?php require 'include/footer.php'; ?>
		</div>
	</body>
</html>
