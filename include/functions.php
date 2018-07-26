<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function check_session(){
	if(!isset($_SESSION["uname"]))
	{
		header('Location:controller.php');
		exit();		
	}
}

function check_user($cat){
	
	if(isset($_SESSION["uname"]) && isset($_SESSION["cat"]))
	{
		if(!($_SESSION["cat"] == $cat))
		{
					header('Location:controller.php');
		}
	}
	else
	{
		if(validate_cookie()) 
		{	
				if(!($_SESSION["cat"] == $cat))
				{
					header('Location:controller.php');
				}
		}
		else 
		{
			header('Location:index.php');
		}
	
	}
}


function validate_cookie(){
	
	if( isset($_COOKIE["uname"]) && isset($_COOKIE["pass"]) && isset($_COOKIE["cat"]) )
	{
			require 'variables.php';

			$name = $_COOKIE["uname"];
			$pass = $_COOKIE["pass"];
			$cat = $_COOKIE["cat"];
		
			$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
			
			if (!$con) 
			{
				die("Connection failed: " . mysqli_connect_error());
			}

			$sql = "SELECT * FROM user WHERE uname='$name' and pass='$pass' and cat='$cat' ";

			$result = mysqli_query($con, $sql);

			if (mysqli_num_rows($result) > 0) 
			{
				$row = mysqli_fetch_assoc($result);
				
				$_SESSION["uname"] = $row["uname"];
				$_SESSION["cat"] = $row["cat"];

				mysqli_close($con);				
				return true;
			}		
			mysqli_close($con);
	}
	return false;
}

function redirect()
{		
	if($_SESSION["cat"] == "student"){
				header('Location:student_home.php');
	}

	if($_SESSION["cat"] == "examiner"){
				header('Location:examiner_home.php');
	}
	
	if($_SESSION["cat"] == "admin"){
				header('Location:admin_home.php');
	}
}


?>