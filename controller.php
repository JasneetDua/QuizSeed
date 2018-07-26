<?php
session_start();
require 'include/functions.php';

if( isset($_SESSION["uname"]) && isset($_SESSION["cat"]) )
{
	redirect();
}

else
{
	if(validate_cookie()) {	
			redirect();
	}
	else {
			header('Location:index.php');
	}
}

?>