<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");

		if ($result = @$connection->query(
		sprintf("SELECT * FROM users WHERE email='%s'",
		mysqli_real_escape_string($connection,$login))))
		{
			$numberUsers = $result->num_rows;
			
			if($numberUsers>0)
			{
				$verse = $result->fetch_assoc();
				
				if (password_verify($password, $verse['password']))
				{
					$_SESSION['logged'] = true;
					$_SESSION['id'] = $verse['id'];
					$_SESSION['username'] = $verse['username'];
					$_SESSION['email'] = $verse['email'];
					
					unset($_SESSION['error']);
					$result->free_result();
					header('Location: mainPage.php');
				}
				else
				{
					$_SESSION['error'] = '<span>Nieprawidłowy e-mail lub hasło!</span>';
					header('Location: index.php');
				}
				
			}
			else 
			{		
				$_SESSION['error'] = '<span>Nieprawidłowy e-mail lub hasło!</span>';
				header('Location: index.php');
			}
			
		}
		
		$connection->close();
	}
	
?>