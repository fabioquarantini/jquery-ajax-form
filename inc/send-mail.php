<?php
// Set header type
header('Content-Type:application/json; charset=utf-8');

// Turn on output buffering
ob_start();

// Array to hold validation errors
$errors = array();

// Array to pass back data
$data = array();

// PHP email class
require 'phpmailer/PHPMailerAutoload.php';

// PHP validation
require 'form-validations.php';

// Get input value
foreach ( $_POST as $key=>$value ) {
	$$key = trim( stripslashes( html_entity_decode( $_POST[$key], ENT_QUOTES, 'UTF-8' ) ) );
}

// Name validation
if ( empty( $name ) ) {

	$errors['name'] = 'Il nome è obbligatorio.';

} elseif ( !is_name( $name ) ) {

	$errors['name'] = 'Deve essere un nome valido.';

}

// Mail validation
if ( empty( $email ) ) {

	$errors['email'] = 'La mail è obbligatoria.';

} elseif ( !is_email( $email ) ){

	$errors['email'] = 'La mail deve essere valida.';

}

// Message validation
if ( empty( $message ) ) {

	$errors['message'] = 'Il messaggio è obbligatorio.';

}

// Honeypot captcha (hide the input with css)
if ( !empty( $robots ) ) {

	$errors['robots'] = 'Sei un robot.';

}

// if there are any errors in our errors array, return a success boolean of false
if ( !empty( $errors ) ) {

	// if there are items in our errors array, return those errors
	$data['success'] = false;
	$data['errors']  = $errors;

} else { // if there are no errors process our form

	// Html mail
	$messageBody = '<html><head><style> td, th { font-family: Arial, Helvetica, sans-serif; font-size:14px; color:#838d8e; line-height: 30px;}</style></head><body bgcolor="#edf0f1">';
	$messageBody .= '<table bgcolor="#fff" style="border-color: #666; max-width:600px; width:100%; margin:0 auto;" align="center" cellpadding="10" border="0" >';
	$messageBody .= "<thead bgcolor='#4d9b83'><tr><th style='color:#fff; text-transform: uppercase;'>Contatto</th></tr></thead>";
	$messageBody .= "<tr><td><strong>Nome e cognome:</strong> {$name}</td></tr>";
	$messageBody .= "<tr bgcolor='#f5f7f7'><td><strong>Email:</strong> {$email}</td></tr>";
	$messageBody .= "<tr><td><strong>Messaggio:</strong> {$message}</td></tr>";
	$messageBody .= "</table>";
	$messageBody .= "</body></html>";

	// Create a new PHPMailer instance
	$mail = new PHPMailer;

	// Set PHPMailer to use the sendmail transport
	$mail->isSendmail();

	// Set who the message is to be sent from
	$mail->setFrom( $email, $name );

	// Set an alternative reply-to address
	$mail->addReplyTo( $email, $name );

	// Set who the message is to be sent to
	$mail->addAddress('test@domain.com', 'Name Surname');

	// Set email format to HTML
	$mail->IsHTML( true );

	// Set the subject line
	$mail->Subject = 'Contatto ricevuto dal sito';

	// Set mail message
	$mail->Body =  $messageBody;

	// send the message, check for errors
	if ( !$mail->send() ) {

		// Show a message of error with details
		$errors['mailer'] = 'Email non inviata: ' . $mail->ErrorInfo;
		$data['success'] = false;
		$data['errors']  = $errors;

	} else {

		// Show a message of success and provide a true success variable
		$data['success'] = true;
		$data['message'] = 'Success! Email inviata';

	}

}

echo json_encode( $data );

?>