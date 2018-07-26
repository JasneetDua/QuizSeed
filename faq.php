<?php
	require 'include/variables.php';


	$faq = array();

	$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

	if (!$con) 
	{
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM faq ORDER BY sno";

	$result = mysqli_query($con, $sql);

	if (mysqli_num_rows($result) > 0) 
	{
		while($row = mysqli_fetch_assoc($result)) {
			$faq[] = $row;
		}
	}
	mysqli_close($con);
?>



<html>
	<head>
		<title>QuizSeed</title>
		<?php require 'include/head.php'; ?>
		
		<script>
			$(document).ready(function() {
 
				$('.faq_question').click(function() {

					if ($(this).parent().is('.open'))
					{
						$(this).closest('.faq').find('.faq_answer_container').animate({'height':'0'},500);
						$(this).closest('.faq').removeClass('open');
					}
					else
					{
						var newHeight =$(this).closest('.faq').find('.faq_answer').height() +'px';
						$(this).closest('.faq').find('.faq_answer_container').animate({'height':newHeight},500);
						$(this).closest('.faq').addClass('open');
					}
				});
			});
		</script>
		<style>
			/*FAQS*/
			
			.faq {
				
				margin-top: 20px;
				color: black;
			}
			.faq_question {
				margin: 0px;
				padding: 0px 0px 5px 0px;
				display: inline-block;
				cursor: pointer;
				font-weight: bold;
				font-size: 18px;
			}

			.faq_answer_container {
				height: 0px;
				overflow: hidden;
				padding: 0px;
				font-size: 16px;
			}
		</style>

		
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
								<li class="active"><a href="#"> FAQ's </a></li>
								<li><a href="contact.php"> Contact Us </a></li>
							</ul>
					</nav>
				</div>
			</header>
			
			<main class="row">
		
				<div class="title text-center col-md-12 ">
					Faq's
				</div>
				<br><br><br><br><br>
				<div class="faq_container col-md-8 col-md-offset-2 well">
				<?php					
						foreach($faq as $qna)
						{
							
							echo "<div class='faq'>",
									"<div class='faq_question'>
										Q",$qna["sno"],". ",$qna["ques"],
									"</div>
								 	<div class='faq_answer_container'> 
										<div class='faq_answer'> &nbsp; 
								 			A. &nbsp;&nbsp;",$qna["ans"],
									"</div>
									</div>
								</div>";
						}
				 ?>
				 </div>
			</main>

			<?php require 'include/footer.php'; ?>
		</div>
	</body>
</html>
