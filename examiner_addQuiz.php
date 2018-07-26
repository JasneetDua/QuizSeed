<?php

session_start();
require 'include/functions.php';
require 'include/variables.php';
check_user("examiner");

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
						<a class="navbar-brand logo" href="examiner_home.php">
							<i>Examiner Home</i>
						</a>

						<button class="collapsed navbar-toggle x" data-toggle="collapse" data-target="#ShowNav">
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
						</button>
					</nav>
					
					<nav class="collapse navbar-collapse" id="ShowNav">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="examiner_home.php">Home</a></li>
								<li><a href="examiner_user.php">User</a></li>
								<li><a href="examiner_ranking.php">Ranking</a></li>
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
											<li class="divider"></li>
											<li><a href="./profile.php"> Profile </a></li>
										</ul>
								</li>
							</ul>
					</nav>
				</div>
			</header>
			
			<main class="row">
	<div class="container">
      <div class="row">
		  <h2>Add Quiz</h2>
		  <hr>

<?php
$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
$uname  = $_SESSION['uname'];
		  
if(@$_GET['q']=='success' && @$_GET['step']==3) 
{
	echo $alert_success,"Quiz Added",$alert_end;
	
	echo "<a class='btn btn-primary' href='examiner_home.php'>Continue</a>";
}
		  
if(@$_GET['q']=='addquiz') 
{
	$name = $_POST['name'];
	$name= ucwords(strtolower($name));
	$total = $_POST['total'];
	$correct = $_POST['right'];
	$wrong = $_POST['wrong'];
	$time = $_POST['time'];
	$tag = $_POST['tag'];
	$desc = $_POST['desc'];
	$id=uniqid();

	$q3=mysqli_query($con,"INSERT INTO quiz VALUES  ('$id','$name' , '$correct' , '$wrong','$total','$time' ,'$desc','$tag',NOW(),'$uname')");
	
	header("location:examiner_addQuiz.php?step=2&eid=$id&n=$total");
}
	  
if(@$_GET['q']== 'addqns' ) 
{
	
$n=@$_GET['n'];
$eid=@$_GET['eid'];
$ch = 4;

for($i=1;$i<=$n;$i++)
{
	
$qid=uniqid();
$qns = $_POST['qns'.$i];
$q3=mysqli_query($con,"INSERT INTO questions VALUES  ('$eid','$qid','$qns' , '$ch' , '$i')");

$oaid=uniqid();
$obid=uniqid();
$ocid=uniqid();
$odid=uniqid();
	
$a=$_POST[$i.'1'];
$b=$_POST[$i.'2'];
$c=$_POST[$i.'3'];
$d=$_POST[$i.'4'];
$qa=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$a','$oaid')") or die('Error61');
$qb=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$b','$obid')") or die('Error62');
$qc=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$c','$ocid')") or die('Error63');
$qd=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$d','$odid')") or die('Error64');
$e=$_POST['ans'.$i];
switch($e)
{
case 'a':
$ansid=$oaid;
break;
case 'b':
$ansid=$obid;
break;
case 'c':
$ansid=$ocid;
break;
case 'd':
$ansid=$odid;
break;
default:
$ansid=$oaid;
}


$qans=mysqli_query($con,"INSERT INTO answer VALUES  ('$qid','$ansid')");

}
	
header("location:examiner_addQuiz.php?q=success&step=3");
}		  
		  
		  
		  
if(!(@$_GET['step']) ) {

echo '<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Quiz Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6">   
 <form class="form-horizontal title1" name="form" action="examiner_addQuiz.php?q=addquiz"  method="POST">
<fieldset>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="name"></label>  
  <div class="col-md-12">
  <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text">
    
  </div>
</div>



<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="total"></label>  
  <div class="col-md-12">
  <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="right"></label>  
  <div class="col-md-12">
  <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="wrong"></label>  
  <div class="col-md-12">
  <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="time"></label>  
  <div class="col-md-12">
  <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="tag"></label>  
  <div class="col-md-12">
  <input id="tag" name="tag" placeholder="Enter #tag which is used for searching" class="form-control input-md" type="text">
    
  </div>
</div>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="desc"></label>  
  <div class="col-md-12">
  <textarea rows="8" cols="8" name="desc" class="form-control" placeholder="Write description here..."></textarea>  
  </div>
</div>


<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';
	
}
	  
// add quiz step2 start -->
	
if((@$_GET['step'])==2) 
{
	
echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6">
 <form class="form-horizontal title1" name="form" action="examiner_addQuiz.php?q=addqns&n='.@$_GET['n'].'&eid='.@$_GET['eid'].'" method="POST">
<fieldset>';
 
 for($i=1;$i<=@$_GET['n'];$i++)
 {
echo '<b>Question number&nbsp;'.$i.'&nbsp;:</><br /><!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="qns'.$i.' "></label>  
  <div class="col-md-12">
  <textarea rows="3" cols="5" name="qns'.$i.'" class="form-control" placeholder="Write question number '.$i.' here..."></textarea>  
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'1"></label>  
  <div class="col-md-12">
  <input id="'.$i.'1" name="'.$i.'1" placeholder="Enter option a" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'2"></label>  
  <div class="col-md-12">
  <input id="'.$i.'2" name="'.$i.'2" placeholder="Enter option b" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'3"></label>  
  <div class="col-md-12">
  <input id="'.$i.'3" name="'.$i.'3" placeholder="Enter option c" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'4"></label>  
  <div class="col-md-12">
  <input id="'.$i.'4" name="'.$i.'4" placeholder="Enter option d" class="form-control input-md" type="text">
    
  </div>
</div>
<br />
<b>Correct answer</b>:<br />
<select id="ans'.$i.'" name="ans'.$i.'" placeholder="Choose correct answer " class="form-control input-md" >
   <option value="a">Select answer for question '.$i.'</option>
  <option value="a">option a</option>
  <option value="b">option b</option>
  <option value="c">option c</option>
  <option value="d">option d</option> </select><br /><br />'; 
 }
    
echo '<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';

} 

// add quiz step 2
		  
//<!--add quiz end-->

		  		  
mysqli_close($con);
		  
?>
		  
      </div>
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
