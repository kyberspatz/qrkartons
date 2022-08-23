<?php

if(!is_dir("phpqrcode")){
	$file = "phpqrcode-2010100721_1.1.4.zip";
	file_put_contents($file,file_get_contents("https://sourceforge.net/projects/phpqrcode/files/releases/".$file."/download"));

	//https://stackoverflow.com/posts/8889126/revisions
	// assuming file.zip is in the same directory as the executing script.

	// get the absolute path to $file
	$path = pathinfo(realpath($file), PATHINFO_DIRNAME);

	$zip = new ZipArchive;
	$res = $zip->open($file);
	if ($res === TRUE) {
	  // extract it to the path we determined above
	  $zip->extractTo($path);
	  $zip->close();
	 // echo "WOOT! $file extracted to $path";
	  unlink($file);
	} else {
	  echo "Doh! I couldn't open $file"; exit;
	}

}

if(!is_dir("images")){mkdir("images");}
if(!is_dir("kartons")){mkdir("kartons");}

if(!is_file("phpqrcode/qrimage_original.php"))
{
	$file = "phpqrcode/qrimage.php";
	if(is_file($file))
	{
		file_put_contents("phpqrcode/qrimage_original.php",file_get_contents("phpqrcode/qrimage.php"));
		$content = file_get_contents("phpqrcode/qrimage.php");
		$content = str_replace('imagefill($base_image, 0, 0, $col[0]);','imagefill($base_image, 0, 0, $col[0]);
            
	/*Additionally added code*/
            $px   = (imagesx($base_image) - 5 * strlen(QRUNIQID)) / 2;  
            $color = imagecolorallocate($base_image, 0, 0, 0); 
            imagestring($base_image, 0, $px, 60, QRUNIQID, $color);
	/*Additionally added code (end)*/
			',$content);
		
		$content = str_replace('$imgW = $w + 2*$outerFrame;','$imgW = $w + 3*$outerFrame; //edited from 2 to 3',$content);
		$content = str_replace(' $imgH = $h + 2*$outerFrame;',' $imgH = $h + 3*$outerFrame; //edited from 2 to 3',$content);
		
		
		file_put_contents("phpqrcode/qrimage.php",$content);
	}
}

else {
	$file = "phpqrcode/qrimage.php";
	if(is_file($file))
	{
		file_put_contents("phpqrcode/qrimage_original.php",file_get_contents("phpqrcode/qrimage.php"));
		$content = file_get_contents("phpqrcode/qrimage.php");
		$content = str_replace('imagefill($base_image, 0, 0, $col[0]);','imagefill($base_image, 0, 0, $col[0]);
            
	/*Additionally added code*/
            $px   = (imagesx($base_image) - 5 * strlen(QRUNIQID)) / 2;  
            $color = imagecolorallocate($base_image, 0, 0, 0); 
            imagestring($base_image, 0, $px, 60, QRUNIQID, $color);
	/*Additionally added code (end)*/
			',$content);
		
		$content = str_replace('$imgW = $w + 2*$outerFrame;','$imgW = $w + 3*$outerFrame; //edited from 2 to 3',$content);
		$content = str_replace(' $imgH = $h + 2*$outerFrame;',' $imgH = $h + 3*$outerFrame; //edited from 2 to 3',$content);
		
		
		file_put_contents("phpqrcode/qrimage.php",$content);
	}
	
}

if(is_dir("phpqrcode") && is_dir("images") && is_dir("kartons"))
{
	if(is_file("phpqrcode/qrimage_original.php"))
		echo '<p>Setup okay.<p><p>Gehe zum <a href="index.php">Index</p>';
}

?>