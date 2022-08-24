<?php
include("_header.php");
include("navi.php");

//Danke an https://werner-zenk.de/php/den_inhalt_aller_textdateien_nach_einem_suchbegriff_durchsuchen.php
?>
<form action="" method="post">
 <label>Volltextsuche: <input type="text" name="text" required autofocus></label> 
 <input type="submit" value=">>">
</form>

<?php
//  Den Inhalt aller Textdateien nach einem Suchbegriff
//  durchsuchen und gefundene Dateien als Link ausgeben. 
//  Durchsucht werden alle Unterverzeichnisse.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 //$verzeichnis = "./"; // Verzeichnis angeben
 $verzeichnis = "kartons/"; // Verzeichnis angeben
 if(!empty($_POST["text"])){
 $erg = alle_dateien($verzeichnis, $_POST["text"]);
 if(!empty($erg)){


$sorted = array ();
	for($a=0;$a<count($erg);$a++)
		{
			$sorted[$a] = $erg[$a];
			$sorted[$a] = substr($sorted[$a] ,strrpos($sorted[$a] ,"/")+1);
			$sorted[$a] = $sorted[$a]."|".$a;
		}
		natsort($sorted);
		$sorted = array_values($sorted);
		
	 for($a=0;$a<count($sorted);$a++)
	 {
		$nr = substr($sorted[$a],strpos($sorted[$a],"|")+1);
		$ergneu[] = $erg[$nr];
	 }
 }

 if(!empty($ergneu))
	{
	 	  	 
	 echo '<p>Suchergebnisse:</p>';
		foreach ($ergneu as $zaehler => $element) 
		{
			$datei = $element;
			$linktext = $element;
			$element = str_replace('\\', '/', $element);
			$linktext = substr($element,strpos($element,"/")+1);
			$linktext = substr($linktext,0,strrpos($linktext,"."));
			$pre = "";
			if($zaehler<9){$pre = "&nbsp;&nbsp;&nbsp;&nbsp;";}
			elseif($zaehler>=9 && $zaehler<99){$pre = "&nbsp;&nbsp;";}
			$element = substr($linktext,0,strrpos($linktext,"."));
			$element = "?karton=".$element;
 
			echo $pre.($zaehler+1) . '. <a href="index.php?karton='. $linktext .'">'. $linktext.'</a><br>';
  
			$inhalt = file($datei);
			echo "<h2>Karton #".$linktext."</h2><hr>";
				
				for($a=0;$a<count($inhalt);$a++)
					{
						$zeile  = strtolower(trim($inhalt[$a]));
						if(strpos($zeile,$_POST['text']) !== false){echo 'Zeile #'.($a+1).': '.$inhalt[$a].'<br>';}
					}
		echo "<hr>";

	}
 
 } // Ende erg
  else {echo "Der gewünschte Begriff konnte nicht gefunden werden.";echo "<hr>";}
} else {echo "Bitte einen Suchbegriff eingeben.";echo "<hr>";}
}

function alle_dateien($dir, $text) {
 $files = Array();
 $file_tmp = glob($dir . '*', GLOB_MARK | GLOB_NOSORT);
 foreach ($file_tmp as $item) {
  if (substr($item,-1) != DIRECTORY_SEPARATOR) {
  $type = substr($item, -3);
   if (in_array($type, array("txt","test"))) {
    $inhalt = file_get_contents($item);
	if(!empty($text)){
		if (stristr($inhalt, $text)) {
		$files[] = $item;
		}
	}
   }
  }
  else {
  $files = array_merge($files, alle_dateien($item, $text));
  }
 }

 return $files;

}
ABBRUCH:
?>