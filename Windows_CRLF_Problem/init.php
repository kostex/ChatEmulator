<?php
$groep = isset( $_POST['groep'] ) ? $_POST['groep'] : '';
if ( $groep != '' ) {
	$file=fopen( $groep . "/chat_personen.txt","w+");
	$regel = $_POST['tester_geslacht'] . $_POST['tester_naam'] . PHP_EOL;
	fwrite($file,$regel);
	$regel = $_POST['leerling_geslacht'] . $_POST['leerling_naam'];
	fwrite($file,$regel);	
	fclose($file);
}
?>