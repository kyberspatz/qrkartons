<!doctype html>
<html lang="de" ⚡<?=isset($_GET['theme']) ? ' data-theme="' . $_GET['theme'] . '"' : '' ?>>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartons</title>
	<meta name="robots" content="noindex, nofollow, noarchive, nosnippet, max-image-preview:none, notranslate" />
	<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌸</text></svg>">
    <meta name="description" content="Yunas Webseite">
	</head>
<?php
include("navi.php");
if(!is_dir("kartons/")){header("Location: setup.php");exit;}

$ordner = "kartons/";
$erlaubte_dateien = array_slice(scandir($ordner),2);

if(isset($_GET['suche'])){
	include("volltextsuche.php");
	echo "<hr>";
	
}if(isset($_GET['liste'])){
	include("liste.php");
	echo "<hr>";
}


if(!isset($_GET['karton']))
{
	if(!isset($_POST['karton'])){
	?>
	<form action="?" method="GET">
	<input type="text" autofocus required name="karton" placeholder="Karton-ID"><button type="submit">Karton suchen</button>
	</form>
	<?php
}}
else 
{
	if(isset($_GET['karton'])){$karton_id=strip_tags(trim($_GET['karton']));}
	if(isset($_POST['karton'])){$karton_id=strip_tags(trim($_POST['karton']));}
	if(!in_array($karton_id.".txt",$erlaubte_dateien))
	{
		echo "Nix gefunden.";
		exit;
	}
	// Karton vorhanden
	else 
	{
		$inhalt = file_get_contents($ordner.$karton_id.".txt");
		if(isset($_POST['inhalt']) && isset($_POST['id']) && isset($_POST['speichern']))
		{
			
					$karton_id=strip_tags(trim($_GET['karton']));
					if(!in_array($karton_id.".txt",$erlaubte_dateien))
					{
						echo "Nix gefunden.";
						exit;
					} else {
							echo "Die Datei wurde am ".date("d.m.Y",time())." um ".date("H:i:s",time())." Uhr gespeichert.<hr>";
							file_put_contents($ordner.$karton_id.".txt",$_POST['inhalt']);
							$inhalt = file_get_contents($ordner.$karton_id.".txt");
							
					}
		}
		
		if(isset($_GET['edit']))
		{
			echo '<h2>Karton #'.$karton_id.'</h2>';
			?>
			
			<form action="?karton=<?php echo $karton_id;?>" method="POST">
			<textarea style="width:80vw;height:40vh;" name="inhalt"><?php echo $inhalt ?></textarea><br>
			<button type="submit">speichern</button>
			<input type="hidden" name="speichern">
			<input type="hidden" name="id" value="<?php echo $karton_id;?>">
			</form>
			<?php
			exit;
		}
		
		echo '<h2>Karton #'.$karton_id.'</h2><a href="?karton='.$karton_id.'&edit">Inhalt editieren</a><hr>';
		$inhalt = str_replace("\r\n","<br>",$inhalt);
		echo $inhalt;
	}
}

?>