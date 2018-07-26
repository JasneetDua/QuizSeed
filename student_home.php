<?php

session_start();
require 'include/functions.php';
require 'include/variables.php';
check_user("student");
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
						<a class="navbar-brand logo" href="student_home.php">
							<i>Student Home</i>
						</a>

						<button class="collapsed navbar-toggle x" data-toggle="collapse" data-target="#ShowNav">
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
							<i class="icon-bar"></i>
						</button>
					</nav>
					
					<nav class="collapse navbar-collapse" id="ShowNav">
							<ul class="nav navbar-nav navbar-right">
								<li class="active"><a href="#">Home</a></li>
								<li><a href="student_history.php">History</a></li>
								<li><a href="student_ranking.php">Ranking</a></li>
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

<?php
						
$uname = $_SESSION['uname'];						
$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

if(@$_GET['q']==null)
{
	echo "<h2>Availabe Test</h2><hr>";
	$result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');

	echo  '
	<div class="panel">
	<div class="table-responsive">
	<table class="table table-striped title1">
	<tr>
		<td><b>S.N.</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td>
	</tr>';

	$c=1;
	while($row = mysqli_fetch_array($result)) {
		$title = $row['title'];
		$total = $row['total'];
		$correct = $row['correct'];
		$time = $row['time'];
		$eid = $row['eid'];

		$q12=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND uname='$uname'" )or die('Error98');
		$rowcount=mysqli_num_rows($q12);	

		if($rowcount == 0)
		{
		echo '<tr>
				<td>'.$c++.'</td><td>'.$title.'</td><td>'.$total.'</td><td>'.$correct*$total.'</td><td>'.$time.'&nbsp;min</td>
		<td><b>
		<a href="student_home.php?q=quiz&step=1&eid='.$eid.'&n=1&t='.$total.'" class="pull-right btn sub1" style="margin:0px;background:#99cc32"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></td></tr>';
		}
		else
		{
			echo '<tr style="color:#99cc32"><td>'.$c++.'</td><td>'.$title.'&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>'.$total.'</td><td>'.$correct*$total.'</td><td>'.$time.'&nbsp;min</td>
		<td><b>
		<a href="#" class="pull-right btn sub1 disabled" style="margin:0px;background:red"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Attempted</b></span></a></b></td></tr>';
		}
	}
	$c=0;
	echo '</table></div></div>';
}
						
