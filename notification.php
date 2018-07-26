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
								<li class="active"><a href="#"> Notifications </a></li>
								<li><a href="faq.php"> FAQ's </a></li>
								<li><a href="contact.php"> Contact Us </a></li>
							</ul>
					</nav>
				</div>
			</header>
			
			<main class="row">
				
	<div class="container">
      <div class="row">
		  <br>
		  <div class="row">
		  	<h2 class="text-center title">Test : Recently Added </h2>
		  </div>
		 	<hr>
			<?php

			$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

			$result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC LIMIT 5") or die('Error');
			echo  '
			<div class="well">
			<div class="table-responsive">
			<table class="table">
			<tr class="active">
				<td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td>

			</tr>';
			$c=1;
			while($row = mysqli_fetch_array($result)) 
			{
				$title = $row['title'];
				$total = $row['total'];
				$correct = $row['correct'];
				$time = $row['time'];
				$eid = $row['eid'];

				echo '<tr><td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$correct*$total.'</td><td>'.$time.'&nbsp;min</td>
				</tr>';
			}
			echo '</table></div></div>';
			?>
      </div>
    </div>				

				
				
			</main>
			<?php require 'include/footer.php'; ?>
		</div>
	</body>
</html>
