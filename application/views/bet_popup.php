<script src="<?php echo base_url();?>js/ajaxupload.js"></script>
<div class="popup_mobs_rgister" id="close_popup" >
    	<div class="cross" ><img src="<?php echo base_url();?>images/cros.png" onClick="close_popup();"/></div>
        <h1>Conter Bet</h1>
        <div class="content_box_reg">
        <script type='text/javascript'><!--

			$(document).ready(function() {
				enableSelectBoxes();
			});
			//-->
		</script>
        <form name="repropse_form" id="repropse_form" enctype="multipart/form-data" method="post" >
        	<div class="reg_field_cont">
            <input type="hidden" class="register_form_cnt" name="coins"  id="coins" value="<?php echo $user_coins['user_coins'];?>"/>
            	<label class="register_content">Title:</label>
                <input type="text" class="register_field" name="title"  id="title" value="<?php echo $bet_data['title'];?>"/>
            </div>
            
            <div class="reg_field_cont">
            	<label class="register_content">Category:</label>
              <div class='selectBox' style="margin-left:10px;" id="abc" >
			<span class='selected' ></span>
			<span class='selectArrow'>&#9660</span>
			<div id="select_category" class="selectOptions" style="width:98%;border:none; border: 1px solid gray;" >
           		<span class="selectOption" value="">Select</span>
				<?php foreach($category as $cat){?>
                <span <?php if($cat['category_id']==$bet_data['category_id']){ ?>class="selectOption selectedOption"<?php }else{?>class="selectOption"<?php }?> value="<?php echo $cat['category_id'];?>"><?php echo  $cat['category_name'];?></span>
				<?php }?>
        </div>
		</div>
            </div>
            
            <div class="reg_field_cont">
            	<label class="register_content">Question:</label>
                <input type="text" class="register_msg_field" name="question"  id="question"value="<?php echo $bet_data['question'];?>" />
            </div>
            
            <div class="reg_field_cont">
            	<label class="register_content">Answer type:</label>
                <div class='selectBox' style="margin-left:10px;">
			<span class='selected'></span>
			<span class='selectArrow'>&#9660</span>
			<div id="question_type" class="selectOptions" style="width:98%;border:none; border: 1px solid gray;" >
            	<span class="selectOption" value="">Select</span>
				<span <?php if($bet_data['answer_type']=='Text'){ ?>class="selectOption selectedOption"<?php }else{?>class="selectOption"<?php }?> value="<?php echo $bet_data['answer_type'];?>">Text</span>
				<span <?php if($bet_data['answer_type']=='Image'){ ?>class="selectOption selectedOption"<?php }else{?>class="selectOption"<?php }?> value="<?php echo $bet_data['answer_type'];?>">Image</span>
				<span <?php if($bet_data['answer_type']=='Video'){ ?>class="selectOption selectedOption"<?php }else{?>class="selectOption"<?php }?> value="<?php echo $bet_data['answer_type'];?>">Video</span>
			</div>
		</div>
            </div>
            
            <?php if($bet_data['answer_type']=='Text'){$style='style="display:block;"';}else{$style='style="display:none;"';}?>
               <div class="reg_field_cont" id="question_text" <?php echo $style;?>>
            	 <div class="reg_field_cont">
            	<label class="register_content">My Answer:</label>
                <input type="text" class="register_msg_answer" name="my_answer" id="my_ans" value="<?php echo $bet_data['my_answer'];?>"/>
            	</div>
            
           		<div class="reg_field_cont">
            	<label class="register_content">Your Answer:</label>
                <input type="text" class="register_msg_answer" name="your_answer"  id="you_ans" value="<?php echo $bet_data['your_answer'];?>"/>
           		</div>
            </div>
            
             <?php if($bet_data['answer_type']=='Image'){$style='style="display:block;"';}else{$style='style="display:none;"';}?>
               <div class="reg_field_cont"  id="question_image" <?php echo $style;?>>
            	 <div class="reg_field_cont">
            	<label class="register_content">My Image:</label>
                <a href="#_" id="myImage"><img src="<?php echo base_url();?>images/upload.png" /></a>
                 <span id="status"></span>
                <div id="files">
                 <img width="75" alt="" src="<?php echo base_url();?>images/bet_images/<?php echo $bet_data['my_answer'] ?>" <?php echo $style;?>>
                </div>
                 <?php /*?><ul id="files">
                   <!---update--->
                 <li class="success">
                <img width="75" alt="" src="<?php echo base_url();?>images/bet_images/<?php echo $bet_data['my_answer'] ?>">
                <br>
                <?php echo $bet_data['my_answer'] ;?>
                </li>
                 <!---end update--->
                 </ul><?php */?>
               <input type="hidden"  name="my_image" id="my_image"  value="<?php echo $bet_data['my_answer'];?>"/>
            	</div>
            
           		<div class="reg_field_cont">
            	<label class="register_content">Your Image:</label>
                 <a href="#_" id="youImage"><img src="<?php echo base_url();?>images/upload.png" /></a>
                 <span id="youStatus"></span>
                <div id="youFiles">
                <img width="75" alt="" src="<?php echo base_url();?>images/bet_images/<?php echo $bet_data['your_answer'] ?>" <?php echo $style;?>>
                </div>
               <?php /*?>  <ul id="youFiles">
                  <!---update--->
                  <li class="success">
                <img width="75" alt="" src="<?php echo base_url();?>images/bet_images/<?php echo $bet_data['your_answer'] ?>">
                <br>
                <?php echo $bet_data['your_answer'] ;?>
                </li>
                <!---end update--->
                 </ul><?php */?>
               <input type="hidden"  name="your_image" id="your_image" value="<?php echo $bet_data['your_answer'];?>" />
           		</div>
            </div>
            
            <?php if($bet_data['answer_type']=='Video'){$style='style="display:block;"';}else{$style='style="display:none;"';}?>
        	   <div class="reg_field_cont"  id="question_video"  <?php echo $style;?>>
            	<div class="reg_field_cont">
            	<label class="register_content">My Video:</label>
                 <a href="#_" id="myVideo"><img src="<?php echo base_url();?>images/video_upload.png" /></a>
                 <span id="myVideoStatus"></span>
                 <div id="myVideofiles">
                 <img width="75" alt="" src="<?php echo base_url();?>images/1359749761_video-icon.png" <?php echo $style;?>></div>
               <input type="hidden"  name="my_video" id="my_video" value="<?php echo $bet_data['my_answer'];?>" />
            	</div>
            
           		<div class="reg_field_cont">
            	<label class="register_content">Your Video:</label>
                <a href="#_" id="yourVideo"><img src="<?php echo base_url();?>images/video_upload.png" /></a>
                 <span id="yourVideoStatus"></span>
                 <div id="yourVideofiles"> <img width="75" alt="" src="<?php echo base_url();?>images/1359749761_video-icon.png" <?php echo $style;?>></div>
               <input type="hidden"  name="your_video" id="your_video" value="<?php echo $bet_data['your_answer'];?>"  />
           		</div>
            </div>
            
            
            <div class="reg_field_cont">
            	<label class="register_content">Wager:</label>
                <input type="text" class="register_field" name="wager" value="<?php echo $bet_data['wager'];?>" id="wager" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="8" />
            </div>
            
            <div class="reg_field_cont">
            	<label class="register_content">Post:</label>
              <div style="float:left;">
                <label class="post_label">Post to Wall</label>
        <?php  if($bet_data['post']=='wall'){$select='checked="checked"';}else{$select='';}?>
              <input name="post"  id="post" type="radio" value="wall" class="rdo_btn" <?php echo $select;?>/>
                </div>
                <div style="float:left;">
                <label class="post_label">Post to Gen Fourm</label>
        <?php  if($bet_data['post']=='forum'){$select='checked="checked"';}else{$select='';}?>
            <input name="post"  id="post" type="radio" value="forum" class="rdo_btn" <?php echo $select;?> />
                </div>
                <div style="float:left;">
                <label class="post_label">Both</label>
         <?php  if($bet_data['post']=='both'){$select='checked="checked"';}else{$select='';}?>
             <input name="post"  id="post" type="radio" value="both" class="rdo_btn" <?php echo $select;?> />
                </div>
                
            </div>
            
            <div class="reg_field_cont">
            	<label class="register_content">Time Limit:</label>
                <div class='selectBox'  style="margin-left:10px;">
			<span class='selected' style="width:220px;"></span>
			<span class='selectArrow'>&#9660</span>
			<div id="time_limit" class="selectOptions" style="width:98%;border:none;height:
            150px;overflow:auto; border: 1px solid gray;" >
           		 <span class="selectOption" value="">Select</span>
				<?php for($i=1;$i<=30;$i++){?>
                <span <?php if($bet_data['time_limit']==$i){ ?>class="selectOption selectedOption"<?php }else{?>class="selectOption"<?php }?> value="<?php echo $i;?>"><?php echo $i;?></span>
                <?php } ?>
			</div>
		</div>
        <div class="time_limet">1-30 Days</div>
            </div>
            
            <div class="reg_field_cont">
            	<label class="register_content">Expiration:</label>
                <div class='selectBox' style="margin-left:10px;" <?php echo 'value="'.$bet_data['expiration'].'"';?>>
			<span class='selected' style="width:220px;"><?php echo $bet_data['expiration'];?></span>
			<span class='selectArrow'>&#9660</span>
			<div id="expiration" class="selectOptions" style="width:98%;border:none;height:
            150px;overflow:auto; border: 1px solid gray;" >
            	<span class="selectOption" value="">Select</span>
                <?php for($i=1;$i<=7;$i++){?>
				<span <?php if($bet_data['expiration']==$i){ ?>class="selectOption selectedOption"<?php }else{?>class="selectOption"<?php }?> value="<?php echo $i;?>"><?php echo $i;?></span>
                 <?php } ?>
			</div>
		</div>
        <div class="time_limet">1-7 Days</div>
            </div>
            
            <div class="reg_field_cont">
            	<label class="register_content">Tount Friend:</label>
                <input type="text" class="register_field" name="tount_friend" value="<?php echo $bet_data['tount_friend'];?>"/>
            </div>
            <span id="bet_oppup_msg" style="color:#F00; font-weight:900; margin-left:15px; width:90%; text-align:right; float:left;"></span>
            <div class="btn_box_reg">
            	<a href="#" class="reg_btn" onclick="submit_repropse(<?php echo $bet_data['category_id'];?>);">Submit</a>
                <a href="#" class="reg_btn" onClick="close_popup();">cancel</a>
                
                <span id="ajax_loader"></span>
                

            </div> 
            <input type="hidden" name="category" id="category" value="<?php echo $bet_data['category_id'];?>" />
            <input type="hidden" name="answer_type" id="answer_type" value="<?php echo $bet_data['answer_type']?>" />
            <input type="hidden" name="timelimit" id="timelimit" value="<?php echo $bet_data['time_limit'];?>" />
            <input type="hidden" name="expire" id="expire" value="<?php echo $bet_data['expiration'];?>" />
            <input type="hidden" name="bet_id" id="bet_id" value="<?php echo $bet_data['bet_id'];?>" />
            <input type="hidden" name="creator_id" id="creator_id" value="<?php echo $bet_data['creater_id'];?>" />
            <input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id;?>" />
            </form>
        </div>
    </div>
    
    <div class="main-popup" id="main-popup_1" style="display:none;">
<div class="cross"><img src="<?php echo base_url();?>images/cros.png" onclick="close_detail();"/></div>

  <div class="popupNew" id="popupnew_1"></div>

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
					$('#files').text(file).addClass('error');
				} else{
					var image_link = response;
					document.getElementById("files").innerHTML='';
					document.getElementById("my_image").value=image_link;
					//$('<li></li>').appendTo('#files').html('<img src="<?php echo base_url();?>images/bet_images/'+image_link+'" alt="" width="75"/><br />'+file).addClass('success');
					$('#files').html('<img src="<?php echo base_url();?>images/bet_images/'+image_link+'" alt="" width="75"/>').addClass('success');
					
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
					$('#youFiles').text(file).addClass('error');
				} else{
					var image_link = response;
				    document.getElementById("youFiles").innerHTML='';
					document.getElementById("your_image").value=image_link;
					$('#youFiles').html('<img src="<?php echo base_url();?>images/bet_images/'+image_link+'" alt="" width="75"/>').addClass('success');
					
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