<?php
$groep = isset( $_POST['groep'] ) ? $_POST['groep'] : '';
$win_or_linux_server = trim(file_get_contents('./win_or_linux_server.txt'));

if ( $groep != '' ) {
	$file=fopen( $groep . "/chat_personen.txt","w+");
	$regel = $_POST['tester_geslacht'] . $_POST['tester_naam'] . PHP_EOL;
	fwrite($file,$regel);
	if ($win_or_linux_server == 'linux') {
		$regel = $_POST['leerling_geslacht'] . $_POST['leerling_naam'] . PHP_EOL;
	} else {
		$regel = $_POST['leerling_geslacht'] . $_POST['leerling_naam'];
	}
	fwrite($file,$regel);	
	fclose($file);
}
?>