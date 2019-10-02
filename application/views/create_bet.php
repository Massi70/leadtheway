<script src="<?php echo base_url();?>js/ajaxupload.js">

var coins= '<?php echo $user_coins['user_coins'];?>';

</script>

<!----Popup----->

<div class="popup_mobs" style="display:none; top:50%" id="success_msg">

  <h1>Bet Create Sucessfully</h1>

  <a href="#_" class="acpt_btn" style="margin-left:90px;" >Done</a> </div>

<!---- End popup----->

<div class="registarion_lft">

  <h1>Propose Bet</h1>

  <div class="form_registration"> 

    <script type='text/javascript'><!--

			$(document).ready(function() {

				enableSelectBoxes();

			});//-->

		

		</script>

    <form name="bet_form" id="bet_form" enctype="multipart/form-data" method="post" >

      <div class="reg_field_form">

        <label class="register_form_lbl">Title:</label>

        <input type="text" class="register_form_cnt" name="title"  id="title"/>

        <input type="hidden" class="register_form_cnt" name="coins"  id="coins" value="<?php echo $user_coins['user_coins'];?>"/>

      </div>

      <div class="reg_field_form">

        <label class="register_form_lbl">Category:</label>

        <div class='selectBox' > <span class='selected' ></span> <span class='selectArrow'>&#9660</span>

          <div id="select_category" class="selectOptions" style="width:98%;border:none; border: 1px solid gray;" > <span class="selectOption" value="">Select</span>

            <?php foreach($category as $cat){?>

            <span class="selectOption" value="<?php echo $cat['category_id'];?>"><?php echo  $cat['category_name'];?></span>

            <?php }?>

          </div>

        </div>

      </div>

      <div class="reg_field_form">

        <label class="register_form_lbl">Question:</label>

        

        <!-- <input type="text" class="register_form_msg" name="question" />-->

        

        <textarea class="register_form_msg" name="question" id="question"></textarea>

      </div>

      <div class="reg_field_form">

        <label class="register_form_lbl">Answer type:</label>

        <div class='selectBox'> <span class='selected'></span> <span class='selectArrow'>&#9660</span>

          <div id="question_type" class="selectOptions" style="width:98%;border:none; border: 1px solid gray;" > <span class="selectOption" value="">Select</span> <span class="selectOption" value="Text">Text</span> <span class="selectOption" value="Image">Image</span> <span class="selectOption" value="Video">Video</span> </div>

        </div>

      </div>

      <div class="reg_field_form" id="question_text" style="display:none;">

        <div class="reg_field_form">

          <label class="register_form_lbl">My Answer:</label>

          <input type="text" class="register_form_ans" name="my_answer" id="my_ans" />

        </div>

        <div class="reg_field_form">

          <label class="register_form_lbl">Your Answer:</label>

          <input type="text" class="register_form_ans" name="your_answer"  id="you_ans"/>

        </div>

      </div>

      

      <!--<div class="reg_field_form"  id="question_image" style="display:none;">

            	 <div class="reg_field_form">

            	<label class="register_form_lbl">My Image:</label>

                <a href="#_" id="myImage">Image upload</a>

                 <span id="status"></span>

                 <ul id="files"></ul>

               <input type="hidden"  name="my_image" id="my_image" value=""  />

            	</div>

            

           		<div class="reg_field_form">

            	<label class="register_form_lbl">Your Image:</label>

                 <a href="#_" id="youImage">Image upload</a>

                 <span id="youStatus"></span>

                 <ul id="youFiles"></ul>

               <input type="hidden"  name="your_image" id="your_image" value=""  />

           		</div>

            </div>-->

      

      <div class="reg_field_form"  id="question_image" style="display:none;">

        <div class="reg_field_form">

          <label class="register_form_lbl">My Image:</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <a href="#_" id="myImage"><img src="<?php echo base_url();?>images/upload.png" /></a> <span id="status"></span>

          <div id="files"></div>

          <input type="hidden"  name="my_image" id="my_image" value=""  />

        </div>

        <div class="reg_field_form">

          <label class="register_form_lbl">Your Image:</label>

          &nbsp;

          <a href="#_" id="youImage"><img src="<?php echo base_url();?>images/upload.png" /></a> <span id="youStatus"></span>

          <div id="youFiles"></div>

          <input type="hidden"  name="your_image" id="your_image" value=""  />

        </div>

      </div>

      <div class="reg_field_form"  id="question_video"  style="display:none;">

        <div class="reg_field_form">

          <label class="register_form_lbl">My Video:</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <a href="#_" id="myVideo"><img src="<?php echo base_url();?>images/video_upload.png" /></a> <span id="youStatus"></a> <span id="myVideoStatus"></span>

          <div id="myVideofiles"></div>

          <input type="hidden"  name="my_video" id="my_video" value=""  />

        </div>

        <div class="reg_field_form">

          <label class="register_form_lbl">Your Video:</label>

          &nbsp;

          <a href="#_" id="yourVideo"><img src="<?php echo base_url();?>images/video_upload.png" /></a> <span id="youStatus"></a> <span id="yourVideoStatus"></span>

          <div id="yourVideofiles"></div>

          <input type="hidden"  name="your_video" id="your_video" value=""  />

        </div>

      </div>

      

      <!--<div class="reg_field_cont"  id="question_video"  style="display:none;">

            	<div class="reg_field_cont">

            	<label class="register_content">My Video:</label>

                <input type="file" class="register_msg_answer" name="my_video" id="my_vdo" />

            	</div>

            

           		<div class="reg_field_cont">

            	<label class="register_content">Your Video:</label>

                <input type="file" class="register_msg_answer" name="your_video" id="you_vdo" />

           		</div>

            </div>--> 

      

      <!-- <div class="reg_field_cont">

            	<label class="register_content">My Answer:</label>

                <input type="text" class="register_msg_answer" name="my_answer" />

            </div>

            

            <div class="reg_field_cont">

            	<label class="register_content">Your Answer:</label>

                <input type="text" class="register_msg_answer" name="your_answer" />

            </div>-->

      

      <div class="reg_field_form">

        <label class="register_form_lbl">Wager:</label>

        <input type="text" class="register_form_ans"  name="wager" id="wager" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="8"/>

      </div>

      <div class="reg_field_form">

        <label class="register_form_lbl">Post:</label>

        <div style="float:left;">

          <label class="post_label">Post to Wall</label>

          <input name="post" id="post" type="radio" value="wall" class="rdo_btn" />

        </div>

        <div style="float:left;">

          <label class="post_label">Post to Gen Fourm</label>

          <input name="post"id="post" type="radio" value="forum" class="rdo_btn" />

        </div>

        <div style="float:left;">

          <label class="post_label">Both</label>

          <input name="post" id="post" type="radio" value="both" class="rdo_btn" />

        </div>

      </div>

      <div class="reg_field_form">

        <label class="register_form_lbl">Time Limit:</label>

        <div class='selectBox'> <span class='selected' style="width:220px;"></span> <span class='selectArrow'>&#9660</span>

          <div id="time_limit" class="selectOptions" style="width:98%;border:none;height:

            150px;overflow:auto; border: 1px solid gray;" > <span class="selectOption" value="">Select</span>

            <?php for($i=1;$i<=30;$i++){?>

            <span class="selectOption" value="<?php echo $i;?>"><?php echo $i;?></span>

            <?php } ?>

          </div>

        </div>

        <div class="time_limet">1-30 Days</div>

      </div>

      <div class="reg_field_form">

        <label class="register_form_lbl">Expiration:</label>

        <div class='selectBox'> <span class='selected' style="width:220px;"></span> <span class='selectArrow'>&#9660</span>

          <div id="expiration" class="selectOptions" style="width:98%;border:none;height:

            150px;overflow:auto; border: 1px solid gray;" > <span class="selectOption" value="">Select</span>

            <?php for($i=1;$i<=7;$i++){?>

            <span class="selectOption" value="<?php echo $i;?>"><?php echo $i;?></span>

            <?php } ?>

          </div>

        </div>

        <div class="time_limet">1-7 Days</div>

      </div>

      <div class="reg_field_form">

        <label class="register_form_lbl">Tount Friend:</label>

        <input type="text" class="register_form_cnt" name="tount_friend" id="tount_friend" />

      </div>

      <div class="reg_field_form"> <a href="#" class="reg_btn" onclick="submit_form();">Submit</a> <a href="#" class="reg_btn"><span id="home">cancel</span></a> <span id="ajax_loader"></span> </div>

      <input type="hidden" name="category" id="category" value="" />

      <input type="hidden" name="answer_type" id="answer_type" value="" />

      <input type="hidden" name="timelimit" id="timelimit" value="" />

      <input type="hidden" name="expire" id="expire" value="" />

    </form>

  </div>

