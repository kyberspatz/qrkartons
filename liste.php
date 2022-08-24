<?php
include("_header.php");
include("navi.php");
$qr_ordner = "images/";
$qrdateien = array_slice(scandir($qr_ordner),2);

if(!empty($qrdateien)){
	foreach($qrdateien as $output)
	{
		$kartonnr= substr($output,0,-4);
		echo '<a href="'.$qr_ordner.$output.'">'.$kartonnr.'</a> | <a href="index.php?karton='.$kartonnr.'&edit">Inhalt editieren</a><br>';
	}
} else 
{
	echo '<p>Es konnte kein QR-Code gefunden werden.</p><p><a href="qrmake.php">Jetzt einen QR-Code erstellen</a></p>';
}
?>