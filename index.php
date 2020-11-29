<?php
	session_start();
	
	if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
	{
		header('Location: mainPage.php');
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
                                <a href="index.php" class="nav-link active">Logowanie</a>
                            </li>
                            <li class="nav-item">
                                <a href="registration.php" class="nav-link">Rejestracja</a>
                            </li>
                        </ul>
						
			<form action="login.php" method="post">

				<h3  class="register-heading">Logowanie użytkownika</h3>

				<div class="row register-form">

					<div class="col-md-10 inputs offset-md-1">

						<div class="form-group col-md-9 mx-auto">
							<div class="icons">
								<i class='icon-email'></i>
							</div>
							<input type="email" class="form-control" placeholder="Email *" value="" name="login"/>
						</div>

						<div class="form-group col-md-9 mx-auto">
							<div class="icons">
								<i class='icon-lock-filled'></i>
							</div>
							<input type="password" class="form-control" placeholder="Hasło *" value="" name="password"/>
						</div>

					<?php
						if(isset($_SESSION['error']))
						{	
							 echo "<div id='name2' class='error'>".$_SESSION['error']."</div>";
						}
					?>
					</div>

				   	<div class="col-md-12">

						<input type="submit" class="btnRegister" value="Zaloguj się"/>

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
	<script src="jquery-3.2.1.min.js"></script>
	
</body>
</html>
