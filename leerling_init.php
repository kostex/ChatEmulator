<?php
$groep = isset( $_POST['groep'] ) ? $_POST['groep'] : '';
if ( $groep != '' ) {
	$file=fopen( $groep . "/chat_personen.txt","r");
	$regel=fgets($file);
	echo $regel;
	$regel=fgets($file);
	echo $regel;
	fclose($file);
}
?>