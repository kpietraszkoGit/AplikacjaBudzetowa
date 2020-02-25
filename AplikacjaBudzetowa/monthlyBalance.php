<?php

	session_start();//zeby tablica session działała,globalny pojemnik na dane
	
	if (isset($_SESSION['ok'])) unset($_SESSION['ok']);//kasowanie informacji o dodaniu przychodu
	if (isset($_SESSION['ok2'])) unset($_SESSION['ok2']);
	
	if (!isset($_SESSION['logged']))//jesli zmienna nie bedzie ustawiona, czyli zalogowani nie bedziemy
	{
		header('Location: index.php');
		exit();
	}
	
	$dbhandle = new mysqli('localhost','root','','aplikacjabudzetowa');
	echo $dbhandle->connect_error;
	
	$user_id = $_SESSION['id'];
	
	$query = "SELECT user_id, SUM(amount), expense_category_assigned_to_user_id FROM expenses WHERE MONTH(date_of_expense) = MONTH(CURDATE()) AND YEAR(date_of_expense) = YEAR(CURDATE()) AND user_id='$user_id' GROUP BY  expense_category_assigned_to_user_id ORDER BY SUM(amount) DESC";
	$res = $dbhandle->query($query);
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
	
	<!--wykres kolowy-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['expense_category_assigned_to_user_id', 'amount'],
          
          <?php 
			//while($row=$res->fetch_assoc())
			while($row = mysqli_fetch_array($res))
			{
				echo "['".$row['expense_category_assigned_to_user_id']."',".$row[ 'SUM(amount)']."],";
			}

          ?>

        ]);

        var options = {
          title: 'WYDATKI Z BIEŻĄCEGO MIESIĄCA:',
          //pieHole: 0.4,
		  //backgroundColor: 'red',
		  //chartArea:{width:'auto',height:'auto'},
		  legend: {textStyle: {color: '#495057'}},
		  titleTextStyle: {color: '#495057', fontName: 'Open Sans', fontSize: '16px'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}

$(window).on("throttledresize", function (event) {
    var options = {
        width: '100%',
        height: '100%'
    };

    var data = google.visualization.arrayToDataTable([]);
    drawChart(data, options);
});
    </script>
	
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
					
					<li class="nav-item">
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
					
					<li class="nav-item active">
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
                        <p>Niektórzy ludzie są tak oszczędni, jakby mieli wiecznie żyć, inni tak rozrzutni, jakby mieli natychmiast umrzeć. <br> – Arystoteles –</p>
                    </div>
					
                    <div class="col-lg-9 register-right">
                        
						
                        <div class="tab-content" id="myTabContent">
						
							<div class="row registerBalance-form justify-content-md-center">
							
								<div class="col-md-6 mb-4">
								<h3 class="register-headingBalance">Bieżący miesiąc:</h3>
								</div>
								
								<div id="button" class="col-md-6 mb-4">
			
									<div class="dropdown">
									
									  <button onclick="myFunction()" class="dropbtn">Wybierz okres<i class="icon-down-dir"></i></button>
									  <div id="myDropdown" class="dropdown-content">
										<a href="monthlyBalance.php">Bieżący miesiąc</a>
										<a href="lastMonthlyBalance.php">Poprzedni miesiąc</a>
										<a href="yearBalance.php">Bieżący rok</a>
										<a href="#" data-toggle="modal" data-target="#exampleModal">Niestandardowy</a>
									  </div>
									  
									</div>
								
								</div>
							
								<div class="col-md-5 balance">
									<p class="titleBox">Przychody</p>
													
									<table cellpadding="10" cellspacing="0"><!--wypisanie danych w tabeli -->
										<thead>
											<tr><th>Kategorie</th><th>Przychód</th></tr>
										</thead>
										<tbody><!--wypisanie danych w tabeli , foreach-dla kazdego-petla//wyjmowanie rekord po rekordzie as-jako $user-bufor-->
											<?php
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
																//echo "id zalogowanego użytkownika:".$user_id = $_SESSION['id'];
																$user_id = $_SESSION['id'];
																if($result = $connection->query("SELECT user_id, SUM(amount), income_category_assigned_to_user_id FROM incomes WHERE MONTH(date_of_income) = MONTH(CURDATE()) AND YEAR(date_of_income) = YEAR(CURDATE()) AND user_id='$user_id' GROUP BY  income_category_assigned_to_user_id ORDER BY SUM(amount) DESC"))
																{
																//biezacy miesiac o tym samym id
																//if($result = $connection->query("SELECT user_id, income_category_assigned_to_user_id, amount FROM incomes WHERE MONTH(date_of_income) = MONTH(CURDATE()) AND YEAR(date_of_income) = YEAR(CURDATE()) AND user_id='$user_id'"))
																//{
																	//suma wszystkich kategorii
																	//$result = $connection->query("SELECT income_category_assigned_to_user_id, SUM(amount) FROM incomes GROUP BY  income_category_assigned_to_user_id ORDER BY SUM(amount) DESC");
																	$sumIncomes = 0;
																	while($row = mysqli_fetch_array($result))
																	{ 
																		echo "<tr><td>".$row['income_category_assigned_to_user_id']."</td><td>".$row[ 'SUM(amount)']."</td></tr>";
																		$number = $row[ 'SUM(amount)'];
																		$sumIncomes += $number;
																	}
																	//$_SESSION['sumIncomes'] = $sum;
																	//echo $_SESSION['sumIncomes'] = $sum;
																	//echo $sumIncomes;
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
											?>
										</tbody>
									</table>
								</div>
								
								<div class="col-md-5 ml-md-1 balance">
									<p class="titleBox">Wydatki</p>
									
									<table cellpadding="10" cellspacing="0"><!--wypisanie danych w tabeli -->
										<thead>
											<tr><th>Kategorie</th><th>Wydatek</th></tr>
										</thead>
										<tbody><!--wypisanie danych w tabeli , foreach-dla kazdego-petla//wyjmowanie rekord po rekordzie as-jako $user-bufor-->
											<?php
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
																//echo "id zalogowanego użytkownika:".$user_id = $_SESSION['id'];
																$user_id = $_SESSION['id'];
																if($result2 = $connection->query("SELECT user_id, SUM(amount), expense_category_assigned_to_user_id FROM expenses WHERE MONTH(date_of_expense) = MONTH(CURDATE()) AND YEAR(date_of_expense) = YEAR(CURDATE()) AND user_id='$user_id' GROUP BY  expense_category_assigned_to_user_id ORDER BY SUM(amount) DESC"))
																{
																//biezacy miesiac o tym samym id
																//if($result = $connection->query("SELECT user_id, income_category_assigned_to_user_id, amount FROM incomes WHERE MONTH(date_of_income) = MONTH(CURDATE()) AND YEAR(date_of_income) = YEAR(CURDATE()) AND user_id='$user_id'"))
																//{
																	//suma wszystkich kategorii
																	//$result = $connection->query("SELECT income_category_assigned_to_user_id, SUM(amount) FROM incomes GROUP BY  income_category_assigned_to_user_id ORDER BY SUM(amount) DESC");
																	$sumExpenses = 0;
																	while($row2 = mysqli_fetch_array($result2))
																	{ 
																		echo "<tr><td>".$row2['expense_category_assigned_to_user_id']."</td><td>".$row2[ 'SUM(amount)']."</td></tr>";
																		$nameExpense = $row2['expense_category_assigned_to_user_id'];
																		$numberExpense = $row2[ 'SUM(amount)'];
																		$sumExpenses += $numberExpense;
																	}
																	//echo $sumExpenses;
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
											?>
										</tbody>
									</table>
								</div>
								
								<div class="col-md-10 resumeBalance">
									<p class="titleBox">Bilans</p>
									<table cellpadding="10" cellspacing="0">
									   <thead>
											<tr><th>Bilans</th><th>
											<?php
											$difference = $sumIncomes - $sumExpenses;
											echo $difference;
											?>
											</th></tr>
										</thead>
									</table>
											<?php
												if($difference<0)
												{	
													 echo"<div id='sum'>Uważaj, wpadasz w długi!</div>";
												}
												else
												{
													echo"<div id='sum2'>Gratulacje. Świetnie zarządzasz finansami!</div>";
												}
											?>
								</div>
								
								<div class="col-md-10 resumeBalance">
									<p class="titleBox">Wykres</p>
									<div id="chart_wrap"><div id="chart_div"></div></div>
								</div>

								<!-- Modal -->
								<form method="post" action="dateRange.php">								
									<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
														<div class="icons"><h5 class="modal-title" id="exampleModalLabel"><i class='icon-calendar'></i>Wybierz zakres dat: </h5>
														 </div>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<div class="form-group col-md-9 mx-auto">
														<div class="to">
															<p> od </p>
														</div>
														<input type="date" class="form-control" id="days" name="day1" value="" min="1900-01-01" max="2500-01-01" required />
													</div>
													<div class="form-group col-md-9 mx-auto">
														<div class="to">
															<p> do </p>
														</div>
														<input type="date" class="form-control" id="days2" name="day2" value="" min="1900-01-01" max="2500-01-01" required />
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
													<button type="submit" class="btn ok">OK</button>
												</div>
											</div>
										</div>
									</div>
								</form>

							</div>
							
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