else if(@$_GET['q']== 'quiz' && @$_GET['step']==1) 
{
	$eid=@$_GET['eid'];
	$sn=@$_GET['n'];
	$total=@$_GET['t'];
		
	
	//---------------------Timer Start Coding Goes Here -----------------------//
		if($sn==1 && !isset($_SESSION['count_down']))
		{
			$fetch_time = mysqli_query($con,"SELECT * FROM quiz WHERE eid ='$eid'") or die('Error');			
			$row = mysqli_fetch_array($fetch_time);	
			
			$time_up = time(); //current time			
			$time_up = strtotime("+".$row['time']." min", $time_up); //ending time = current + fetch
			
			$_SESSION['count_down'] = $time_up;
		}
	//-----------------------------------------------------------------------------
	
	
	
	$q = mysqli_query($con,"SELECT * FROM questions WHERE eid='$eid' AND sn='$sn' " );
	
	echo '
 			<div class="text-right"><span id="timer" class="well"></span></div>
		  <h2>Test</h2>
		  <hr>';
		
	echo '<div class="panel" style="margin:5%">';
	
	while( $row=mysqli_fetch_array($q) )
	{
		$qns=$row['qns'];
		$qid=$row['qid'];
		echo '<b>Question &nbsp;'.$sn.'&nbsp;::<br />'.$qns.'</b><br /><br />';
	}
	$q=mysqli_query($con,"SELECT * FROM options WHERE qid='$qid' " );
	echo '<form action="student_home.php?q=quiz&step=2&eid='.$eid.'&n='.$sn.'&t='.$total.'&qid='.$qid.'" method="POST"  class="form-horizontal">
	<br />';

	while($row=mysqli_fetch_array($q) )
	{
		$option=$row['option'];
		$optionid=$row['optionid'];
		echo'<input type="radio" name="ans" value="'.$optionid.'">'.$option.'<br /><br />';
	}
	echo'<br /><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;Submit</button></form></div>';
	
	?>
						
		<script>
			// Set the date we're counting down to
			var countDownDate = new Date("<?php echo date("F d, Y H:i:s", $_SESSION['count_down']); ?>").getTime();
			var  start = new Date("<?php echo date("F d, Y H:i:s", time() ); ?>");
			
			// Update the count down every 1 second
			var x = setInterval(function() {

				start.setSeconds(start.getSeconds() + 1);
				// Get todays date and time
				var now = start.getTime();

				// Find the distance between now an the count down date
				var distance = countDownDate - now;

				// Time calculations for days, hours, minutes and seconds
				var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance % (1000 * 60)) / 1000);

				// Output the result in an element with id="timer"
				if(days == 0)
				{
					document.getElementById("timer").innerHTML = " Time Left : " + hours + "h " + minutes + "m " + seconds + "s ";
				}
				else 
				{
					document.getElementById("timer").innerHTML = " Time Left : " + days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
				}
				
				// If the count down with 1 min left 				
				if (distance == (1000 * 60)) {
					alert("Only 1 Minute Left");
				}

				
				// If the count down is over, write some text 
				if (distance < 0) {
					
					clearInterval(x);
					window.location ="student_home.php?<?php echo "q=quiz&step=2&eid='.$eid.'&n='.$total.'&t='.$total.'&qid='.$qid"; ?>";
				}
			}, 1000);
</script>
					
						
	<?php
	
}
						
