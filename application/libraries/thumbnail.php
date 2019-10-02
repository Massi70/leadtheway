<?php
class thumbnail 
{
	function createthumbs($pathToImages, $pathToThumbs, $thumbWidth , $thumbHeight)
{ 
	
	
	$info = pathinfo($pathToImages);
	
	//create thumb if image type is png
    if( strtolower($info['extension']) == 'png' ) 
    {     
	  $f = $info['dirname']."/".$info['basename'];	 
      $img = imagecreatefrompng( "{$f}" );
      $width = imagesx( $img );
      $height = imagesy( $img );
      $new_width = $thumbWidth;
      $new_height = $thumbHeight;
     // $new_height = floor( $height * ( $thumbWidth / $width ) );	  
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
	  $white = imagecolorallocate( $tmp_img, 255, 255, 255);
	  // make background white
	  imagefilledrectangle($tmp_img, 275, 272, 0, 0, $white);
	  imagecolortransparent( $tmp_img, $white);
	  //resize image
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
      imagepng( $tmp_img, $pathToThumbs);	  
    }
	//create thumb if image type is gif
	else if( strtolower($info['extension']) == 'gif' ) 
    {     
	  $f = $info['dirname']."/".$info['basename'];	 
      $img = imagecreatefromgif( "{$f}" );
      $width = imagesx( $img );
      $height = imagesy( $img );
      $new_width = $thumbWidth;
      $new_height = $thumbHeight;  
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
      imagegif( $tmp_img, $pathToThumbs);	  
    }
	//create thumb if image type is jpg
	else if( (strtolower($info['extension']) == 'jpg') || strtolower($info['extension']) == 'jpeg') 
    {     
	  $f = $info['dirname']."/".$info['basename'];	 
      $img = imagecreatefromjpeg( "{$f}" );
      $width = imagesx( $img );
      $height = imagesy( $img );
      $new_width = $thumbWidth;
      $new_height = $thumbHeight;
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
      imagejpeg( $tmp_img, $pathToThumbs);	  
    }
return $pathToThumbs;
}
}

?>