</div>

<div class="registarion_rhgt">

  <h1>Profile</h1>

  <ul class="bullets_prof">

    <li>Total Coins (<?php echo $user_coins['user_coins'];?>)</li>

    <li>Total Wins (<?php echo $user_coins['total_win'];?>)</li>

    <li>Total Lost (<?php echo ($lost_bet['lost_bet']-$user_coins['total_win']);?>)</li>

  </ul>

</div>

<script>

	

<!----Image uploader----->

$(function(){

		var btnUpload=$('#myImage');

		var status=$('#status');

		new AjaxUpload(btnUpload, {

			action: '<?php echo base_url();?>index/uploadPicture',

			name: 'UploadMyImage',

			onSubmit: function(file, ext){

				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 

					// extension is not allowed 

					status.text('Only JPG, PNG or GIF files are allowed');

					return false;

				}

				status.text('Uploading...');

			},

			onComplete: function(file, response){

				//On completion clear the status

				status.text('');

				//Add uploaded file to list

				if(response=="0" || response==0){

					document.getElementById("my_image").value='';

					//$('<li></li>').appendTo('#files').text(file).addClass('error');

					$('#files').text(file).addClass('error');

				} else{

					var image_link = response;

					document.getElementById("files").innerHTML='';

					document.getElementById("my_image").value=image_link;

					$('#files').html('<img src="<?php echo base_url();?>images/bet_images/'+image_link+'" alt="" width="75" />').addClass('success');

					//$('<li></li>').appendTo('#files').html('<img src="<?php echo base_url();?>images/bet_images/'+image_link+'" alt="" width="75"/><br />'+file).addClass('success');

					

				}

			}

		});

		

	});

	

