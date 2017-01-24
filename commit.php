<?php
$groep = isset( $_POST['groep'] ) ? $_POST['groep'] : '';
if ( $groep != '' ) {
	$file = fopen( $groep . "/chatlog.txt","a");
	$regel = $_POST['datum'] . $_POST['naam'] . "|" . $_POST['bericht'] . $_POST['tijd'] . PHP_EOL;
	fwrite($file,$regel);
	fclose($file);
}
?>