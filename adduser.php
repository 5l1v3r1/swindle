<?php
	session_start();
	$host = "host";
	$dbname = "dbname";
	$user = "user";
	$password = "password";

	function dbConnexion($host,$dbname,$user,$password)
	{
		return new PDO('mysql:host='.$host.';dbname='.$dbname.'',$user,$password);
	}

	$skype = isset($_POST['skype']) ? $_POST['skype'] : 0;
	$username = isset($_SESSION['username']) ? $_SESSION['username'] : 0;
	$fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 0;
	if(!isset($_SESSION['email']))
		$email = isset($_POST['email']) ? $_POST['email'] : 0;
	else
		$email = $_SESSION['email'];
	$stats = isset($_SESSION['stats']) ?$_SESSION['stats'] : 0;

	if(!empty($skype) && !empty($username) && !empty($fullname) && !empty($email) && !empty($stats)){
		$DB = dbConnexion($host,$dbname,$user,$password);
		$querySearch = 'SELECT count(*) FROM '.$dbname.' WHERE email = :email';
		$queryInsert = 'INSERT INTO '.$dbname.' (username, fullname, email, skype, stats)
				VALUES (?, ?, ?, ?, ?)';
		
		try
		{
			$search = $DB->prepare($querySearch);
			$search->execute(array(':email' => $email));
			$v = $search->fetch();
			if($v[0] == 0){
				$insert = $DB->prepare($queryInsert);
				$insert->execute(array($username,$fullname,$email,$skype,$stats));
			}
		} 				
		catch(PDOException $e)
		{
	  		echo "Error, pdoException.";
		}
		echo "ok";
	}
	else
		echo "Error, empty fields.";
?>