<?php
	session_start();
	
	if (isset($_SESSION['ok'])) unset($_SESSION['ok']);
	if (isset($_SESSION['ok2'])) unset($_SESSION['ok2']);
	
	if (!isset($_SESSION['logged']))
	{
		header('Location: index.php');
		exit();
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
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="img/portfel.png">
	
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->	

</head>

<body>

	<header>
		
		<div class="logo2">
		<img src="img/napis5.png" class="img-fluid" alt="logo"/>
		</div>
		
		<nav class="navbar navbar-custom bg-gold navbar-expand-lg mb-4 mt-1 menu">
		
			<a class="navbar-brand" href="#"></a>
			
			<button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"><i class="icon-menu"></i></span>
			</button>
		
			<div class="collapse navbar-collapse" id="mainmenu">
				
				<ul class="navbar-nav mx-auto">
				
					<li class="nav-item active">
						<a class="nav-link" href="mainPage.php"><i class="icon-home"></i> Strona Główna </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="addIncome.php"><i class="icon-dollar"></i> Dodaj Przychód </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="addExpense.php"><i class="icon-bag"></i> Dodaj Wydatek </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="monthlyBalance.php"><i class="icon-chart-bar"></i> Przeglądaj Bilans </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="icon-cog"></i> Ustawienia </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="logout.php"><i class="icon-logout"></i> Wyloguj się </a>
					</li>
				
				</ul>
			
			</div>
		
		</nav>
		
	</header>
	
	<main>
		
		<section>
		
		<div class="container register">
			
                <div class="row">

                    <div class="col-lg-3 register-left">
			<div id="icon"><i class="icon-money-1"></i></div>
			<div class="welcome col-md-12">Witaj</div>
			<?php
				echo "<div id='name2' class='welcome col-md-12 mb-1'>".$_SESSION['username']."</div>"
			?>	
                        <div class="col-md-12 mb-4">W menu głównym możesz wybrać opcje dodania przychodu i wydatku oraz przeglądać swój bilans finansowy z różnego okresu.</div>
                    </div>
					
                    <div class="col-lg-9 register-right">
                        					
                        <div class="tab-content" id="myTabContent">
						                      
                                <h3 class="register-heading">Logowanie powiodło się!</h3>
								
                                <div class="row description-form">
								
					<p class="description">Pierwszy krok do planowania swojego domowego budżetu wykonany. Co chcesz teraz zrobić?</p>

					<img src="img/mysliciel.png" alt="money" class="img-fluid" />
									
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
