<?php



require_once('./function.php');


$errors = [];


if (!empty($_POST)) {



	/*

		TODO creem un utilizator folosind datele furnizate

		1. verificam daca adresa de email este valida
		2. verificam daca nu adresa de email deja introdusa
		3. securizam parola cu MD5
		4. trimite un email de confirmare cu datele introduse

	 */

	if (empty($_POST['first_name'])) {
		$errors['first_name'] = 'Eroare: Numele nu este completat';
	}

	if (empty($_POST['last_name'])) {
		$errors['last_name'] = 'Eroare: Numele de familie nu este completat';
	}

	if (empty($_POST['email'])) {
		$errors['email'] = 'Eroare: Emailul nu este completat';
	} else {
		/**
		 * 1
		 */
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Eroare: Emailul nu este corect';
		}
	}

	if (empty($_POST['password'])) {
		$errors['password'] = 'Eroare: Parola nu este completata';
	}





	/**
	 * Verificam sa nu avem adresa de email neconforma sau
	 * duplicati in baza de date
	 */
	if (empty($errors)) {


		/**
		 * SQL INJECTION : valentin@php.com"; SELECT id FROM a_php_users WHERE id > 0;
		 */

		/**
		 * facem un query pentru a gasi emailul existent in baza de date
		 */
		// $sql = 'SELECT username FROM a_php_users WHERE username = "'. $_POST['email'] .'" ';
		// $result = mysqli_query($db, $sql);


		// if ($result) {

		// 	 // trecem prin toate rezultatele gasite si creem un obiect pe care il folosim la validare
		// 	while ($row = mysqli_fetch_assoc($result)) {
		// 		$utilizator_db = $row;
		// 	}


		// 	// Free result set
		// 	mysqli_free_result($result);
		// }


		if ($stmt = mysqli_prepare($db, "SELECT username FROM users WHERE username = ?")) {

			/* bind parameters for markers */
			mysqli_stmt_bind_param($stmt, "s", $_POST['email']);

			/* execute query */
			mysqli_stmt_execute($stmt);

			/* bind result variables */
			mysqli_stmt_bind_result($stmt, $result_from_db);

			/* fetch value */
			mysqli_stmt_fetch($stmt);

			/* close statement */
			mysqli_stmt_close($stmt);
		}

		global $result_from_db;

		if ($result_from_db) {
			$errors['email'] = 'Error: email existent in arhivele noastre';
		}

	}


	/**
	 * Ajungem sa introducem in baza de date doar dupa ce validam
	 * si datele existente deja in baza de date.
	 */
	if (empty($errors)) {

		// $sql = 'INSERT INTO a_php_users
		// 	SET
		// 		username = "'. $_POST['email'] .'",
		// 		password = "'. $password .'",
		// 		first_name = "'. $_POST['first_name'] .'",
		// 		last_name = "'. $_POST['last_name'] .'"
		// ';
		// $sql = 'INSERT INTO a_php_users SET
		// 		(username, password, first_name, last_name)
		// 	VALUES
		// 		("", "", "", ""),
		// 		("", "", "", ""),
		// 		("", "", "", "") ';

		if ($stmt = mysqli_prepare($db, "INSERT INTO users SET username = ?, password = ?, first_name = ?, last_name = ?")) {

			mysqli_stmt_bind_param($stmt, "ssss", $_POST['email'], md5($_POST['password']), $_POST['first_name'], $_POST['last_name']);

			mysqli_stmt_execute($stmt);



			/**
			 * Verificam daca avem o eroare din cauza queriului la baza de date
			 */
			if (!empty($stmt->error_list)) {

				$errors['db'] = 'Eroare la crearea utilizatorului';
			}

			/* close statement */
			mysqli_stmt_close($stmt);


			header('Location: ./confirm.php');
			exit;
		} else {

			$errors['db'] = 'Eroare la crearea utilizatorului';
		}


	}

	// die;

}


?><?php include_once('./header.php') ?>

<br>
<br>
<?php include_once ('./errors.php') ?>


<form action="./signup.php" method="POST">

	<div class="row">


		<div class="wrapper-input column medium-6 <?php

			if (!empty($errors['first_name'])) {
				echo 'error';
			}

		?>">
			<label for="first_name">Nume</label>
			<input
				type="text"
				name="first_name"
				id="first_name"
				placeholder="Introdu nume"
				value="<?php echo (!empty($_POST['first_name'])) ? $_POST['first_name'] : '' ?>"
				>

			<?php
			if (!empty($errors['first_name'])) {
				echo '<span>'. $errors['first_name'] .'</span>';
			}
			?>

		</div>

		<div class="wrapper-input column medium-6 <?php

			if (!empty($errors['last_name'])) {
				echo 'error';
			}

		?>">
			<label for="last_name">Nume de familie</label>
			<input
				type="text"
				name="last_name"
				id="last_name"
				placeholder="Introdu nume de familie"
				value="<?php echo (!empty($_POST['last_name'])) ? $_POST['last_name'] : '' ?>"
				>

				<?php
				if (!empty($errors['last_name'])) {
					echo '<span>'. $errors['last_name'] .'</span>';
				}
				?>

		</div>

		<div class="wrapper-input column medium-6 <?php

			if (!empty($errors['email'])) {
				echo 'error';
			}

		?>">
			<label for="email">Email</label>
			<input
				type="email"
				name="email"
				id="email"
				placeholder="Introdu emailul tau"
				value="<?php echo (!empty($_POST['email'])) ? $_POST['email'] : '' ?>"
				>

			<?php
			if (!empty($errors['email'])) {
				echo '<span>'. $errors['email'] .'</span>';
			}
			?>


		</div>

		<div class="wrapper-input column medium-6 <?php

			if (!empty($errors['password'])) {
				echo 'error';
			}

		?>">
			<label for="password">Password</label>
			<input
				type="password"
				name="password"
				id="password" placeholder="Introdu parola" >


			<?php
			if (!empty($errors['password'])) {
				echo '<span>'. $errors['password'] .'</span>';
			}
			?>


		</div>


		<div class="wrapper-submit column medium-6 medium-centered">
			<input type="submit" class="button expanded" value="Trimite">
		</div>

	</div>
</form>



<?php include_once('./footer.php') ?>

