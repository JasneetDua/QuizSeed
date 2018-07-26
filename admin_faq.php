<?php
	session_start();
	require 'include/variables.php';
	require 'include/functions.php';
	check_user("admin");

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
		while($row = mysqli_fetch_assoc($result)) 
		{
			$faq[] = $row;
		}
	}



	$msg="";				//overide msg to display after operation
	$qNumber="";			//declaration

	if(isset($_GET['q'])){
		$qNumber  = $_GET['q'] ;
	}

	if(isset($_GET['request']) && $_GET['request']=="edit"){
		

		$edit="";
		
		foreach ($faq as $n=>$c)
		  if ($c['sno'] == $qNumber) {
			$edit=$c;
			break;
		  }

		if(end($faq)['sno'] < $qNumber || $qNumber=="" || $edit=="") //url Validate
		{
			header("Location:admin_faq.php");
			exit();
		}

		
		if(isset($_POST['sno']) && isset($_GET['q']))
		{
			if( is_numeric($_POST['sno']) && !($_POST['ques']=="") && !($_POST['ans']=="") )
			{	
				$sno = $_POST['sno'];
				$ques = $_POST['ques'];
				$ans = $_POST['ans'];
				
				$sql = "UPDATE faq SET sno = '$sno', ques = '$ques', ans = '$ans' WHERE sno = $qNumber";

					if (mysqli_query($con,$sql)) {
						$msg = $alert_success." FAQ Successfully Updated :) Please Refresh the Page to See Changes".$alert_end;
						
					} else {
						$msg = $alert_danger." Something went Wrong :( ".$alert_end;
					}	

			}
			else
			{
				$msg = $alert_danger." Please Provide Proper Data to Update ".$alert_end;
			}			
			unset($_GET['request']);
		}
	}

	if(isset($_GET['request']) && $_GET['request']=="add") {

		$qNumber = sizeof($faq)+1;

		if(isset($_POST['sno']))
		{
			if( is_numeric($_POST['sno']) && !($_POST['ques']=="") && !($_POST['ans']=="") )
			{	
				$sno = $_POST['sno'];
				$ques = $_POST['ques'];
				$ans = $_POST['ans'];
				
				$sql = "INSERT INTO faq (sno,ques,ans) VALUES ('$sno', '$ques', '$ans')";

					if (mysqli_query($con,$sql)) {
						$msg = $alert_success." FAQ Successfully Added :) Please Refresh the Page to See Changes".$alert_end;
					} else {
						$msg = $alert_danger." Something went Wrong :( ".$alert_end;
					}	

			}
			else
			{
				$msg = $alert_danger." Please Provide Proper Data to Add FAQ ".$alert_end;
			}
			unset($_GET['request']);
		}
		
	}

	if(isset($_GET['request']) && $_GET['request']=="delete")
	{		
		$edit="";
		
		foreach ($faq as $n=>$c)
		  if ($c['sno'] == $qNumber) {
			$edit = $c;
			break;
		 }

		if(end($faq)['sno'] < $qNumber || $qNumber=="" || $edit=="") //url Validate with qno
		{
			header("Location:admin_faq.php");
			exit();
		}
		
		$sql = "DELETE FROM faq WHERE sno = $qNumber";

			if (mysqli_query($con,$sql)) {
				$msg = $alert_success." FAQ Successfully Deleted :) Please Refresh the Page to See Changes".$alert_end;

			} else {
				$msg = $alert_danger." Something went Wrong :( ".$alert_end;
			}	
		
	unset($_GET['request']);		
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
				<?php
					
					if(!isset($_GET['request']))
					{					
					?>
						<h1>FAQ's</h1>
						<hr>
						<div class="row">
							<div class="col-md-12">
									<?php
											echo $msg;
						
											foreach($faq as $qna)
											{

												echo "<div class='faq'>",
														"<div class='faq_question'>";

												echo "<a class='badge button' href='admin_faq.php?q=",$qna['sno'],"&request=edit'>Edit</a>
														
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
								<br>
								<a class="btn btn-primary" href="./admin_faq.php?request=add">Add More</a>
							</div>
					  	</div>
					
					<?php
					}
					elseif($_GET['request']=="edit")
					{		
					?>
						<h1>Edit FAQ</h1>
						<hr>
						<div class="row">
							<div class="col-md-12">
								
								<form action="admin_faq.php?request=edit&q=<?php echo $qNumber ?>" method="post"  class="form-horizontal" role="form">
									<div class="form-group">
										<label class="col-md-3 control-label">Q.No. :</label>
										<div class="col-md-2">
											<input type="number" class="form-control" name="sno" value="<?php echo $qNumber?>" required>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label">Question :</label>
										<div class="col-md-8">
											<textarea class="form-control" name="ques" rows="4" required><?php echo $edit['ques']?></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">Answer :</label>
										<div class="col-md-8">
											<textarea class="form-control" name="ans" rows="8" required><?php echo $edit['ans']?></textarea>
										</div>
									</div>
									<br>
									<br>
									<div class="col-md-offset-3">
										<input type="submit" value="Save Changes" class="btn btn-primary">
										<a class="btn btn-default" href="admin_faq.php?request=delete&q=<?php echo $qNumber; ?>">Delete</a>
									</div>	
								</form>
							</div>
					  	</div>
					
					

					<?php	
					}
					elseif($_GET['request']=="add")
					{
					?>
					
						<h1>Add FAQ</h1>
						<hr>
						<div class="row">
							<div class="col-md-12">
								
								<form action="admin_faq.php?request=add" method="post" class="form-horizontal" role="form">
									<div class="form-group">
										<label class="col-md-3 control-label">Q.No. :</label>
										<div class="col-md-2">
											<input type="number" class="form-control" name="sno" value="<?php echo $qNumber?>" required>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label">Question :</label>
										<div class="col-md-8">
											<textarea class="form-control" name="ques" rows="4" required></textarea>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">Answer :</label>
										<div class="col-md-8">
											<textarea class="form-control" name="ans" rows="8" required></textarea>
										</div>
									</div>
									<br>
									<br>
									<div class="col-md-offset-3">
										<input type="submit" value="Add FAQ" class="btn btn-primary">
										<a class="btn btn-default" href="admin_faq.php">Cancel</a>
									</div>	
								</form>
							</div>
					  	</div>

					
					
					
					
					<?php
					}
					else
					{
						echo $alert_danger,"Unknown Request Error",$alert_end;
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
