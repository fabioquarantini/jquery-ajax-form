<?php

// Email validation
function is_email( $value ) {

	$r = "([a-z0-9]+[\._\-]?){1,3}([a-z0-9])*";
	$r = "/(?i)^{$r}\@{$r}\.[a-z]{2,6}$/";
	return preg_match( $r, $value );

}

// Telephone validation
function is_telephone_number( $value ) {

	return preg_match( "/^(\+39)?(\s)?[0-9]{1,4}(\/|-|\\\\)?[0-9]{3,13}$/", $value );

}

// Url validation
function is_url( $value ) {

	$er = "/^((http|https|ftp):\/\/|[w]{3}[0-9]{0,1}\.)([a-zA-Z0-9]([a-zA-Z0-9\-_]+\.|[a-zA-Z0-9\-_]+|)+[a-zA-Z0-9]\.[a-zA-Z]{2,6})(:[0-9]{1,5}|)(\/.{0,1024}|)$/i";
	return preg_match( $er, $value );

}

// Name validation
function is_name( $value ) {

	$control = 0;
	$pattern = "^[a-z A-Z\.&, àéèùòüäëÄöÿÖÜ']+$";

	if ( ( ereg($pattern, $value) ) AND ( $value != "" ) ) {
		$control = 1;
	}

	return $control;

}

// Numeric validation
function is_number( $value ) {

	$control = 0;
	$pattern = "^[0-9.,]+$";

	if ( ereg( $pattern, $value) )	{
		$control = 1;
	}

	return $control;

}

?>