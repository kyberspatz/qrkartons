<?php

$uniqid = uniqid();
$text = $_SERVER['REQUEST_URI']."?karton=". $uniqid;
define("QRTEXT", $_SERVER['REQUEST_URI']."?karton=". $uniqid);
define("QRUNIQID", $uniqid);

include 'phpqrcode/qrlib.php';
// $path variable store the location where to 
// store image and $file creates directory name
// of the QR code file by using 'uniqid'
// uniqid creates unique id based on microtime
$path = 'images/';
//$file = $path.uniqid().".png";
$file = $path.$uniqid.".png";
  
// $ecc stores error correction capability('L')
$ecc = 'H';
$pixel_size = 10;
$frame_size = 10;
  
// Generates QR Code and Stores it in directory given
QRcode::png($text, $file, $ecc, $pixel_size, $frame_size);
file_put_contents("kartons/".$uniqid.".txt","");
  
// Displaying the stored QR code from directory
//echo "<center><img src='".$file."'></center>";
?><html lang="de" >

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow, noarchive, nosnippet, max-image-preview:none, notranslate" />
  <title>Yuna: Kartons</title>
  <style>
html { 
	overflow:hidden;
	background-color:#222222;
}
div {
 display: flex;
 justify-content: center;
 align-items: center;
 height: 95vh;
 }


img {
 height: 80%;
 width: auto;
 border-radius:15px;
}

	
@media all and (max-width: 400px) {

		img {
			height: auto;
			width: 90vw;
		}
	
  }

</style>
<body>
<?php include("navi.php");?>
<div class="flex">
    <img src="<?php echo $file;?>">
</div>

</body>

