<?php

session_start();


require_once('./function.php');




if (!empty($_POST)) {


	if (empty($_POST['email'])) {
		$errors['email'] = 'Eroare: Emailul nu este completat';
	}

	if (empty($_POST['password'])) {
		$errors['password'] = 'Eroare: Parola nu este completata';
	}


	if (empty($errors)) {


		$utilizator_db = [];


		/**
		 * facem un query pentru a gasi utilizatorul in baza de date
		 */
		$sql = 'SELECT * FROM users WHERE username = "'. $_POST['email'] .'" ';
		$result = mysqli_query($db, $sql);


		if ($result) {

			 // trecem prin toate rezultatele gasite si creem un obiect pe care il folosim la validare
			while ($row = mysqli_fetch_assoc($result)) {
				$utilizator_db = $row;
			}


			// Free result set
			mysqli_free_result($result);
		}



		if (
			isset($utilizator_db['username']) &&
			isset($utilizator_db['password']) &&
			($utilizator_db['username'] === $_POST['email']) &&
			($utilizator_db['password'] === md5($_POST['password']))
		) {


			$_SESSION['logged_in'] = true;

			header('Location: ./index.php');
			exit;

		} else {

			echo 'Te rog verifica informatia!';
		}



	}


}




?><?php include_once('./header.php') ?>

<br>
<br>

<form action="./login.php" method="POST">

	<div class="row">

		<div class="wrapper-input column medium-6 <?php

				if (!empty($errors['email'])) {
					echo 'error';
				}

			?>">
			<label for="email">Email</label>
			<input
				type="text"
				name="email"
				id="email"
				placeholder="Introdu emailul tau"
				>


				<?php
				if (!empty($errors['email'])) {
					echo '<span>Eroare: camp necompletat</span>';
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
					echo '<span>Eroare: camp necompletat</span>';
				}
				?>

		</div>


		<div class="wrapper-submit column medium-6 medium-centered">
			<input type="submit" class="button expanded" value="Trimite">
		</div>


		<div class="column">
			<a data-open="modal-reset">Am uitat parola</a>
		</div>

	</div>


</form>


<div class="reveal" id="modal-reset" data-reveal>

	<div class="row column">

		<h1>Hai sa te ajut!</h1>
		<p>Completeaza formularul de mai jos si iti vom trimite o parola noua</p>
	</div>

	<form action="./index.php?action=reset" method="POST">
		<div class="row">
			<div class="column wrapper-input medium-8">
				<input
					type="text"
					name="email"
					id="email"
					placeholder="Introdu emailul tau"
					>
			</div>
			<div class="column wrapper-input medium-4">
				<input type="submit" class="button expanded" value="Trimite">
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Inchide" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<?php include_once('./footer.php') ?>