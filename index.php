<?php

/* Turn on output buffering */
ob_start();


/* Set error to false */
$err = false;


/* Get input value*/
foreach ( $_POST as $key=>$value ){
	$$key = trim( stripslashes( html_entity_decode( $_POST[$key], ENT_QUOTES, 'UTF-8' ) ) );
}

/* Mail options */
require_once( "inc/mail-config.php" );


/* PHP email class */
require_once( "inc/class.phpmailer.php" );


/* PHP validation */
require_once( "inc/validation.php" );

?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Mail form</title>
		<link rel="stylesheet" href="css/main.css">
	</head>
	
	<body>

		<h1>Mail form</h1>

		<form id="mail-form" name="mail-form" method="post" data-validate="parsley" action="<?php echo $_SERVER['PHP_SELF']; ?>">

			<label for="name">Name*:</label>
			<input id="name" name="name" type="text" placeholder="Insert name" data-required="true" value="<?php echo $name; ?>" />

			<?php 
				if ($_POST && $name==""){
					$err=true;
					echo "<span class=\"error\">This value is required.</span>";
				}
				elseif ($_POST && $name!="" && !IsName($name)){
					$err=true;
					echo "<span class=\"error\">This value should be a valid name.</span>";
				}
			?>

			<label for="surname">Surname:</label>
			<input id="surname" name="surname" type="text" value="<?php echo $surname; ?>" />

			<label for="telephone">Telephone:</label>
			<input id="telephone" name="telephone" type="tel" value="<?php echo $telephone; ?>" />

			<label for="email">Email*:</label>
			<input id="email" name="email" type="text" data-type="email" data-required="true" value="<?php echo $email; ?>" />

			<?php 
			if ($_POST && $email==""){
				$err=true;
				echo "<span class=\"error\">This value is required.</span>";
			}
			elseif ($_POST && $email!="" && !IsEmail($email)){
				$err=true;
				echo "<span class=\"error\">This value should be a valid email.</span>";
			}
			?>

			<label for="message">Message:</label>
			<textarea name="message" cols="25" rows="4" id="message"><?php echo $message; ?></textarea>
			
			<button type="submit" value="Submit">Submit</button>

		</form>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="js/parsley.min.js"></script>
		<!-- script src="js/messages.it.js"></script -->

		<?php

		if ( $_POST && $err === false ) {

			/* Html for mail message */
			$messageBody = '<html><head><style> td { font-family: Arial, Helvetica, sans-serif; font-size:12px;}</style></head><body>';
			$messageBody .= '<table style="border-color: #666; width:600px; margin:0 auto;" align="center" cellpadding="10">';
			$messageBody .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>{$name}</td></tr>";
			$messageBody .= "<tr style='background: #eee;'><td><strong>Surname:</strong> </td><td>{$surname}</td></tr>";
			$messageBody .= "<tr style='background: #eee;'><td><strong>Telephone:</strong> </td><td>{$telephone}</td></tr>";
			$messageBody .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>{$email}</td></tr>";
			$messageBody .= "<tr style='background: #eee;'><td><strong>Message:</strong> </td><td>{$message}</td></tr>";
			$messageBody .= "</table>";
			$messageBody .= "</body></html>";

			/* Create a new PHPMailer instance */
			$mail = new PHPMailer();

			/* Set lenguage error message (Default English) */
			//$mail->SetLanguage( "it", 'language/' );

			/* Set who the message is to be sent from */
			$mail->SetFrom( $email, $name );

			/* Set an alternative reply-to address */
			$mail->AddReplyTo( $email, $name );

			/* Set who the message is to be sent to (define in mail-config.php) */
			$mail->AddAddress( EMAILADDRESS, MAILNAME );
			$mail->AddBCC( EMAILADDRESSBCC, MAILNAMEBCC );
			
			/* Set charset */
			$mail->CharSet = 'UTF-8';
			
			/* Set word wrap to 50 characters */
			$mail->WordWrap = 50;

			/* Add attachment */
			//$mail->AddAttachment('doc/example.pdf', 'invoice.pdf');

			/* Set email format to HTML */
			$mail->IsHTML(true);

			/* Set the subject line */
			$mail->Subject = 'Here is the subject';

			/* Mail message */
			$mail->Body =  $messageBody;

			/* Alternative plain-text message */
			$mail->AltBody = 'This is a plain-text message body'; 

			/* Mail message with embedded image */
			//$mail->AddEmbeddedImage("photo.jpg", "my-attach", "photo.jpg");
			//$mail->Body = 'Embedded Image: <img alt="image" src="cid:my-attach" />';

			if( !$mail->Send() ) {

				/* Response email not sent */
				echo 'Message could not be sent. (' . $mail->ErrorInfo . ')';

				/* Redirect to error page */
				//header("location:mail-error.html");

			} else {

				/* Response email sent */
				echo 'Message has been sent';

				/* Redirect to mail sent page */
				//header("location:mail-sent.html");

			}

		}

		?>

	</body>

</html>