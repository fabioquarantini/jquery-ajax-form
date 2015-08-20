<!doctype html>
<html lang="">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Ajax Form</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/main.css">
	</head>

	<body>

		<form class="form" method="post" action="inc/send-mail.php">

			<div class="form__row">
				<label class="form__label" for="name">Nome e cognome*:</label>
				<input class="form__input" id="name" name="name" type="text" placeholder="Nome e cognome" value="<?php echo $name; ?>" />
			</div>

			<div class="form__row">
				<label class="form__label" for="email">Email*:</label>
				<input class="form__input" id="email" name="email" type="email" placeholder="Email" value="<?php echo $email; ?>" />
			</div>

			<div class="form__row">
				<label class="form__label" for="message">Messaggio*:</label>
				<textarea class="form__textarea" id="message" name="message" placeholder="Messaggio" cols="25" rows="4" ><?php echo $message; ?></textarea>
			</div>

			<div class="form__row hidden">
				<label class="form__label" for="robots">Se sei un umano lascia questo campo vuoto:</label>
				<input class="form__input" id="robots" name="robots" type="text" />
			</div>

			<button class="form__button" type="submit">Invia</button>

		</form>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/jquery-1.11.3.min.js"><\/script>')</script>
		<script src="js/scripts.js"></script>

	</body>

</html>
