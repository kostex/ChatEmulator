<?php
$groep = isset( $_POST['groep'] ) ? $_POST['groep'] : '';
if ( $groep != '' ) { 
	$file=fopen($groep . "/chatlog.txt","r");
	$samenstel= '';
	while(! feof($file) ){
		$line=fgets($file);
		if (strlen($line) > 5) {
			$id = substr($line,0,7);
			$naam = isset( $_POST['naam'] ) ? $_POST['naam'] : 'Frits';
			$naam = substr($line,7,strpos($line,'|')-7);
			$bericht = substr($line,strpos($line,'|')+1);
			$bericht = substr($bericht,0,strlen($bericht)-6);
			$tijd = substr($line,-6,5);
			$samenstel = $samenstel . "<div id='" . $id . "' class='";
			if($naam==$_POST['naam']) {
				$samenstel = $samenstel . "rechts";
			} else {
				$samenstel = $samenstel . "links";
			}
			$samenstel =  $samenstel . "'>";
			if ($bericht[0]=='/'){
			 $samenstel = $samenstel . '<img src="images/' . $bericht[1] . $bericht[2] . $bericht[3] . '.jpg" width="200px">' . "<div class='time'>" . $naam . ' ' . $tijd . "<img src='images/check.png' width='20px'/></div></div>";
			} else {
				if ($bericht[0]=='@') {
					$samenstel = $samenstel . '<img src="emoji/emoji_' . substr($bericht,1) . '.png">' . "<div class='time'>" . $naam . ' ' . $tijd . "<img src='images/check.png' width='20px'/></div></div>";
				} else {
					$samenstel = $samenstel . htmlspecialchars($bericht) . "<div class='time'>" . $naam . ' ' . $tijd . "<img src='images/check.png' width='20px'/></div></div>";
				}
			}
		}
	}
	fclose($file);
	echo $samenstel;
}
?>