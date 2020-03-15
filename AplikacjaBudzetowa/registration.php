<?php

	session_start();//zeby tablica session działała,globalny pojemnik na dane
	
	//////////////////rejestracja///////////////////////////
	if (isset($_SESSION['error'])) unset($_SESSION['error']);
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$allOK=true;
		
		//Sprawdź poprawność nickname'a
		$nick = $_POST['nick'];
		
		//Sprawdzenie długości nicka
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$allOK=false;
			$_SESSION['e_nick']="Imię musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$allOK=false;
			$_SESSION['e_nick']="Imię może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$allOK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1)<8) || (strlen($password1)>20))
		{
			$allOK=false;
			$_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($password1!=$password2)
		{
			$allOK=false;
			$_SESSION['e_password']="Podane hasła nie są identyczne!";
		}	

		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
			
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password1'] = $password1;
		$_SESSION['fr_password2'] = $password2;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$result = $connection->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$result) throw new Exception($connection->error);
				
				$howManyEmails = $result->num_rows;
				if($howManyEmails>0)
				{
					$allOK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		
				
				if ($allOK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
					if ($connection->query("INSERT INTO users VALUES (NULL, '$nick', '$password_hash', '$email')"))
					{
						$_SESSION['successfulRegistration']=true;
						$user_id = $connection->insert_id;//pobieranie id po rejestracji
						
						$connection->query("INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT '$user_id', name FROM incomes_category_default");
						
						$connection->query("INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT '$user_id', name FROM expenses_category_default");
						
						$connection->query("INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT '$user_id', name FROM payment_methods_default");
						
						$_SESSION['successfulRegistration']=true;
						
						header('Location: welcome.php');
					}
					else
					{
						throw new Exception($connection->error);
					}
					
				}
				
				$connection->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
?>

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Aplikacja budżetu osobistego</title>
	<meta name="description" content="Aplikacja do prowadzenia budżetu osobistego">
	<meta name="keywords" content="budzet, budżet, aplikacja, finanse, prowadzenie budżetu">
	<meta name="author" content="Kamil Pieraszko">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="cssFontello/fontello.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Philosopher&display=swap" rel="stylesheet">
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="img/portfel.png"> <!--ikonka w zakładce-->

	<!--<script src="date.js"></script>-->
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
</head>

<body>

	<header>

		<div class="logo2">
		<img src="img/napis5.png" class="img-fluid" alt="logo"/>
		</div>
	</header>
	
	<main>
		
		<section>
		
			<div class="container register mt-1">
			
                <div class="row">
				
                    <div class="col-lg-3 register-left">
						<div id="icon"><i class="icon-money-1"></i></div>
                        <h3>Witaj w aplikacji Personal Budget</h3>
                        <p>Aplikacja pomoże Ci w prowadzeniu swojego własnego budżetu, wystarczy się tylko zarejestrować i zalogować.</p>
                    </div>
					
                    <div class="col-lg-9 register-right">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a href="index.php" class="nav-link">Logowanie</a>
                            </li>
                            <li class="nav-item">
                                <a href="registration.php" class="nav-link active">Rejestracja</a>
                            </li>
                        </ul>
								
						<form method="post">
					
							<h3 class="register-heading">Rejestracja użytkownika</h3>
							
							<div class="row register-form">
							  
								<div class="col-md-10 inputs offset-md-1">

									<div class="form-group col-md-9 mx-auto">
										<div class="icons">
											<i class='icon-user'></i>
										</div>
										<input id="imie" name="nick" type="text" class="form-control" placeholder="Imię *" value="<?php
											if (isset($_SESSION['fr_nick']))
											{
												echo $_SESSION['fr_nick'];
												unset($_SESSION['fr_nick']);
											}
										?>" />
										<?php
											if (isset($_SESSION['e_nick']))
											{
												echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
												unset($_SESSION['e_nick']);
											}
										?>
									</div>     

									<div class="form-group col-md-9 mx-auto">
										<div class="icons">
											<i class='icon-email'></i>
										</div>
										<input type="email" name="email" class="form-control" placeholder="Email *" value="<?php
											if (isset($_SESSION['fr_email']))
											{
												echo $_SESSION['fr_email'];
												unset($_SESSION['fr_email']);
											}
										?>" />
										<?php
											if (isset($_SESSION['e_email']))
											{
												echo '<div class="error">'.$_SESSION['e_email'].'</div>';
												unset($_SESSION['e_email']);
											}
										?>
									</div>
									
									<div class="form-group col-md-9 mx-auto">
										<div class="icons">
											<i class='icon-lock-filled'></i>
										</div>
										<input type="password" name="password1" class="form-control" placeholder="Hasło *"  value="<?php
											if (isset($_SESSION['fr_password1']))
											{
												echo $_SESSION['fr_password1'];
												unset($_SESSION['fr_password1']);
											}
										?>"/>
										<?php
											if (isset($_SESSION['e_password']))
											{
												echo '<div class="error">'.$_SESSION['e_password'].'</div>';
												unset($_SESSION['e_password']);
											}
										?>
									</div>
									
									<div class="form-group col-md-9 mx-auto">
										<div class="icons">
											<i class='icon-lock-filled'></i>
										</div>
										<input type="password" name="password2" class="form-control" placeholder="Powtórz hasło *" value="<?php
											if (isset($_SESSION['fr_password2']))
											{
												echo $_SESSION['fr_password2'];
												unset($_SESSION['fr_password2']);
											}
										?>"/>	
									</div>
									
								</div>
				
								<div class="col-md-12">
									
									<input type="submit" class="btnRegister" value="Zarejestruj się"/>
									
								</div>
								
							</div>
							
						</form>
						
                    </div>
					
                </div>

            </div>							
				
		</section>
		
	</main>
	
	<footer>
		
		<div class="info">
			All rights reserved &copy; 2020, Personal Budget created by Kail
		</div>
	
	</footer>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	<script src="jquery-3.2.1.min.js"></script><!--musi byc powyżej pliku,js-->
	
</body>
</html>