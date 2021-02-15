<!-- formulaire d'upload-->
<form method="post" enctype="multipart/form-data" action="">
	<p>
		<input type="file" name="file" size="30">
		<input type="submit" name="upload" value="Envoyer">
	</p>
</form>

<?php
function getExtension($str) 
{

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}
if(isset($_POST['upload']))
{
	define ("MAX_SIZE",	"400");
	$errors	=	0;
	$filename		=	$_FILES["file"]["name"];
	$uploadedfile 	= 	$_FILES['file']['tmp_name'];
	$type_file 		= $_FILES['file']['type'];
	if ($filename) 
	{
		if( !is_uploaded_file($uploadedfile) )
		{
			exit("Le fichier est introuvable");
		}
		// on vérifie maintenant l'extension
		elseif( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') )
		{
			exit("Le fichier n'est pas une image");
		}
		else
		{
			$size		=	filesize($_FILES['file']['tmp_name']);
			if ($size > MAX_SIZE*4024)
			{
				exit ("verifier la taille de votre image!!");
				$errors=1;
			}
			$extension 	= 	getExtension($filename);
			$extension 	= 	strtolower($extension);
			if($extension=="jpg" || $extension=="jpeg" )
			{
				$uploadedfile 	= 	$_FILES['file']['tmp_name'];
				$src 			= 	imagecreatefromjpeg($uploadedfile);
			}
			else if($extension=="png")
			{
				$uploadedfile 	= 	$_FILES['file']['tmp_name'];
				$src 			= 	imagecreatefrompng($uploadedfile);
			}
			else 
				$src 	= 	imagecreatefromgif($uploadedfile);
			
			list($width,$height)	=	getimagesize($uploadedfile);

			$newwidth	=	60;
			$newheight	=	($height/$width)*$newwidth;
			$tmp		=	imagecreatetruecolor($newwidth,$newheight);

			$newwidth1	=	25;
			$newheight1	=	($height/$width)*$newwidth1;
			$tmp1		=	imagecreatetruecolor($newwidth1,$newheight1);

			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			imagecopyresampled($tmp1, $src, 0, 0, 0, 0, $newwidth1, $newheight1, $width, $height);

			$filename 	= 	"". $_FILES['file']['name'];
			$filename1 	= 	"small". $_FILES['file']['name'];

			imagejpeg($tmp,$filename,100);
			imagejpeg($tmp1,$filename1,100);

			imagedestroy($src);
			imagedestroy($tmp);
			imagedestroy($tmp1);
			echo "miniature: <img src='{$filename1}'/><br/><br/>";
			echo "image originale: <img src='{$filename}'/>";
		}
	}
	
}
	
?>