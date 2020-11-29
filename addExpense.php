<?php

	session_start();	
	
	if (isset($_SESSION['ok'])) unset($_SESSION['ok']);
	
	if (!isset($_SESSION['logged']))
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
				if($connection->query("INSERT INTO expenses (id, user_id, amount, date_of_expense, expense_comment,  expense_category_assigned_to_user_id, payment_method_assigned_to_user_id) VALUES (NULL, '$user_id', '$amount', '$day', '$comment', (SELECT id FROM expenses_category_assigned_to_users WHERE name='$category' AND user_id='$user_id'), (SELECT id FROM payment_methods_assigned_to_users WHERE name='$pay' AND user_id='$user_id'))"))
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
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="img/portfel.png"> <!--ikonka w zakładce-->
	
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

		<nav class="navbar navbar-custom bg-gold navbar-expand-lg mb-4 mt-1 menu">
		
			<a class="navbar-brand" href="#"></a>
			
			<button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"><i class="icon-menu"></i></span>
			</button>
		
			<div class="collapse navbar-collapse" id="mainmenu">
				
				<ul class="navbar-nav mx-auto">
				
					<li class="nav-item">
						<a class="nav-link" href="mainPage.php"><i class="icon-home"></i> Strona Główna </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="addIncome.php"><i class="icon-dollar"></i> Dodaj Przychód </a>
					</li>
					
					<li class="nav-item active">
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
							<option value="Gotówka">Gotówka</option>
							<option value="Karta debetowa">Karta debetowa</option>
							<option value="Karta kredytowa">Karta kredytowa</option>

						</select>
                                        </div>
										
                                        <div class="form-group col-md-9 mx-auto">
						<div class="icons">
							<i class='icon-list-bullet'></i>
						</div>
						<select class="form-control category" name="category">

							<option value="0" selected disabled>Kategorie wydatku *</option>
							<option value="Transport">Transport</option>
							<option value="Książki">Książki</option>
							<option value="Jedzenie">Jedzenie</option>
							<option value="Mieszkanie">Mieszkanie</option>
							<option value="Telekomunikacja">Telekomunikacja</option>
							<option value="Opieka zdrowotna">Opieka zdrowotna</option>
							<option value="Ubranie">Ubranie</option>
							<option value="Higiena">Higiena</option>
							<option value="Dzieci">Dzieci</option>
							<option value="Rozrywka">Rozrywka</option>
							<option value="Wycieczka">Wycieczka</option>
							<option value="Oszczędności">Oszczędności</option>
							<option value="Na emeryture">Na emeryture</option>
							<option value="Spłata długów">Spłata długów</option>
							<option value="Darowizna">Darowizna</option>
							<option value="Inne">Inne...</option>

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
			All rights reserved &copy; 2020, Personal Budget created by Kail
		</div>
	
	</footer>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	<script src="jquery-3.2.1.min.js"></script>
	
</body>
</html>
