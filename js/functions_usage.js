$(document).ready(function(){
		$('#loginForm #email').click(function(){
			if($(this).val()=='username / email'){
				$(this).val('');
			}
		});
		$('#loginForm #password').click(function(){
			if($(this).val()=='password'){
				$(this).val('');
			}
		});
		$('#loginForm #email').blur(function(){
			if($(this).val()==''){
				$(this).val('username / email');
			}
		});
		if(showContacts==1){
			$('.import_contacts').modal();
		}
		$('.cancl_btn a').click(function(){
			var total=$(this).attr('id');
			var selectedEmail=false;
			for(var i=1;i<=total;i++){
				if($('#emails_'+i).is(':checked')){
					selectedEmail=true;
					break;
				}
			}
			if(selectedEmail==false){
				//Show Error message
				$('#contact_error_msg').html('Please select atleast one email address');
				$('#contact_error_msg').show();
				return false;
			}else{
				$('#contact_error_msg').hide();
				//Send Email for sending invitation
				ajax(baseUrl+'index/sendInvitations/','testDiv','contactsForm1','');
				$('#basic-modal-content2').html('<div style="font-size: 18px; margin-top: 100px;text-align: center;">Thank You for sending invitation to your friends</div>');
			}
		})
		$('#selectAll').click(function(){
			var total=$('.cancl_btn a').attr('id');
			if($(this).is(':checked')){
				for(var i=1;i<=total;i++){
					$('#emails_'+i).attr('checked',true);
				}	
			}else{
				for(var i=1;i<=total;i++){
					$('#emails_'+i).attr('checked',false);
				}	
				
			}
		});
		
	

	//For Popups 

	$('.basic-modal .basic').click(function (e) {
		$('#basic-modal-content').modal();
		return true;
	});
	
});
$(function() {
		
		$('#instagram_feeds span.pic_vd1').live('click',function(){
			var photoId=$(this).attr('id');
			window.location.replace(baseUrl+'instagram/photo/'+photoId+'/');
		});
		
		
		$('.pic_vd').live('click',function(){
			var videoId=$(this).attr('id');
			window.location.replace(baseUrl+'home/video/'+videoId+'/');
			//ajax(baseUrl+'home/video/'+videoId+'/','inner','','spinner');	
		});
		$('#instagram_feeds .main_video a').live('click',function(){
			var photoId=$(this).attr('id');
			window.location.replace(baseUrl+'instagram/photo/'+photoId+'/');
			//ajax(baseUrl+'home/video/'+videoId+'/','inner','','spinner');	
		});
		$('#flickogram_feeds .main_video a').live('click',function(){
			var videoId=$(this).attr('id');
			window.location.replace(baseUrl+'home/video/'+videoId+'/')
			//ajax(baseUrl+'home/video/'+videoId+'/','inner','','spinner');	
		});
		$('.user_vw_ref a').live('click',function(){
			var videoId=$(this).attr('id');
			//window.location.replace(baseUrl+'home/video/'+videoId+'/')
			if(videoId!=undefined){
				//ajax(baseUrl+'home/video/'+videoId+'/','inner','','spinner');
				window.location.replace(baseUrl+'home/video/'+videoId+'/')	
			}
		});
	});
//fucntion for like video
$('.hrt_pic').live('click',function(){
			var id=$(this).find('.hrt_in_pic').attr('id');
			//return false;
			if(id==undefined || id==''){
				return false;
			}else{
				if(id=='login'){
					//$('.login_bx_ins').html('You must login to like video');
					//$('.why_birth_pop').modal();
				}else if(id=='already_liked'){
				}else{
					//Like this video
					ajax(baseUrl+'home/likeVideo/'+id,'test_div','','');
					$(this).find('.hrt_in_pic').addClass('hrt_in_pic_active');
					$(this).find('.hrt_in_pic').removeClass('hrt_in_pic');
					var totalLikes=$(this).find('.hrt_txt').html();
					totalLikes++;
					$(this).find('.hrt_txt').html(totalLikes);
					
				}
			}
		})	;