$(function(){

		var btnUpload=$('#youImage');

		var status=$('#youStatus');

		new AjaxUpload(btnUpload, {

			action: '<?php echo base_url();?>index/uploadPicture',

			name: 'UploadMyImage',

			onSubmit: function(file, ext){

				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 

					// extension is not allowed 

					status.text('Only JPG, PNG or GIF files are allowed');

					return false;

				}

				status.text('Uploading...');

			},

			onComplete: function(file, response){

				//On completion clear the status

				status.text('');

				//Add uploaded file to list

				if(response=="0" || response==0){

					document.getElementById("your_image").value='';

					//$('<li></li>').appendTo('#youFiles').text(file).addClass('error');

					$('#youFiles').text(file).addClass('error');

				} else{

					var image_link = response;

				    document.getElementById("youFiles").innerHTML='';

					document.getElementById("your_image").value=image_link;

					$('#youFiles').html('<img src="<?php echo base_url();?>images/bet_images/'+image_link+'" alt="" width="75"/>').addClass('success');

					//$('<li></li>').appendTo('#youFiles').html('<img src="<?php echo base_url();?>images/bet_images/'+image_link+'" alt="" width="75"/><br />'+file).addClass('success');

					

				}

			}

		});

		

	});

	

	<!----video uploader----- >

$(function(){

		var btnUpload=$('#myVideo');

		var status=$('#myVideoStatus');

		new AjaxUpload(btnUpload, {

			action: '<?php echo base_url();?>index/uploadVideo',

			name: 'UploadMyVideo',

			onSubmit: function(file, ext){

				 if (! (ext && /^(mov|mp4)$/.test(ext))){ 

					// extension is not allowed 

					status.text('Only mov,or mp4 files are allowed');

					return false;

				}

				status.text('Uploading...');

			},

			onComplete: function(file, response){

				//On completion clear the status

				status.text('');

				//Add uploaded file to list

				if(response=="0" || response==0){

					document.getElementById("my_video").value='';

					$('#myVideofiles').text(file).addClass('error');

				} else{

					var image_link = response;

					document.getElementById("myVideofiles").innerHTML='';

					document.getElementById("my_video").value=image_link;

					$('#myVideofiles').html('<img width="75" alt="" src="<?php echo base_url();?>images/1359749761_video-icon.png" onclick="open_video(\''+image_link+'\');">').addClass('success');

					

				}

			}

		});

		

	});

	

$(function(){

		var btnUpload=$('#yourVideo');

		var status=$('#yourVideoStatus');

		new AjaxUpload(btnUpload, {

			action: '<?php echo base_url();?>index/uploadVideo',

			name: 'UploadMyVideo',

			onSubmit: function(file, ext){

				 if (! (ext && /^(mov|mp4)$/.test(ext))){ 

					// extension is not allowed 

					status.text('Only mov,or mp4 files are allowed');

					return false;

				}

				status.text('Uploading...');

			},

			onComplete: function(file, response){

				//On completion clear the status

				status.text('');

				//Add uploaded file to list

				if(response=="0" || response==0){

					document.getElementById("your_video").value='';

					$('#yourVideofiles').text(file).addClass('error');

				} else{

					var image_link = response;

					document.getElementById("yourVideofiles").innerHTML='';

					document.getElementById("your_video").value=image_link;

					$('#yourVideofiles').html('<img width="75" alt="" src="<?php echo base_url();?>images/1359749761_video-icon.png" onclick="open_video(\''+image_link+'\');">').addClass('success');

					

				}

			}

		});

		

	});

<!-----end------>

</script>