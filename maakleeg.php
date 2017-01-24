<?php
$groep = isset( $_POST['groep'] ) ? $_POST['groep'] : '';
if ( $groep != '' ) {
	$leeg = true;
	$filenaam = $groep . '/chatlog.txt';
	if ( filesize($filenaam) ) {
		$file = fopen( $groep . '/chatlog.txt','r');
		$leeg = false;
		date_default_timezone_set('Europe/Amsterdam');
		$bnaam = 'logs/' . date('YmdHis') . '-' . $groep . '.txt';
		$backfile = fopen($bnaam,'w+');
		while(! feof($file) ){
			$line = fgets($file);
			fwrite($backfile,$line);
		}
		fclose($backfile);
		fclose($file);
	}
	if ($leeg == false) {
		$file = fopen( $groep . '/chatlog.txt','w+' );
		fclose($file);
	}
}
?>