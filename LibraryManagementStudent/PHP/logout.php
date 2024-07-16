<?php
	session_start();
	unset($_SESSION['username']);
	unset($_SESSION['course']);
	header("location: mainpage.php");
?>