<?php
include("_header.php");
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