else if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) 
{
		$eid=@$_GET['eid'];
		$sn=@$_GET['n'];
		$total=@$_GET['t'];
		$ans = 0;		
		if(isset($_POST['ans'])){
			$ans=$_POST['ans'];
		}
	
		$qid=@$_GET['qid'];
	
		$q=mysqli_query($con,"SELECT * FROM answer WHERE qid='$qid' " );
		while($row=mysqli_fetch_array($q) )
		{
			$ansid=$row['ansid'];
		}
		if($ans == $ansid)
		{
			$q=mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' " );
			while($row=mysqli_fetch_array($q) )
			{
				$correct=$row['correct'];
			}
			if($sn == 1)
			{
				$q=mysqli_query($con,"INSERT INTO history VALUES('$uname','$eid' ,'0','0','0','0',NOW())")or die('Error');
			}
			
			$q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND uname='$uname' ")or die('Error115');

			while($row=mysqli_fetch_array($q) )
			{
				$s=$row['score'];
				$r=$row['correct'];
			}
			$r++;
			$s=$s+$correct;
			$q=mysqli_query($con,"UPDATE `history` SET `score`=$s,`level`=$sn,`correct`=$r, date= NOW()  WHERE  uname = '$uname' AND eid = '$eid'")or die('Error124');
		} 
		else
		{
			$q=mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' " )or die('Error129');

			while($row=mysqli_fetch_array($q) )
			{
				$wrong=$row['wrong'];
			}
			if($sn == 1)
			{
				$q=mysqli_query($con,"INSERT INTO history VALUES('$uname','$eid' ,'0','0','0','0',NOW() )")or die('Error137');
			}
			$q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND uname='$uname' " )or die('Error139');
			while($row=mysqli_fetch_array($q) )
			{
				$s=$row['score'];
				$w=$row['wrong'];
			}
			$w++;
			$s=$s-$wrong;
			$q=mysqli_query($con,"UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w, date=NOW() WHERE  uname = '$uname' AND eid = '$eid'")or die('Error147');
		}
		if($sn != $total)
		{
			$sn++;
			header("location:student_home.php?q=quiz&step=1&eid=$eid&n=$sn&t=$total")or die('Error152');
		}
		else
		{
			
			//---------------------Timer Destroy Coding Goes Here -----------------------//
			
			
				unset($_SESSION['count_down']);	
			
			
			//-----------------------------------------------------------------------------
			
			
			$q=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND uname='$uname'" )or die('Error156');
			while($row=mysqli_fetch_array($q) )
			{
				$s=$row['score'];
			}
			
			$q=mysqli_query($con,"SELECT * FROM rank WHERE uname='$uname'" )or die('Error161');
			$rowcount=mysqli_num_rows($q);
			
			if($rowcount == 0)
			{
				$q2=mysqli_query($con,"INSERT INTO rank VALUES('$uname','$s',NOW())")or die('Error165');
			}
			else
			{
				while($row=mysqli_fetch_array($q) )
				{
					$sun=$row['score'];
				}
				$sun=$s+$sun;
				$q=mysqli_query($con,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE uname= '$uname'")or die('Error174');
			}
			header("location:student_home.php?q=result&eid=$eid");
		}
}						
elseif ( @$_GET['q']== 'result' && @ $_GET['eid']) 
{
	$eid=@$_GET['eid'];
	
	$q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND uname='$uname' " )or die('Error157');
	echo  '<div class="panel">
	<center><h1 class="title" style="color:#660033">Exam Result</h1><center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';

	while($row=mysqli_fetch_array($q) )
	{
	$s=$row['score'];
	$w=$row['wrong'];
	$r=$row['correct'];
	$qa=$row['level'];
	echo '<tr style="color:#66CCFF"><td>Total Questions</td><td>'.$qa.'</td></tr>
		  <tr style="color:#99cc32"><td>right Answer&nbsp;<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></td><td>'.$r.'</td></tr> 
		  <tr style="color:red"><td>Wrong Answer&nbsp;<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></td><td>'.$w.'</td></tr>
		  <tr style="color:#66CCFF"><td>Score&nbsp;<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td><td>'.$s.'</td></tr>';
	}
	$q=mysqli_query($con,"SELECT * FROM rank WHERE  uname='$uname' " )or die('Error157');
	while($row=mysqli_fetch_array($q) )
	{
	$s=$row['score'];
	echo '<tr style="color:#990000">
		<td>Overall Score&nbsp;<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td>
		<td>'.$s.'</td></tr>';
	echo '<tr style="color:#990000">
		
		<td colspan="2" align="center"><a href="student_home.php" class="btn btn-success">Home</a></td></tr>';

	}
	echo '</table></div>';

}
						
else if(@$_GET['q']== 'quizre') 
{
	$eid=@$_GET['eid'];
	$n=@$_GET['n'];
	$t=@$_GET['t'];
	$q=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND uname='$uname'" )or die('Error156');
	while($row=mysqli_fetch_array($q) )
	{
		$s=$row['score'];
	}
	$q=mysqli_query($con,"DELETE FROM `history` WHERE eid='$eid' AND uname='$uname' " )or die('Error184');
	$q=mysqli_query($con,"SELECT * FROM rank WHERE uname='$uname'" )or die('Error161');
	while($row=mysqli_fetch_array($q) )
	{
		$sun=$row['score'];
	}
	$sun=$sun-$s;
	$q=mysqli_query($con,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE uname= '$uname'")or die('Error174');
	header("location:student_home.php?q=quiz&step=1&eid=$eid&n=1&t=$t");
}						
	mysqli_close($con);		  
?>

						
						
						
						
						
						
					</div>
				</div>
		  	</main>
			<footer class="navbar navbar-fixed-bottom mainFooter blackFooter">Copyright &copy; <?php echo date('Y')?> QuizSeed. All Rights Reserved.</footer>
		</div>
	</body>
</html>
