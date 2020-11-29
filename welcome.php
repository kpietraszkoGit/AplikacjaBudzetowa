<?php
	session_start();
	
	if (!isset($_SESSION['successfulRegistration']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['successfulRegistration']);
	}

	if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_password1'])) unset($_SESSION['fr_password1']);
	if (isset($_SESSION['fr_password2'])) unset($_SESSION['fr_password2']);

	if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
	
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
				
			<div class="tab-content" id="myTabContent">


				<h3 class="register-heading">Rejestracja powiodła się!</h3>

				<div class="row description-form">

				 <p class="description">Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto!</p>

				 <img src="img/kobieta2.png" alt="money" class="img-fluid" />

				</div>

			</div>
						
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
	<script src="jquery-3.2.1.min.js"></script>
	
</body>
</html>
