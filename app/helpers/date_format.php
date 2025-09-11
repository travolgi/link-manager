<?php
function dateFormat( $string, $format = 'd-m-Y H:i:s' ) {
	if ( !$string ) {
		return false;
	}
	$date = date_create($string);
	return date_format( $date, $format);
}