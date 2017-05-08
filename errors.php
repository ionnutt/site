<?php if (!empty($successes) || !empty($_SESSION['successes'])) { ?>
<div class="row column">
	<div class="callout success"><?php

		if (!empty($successes))
			echo implode('<br>', $successes);

		if (!empty($_SESSION['successes'])) {
			echo implode('<br>', $_SESSION['successes']);
			unset($_SESSION['successes']);
		}

	?></div>
</div>
<?php } ?>

<?php if (isset($errors['db']) || !empty($_SESSION['errors']['db'])) { ?>
<div class="row column">
	<div class="callout alert"><?php

		if (isset($errors['db']))
			echo $errors['db'];

		if (!empty($_SESSION['errors']['db'])) {

			echo $_SESSION['errors']['db'];
			unset($_SESSION['errors']['db']);
		}

	?></div>
</div>
<?php } ?>