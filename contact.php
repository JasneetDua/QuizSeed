<html>
	<head>
		<?php require 'include/head.php'; ?>

		<title>QuizSeed</title>
		<link href="./css/contact.css" rel="stylesheet">
		<style>
			
			input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button 
			{
				-webkit-appearance: none;
    			margin: 0;
			}
			input[type="number"] {
				-moz-appearance: textfield;
			}
		
		</style>
		<script>
		
			$(document).ready(function(){ 
			$('#characterLeft').text('140 characters left');
			$('#message').keydown(function () {
				var max = 140;
				var len = $(this).val().length;
				if (len >= max) {
					$('#characterLeft').text('You have reached the limit');
					$('#btnSubmit').addClass('disabled');            
				} 
				else {
					var ch = max - len;
					$('#characterLeft').text(ch + ' characters left');
					$('#btnSubmit').removeClass('disabled');
				}
			});    
		});

		
		
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
								<li><a href="index.php"> Home </a></li>
								<li><a href="notification.php"> Notifications </a></li>
								<li><a href="faq.php"> FAQ's </a></li>
								<li class="active"><a href="#"> Contact Us </a></li>
							</ul>
					</nav>
				</div>
			</header>

			<main class="row">
				<div class="row">		
					<section class="col-md-6 col-md-offset-3 text-center">
						<p class="title fadeInDown animated">Our Contact</p>
                        <p class="description fadeInUp animated"><i></i>We Love to Discuss<em></em></p>
					</section>
				</div>
				<br>
				
                         
				<div class="row">
					<br>
					<div class="container contact-container">

						<section class="col-md-4 contact">
								<div class="icon-container bounceIn">
										<span class="glyphicon glyphicon-home"></span>
								 </div>
								<div class="text-container">
										<div class="head">ADDRESS</div>
										<div class="desc">
											<p> xyz, Los Angeles</p>
										</div>
									<div class="clearfix"></div>
								</div>
						</section>

						<section class="col-md-4 contact">
								<div class="icon-container bounceIn">
										<span class="glyphicon glyphicon-envelope"></span>
								 </div>
								<div class="text-container">
										<div class="head">EMAIL</div>
										<div class="desc">
											<p>
											<a href="mailto:contact@quizseed.com">contact@quizseed.com</a>
											
											</p>
										</div>
									<div class="clearfix"></div>
								</div>
						</section>
						<section class="col-md-4 contact">
								<div class="icon-container bounceIn">
										<span class="glyphicon glyphicon-phone"></span>
								 </div>
								<div class="text-container">
										<div class="head">PHONE</div>
										<div class="desc">
											<p>
											
											<a href="tel:121">+91 (999)123 4567</a>
											</p>
										</div>
									<div class="clearfix"></div>
								</div>
						</section>
						
					</div>
				
				</div>
				
				<div class="row">
					<div class="container contact-container ">
						<section class="col-md-12 contact">
							<!-- Trigger -->
							  <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#feedback_form">Feedback !</button>

							  <!-- Target -->
							  <div class="modal fade" id="feedback_form" role="dialog">
								<div class="modal-dialog">

								  <!-- Form -->
								  <div class="modal-content">
									<div class="modal-header bg-primary text-primary">
									  <button type="button" class="close" data-dismiss="modal">&times;</button>
									  <h4 class="modal-title">Feedback Form</h4>
									</div>
									  
									<form action="feedback.php" method="post">
										<div class="modal-body">
											
											<div class="form-group">
												<input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
											</div>
											<div class="form-group">
												<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
											</div>
											<div class="form-group">
												<input type="number" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required>
											</div>
											<div class="form-group">
												<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
											</div>
											<div class="form-group">
											<textarea class="form-control" type="textarea" id="message" name="msg" placeholder="Message" maxlength="140" rows="7"></textarea>
												<span class="help-block"><p id="characterLeft" class="help-block ">You have reached the limit</p></span>                    
											</div>
											
										</div>
										<div class="modal-footer">
										  <input type="submit" value="send" class="btn btn-primary">
										</div>
									</form>
								  </div>

								</div>
							  </div>
						</section>
					</div>
				</div>
			</main>
			<br>
			<br>
			<br>
			<br>
			<br>
			<?php require 'include/footer.php'; ?>
			
		</div>
	
	</body>
</html>