$('.likes_ht').live('click',function(){
			var id=$(this).find('.lkht_pic').attr('id');
			
			//return false;
			if(id==undefined || id==''){
				return false;
			}else{
				if(id=='login'){
					//$('.login_bx_ins').html('You must login to like video');
					//$('.why_birth_pop').modal();
				}else if(id=='already_liked'){
				}else{
					//Like this video
					ajax(baseUrl+'home/likeVideo/'+id,'test_div','','');
					$(this).find('.lkht_pic').addClass('lkht_pic_active');
					$(this).find('.lkht_pic').removeClass('lkht_pic');
					var totalLikes=$(this).find('.lkht_txt').html();
					totalLikes++;
					$(this).find('.lkht_txt').html(totalLikes);
					
				}
			}
		})	;
			
function videoposting(urls){			
					//var urls=$(this).find('#video_link').val();
					var urls=urls;//$('#hdnurl').val();
					$('#video_add_error_msg').hide();
					var contents='';
					if(urls==''){
						//urls
					}else{
						$.ajax({
								type: "POST",
								url:baseUrl+'home/postVideos/',
								cache:false,
								data:{url:urls},
								success: function(msg){	
									if(msg=='Invalid url'){
										$('#video_add_error_msg').html('Invalid url');
										$('#video_add_error_msg').show();
									}else{
										$('#video_add_error_msg').html('Successfully added');
										$('#video_add_error_msg').show();
										var dt=eval('('+ msg +')');
										var date_added=dt.currentServerTime-2;
										if(userLising=='thumbnail'){	
											contents+='<li class="frst"><a href="#"><span class="pic2_ins"><span class="vd_ins">';
											contents+='<span class="user_pic_dt"><span class="user_pd_lft">'+thumbnail(dt.profile_picture_width,dt.profile_picture_height,baseUrl+'images/profile_pictures/'+dt.profile_picture,31,31)+'</span><span class="user_pd_rgt"><span class="user_name">'+dt.user_name+'</span><span class="hours"><abbr class="timeago" title="'+date_added+'"></abbr></span></span></span>';
											contents+='<span class="pic_vd" id="'+dt.id+'">'+thumbnail(dt.thumbnail_width,dt.thumbnail_height,dt.thumbnail,169,120)+'</span>';	
											contents+='<span class="pic_kids">'+subStrJs(dt.video_title,24)+'</span>';	
											contents+='<span class="rf_ht"><span class="hrt_pic" title="Like Video"><span class="hrt_in_pic" id="'+dt.id+'"></span><span class="hrt_txt">0</span></span><span class="cmnt_pic"><span class="cmnt_in_pic"></span><span class="hrt_txt">0</span></span><span class="rflc_pic"></span></span>';
											contents+='</span></span></a></li>';	
											//Remove message
											if($('#video_content').html()=='<ul><div class="no_video">No videos found</div></ul>'){
												contents='<ul>'+contents+'</ul>';
												$('#video_content').html(contents);	
											}else{
												//Get Lase Element of li
												if($('#video_content ul li:last').hasClass('show_more_li')){
													//Remove 2nd Last element
													$('#video_content ul li:last').prev("li").remove();
													
												}
												$('#video_content ul li:first').removeClass('frst');	
												$('#video_content ul').prepend(contents);	
											}
										
										}else{
											contents+='<li><div class="main_l_pic"><div class="main_l_ins">';	
											contents+='<div class="main_l_reflick"><div class="main_r_lft"><div class="ref_pic"><a href="#"><span class="dt_pic">'+thumbnail(dt.profile_picture_width,dt.profile_picture_height,baseUrl+'images/profile_pictures/'+dt.profile_picture,34,34)+'</span><span class="otadros"><span class="ota_txt">'+dt.user_name+'</span><span class="ota2_txt"><abbr class="timeago" title="'+dt.date_added+'"></abbr></span></span></a></div><div class="ref_folow"><a href="#">Following</a></div></div><div class="main_r_rgt"><div class="reflick_sep"></div> <div class="rflick_txt"><a href="#">Reflick</a></div></div></div>';	
										 //main-video
											contents+='<div class="main_video" ><a href="javascript:;" id="'+dt.id+'">'+thumbnail(dt.thumbnail_width,dt.thumbnail_height,dt.thumbnail,549,302)+'</a></div>';       
										 // main-like
										 if(uId==0){
											contents+='<div class="main_like"><div class="likes_ht"><a href="javascript:;"><span class="lkht_pic"></span><span class="lkht_txt">0</span></a></div>';
										 }else{
											contents+='<div class="main_like"><div class="likes_ht" id="'+dt.id+'"><a href="javascript:;"><span class="lkht_pic"></span><span class="lkht_txt">0</span></a></div>';
										 }
											
	
										  contents+='<div class="lk_sep"></div>';
											  contents+='<div class="cmnt_ht"><a href="#"><span class="lkht_pic"></span><span class="lkht_txt">0</span></a></div>';
											  contents+='<div class="lk_sep"></div>';
											  contents+='<div class="main_view"><div class="lk_sep"></div><div class="mn_vie_txt">0 views</div></div> </div>';
											//Remove message
											if($('#video_content').html()=='<ul><div class="no_video">No videos found</div></ul>'){
												contents='<ul>'+contents+'</ul>';
												$('#video_content').html(contents);	
											}else{
												//Get Lase Element of li
												if($('#video_content ul li:last').hasClass('show_more_li')){
													//Remove 2nd Last element
													$('#video_content ul li:last').prev("li").remove();
													
												}
												$('#video_content ul li:first').removeClass('frst');	
												$('#video_content ul').prepend(contents);	
											}
												
										}										
										$('#video_link').val('');
										$('#video_detail').remove();
										currentServerTime=dt.currentServerTime;
										niceTime();
									}
								},beforeSend: function(){
									$('#add_video_spinner').show();
								 },
								complete: function(){
									$('#add_video_spinner').hide();	
								}
							});
					}
					return false;
							
		}				
