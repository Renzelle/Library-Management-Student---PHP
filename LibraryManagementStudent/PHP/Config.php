<?php
	/*database credentials*/
	define('DB_SERVER', '127.0.0.1');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'libraryManagementStudent');

	/* attempt to connect to MYSQL database */
	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	//check if successful
	if($link === false)
	{
		die("ERROR: Could not connect " . mysqli_connect_error());
	}

	//time zone
	date_default_timezone_set('Asia/Manila');
?>