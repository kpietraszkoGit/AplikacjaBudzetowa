<?php

	session_start();//zeby tablica session działała,globalny pojemnik na dane	
	
	if (isset($_SESSION['ok'])) unset($_SESSION['ok']);
	
	if (!isset($_SESSION['logged']))//jesli zmienna nie bedzie ustawiona, czyli zalogowani nie bedziemy
	{
		header('Location: index.php');
		exit();
	}
	
	if (isset($_POST['amount']))
	{
		$user_id = $_SESSION['id'];
		$amount = $_POST['amount'];
		$day = $_POST['day'];
		$pay= $_POST['pay'];
		$category = $_POST['category'];
		$comment = $_POST['comment'];
		

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
					if($connection->query("INSERT INTO expenses VALUES (NULL, '$user_id', '$category ', '$pay ', '$amount', '$day', '$comment')"))
					{
						$_SESSION['ok2'] = '<span>Wydatek został dodany!</span>';
					}
					else
					{
						throw new Exception($connection->error);
					}
					
					$connection->close();
				}
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!</span>';
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
	
	<script src="date.js"></script>
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
</head>

<body onload="today();">

	<header>
		
		<div class="logo2">
		<img src="img/napis5.png" class="img-fluid" alt="logo"/>
		</div>
		<!--<h1 class="logo">Personal Budget<i class="icon-money"></i></h1>-->
		<!--<p id="quotation">"Bądź oszczędnym, abyś mógł być szczodrym." – Aleksander Fredro</p>-->
		<nav class="navbar navbar-custom bg-gold navbar-expand-lg mb-4 mt-1 menu"><!--navbar-dark cimny kolor logo, bg-primary-kolor tła, navbar-expand-md- menu rozwijaj sie od widoku medium, lg-od dużego rozmiaru-->
		
			<a class="navbar-brand" href="#"></a><!--d-display, mr-1-margin right rozmiar 1, align-bottom- wyrównanie do dołu -->
			
			<button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"><i class="icon-menu"></i></span>
			</button>
		
			<div class="collapse navbar-collapse" id="mainmenu"><!--zapadniecie się menu, schowanie się-->
				
				<ul class="navbar-nav mx-auto"><!--mr-auto-margin automatyczny-->
				
					<li class="nav-item"><!--trzeba pisać takie klasy, active-wyróżniona zakładka w menu-->
						<a class="nav-link" href="mainPage.php"><i class="icon-home"></i> Strona Główna </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="addIncome.php"><i class="icon-dollar"></i> Dodaj Przychód </a>
					</li>
					
					<li class="nav-item active">
						<a class="nav-link" href="addExpense.php"><i class="icon-bag"></i> Dodaj Wydatek </a>
					</li>
					
					<!--<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true"><i class="icon-home"></i> Przeglądaj Bilans </a>
						
						<div class="dropdown-menu" aria-labelledby="submenu">
						
							<a class="dropdown-item" href="#"> Bieżący miesiąc </a>
							<a class="dropdown-item" href="#"> Poprzedni miesiąc </a>
							
							<div class="dropdown-divider"></div>
							
							<a class="dropdown-item" href="#"> Bieżący rok </a>
							<a class="dropdown-item" href="#"> Niestandardowy </a>
						
						</div>
						
					</li>-->
					
					<li class="nav-item">
						<a class="nav-link" href="monthlyBalance.php"><i class="icon-chart-bar"></i> Przeglądaj Bilans </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="icon-cog"></i> Ustawienia </a><!--disabled-opcja wyszarzona, nieaktywna-->
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
                       <!-- <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>-->
						<div id="icon"><i class="icon-money-1"></i></div>
                        <!--<div class="welcome col-md-12">Witaj</div>
						<div id="name2" class="welcome col-md-12 mb-1">Kamil</div>-->
						<!--<h3>Witaj Kamil</h3>-->
                        <p> "Sposoby wzbogacania się są liczne. Oszczędzanie jest jednym z najlepszych." <br> – Francis Bacon –</p>
                    </div>
					
                    <div class="col-lg-9 register-right">
                        
						
                        <div class="tab-content" id="myTabContent">
						
							<form method="post">
							
                                <h3 class="register-heading2">Wprowadź dane wydatku:</h3>
								
                                <div class="row register-form">
								
                                    <div class="col-md-10 inputs offset-md-1">

                                        <div class="form-group col-md-9 mx-auto">
											<div class="icons">
												<i class='icon-pencil'></i>
											</div>
											<input type="number"  class="form-control" name="amount" step="0.01" placeholder="Kwota *" value="" required />
                                        </div>     
										
										<div class="form-group col-md-9 mx-auto">
											<div class="icons">
												<i class='icon-calendar'></i>
											</div>
											<input type="date" id="days"  class="form-control" name="day" value="" min="1900-01-01" max="2500-01-01" required />
                                        </div>
										
										<div class="form-group col-md-9 mx-auto">
											<div class="icons">
												<i class='icon-wallet'></i>
											</div>
											<select class="form-control category" name="pay">
											
												<option value="0" selected disabled>Sposób płatności *</option>
												<option value="1">Gotówka</option>
												<option value="2">Karta debetowa</option>
												<option value="3">Karta kredytowa</option>
											
											</select>
                                        </div>
										
                                        <div class="form-group col-md-9 mx-auto">
											<div class="icons">
												<i class='icon-list-bullet'></i>
											</div>
											<select class="form-control category" name="category">
											
												<option value="0" selected disabled>Kategorie wydatku *</option>
												<option value="1">Transport</option>
												<option value="2">Książki</option>
												<option value="3">Jedzenie</option>
												<option value="4">Mieszkanie</option>
												<option value="5">Telekomunikacja</option>
												<option value="6">Opieka zdrowotna</option>
												<option value="7">Ubranie</option>
												<option value="8">Higiena</option>
												<option value="9">Dzieci</option>
												<option value="10">Rozrywka</option>
												<option value="11">Wycieczka</option>
												<option value="12">Oszczędności</option>
												<option value="13">Na emeryture</option>
												<option value="14">Spłata długów</option>
												<option value="15">Darowizna</option>
												<option value="16">Inne...</option>
											
											</select>
                                        </div>
										
										<div class="form-group col-md-9 mx-auto">
											<div class="icons">
												<i class='icon-pencil'></i>
											</div>
                                            <input type="text" class="form-control" placeholder="Komentarz *" name="comment"
											value="" />
                                        </div>
										
                                    </div>
									
									<?php
										if(isset($_SESSION['ok2']))
										{	
											 echo "<div id='name2' class='add'>".$_SESSION['ok2']."</div>";
										}
									?>
							
									<div class="col-md-12 buttonsExpense">
									
										<input type="submit" class="btn-success btnRegister2"  value="Dodaj"/>
										
										<input type="reset" class="btn-danger btnRegister2"  value="Anuluj"/>
									
									</div>
										
									<!--</div>
									
									<div class="col-sm-6 buttons">
										
										<input type="submit" class="btn-success btnRegister2"  value="Dodaj"/>
										
									</div>-->

                                </div>
								
							</form>	
							
                        </div>
						
                    </div>
					
                </div>

            </div>
				
		</section>
		
	</main>
	
	<footer>
		
		<div class="info">
			Wszelkie prawa zastrzeżone &copy; 2019 Dziękuję za wizytę!
		</div>
	
	</footer>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	<script src="jquery-3.2.1.min.js"></script><!--musi byc powyżej pliku,js-->
	
</body>
</html>