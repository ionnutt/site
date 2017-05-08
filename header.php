<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Numele Site-ului</title>

	<link rel="stylesheet" href="./css/foundation.css">
	<link rel="stylesheet" href="./css/app.css">
	<link rel="stylesheet" href="./css/style.css">


</head>
<body>

	<header class="row column header">
		<a href="./">Logo-ul Site</a>

		<nav class="float-right">
			<ul class="menu-login">
				<?php if (!isset($_SESSION['logged_in'])) { ?>
				<li>
					<a href="./login.php">Logheaza-te</a>
				</li>
				<li>
					<a href="./signup.php">Inregistreaza-te</a>
				</li>
				<?php } else { ?>
				<li>
					<a href="#">Contul meu</a>
				</li>
				<li>
					<a href="./?action=logout">Delogheaza-te</a>
				</li>
				<?php } ?>
			</ul>
		</nav>
	</header>

	<div class="row">
		<div class="nav-menu">
			 <ul class="menu">
				  <li class="menu-text">Site Title</li>
				  <li><a href="home.php">Acasa</a></li>
				  <li><a href="despre-noi.php">Despre noi</a></li>
				  <li><a href="#3">Link 3</a></li>
				  <li><a href="#4">Link 4</a></li>
				  <li><a href="#5">Link 5</a></li>
				  <li><a href="#6">Link 6</a></li>
				  <li><a href="user_list.php">Listare</a></li>
				  <li><a href="contact.php">Contact</a></li>
			</ul>
		</div>
	 </div>


	<div class="column">
		

			<div class="column medium-6">
				<h3>Utilizatori</h3>

				<ul>
					<li>
						<a href="./user_list.php">Listare</a>
					</li>
				</ul>
			</div>
		

	</div>

