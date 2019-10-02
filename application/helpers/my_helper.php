<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function thumbnail($imgSrc,$width,$height,$imgUrl,$type='gallery'){

	$size=getimagesize($imgSrc);

	$originalWidth=$size[0];

	$originalHeight=$size[1];

	$factor = min ( $width / $originalWidth, $height / $originalHeight);

	

	if($originalWidth>$width){

		$newWidth=round ($originalWidth * $factor);

	}else{

		$newWidth=$originalWidth;

	}

	if($originalHeight>$height){

		$newHeight=round ($originalHeight * $factor);

	}else{

		$newHeight=$originalHeight;

	}

	$margin= 0;

	

	if($newHeight<$height){

		$margin=floor(($height-$newHeight)/2);

	} 

	if($type=='header'){

		return "<img  src='".$imgUrl."' width='".$newWidth."' height='".$newHeight."' style='margin:".$margin."px 0px; '>";

	}else{

		return "<img  src='".$imgUrl."' width='".$newWidth."' height='".$newHeight."' style='margin:".$margin."px 0px; ' class='vidimg'>";

	}

}

function thumbnail2($imgSrc,$width,$height,$imgUrl,$originalWidth,$originalHeight){

	/*$size=getimagesize($imgSrc);

	$originalWidth=$size[0];

	$originalHeight=$size[1];*/



	$factor = min ( $width / $originalWidth, $height / $originalHeight);

	

	if($originalWidth>$width){

		$newWidth=round ($originalWidth * $factor);

	}else{

		$newWidth=$originalWidth;

	}

	if($originalHeight>$height){

		$newHeight=round ($originalHeight * $factor);

	}else{

		$newHeight=$originalHeight;

	}

	$margin= 0;

	

	if($newHeight<$height){

		$margin=floor(($height-$newHeight)/2);

	} 



	return "<img  src='".$imgUrl."' width='".$newWidth."' height='".$newHeight."' style='margin:".$margin."px 0px; '>";

	

}

function nicetime($date,$currentTime)

{

    if(empty($date)) {

        return "No date provided";

    }

   

    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

    $lengths         = array("60","60","24","7","4.35","12","10");

   

    $now             =$currentTime;

    $unix_date         = $date;

   

       // check validity of date

    if(empty($unix_date)) {   

        return "Bad date";

    }



    // is it future date or past date

    if($now > $unix_date) {   

        $difference     = $now - $unix_date;

        $tense         = "ago";

       

    } else {

        $difference     = $unix_date - $now;

        $tense         = "from now";

    }

   

    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {

        $difference /= $lengths[$j];

    }

   

    $difference = round($difference);

   

    if($difference != 1) {

        $periods[$j].= "s";

    }

   

    return "$difference $periods[$j] {$tense}";

}

function d($arr){

	echo "<pre>";

		print_r($arr);

	echo "</pre>";

}

function resizImage($file, $width = 0, $height = 0, $proportional = true, $output = 'file', $delete_original = false ){

if ( $height <= 0 && $width <= 0 ) { return false; }

	

$info = getimagesize($file);

$image = '';



$final_width = 0;

$final_height = 0;

list($width_old, $height_old) = $info;

	

if ($proportional) 

{

	if ($width == 0){

		 $factor = $height/$height_old;

	}elseif ($height == 0){

		 $factor = $width/$width_old;

	}else{ 

		$factor = min ( $width / $width_old, $height / $height_old);

	}

	

	if($width_old>$width){	

		$final_width = round ($width_old * $factor);

	}else{

		$final_width = $width_old;

	}

	if($height_old>$height){

		$final_height = round ($height_old * $factor);

	}else{

		$final_height = $height_old;

	}

} 

else

{

	$final_width = ( $width <= 0 ) ? $width_old : $width;

	$final_height = ( $height <= 0 ) ? $height_old : $height;

}

	

switch ($info[2]) 

{

	case IMAGETYPE_GIF:

	$image = imagecreatefromgif($file);

	break;

	

	case IMAGETYPE_JPEG:

	$image = imagecreatefromjpeg($file);

	break;

	

	case IMAGETYPE_PNG:

	$image = imagecreatefrompng($file);

	break;

	

	default:

	return false;

}

	

$image_resized = imagecreatetruecolor( $final_width, $final_height );

if(($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) 

{

$trnprt_indx = imagecolortransparent($image);



// If we have a specific transparent color

if($trnprt_indx >= 0) 

				 {

	

						 // Get the original image's transparent color's RGB values

						 $trnprt_color    = imagecolorsforindex($image, $trnprt_indx);

	

						 // Allocate the same color in the new image resource

						 $trnprt_indx    = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

	

						 // Completely fill the background of the new image with allocated color.

						 imagefill($image_resized, 0, 0, $trnprt_indx);

	

						 // Set the background color for new image to transparent

						 imagecolortransparent($image_resized, $trnprt_indx);

	

	

				 }

				 // Always make a transparent background color for PNGs that don't have one allocated already

				 elseif ($info[2] == IMAGETYPE_PNG) 

				 {

	

						 // Turn off transparency blending (temporarily)

						 imagealphablending($image_resized, false);

	

						 // Create a new transparent color for image

						 $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);

	

						 // Completely fill the background of the new image with allocated color.

						 imagefill($image_resized, 0, 0, $color);

	

						 // Restore transparency blending

						 imagesavealpha($image_resized, true);

				 }

		 }

		 

		 if(imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old))

		 {

			  echo "";

		 } 

		 else

		 {

				echo "<span class='failed'>FAILED at 'imagecopyresampled' !!</span>";

		 }

		 //

		 $matrix = array(    

										array( -1, -1, -1 ),

										array( -1, 16, -1 ),

										array( -1, -1, -1 ) 

										);

		$divisor = 8;

		$offset = 0;							

		imageconvolution($image_resized, $matrix, $divisor, $offset);

		//

		 if($delete_original) @unlink($file);

		 //

		 switch (strtolower($output))

		 {

				 case 'browser':

						 $mime = image_type_to_mime_type($info[2]);

						 header("Content-type: $mime");

						 $output = NULL;

				 break;

				 case 'file':

						 $output = $file;

				 break;

				 case 'return':

						 return $image_resized;

				 break;

				 default:

				 break;

		 }

	

		 switch ($info[2])

		 {

				 case IMAGETYPE_GIF:

						 if (!imagegif($image_resized, $output)){return false;};

				 break;

				 case IMAGETYPE_JPEG:

						 if (!imagejpeg($image_resized, $output, 100)){return false;};

				 break;

				 case IMAGETYPE_PNG:

						 if (!imagepng($image_resized, $output)){return false;};

				 break;

				 default:

						 return false;

		 }

		 imagedestroy($image_resized);

		 return true;

	

	}
?>