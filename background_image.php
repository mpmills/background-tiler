<?php

// get file name
$filename = isset($_GET["f"]) ? $_GET["f"] : "bgCanvas1.png";

$out_image = backgroundTiler($filename);

header("Content-type: image/png");
imagepng($out_image);
imagedestroy($out_image);

function backgroundTiler($fileName){

	$img = imagecreatefrompng($fileName);

	$size_x = imagesx($img);
	$size_y = imagesy($img);

	// image positioning
	$x1 = 0;
	$y1 = 0;
	$x2 = $size_x;
	$y2 = $size_y;

	// new image sizes
	$out_size_x = $size_x * 2;
	$out_size_y = $size_y * 2;

	// 1. create a blank image of the appropriate size
	// create the new outimage of twice the width and twice the height
	$out_image = imagecreatetruecolor($out_size_x, $out_size_y);

	// 2. assign transparency, set alphablending to false and set savealpha to true;
	// assign transparency to the new image
	imagecolortransparent($out_image, imagecolorallocate($out_image, 0, 0, 0));
	imagealphablending($out_image, false);
	imagesavealpha($out_image, true);

	//imagecopyresampled ($dst_image, $src_image ,      $dst_x,	$dst_y,	$src_x , 		$src_y, 		$dst_w , $dst_h, 	$src_w, 	$src_h )
	$topLeft = imagecopyresampled($out_image, $img, 	$x1, 	$y1,	0, 				0, 				$size_x, $size_y, 	$size_x, 	$size_y);
	$topRight = imagecopyresampled($out_image, $img, 	$x2, 	$y1,	($size_x-1), 	0, 				$size_x, $size_y, 	0-$size_x, 	$size_y);
	$bottomLeft = imagecopyresampled($out_image, $img, 	$x1, 	$y2,	0, 				($size_y-1),	$size_x, $size_y, 	$size_x, 	0-$size_y);
	$bottomRight = imagecopyresampled($out_image, $img, $x2, 	$y2,	($size_x-1),	($size_y-1), 	$size_x, $size_y, 	0-$size_x, 	0-$size_y);

	return $out_image;
}

?>