$(function(){
	/******************************************
		Function for clicking on user_user_name
	********************************************/
	$('span.user_name').live('click',function(){
		var url=baseUrl+$(this).text();
		window.location.replace(url);
	})
	$('.us_ref_txt a').live('click',function(){
		var url=baseUrl+$(this).text();
		window.location.replace(url);
	});
	$('#flickogram_feeds span.ota_txt').live('click',function(){
		return false;
	})
	
	$('#flickogram_feeds span.ota_txt').live('click',function(){
		var url=baseUrl+$(this).text();
		window.location.replace(url);
	})
	
	
	/*****************************
	Functions for Index login
	******************************/
	$('#video_link').click(function(){
		if($(this).val()=='add Youtube / Vimeo link here'){
					$(this).val('');
				}
		});
	$('#video_link').blur(function(){
			if($(this).val()==''){
						$(this).val('add Youtube / Vimeo link here');
					}
		});
	$('#showVideo').submit(function(){
					var urls=$(this).find('#video_link').val();
					$('#video_add_error_msg').hide();
					var contents='';
					if(urls==''){
						//urls
					}else{
						$.ajax({
								type: "POST",
								url:baseUrl+'home/showVideos/',
								cache:false,
								data:{url:urls},
								success: function(msg){	
									if(msg=='Invalid url'){
										$('#video_add_error_msg').html('Invalid url');
										$('#video_add_error_msg').show();
									}else{
										$('#video_detail').remove();
											var dt=eval('('+ msg +')');										
											contents+='<div style="height: 200px; width: 520px;" id="video_detail" ><div style="float:left; width: 35%;" id="video_thumb">';
											contents+=thumbnail(dt.thumbnail_width,dt.thumbnail_height,dt.thumbnail,169,120);
											contents+='</div>';
											contents+='<div id="image_description"  style="float:left; width: 65%;"><br />'+subStrJs(dt.video_title,25) +'..<span id="video_delet_id" style="float: right; margin-right: 10px; margin-top: -5px;display:block;"><img width="25px" height="29px" id="18" title="Close" src="'+baseUrl+'images/x.png" onclick="$(\'#video_detail\').remove()"></span><br /><br />'+subStrJs(dt.video_description,130)+'<br /><a href="javascript:;" name="video_posting_a" id="video_posting_a" onclick="videoposting(\''+urls+'\')" style="float: right;">Post</a></div></div>';
											$('.add_vd_ins').append(contents);											
										
									}
								},beforeSend: function(){
									$('#add_video_spinner').show();
								 },
								complete: function(){
									$('#add_video_spinner').hide();	
								}
							});
					}
					return false;
				});
	
	$('#addVideo').submit(function(){
					var urls=$(this).find('#video_link').val();
					$('#video_add_error_msg').hide();
					var contents='';
					if(urls==''){
						//urls
					}else{
						$.ajax({
								type: "POST",
								url:baseUrl+'home/postVideos/',
								cache:false,
								data:{url:urls},
								success: function(msg){	
									if(msg=='Invalid url'){
										$('#video_add_error_msg').html('Invalid url');
										$('#video_add_error_msg').show();
									}else{
										$('#video_add_error_msg').html('Successfully added');
										$('#video_add_error_msg').show();
										var dt=eval('('+ msg +')');
										var date_added=dt.currentServerTime-2;
										if(userLising=='thumbnail'){	
											contents+='<li class="frst"><a href="#"><span class="pic2_ins"><span class="vd_ins">';
											contents+='<span class="user_pic_dt"><span class="user_pd_lft">'+thumbnail(dt.profile_picture_width,dt.profile_picture_height,baseUrl+'images/profile_pictures/'+dt.profile_picture,31,31)+'</span><span class="user_pd_rgt"><span class="user_name">'+dt.user_name+'</span><span class="hours"><abbr class="timeago" title="'+date_added+'"></abbr></span></span></span>';
											contents+='<span class="pic_vd" id="'+dt.id+'">'+thumbnail(dt.thumbnail_width,dt.thumbnail_height,dt.thumbnail,169,120)+'</span>';	
											contents+='<span class="pic_kids">'+subStrJs(dt.video_title,24)+'</span>';	
											contents+='<span class="rf_ht"><span class="hrt_pic" title="Like Video"><span class="hrt_in_pic" id="'+dt.id+'"></span><span class="hrt_txt">0</span></span><span class="cmnt_pic"><span class="cmnt_in_pic"></span><span class="hrt_txt">0</span></span><span class="rflc_pic"></span></span>';
											contents+='</span></span></a></li>';	
											//Remove message
											if($('#video_content').html()=='<ul><div class="no_video">No videos found</div></ul>'){
												contents='<ul>'+contents+'</ul>';
												$('#video_content').html(contents);	
											}else{
												//Get Lase Element of li
												if($('#video_content ul li:last').hasClass('show_more_li')){
													//Remove 2nd Last element
													$('#video_content ul li:last').prev("li").remove();
													
												}
												$('#video_content ul li:first').removeClass('frst');	
												$('#video_content ul').prepend(contents);	
											}
										
										}else{
											contents+='<li><div class="main_l_pic"><div class="main_l_ins">';	
											contents+='<div class="main_l_reflick"><div class="main_r_lft"><div class="ref_pic"><a href="#"><span class="dt_pic">'+thumbnail(dt.profile_picture_width,dt.profile_picture_height,baseUrl+'images/profile_pictures/'+dt.profile_picture,34,34)+'</span><span class="otadros"><span class="ota_txt">'+dt.user_name+'</span><span class="ota2_txt"><abbr class="timeago" title="'+dt.date_added+'"></abbr></span></span></a></div><div class="ref_folow"><a href="#">Following</a></div></div><div class="main_r_rgt"><div class="reflick_sep"></div> <div class="rflick_txt"><a href="#">Reflick</a></div></div></div>';	
										 //main-video
											contents+='<div class="main_video" ><a href="javascript:;" id="'+dt.id+'">'+thumbnail(dt.thumbnail_width,dt.thumbnail_height,dt.thumbnail,549,302)+'</a></div>';       
										 // main-like
										 if(uId==0){
											contents+='<div class="main_like"><div class="likes_ht"><a href="javascript:;"><span class="lkht_pic"></span><span class="lkht_txt">0</span></a></div>';
										 }else{
											contents+='<div class="main_like"><div class="likes_ht" id="'+dt.id+'"><a href="javascript:;"><span class="lkht_pic"></span><span class="lkht_txt">0</span></a></div>';
										 }
											
	
										  contents+='<div class="lk_sep"></div>';
											  contents+='<div class="cmnt_ht"><a href="#"><span class="lkht_pic"></span><span class="lkht_txt">0</span></a></div>';
											  contents+='<div class="lk_sep"></div>';
											  contents+='<div class="main_view"><div class="lk_sep"></div><div class="mn_vie_txt">0 views</div></div> </div>';
											//Remove message
											if($('#video_content').html()=='<ul><div class="no_video">No videos found</div></ul>'){
												contents='<ul>'+contents+'</ul>';
												$('#video_content').html(contents);	
											}else{
												//Get Lase Element of li
												if($('#video_content ul li:last').hasClass('show_more_li')){
													//Remove 2nd Last element
													$('#video_content ul li:last').prev("li").remove();
													
												}
												$('#video_content ul li:first').removeClass('frst');	
												$('#video_content ul').prepend(contents);	
											}
												
										}										
										$('#video_link').val('');
										currentServerTime=dt.currentServerTime;
										niceTime();
									}
								},beforeSend: function(){
									$('#add_video_spinner').show();
								 },
								complete: function(){
									$('#add_video_spinner').hide();	
								}
							});
					}
					return false;
				});	

	/******************************
		Function For Loading Popular Video
	*******************************/	
	$('.popular1').click(function(){
		subType=$(this).attr('title');
		if(userLising=='thumbnail'){
			loadPopularVideos(baseUrl+'home/loadVideos',1,'ul_video','spinner',type,subType);
		}else{
			loadPopularListVideos(baseUrl+'home/loadVideos',1,'ul_video','spinner',type,subType);
		}
	});	

	/******************************
		Function for adding comments
	*******************************/
	$('.ref_c_box #comments').live('click',function(){
			if($(this).val()=='write a comment....'){
				$(this).val('');
			}
	});
	$('.ref_c_box #comments').live('blur',function(){
			if($(this).val()==''){
				$(this).val('write a comment....');
			}
		});
	$('.ref_c_box form#add_video_comments').live('submit',function(){
			var comments=$(this).find('#comments').val();
			//alert("hello");
			var vId=$(this).find('#vId').val();
			var t=$(this).parent().parent().parent().parent();
			var contents='';
			if(comments==''){
				//urls
			}else{
				$.ajax({
						type: "POST",
						url:baseUrl+'home/postComments/',
						cache:false,
						data:{comments:comments,videoId:vId},
						success: function(msg){	
							if(msg=='error'){
							}else{	
									var dt=eval('('+ msg +')');
									contents+='<li><div class="ref_c2_ins"><div class="ref_c_pic"><a href="javascript:;">'+thumbnail(dt.profile_picture_width,dt.profile_picture_height,baseUrl+'images/profile_pictures/'+dt.profile_picture,31,31)+'</a></div>';
									contents+='<div class="user_ref"><div class="us_ref_txt"><a href="#">'+dt.user_name+'</a></div><p>'+htmlentities(dt.comments)+'</p></div>';
								contents+='</div><div class="mn_lk_sep"></div></li>';
								//Remove message
								var cont=t.find('li:first').html();
								t.find('li:first').remove();
								t.prepend(contents);
								console.log(cont);
								t.prepend('<li>'+cont+'</li>');	
								$(this).find('#comments').val('');
							}	
						},beforeSend: function(){
							$(this).find('#add_comments_spinner1').show();	
						},
						complete: function(){
							$(this).find('#add_comments_spinner1').hide();
						}
					});
			}
			return false;
		});	
		
	/******************************
		Function For Reflick Video
	*******************************/	
		//For thumbnail view
	$('.rflc_pic').live('click',function(){
		$(this).remove();
		var videoId=$(this).attr('id');
		if(videoId>0 && uId>0){
			$.ajax({
						type: "POST",
						url:baseUrl+'home/reflickVideo/'+videoId,
						cache:false,
						data:{videoId:videoId},
						success: function(msg){	
							if(msg=='login'){	
								$('#alert_message_content').html('You must login to reflick video.');
								$('#alert_message_content').css('margin','50px 0px');
								$('#basic-modal-content1').modal();
								$('.simplemodal-container').css('height','110px');
							}else if(msg=='no_video'){
								$('#alert_message_content').html('No video found.');
								$('#alert_message_content').css('margin','50px 0px');
								$('#basic-modal-content1').modal();
								$('.simplemodal-container').css('height','110px');
							}else if(msg=='already_reflicked'){
								$('#alert_message_content').html('You have already reflicked video.');
								$('#alert_message_content').css('margin','50px 0px');
								$('#basic-modal-content1').modal();
								$('.simplemodal-container').css('height','110px')
							}else{
								//Success
								$('#alert_message_content').html('Video has been successfully reflicked.');
								$('#alert_message_content').css('margin','50px 0px');
								$('#basic-modal-content1').modal();
								$('.simplemodal-container').css('height','110px');
								
							//	alertMessage('alert_message','alert_message_content','Video has been successfully reflicked.');
							}	
						},beforeSend: function(){
							$('#spinner').show();	
						},
						complete: function(){
							$('#spinner').hide();
						}
					});
		}
		
	});
	
	//For list view	
	$('.rflick_txt a').live('click',function(){
		$(this).remove();
		var videoId=$(this).attr('id');
		if(videoId>0 && uId>0){
			$.ajax({
						type: "POST",
						url:baseUrl+'home/reflickVideo/'+videoId,
						cache:false,
						data:{videoId:videoId},
						success: function(msg){	
							if(msg=='login'){	
								$('#alert_message_content').html('You must login to reflick video.');
								$('#alert_message_content').css('margin','50px 0px');
								$('#basic-modal-content1').modal();
								$('.simplemodal-container').css('height','110px');
							}else if(msg=='no_video'){
								$('#alert_message_content').html('No video found.');
								$('#alert_message_content').css('margin','50px 0px');
								$('#basic-modal-content1').modal();
								$('.simplemodal-container').css('height','110px');
							}else if(msg=='already_reflicked'){
								$('#alert_message_content').html('You have already reflicked video.');
								$('#alert_message_content').css('margin','50px 0px');
								$('#basic-modal-content1').modal();
								$('.simplemodal-container').css('height','110px')
							}else{
								//Success
								$('#alert_message_content').html('Video has been successfully reflicked.');
								$('#alert_message_content').css('margin','50px 0px');
								$('#basic-modal-content1').modal();
								$('.simplemodal-container').css('height','110px');
								
							//	alertMessage('alert_message','alert_message_content','Video has been successfully reflicked.');
							}	
						},beforeSend: function(){
							$('#spinner').show();	
						},
						complete: function(){
							$('#spinner').hide();
						}
					});
		}
		
	});
	
	/************************************
		Function for Searching Videos or users
	************************************/
	$('#searchUserVideoForm').submit(function(){
			var txt=$(this).find('#search_video_user').val();
			if(txt=='' || txt=='#tag or @user name or video title'){
				//Field is empty
			}else{
				//Send ajax Request	
				if($('#refreshSearch').val()==1){
						return true;
				}else{
					ajax(baseUrl+'home/search/','main_div','searchUserVideoForm','spinner');
				}
			}
			return false;
		});
	$('#search_video_user').click(function(){
			if($(this).val()=='#tag or @user name or video title'){
				$(this).val('');
			}
		});
	$('#search_video_user').blur(function(){
			if($(this).val()==''){
				$(this).val('#tag or @user name or video title');
			}
		});
	
		
});