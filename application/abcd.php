<form method="post" action="http://developer.avenuesocial.com/azeemsal/missfire/missfireservices/image/" enctype="multipart/form-data" >
Upload: <input type="file" name="file"  />
<input type="submit" />
</form>


<?php
 function image(){

			if($_FILES['file']['name'] == false || $_FILES['file']['name'] == ""){
				echo "Image Missing";
			}else{
			  $imgName = time().".jpg";
			  $imgPath = BASEPATH."../uploads/".$imgName;
			  $image = base_url().'uploads/'.$imgName;

			  move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath);

			  $this->load->library('imagethumb');
			  $photo = $this->imagethumb->image(base_url().'/uploads/profiles/'.$imgName.'.jpg',126,0);   
			  $this->imagethumb->image(base_url().'/uploads/profiles/'.$imgName.'.jpg',68,68);

			  $data = array(
				'image'=>$imgName,
				'image_path'=>$image
				);
				echo  "Image Inserted Successfully";
			}
 	}
?>