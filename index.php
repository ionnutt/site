<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Numele Site-ului</title>

	<link rel="stylesheet" href="./css/foundation.css">
	<link rel="stylesheet" href="./css/app.css">
	<link rel="stylesheet" href="./css/style.css">
	
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

<?php include 'header.php'; ?>



<?php include 'footer.php'; ?>


<?php

session_start();


require_once('./function.php');



if (!empty($_GET['action'])) {



	/**
	 * executam actiunea de logout
	 */
	if ($_GET['action'] === 'logout') {

		unset($_SESSION['logged_in']);
		header('Location: ./login.php');
		exit;
	}



	/**
	 * executam actiunea de reset
	 */
	if ($_GET['action'] === 'reset') {

		if (!empty($_POST['email'])) {

			if ($_POST['email'] === $utilizator_db['username']) {

				// 1. generam o parola
				// 2. trimitem parola prin email

				/**
				 * Generam o parola random
				 */
				$pass = crypt('123');
				// $pass = md5( mt_rand(0, 999999) );

				/**
				 * limitam parola la 6 caractere
				 */
				$pass = substr($pass, rand(0, 3), 6);



				$message = <<<EOT

<h2>Salut, </h2>

<p>Noua ta parola este: {$pass}</p>
<p>Poti sa o folosesti mergand la adresa: <a href="http://php.codingheads.com/proiect/login.php">Login Catalog</a></p>

<p>Dupa logare poti schimba parola cu una mai retinubila mergand in contul tau.</p>


EOT;

				// To send HTML mail, the Content-type header must be set
				$headers[] = 'MIME-Version: 1.0';
				$headers[] = 'Content-type: text/html; charset=iso-8859-1';

				// Additional headers
				$headers[] = 'From: Catalog PHP <adresa de email>';
				// $headers[] = 'ReplyTo: Catalog PHP <adresa de email>';

				mail($_POST['email'], 'Resetare de parola', $message, implode("\r\n", $headers));

			} else {

				/**
				 * Returnam o eroare si noi?
				 */
			}

		} else {

			/**
			 * Returnam o alta eroare?
			 */
		}


		header('Location: ./login.php');
		exit;
	}





	/**
	 * Proceseaza functia de stergere
	 */
	if (
		($_GET['action'] === 'delete') &&
		isset($_GET['id']) &&
		isset($_GET['source']) &&
		in_array($_GET['source'], array('users', 'categories', 'products', 'orders'))
	) {



		$sql = "DELETE FROM a_php_". $_GET['source'] ." WHERE id = ?";

		if ($stmt = mysqli_prepare($db, $sql)) {

			mysqli_stmt_bind_param($stmt, "i", $_GET['id']);

			mysqli_stmt_execute($stmt);



			/**
			 * Verificam daca avem o eroare din cauza queriului la baza de date
			 */
			if (empty($stmt->error_list)) {

				$_SESSION['successes'][] = $dictionar[$_GET['source']] .' a fost sters.';

				header('Location: ./'. $_GET['source'] .'_list.php');
				exit();

			} else {

				$errors['db'] = 'Eroare la stergerea din tabelul '. $dictionar[$_GET['source']];
			}

			/* close statement */
			mysqli_stmt_close($stmt);
		} else {

			$errors['db'] = 'Eroare la stergerea din tabelul '. $dictionar[$_GET['source']];
		}


	}


}






/**
 * verificam daca sesiunea este inceputa
 */
if (empty($_SESSION['logged_in'])) {

	header('Location: ./login.php');
	exit;
} // (empty($_SESSION['logged_in']))







