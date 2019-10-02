/*********************************************************
	Function For Loading Videos And Comments
**********************************************************/
function delete_video(id){
		var spinnerId = 'spinner';
		var  url = baseUrl+'video/deletevideo/'+id+'/divid';
		$('li#'+id).slideUp(1000);
		setTimeout(function(){	$('li#'+id).remove();},1200);
		ajax(url,'testDiv','',spinnerId);		
		//window.location = baseUrl+'home/?type=myVideos';
}

function delete_comment(id,videoId){
	//var spinnerId = 'spinner';
	var spinnerId = '';
	var  url = baseUrl+'home/deleteComments/'+id+'/?videoId='+videoId;
	$('li#'+id).slideUp(1000);
	setTimeout(function(){	$('li#'+id).remove();},1200);
	ajax(url,'test_div','',spinnerId);
	var totalComments=$('.cmnt_ht span.lkht_txt').html();
	totalComments=parseInt(totalComments)-1;
	$('.cmnt_ht span.lkht_txt').html(totalComments);
}
function loadVideos(url1,page1,divId,spinnerId,type){
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {page:page1,type:type},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var videos=data['videos'];
				var totalData=videos.length;
				if(totalData>0){
					if(page1>1){
						$('.show_more_li').remove();
						//alert(t);
					}
					for(var i=0;i<totalData;i++){
						if(i%3==0){
							contents+='<li class="frst" id="'+videos[i].id+'">';		
						}else{
							contents+='<li id="'+videos[i].id+'">';		
						}
						
						if(videos[i].user_id == uId){
						//if(type == "myVideos"){
							var styleblock = 'display:block;';
						}
						else{
							var styleblock = 'display:none;';
						}
						
						contents+='<a href="#"><span class="pic2_ins"><span class="vd_ins">';
						contents+='<span class="user_pic_dt"><span class="user_pd_lft">'+thumbnail(videos[i].profile_picture_width,videos[i].profile_picture_height,baseUrl+'images/profile_pictures/'+videos[i].profile_picture,31,31)+'</span><span class="user_pd_rgt"><span class="user_name">'+videos[i].user_name+'</span><span class="hours"><abbr class="timeago" title="'+videos[i].date_added+'"></abbr></span></span></span><span style="float: right; margin-right: 10px; margin-top: -27px;'+styleblock+'" id="video_delet_id" ><img src="'+baseUrl+'images/delete.png" width="16px" title="Delete" id="'+videos[i].id+'" height="16px" onclick="delete_video(\''+videos[i].id+'\')" /></span>';
						
						
						//Video Thumbnail
						if(videos[i].video_type=='flickogram'){
							if(videos[i].thumbnail==''){
								contents+='<span class="pic_vd" id="'+videos[i].id+'">'+thumbnail(720,480,baseUrl+'videos_images/no_thumbnail.png',169,120)+'</span>';
							}else{
								contents+='<span class="pic_vd" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,baseUrl+'videos_images/'+videos[i].thumbnail,169,120)+'</span>';	
							}
						}else{
								contents+='<span class="pic_vd" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,videos[i].thumbnail,169,120)+'</span>';	
						}
						
						
						
						contents+='<span class="pic_kids">'+subStrJs(videos[i].video_title,24)+'</span>';	
						contents+='<span class="rf_ht">';
						if(uId==0){
						contents+='<span class="hrt_pic" title="Like Video" ><span class="hrt_in_pic" id="login"></span><span class="hrt_txt">'+videos[i].likes+'</span></span>';
						}else{
							if(videos[i].already_liked==0){
								contents+='<span class="hrt_pic" title="Like Video"  ><span class="hrt_in_pic" id="'+videos[i].id+'"></span><span class="hrt_txt">'+videos[i].likes+'</span></span>';
							}else{
								contents+='<span class="hrt_pic" title="Like Video"><span class="hrt_in_pic_active"  id="already_liked"></span><span class="hrt_txt">'+videos[i].likes+'</span></span>';
							}
						}
						contents+='<span class="cmnt_pic" ><span class="cmnt_in_pic"></span><span class="hrt_txt">'+videos[i].comments+'</span></span>';
						
						if(videos[i].reflicked==0){
							contents+='<span class="rflc_pic" id="'+videos[i].id+'"></span>';
						}
						contents+='</span>';
						contents+='</span></span></a></li>';		
					}
					if(data['show_more']==1){
						contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadVideos(\''+url1+'\',\''+data['page']+'\',\''+divId+'\',\'\',\''+type+'\');$(this).remove();setSpinner();"></a></li>';
					}
										
				}else{
					contents='<div class="no_video">No videos found</div>';
				}
				
				if(page1>1){
					$('#'+divId).append(contents);
				}else{
					$('#'+divId).html(contents);	
				}
				currentServerTime=data['currentServerTime'];
				niceTime();
			} catch(e){
				contents='<div>There are some error to loading content</div>';
				$('#'+divId).html(contents);
		  }
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}
function loadListVideos(url1,page1,divId,spinnerId,type){
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {page:page1,type:type},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var videos=data['videos'];
				var totalData=videos.length;
				if(totalData>0){
					if(page1>1){
						$('.show_more_li').remove();
						//alert(t);
					}
					for(var i=0;i<totalData;i++){
						contents+='<li id="flickogram_feeds"><div class="main_l_pic"><div class="main_l_ins">';	
						contents+='<div class="main_l_reflick"><div class="main_r_lft"><div class="ref_pic"><a href="javascript:;"><span class="dt_pic">'+thumbnail(videos[i].profile_picture_width,videos[i].profile_picture_height,baseUrl+'images/profile_pictures/'+videos[i].profile_picture,34,34)+'</span><span class="otadros"><span class="ota_txt">'+videos[i].user_name+'</span><span class="ota2_txt"><abbr class="timeago" title="'+videos[i].date_added+'"></abbr></span></span></a></div>';
						
						if(videos[i].follow==0 && uId>0){
						//	contents+='<div class="ref_folow"><a href="#">Following</a></div>';
						}
						 contents+='<div class="ref_folow"></div></div><div class="main_r_rgt"><div class="reflick_sep"></div><div class="rflick_txt">';	
						 //Reflick Condition
                 		 if(videos[i].reflicked==0){
							contents+='<a href="javascript:;" id="'+videos[i].id+'">Reflick</a>';
						 }
						
						
						contents+='</div></div></div>';
						
					 	if(videos[i].video_type=='flickogram'){
							if(videos[i].thumbnail==''){
								contents+='<div class="main_video" ><a href="javascript:;" id="'+videos[i].id+'">'+thumbnail(720,480,baseUrl+'videos_images/no_thumbnail.png',549,302)+'</a></div>'; 
							}else{
								contents+='<div class="main_video" ><a href="javascript:;" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,baseUrl+'videos_images/'+videos[i].thumbnail,549,302)+'</a></div>'; 
							}
						}else{
								contents+='<div class="main_video" ><a href="javascript:;" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,videos[i].thumbnail,549,302)+'</a></div>'; 	
						}
					    
       
                         // main-like
						
						 if(uId==0){
                       		contents+='<div class="main_like"><div class="likes_ht"><a href="javascript:;"><span class="lkht_pic" id="login"></span><span class="lkht_txt">'+videos[i].likes+'</span></a></div>';
						 }else{
							 if(videos[i].already_liked==0){
						 		contents+='<div class="main_like"><div class="likes_ht" ><a href="javascript:;"><span class="lkht_pic" id="'+videos[i].id+'"></span><span class="lkht_txt">'+videos[i].likes+'</span></a></div>';
							 }else{
								 contents+='<div class="main_like"><div class="likes_ht" id="already_liked"><a href="javascript:;"><span class="lkht_pic_active" id="already_liked"></span><span class="lkht_txt">'+videos[i].likes+'</span></a></div>';
							}
						 
						 }
					  	 contents+='<div class="lk_sep"></div>';
                       	 contents+='<div class="cmnt_ht"><a href="javascript:;"><span class="lkht_pic"></span><span class="lkht_txt">'+videos[i].comments+'</span></a></div>';
                       	 contents+='<div class="lk_sep"></div>';
                       	 contents+='<div class="main_view"><div class="lk_sep"></div><div class="mn_vie_txt">'+videos[i].views+' views</div></div></div>'; 
						contents+='<div class="mn_lk_sep"></div>';
						 /***********************************
						 	Comments For Listing type
						 ************************************/
                	     contents+='<div class="ref_cmnt"><ul>';
						 if(uId>0){
                         	contents+='<li><div class="ref_c_ins"><div class="ref_c_pic"><a href="javascript:;">'+thumbnail(userData.profile_picture_width,userData.profile_picture_height,baseUrl+'images/profile_pictures/'+userData.profile_picture,28,28)+'</a></div><div class="ref_c_box" style="width:459px;"><form id="add_video_comments" name="add_video_comments"><input type="hidden" id="vId" value="'+videos[i].id+'"><input type="text" id="comments" name="comments" value="write a comment...." /></form></div><div id="add_comments_spinner1" style="display:none;float:right;"><img src="'+baseUrl+'images/add_video.gif" /></div></div><div class="mn_lk_sep"></div></li>';
						 }
						 var comments=videos[i].user_comments;
						 var allComments=videos[i].total_user_comments;
						 var totalComments=comments.length;
						 if(totalComments>0){
						 	for(var j=0;j<totalComments;j++){
								if(comments[j]!=undefined){
								
								 contents+='<li><div class="ref_c_ins"><div class="ref_c_pic"><a href="javascript:;">'+thumbnail(comments[j].profile_picture_width,comments[j].profile_picture_height,baseUrl+'images/profile_pictures/'+comments[j].profile_picture,31,31)+'</a></div>';
								 contents+='<div class="user_ref"><div class="us_ref_txt"><a href="javascript:;">'+comments[j].user_name+'</a></div><p>'+comments[j].comments+'</p> </div></div><div class="mn_lk_sep"></div></li>';
								}
								
							}
							
							if(allComments>totalComments){
								contents+='<li><div class="ref_c_ins"><div class="user_vw_ref"><a href="javascript:;" id="'+videos[i].id+'">View all '+allComments+' Comments</a></div></div></li>';
							}
						 }
                         contents+='</ul></div>'; 
						
						contents+='</div></div></li>';                     
		
					}
					if(data['show_more']==1){
						contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadListVideos(\''+url1+'\',\''+data['page']+'\',\''+divId+'\',\'\',\''+type+'\');$(this).remove();setSpinner();"></a></li>';
					}
					
				}else{
					contents='<div class="no_video">No videos found</div>';
				}
				if(page1>1){
					$('#'+divId).append(contents);
				}else{
					$('#'+divId).html(contents);	
				}
				currentServerTime=data['currentServerTime'];
				niceTime();
			} catch(e){
				contents='<div>There are some error to loading content</div>';
				$('#'+divId).html(contents);
		  }	
			
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		 complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		 }
		});	
}
function loadPopularVideos(url1,page1,divId,spinnerId,type,subType){
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {page:page1,type:type,subType:subType},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var videos=data['videos'];
				var totalData=videos.length;
				if(totalData>0){
					if(page1>1){
						$('.show_more_li').remove();
						//alert(t);
					}
					for(var i=0;i<totalData;i++){
						if(i%3==0){
							contents+='<li class="frst" id="flickogram_feeds">';		
						}else{
							contents+='<li id="flickogram_feeds">';		
						}
						contents+='<a href="#"><span class="pic2_ins"><span class="vd_ins">';
						contents+='<span class="user_pic_dt"><span class="user_pd_lft">'+thumbnail(videos[i].profile_picture_width,videos[i].profile_picture_height,baseUrl+'images/profile_pictures/'+videos[i].profile_picture,31,31)+'</span><span class="user_pd_rgt"><span class="user_name">'+videos[i].user_name+'</span><span class="hours"><abbr class="timeago" title="'+videos[i].date_added+'"></abbr></span></span></span>';
						
						//Video Thumbnail
						if(videos[i].video_type=='flickogram'){
							if(videos[i].thumbnail==''){
								contents+='<span class="pic_vd" id="'+videos[i].id+'">'+thumbnail(720,480,baseUrl+'videos_images/no_thumbnail.png',169,120)+'</span>';
							
							
							}else{
								contents+='<span class="pic_vd" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,baseUrl+'videos_images/'+videos[i].thumbnail,169,120)+'</span>';	
							
							
							}
						}else{
								contents+='<span class="pic_vd" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,videos[i].thumbnail,169,120)+'</span>';	
						
						}
						contents+='<span class="pic_kids">'+subStrJs(videos[i].video_title,24)+'</span>';	
						contents+='<span class="rf_ht">';
						if(uId==0){
						contents+='<span class="hrt_pic" title="Like Video" ><span class="hrt_in_pic" id="login"></span><span class="hrt_txt">'+videos[i].likes+'</span></span>';
						}else{
							if(videos[i].already_liked==0){
								contents+='<span class="hrt_pic" title="Like Video"  ><span class="hrt_in_pic" id="'+videos[i].id+'"></span><span class="hrt_txt">'+videos[i].likes+'</span></span>';
							}else{
								contents+='<span class="hrt_pic" title="Like Video"><span class="hrt_in_pic_active"  id="already_liked"></span><span class="hrt_txt">'+videos[i].likes+'</span></span>';
							}
						}
						contents+='<span class="cmnt_pic"><span class="cmnt_in_pic"></span><span class="hrt_txt">'+videos[i].comments+'</span></span>';
						
						if(videos[i].reflicked==0){
							contents+='<span class="rflc_pic" id="'+videos[i].id+'"></span>';
						}
						contents+='</span>';
						contents+='</span></span></a></li>';		
					}
					if(data['show_more']==1){
						contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadPopularVideos(\''+url1+'\',\''+data['page']+'\',\''+divId+'\',\'\',\''+type+'\',\''+subType+'\');$(this).remove();setSpinner();"></a></li>';
					}
				
				}else{
					contents='<div class="no_video">No videos found</div>';
				}
				
				if(page1>1){
					$('#'+divId).append(contents);
				}else{
					$('#'+divId).html(contents);	
				}
				currentServerTime=data['currentServerTime'];
				niceTime();
			} catch(e){
				contents='<div>There are some error to loading content</div>';
				$('#'+divId).html(contents);
		  }
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}
function loadPopularListVideos(url1,page1,divId,spinnerId,type,subType){
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {page:page1,type:type,subType:subType},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var videos=data['videos'];
				var totalData=videos.length;
				if(totalData>0){
					if(page1>1){
						$('.show_more_li').remove();
						//alert(t);
					}
					
					for(var i=0;i<totalData;i++){

						contents+='<li id="flickogram_feeds"><div class="main_l_pic"><div class="main_l_ins">';	
						contents+='<div class="main_l_reflick"><div class="main_r_lft"><div class="ref_pic"><a href="#"><span class="dt_pic">'+thumbnail(videos[i].profile_picture_width,videos[i].profile_picture_height,baseUrl+'images/profile_pictures/'+videos[i].profile_picture,34,34)+'</span><span class="otadros"><span class="ota_txt">'+videos[i].user_name+'</span><span class="ota2_txt"><abbr class="timeago" title="'+videos[i].date_added+'"></abbr></span></span></a></div>';
						
						if(videos[i].follow==0 && uId>0){
						//	contents+='<div class="ref_folow"><a href="#">Following</a></div>';
						}
						 contents+='<div class="ref_folow"></div></div><div class="main_r_rgt"><div class="reflick_sep"></div><div class="rflick_txt">';	
						 //Reflick Condition
                 		 if(videos[i].reflicked==0){
							contents+='<a href="javascript:;" id="'+videos[i].id+'">Reflick</a>';
						 }	
						 contents+='</div></div></div>';
						 
                        //Video Thumbnail
						if(videos[i].video_type=='flickogram'){
							if(videos[i].thumbnail==''){
								contents+='<div class="main_video" ><a href="javascript:;" id="'+videos[i].id+'">'+thumbnail(720,480,baseUrl+'videos_images/no_thumbnail.png',549,302)+'</a></div>'; 
							}else{
								contents+='<div class="main_video" ><a href="javascript:;" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,baseUrl+'videos_images/'+videos[i].thumbnail,549,302)+'</a></div>'; 
							}
						
						}else{
							contents+='<div class="main_video" ><a href="javascript:;" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,videos[i].thumbnail,549,302)+'</a></div>'; 	
						}      
                         // main-like
						
						 if(uId==0){
                       		contents+='<div class="main_like"><div class="likes_ht"><a href="javascript:;"><span class="lkht_pic" id="login"></span><span class="lkht_txt">'+videos[i].likes+'</span></a></div>';
						 }else{
							 if(videos[i].already_liked==0){
						 		contents+='<div class="main_like"><div class="likes_ht" ><a href="javascript:;"><span class="lkht_pic" id="'+videos[i].id+'"></span><span class="lkht_txt">'+videos[i].likes+'</span></a></div>';
							 }else{
								 contents+='<div class="main_like"><div class="likes_ht" id="already_liked"><a href="javascript:;"><span class="lkht_pic_active" id="already_liked"></span><span class="lkht_txt">'+videos[i].likes+'</span></a></div>';
							}
						 
						 }
					  	 contents+='<div class="lk_sep"></div>';
                       	 contents+='<div class="cmnt_ht"><a href="#"><span class="lkht_pic"></span><span class="lkht_txt">'+videos[i].comments+'</span></a></div>';
                       	 contents+='<div class="lk_sep"></div>';
                       	 contents+='<div class="main_view"><div class="lk_sep"></div><div class="mn_vie_txt">'+videos[i].views+' views</div></div> </div>';
						
                         contents+='<div class="mn_lk_sep"></div>';
						 /***********************************
						 	Comments For Listing type
						 ************************************/
						 var commentsContent='';
                	     commentsContent+='<div class="ref_cmnt"><ul>';
						 if(uId>0){
                         	commentsContent+='<li><div class="ref_c_ins"><div class="ref_c_pic"><a href="javascript:;">'+thumbnail(userData.profile_picture_width,userData.profile_picture_height,baseUrl+'images/profile_pictures/'+userData.profile_picture,28,28)+'</a></div><div class="ref_c_box" style="width:459px;"><form id="add_video_comments" name="add_video_comments"><input type="hidden" id="vId" value="'+videos[i].id+'"><input type="text" id="comments" name="comments" value="write a comment...." /></form></div><div id="add_comments_spinner1" style="display:none;float:right;"><img src="'+baseUrl+'images/add_video.gif" /></div></div><div class="mn_lk_sep"></div></li>';
						 }
						 var comments=videos[i].user_comments;
						 var allComments=videos[i].total_user_comments;
						 var totalComments=comments.length;
						 if(totalComments>0){
						 	for(var j=0;j<totalComments;j++){
								if(comments[j]!=undefined){
								
								 commentsContent+='<li><div class="ref_c_ins"><div class="ref_c_pic"><a href="javascript:;">'+thumbnail(comments[j].profile_picture_width,comments[j].profile_picture_height,baseUrl+'images/profile_pictures/'+comments[j].profile_picture,31,31)+'</a></div>';
								 commentsContent+='<div class="user_ref"><div class="us_ref_txt"><a href="javascript:;">'+comments[j].user_name+'</a></div><p>'+comments[j].comments+'</p> </div></div><div class="mn_lk_sep"></div></li>';
								}
								
							}
							
							if(allComments>totalComments){
								commentsContent+='<li><div class="ref_c_ins"><div class="user_vw_ref"><a href="javascript:;" id="'+videos[i].id+'">View all '+allComments+' Comments</a></div></div></li>';
							}
						 }
                         commentsContent+='</ul></div>';
						 contents+=commentsContent+'</div></div></li>';
						                     
		
					}
				
					if(data['show_more']==1){
						contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadPopularListVideos(\''+url1+'\',\''+data['page']+'\',\''+divId+'\',\'\',\''+type+'\',\''+subType+'\');$(this).remove();setSpinner();"></a></li>';
					}
					
				}else{
					contents='<div class="no_video">No videos found</div>';
				}
				
				if(page1>1){
					console.log(contents);
					$('#'+divId).append(contents);
				}else{
					$('#'+divId).html(contents);	
				}
				currentServerTime=data['currentServerTime'];
				niceTime();
			} catch(e){
				contents='<div>There are some error to loading content</div>';
				$('#'+divId).html(contents);
		  }	
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}
function loadVideoComments(url1,allComments,divId,spinnerId,videoId){
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {allComments:allComments,videoId:videoId},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				
				var comments=data['comments'];
				var totalData=comments.length;
			
				if(totalData>0){
					if(allComments=='all'){
						$('.show_more_li').remove();
						//alert(t);
					}
					for(var i=0;i<totalData;i++){
						
						if(comments[i].user_id == uId){						
							var styleblock = 'display:block;';
						}
						else{
							var styleblock = 'display:none;';
						}
						contents+='<li id ="'+comments[i].id+'"><div class="ref_c2_ins"><div class="ref_c_pic"><a href="javascript:;">'+thumbnail(comments[i].profile_picture_width,comments[i].profile_picture_height,baseUrl+'images/profile_pictures/'+comments[i].profile_picture,31,31)+'</a></div>';
						contents+='<div class="user_ref"><div class="us_ref_txt"><a href="#">'+comments[i].user_name+'</a></div><div style="float:right;'+styleblock+'"><img src="'+baseUrl+'images/icon_delete.gif" style="cursor:pointer" id="deletecomment" width="12" height="12" onclick="delete_comment(\''+comments[i].id+'\','+videoId+')" /></div><p>'+htmlentities(comments[i].comments)+'</p></div>';
						contents+='</div><div class="mn_lk_sep"></div></li>';
                                   		
					}
					if(data['show_more']==1){
						contents+='<li style="width:150px;margin-top:10px auto;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" style="width:150px;margin-left:160px;" onclick="loadVideoComments(\''+url1+'\',\'all\',\''+divId+'\',\'\',\''+videoId+'\');$(this).remove();setSpinner();">View All comments</a></li>';
					}
					
				}else{
					contents='<div class="no_comments">Be the first one to leave the comments.</div>';
				}
				if(allComments=='all'){
					$('#'+divId+'').html(contents);
				}else{
					$('#'+divId+'').append(contents);	
				}
				
			} catch(e){
				contents='<div>There are some error to loading content</div>';
				$('#'+divId).html(contents);
		  }	
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		 complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}

function loadRecomendationVideos(url1,divId,spinnerId){
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 cache:true,
		 type:'GET',
  		 data: {},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var videos=data['videos'];
				var totalData=videos.length;
				if(totalData>0){
					for(var i=0;i<totalData;i++){
						
						contents+='<li><a href="'+baseUrl+'home/video/'+videos[i].id+'"><span class="rem_pic">';
						if(videos[i].video_type=='flickogram'){
							if(videos[i].thumbnail==''){
								contents+=thumbnail(720,480,baseUrl+'videos_images/no_thumbnail.png',120,90);
							}else{
								contents+=thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,baseUrl+'videos_images/'+videos[i].thumbnail,120,90);	
							}
						}else{
							contents+=thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,videos[i].thumbnail,120,90);	
						
						}
						contents+='</span><span class="desc_in"><span class="des_crip">'+subStrJs(videos[i].video_title,20)+'</span><span class="des_user">by '+videos[i].user_name+'</span><span class="des_view">'+videos[i].views+' views</span><span class="detail_lk"><span class="like"><span class="like_pic"></span><span class="like_txt">'+videos[i].likes+'</span><span class="cmnt_pic"></span><span class="like_txt">11</span></span><span class="hours_eg"><abbr class="timeago" title="'+videos[i].date_added+'"></abbr></span></span></span></a></li>';	
	
					}
				
				}else{
					contents='<li class="no_video">No videos found</li>';
				}				
				$('#'+divId).html(contents);	
				currentServerTime=data['currentServerTime'];
				niceTime();
			} catch(e){
				contents='<li class="no_video">There are some error to loading content</div>';
				$('#'+divId).html(contents);
		  }
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}

/**********************************************
	For Loading recomended users
*********************************************/
function loadRecomendationPeoples(url1,divId,spinnerId){
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 cache:true,
		 type:'GET',
  		 data: {},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var userData=data['users'];
				var totalData=userData.length;
				if(totalData>0){
					for(var i=0;i<totalData;i++){						
						contents+='<li><div class="knw_pic"><a href="'+baseUrl+userData[i].user_name+'">'+thumbnail(userData[i].profile_picture_width,userData[i].profile_picture_height,baseUrl+'images/profile_pictures/'+userData[i].profile_picture,50,50)+'</a></div>';
						contents+='<div class="kn_user">';
						contents+='<div class="kn_us_name"><a href="'+baseUrl+userData[i].user_name+'">'+userData[i].user_name+'</a></div>';
						if(userData[i].total_mutual_followers!=undefined){
							contents+='<div class="kn_us_frnd">'+userData[i].total_mutual_followers+' mutual friends</div>';
						}
						contents+='</div>';
						contents+='<div class="view_fl_btn"><a href="javascript:;" onclick="ajax(\''+baseUrl+'index/followUser/'+userData[i].id+'\','+userData[i].id+');$(this).html(\'Following\');">Follow</a></div>';
						contents+='</li>';	
	
					}
				
				}else{
					contents='<li class="no_video" style="width:280px;">No users found</li>';
				}				
				$('#'+divId).html(contents);	
			} catch(e){
				console.log(e);
				contents='<li class="no_video">There are some error to loading content</div>';
				$('#'+divId).html(contents);
		  }
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}


/**********************************
For Instagram feed
**********************************/
function loadInstagramFeeds(url1,nextMaxId,divId,spinnerId){
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {next_max_id:nextMaxId},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var photos=data['data'];
				var nextMaxId=data['next_max_id'];
				
				var totalData=photos.length;
				if(totalData>0){
					if(nextMaxId==0){
					}else{
						$('.show_more_li').remove();
					}
					for(var i=0;i<totalData;i++){
						
						if(i%3==0){
							contents+='<li class="frst" id="instagram_feeds">';		
						}else{
							contents+='<li id="instagram_feeds">';		
						}
						contents+='<a href="#"><span class="pic2_ins"><span class="vd_ins">';
						contents+='<span class="user_pic_dt"><span class="user_pd_lft">'+thumbnail(150,150,photos[i].profile_picture,31,31)+'</span><span class="user_pd_rgt"><span class="user_name">'+photos[i].user_name+'</span><span class="hours"><abbr title="'+photos[i].created_time+'" class="timeago">1 hour ago.</abbr></span></span></span>';
						
						//Video Thumbnail
						
						contents+='<span class="pic_vd1" id="'+photos[i].id+'">'+thumbnail(photos[i].images.low_resolution.width,photos[i].images.low_resolution.height,photos[i].images.low_resolution.url,169,120)+'</span>';	
						if(photos[i].caption!=null){
							contents+='<span class="pic_kids">'+subStrJs(photos[i].caption.text,24)+'</span>';	
						}else{
							contents+='<span class="pic_kids">&nbsp;</span>';
						}
						contents+='<span class="rf_ht">';
							if(photos[i].user_has_liked==0){
								contents+='<span class="hrt_pic" title="Like Video"  ><span class="hrt_in_pic" id="'+photos[i].id+'"></span><span class="hrt_txt">'+photos[i].likes.count+'</span></span>';
							}else{
								contents+='<span class="hrt_pic" title="Like Video"><span class="hrt_in_pic_active"  id="already_liked"></span><span class="hrt_txt">'+photos[i].likes.count+'</span></span>';
							}
						
						contents+='<span class="cmnt_pic"><span class="cmnt_in_pic"></span><span class="hrt_txt">'+photos[i].comments.count+'</span></span>';
						contents+='</span>';
						contents+='</span></span></a></li>';		
					}

					if(nextMaxId==0 || nextMaxId==2){
					}else{
						contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadInstagramFeeds(\''+url1+'\',\''+nextMaxId+'\',\''+divId+'\',\'\');$(this).remove();setSpinner();"></a></li>';
					}
				}else{
					contents='<li>No feeds found</li>';
				}
				if(nextMaxId==0){
					$('#'+divId).html(contents);
				}else{
					$('#'+divId).append(contents);
				}
				
				currentServerTime=data['currentServerTime'];
				niceTime();
			} catch(e){
				contents='<li>There are some error to loading content</li>';
				$('#'+divId).html(contents);
		  		alert(e);
		  }
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}
function loadInstagramFeedsList(url1,nextMaxId,divId,spinnerId){
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {next_max_id:nextMaxId},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var photos=data['data'];
				var nextMaxId=data['next_max_id'];
				
				var totalData=photos.length;
				if(totalData>0){
					if(nextMaxId==0){
					}else{
						$('.show_more_li').remove();
					}
					
					
					for(var i=0;i<totalData;i++){
						contents+='<li id="instagram_feeds"><div class="main_l2_pic"><div class="main_l_ins">';
                        contents+='<div class="main_l_reflick">';
					
						contents+='<div class="main_r_lft">';
						contents+='<div class="ref_pic">'
						contents+='<a href="javascript:;"><span class="dt_pic">'+thumbnail(150,150,photos[i].profile_picture,31,31)+'</span>';
						contents+='<span class="otadros"><span class="ota_txt">'+photos[i].user_name+'</span><span class="ota2_txt"><abbr class="timeago" title="'+photos[i].created_time+'"></span></span></a>';
						
						contents+='</div>';
						contents+='</div>';
                        contents+='<div class="main_r_rgt">';
						contents+='<div class="ref_cmr"><a href="#"></a></div>';
						contents+='<div class="instagram"><a href="#">instagram</a></div>';
						contents+='</div>';
						contents+='</div>'; 
						contents+='<div class="main_video" style="background-color:#2A4966"><a href="javascript:;" id="'+photos[i].id+'">'+thumbnail(photos[i].images.standard_resolution.width,photos[i].images.standard_resolution.height,photos[i].images.standard_resolution.url,550,350)+'</a></div>';            contents+='<div class="main_like">';
						 if(photos[i].user_has_liked==0){
						 		contents+='<div class="likes_ht" ><a href="javascript:;"><span class="lkht_pic" id="'+photos[i].id+'"></span><span class="lkht_txt">'+photos[i].likes.count+'</span></a></div>';
							 }else{
								 contents+='<div class="likes_ht" id="already_liked"><a href="javascript:;"><span class="lkht_pic_active" id="already_liked"></span><span class="lkht_txt">'+photos[i].likes.count+'</span></a></div>';
							}
						
                       
          
                         contents+='<div class="lk2_sep"></div>';   
						 contents+='<div class="cmnt_ht"> <a href="#"><span class="lkht_pic"></span><span class="lkht_txt">'+photos[i].comments.count+'</span></a></div>';      
                          contents+='<div class="lk2_sep"></div>';         
                          contents+='</div><div class="mn_lk2_sep"></div>';
						  
						  /***********************************
						 	Comments For Listing type
						 ************************************/
                	     contents+='<div class="ref_cmnt"><ul>';
						
                         contents+='<li><div class="ref_c_ins"><div class="ref_c_pic"><a href="javascript:;">'+thumbnail(userData.profile_picture_width,userData.profile_picture_height,baseUrl+'images/profile_pictures/'+userData.profile_picture,28,28)+'</a></div><div class="ref_c_box" style="width:459px;"><form id="add_video_comments" name="add_video_comments"><input type="hidden" id="vId" value="'+photos[i].id+'"><input type="text" id="comments" name="comments" value="write a comment...." /></form></div><div id="add_comments_spinner1" style="display:none;float:right;"><img src="'+baseUrl+'images/add_video.gif" /></div></div><div class="mn_lk_sep"></div></li>';
						 
						 var comments=photos[i].comments.data;
						 var allComments=photos[i].comments.count;
						 var totalComments=comments.length;
						 if(totalComments>0){
						 	for(var j=0;j<totalComments;j++){
								
								if(comments[j]!=undefined){
								 contents+='<li><div class="ref_c_ins"><div class="ref_c_pic"><a href="javascript:;">'+thumbnail(150,150,comments[j].from.profile_picture,31,31)+'</a></div>';
								 contents+='<div class="user_ref"><div class="us_ref_txt"><a href="javascript:;">'+comments[j].from.username+'</a></div><p>'+comments[j].text+'</p> </div></div><div class="mn_lk_sep"></div></li>';
								}
								if(j==1){
									break;
								}
							}
							
							if(allComments>2){
								contents+='<li><div class="ref_c_ins"><div class="user_vw_ref"><a href="javascript:;" id="'+photos[i].id+'">View all '+allComments+' Comments</a></div></div></li>';
								
							}
						 }
                         contents+='</ul></div>'; 
						  
						  
						  
						  contents+='</div></div></li>';          
					}

					if(nextMaxId==0 || nextMaxId==2){
					}else{
						contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadInstagramFeedsList(\''+url1+'\',\''+nextMaxId+'\',\''+divId+'\',\'\');$(this).remove();setSpinner();"></a></li>';
					}
				}else{
					contents='<li>No feeds found</li>';
				}
				if(nextMaxId==0){
					$('#'+divId).html(contents);
				}else{
					$('#'+divId).append(contents);
				}
				currentServerTime=data['currentServerTime'];
				niceTime();
			} catch(e){
				contents='<li>There are some error to loading content</li>';
				$('#'+divId).html(contents);
		  		alert(e);
		  }
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}




/*************************************************
	Load Followings Followers Data
*************************************************/
function loadFollowingsData(url1,page1,divId,spinnerId,followingType,searchTxt){

	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {page:page1,followingType:followingType,searchTxt:searchTxt},
 		 success: function(data) {
			
			var contents='';		 
	   		var error=0;
		 try{
				if(data=='fblogin'){
					$('#'+divId).html('<li class="error"><a href="javascript:;" onclick="linkAccountFollowings(\'followings\');"><img alt="fb" src="'+baseUrl+'images/facebook_login.png"></a></li>');
				
				}else if(data=='twitterlogin'){
					$('#'+divId).html('<li><div class="no_video">Your twitter acoount is not linked yet <a href="'+baseUrl+'settings/?profile=1">Click here</a> to link your twitter account.</div></li>');
				}else{
					if(followingType=='flickogram'){
							var data=eval('('+data+')');
							var followingData=data['data'];
						var totalData=followingData.length;
						if(totalData>0){
							if(page1>1){
								$('.show_more_li').remove();
							}
							for(var i=0;i<totalData;i++){
								/****************************************
									
								****************************************/	
								contents+='<li>';
									 contents+='<div class="saman_lft"><div class="sam_pic"><a href="'+baseUrl+followingData[i].user_name+'">'+thumbnail(followingData[i].profile_picture_width,followingData[i].profile_picture_height,baseUrl+'images/profile_pictures/'+followingData[i].profile_picture,50,50)+'</a></div><div class="sam_txt"><a href="'+baseUrl+followingData[i].user_name+'">'+followingData[i].user_name+'</a></div></div>';
									if(followingData[i].following_id!=1){
										if(followingData[i].blocked=='yes'){ 
											contents+='<div class="saman_rgt" ><div class="following_rg"><a href="javascript:;">Following</a></div><div class="bloc_btn_rg" id="unblock"><a href="javascript:;" id="'+followingData[i].following_id+'">Unblock</a></div></div>';
										}else{
											contents+='<div class="saman_rgt" ><div class="following_rg"><a href="javascript:;">Following</a></div><div class="bloc_btn_rg" id="block"><a href="javascript:;" id="'+followingData[i].following_id+'">Block</a></div></div>';
											
										}
									}
									contents+='<div class="fl_line"></div>';
									contents+='</li>';					                     
				
							}
						
							if(data['show_more']==1){
								contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadFollowingsData(\''+url1+'\',\''+data['page']+'\',\''+divId+'\',\'\',\''+followingType+'\');setSpinner();"></a></li>';
							}
							
						}else{
							contents='<div class="no_video">No data found</div>';
						}
						
						if(page1>1){
							$('#'+divId).append(contents);
						}else{
							$('#'+divId).html(contents);	
						}
					}else{
						var data=eval('('+data+')');
						var followingData=data;
						var totalData=followingData.length;
						if(totalData>0){
							for(var i=0;i<totalData;i++){
								contents+='<li>';
								contents+='<div class="saman_lft"><div class="sam_pic"><a href="'+baseUrl+followingData[i].user_name+'">'+thumbnail(followingData[i].profile_picture_width,followingData[i].profile_picture_height,baseUrl+'images/profile_pictures/'+followingData[i].profile_picture,50,50)+'</a></div><div class="sam_txt"><a href="'+baseUrl+followingData[i].user_name+'">'+followingData[i].user_name+'</a></div></div>';
								
								
								if(followingData[i].user_id==null){
									contents+='<div class="saman_rgt" ><div class="following_rg"><a class="follow_user" href="javascript:;" id="'+followingData[i].id+'">Follow</a></div></div>';
								}else{
									if(followingData[i].following_id!=1){
										if(followingData[i].blocked=='yes'){ 
											contents+='<div class="saman_rgt" ><div class="following_rg"><a href="javascript:;">Following</a></div><div class="bloc_btn_rg" id="unblock"><a href="javascript:;" id="'+followingData[i].user_id+'">Unblock</a></div></div>';
										}else{
											contents+='<div class="saman_rgt" ><div class="following_rg"><a href="javascript:;">Following</a></div><div class="bloc_btn_rg" id="block"><a href="javascript:;" id="'+followingData[i].user_id+'">Block</a></div></div>';
										}
									}
								}
								
								
								contents+='<div class="fl_line"></div>';
								contents+='</li>';					                     
				
							}
						}else{
							contents='<div class="no_video">No data found</div>';
						}
						
						if(page1>1){
							$('#'+divId).append(contents);
						}else{
							$('#'+divId).html(contents);	
						}
					}
					
					
				}
			} catch(e){
				console.log(e);
				contents='<li class="error">There are some error to loading content</li>';
				$('#'+divId).html(contents);
		  }	
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}
function loadFollowersData(url1,page1,divId,spinnerId,followingType,searchTxt){
	var contents='';
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {page:page1,followingType:followingType,searchTxt:searchTxt},
 		 success: function(data) {
			
					 
	   		var error=0;
		 try{
				if(data=='fblogin'){
					$('#'+divId).html('<li class="error"><a href="javascript:;" onclick="linkAccountFollowings(\'followers\');"><img alt="fb" src="'+baseUrl+'images/facebook_login.png"></a></li>');
				
				}else if(data=='twitterlogin'){
					$('#'+divId).html('<li><div class="no_video">Your twitter acoount is not linked yet <a href="'+baseUrl+'settings/?profile=1">Click here</a> to link your twitter account.</div></li>');
				}else{
					if(followingType=='flickogram'){
							var data=eval('('+data+')');
							var followingData=data['data'];
						var totalData=followingData.length;
						if(totalData>0){
							if(page1>1){
								$('.show_more_li').remove();
							}
							for(var i=0;i<totalData;i++){
								/****************************************
									
								****************************************/	
								contents+='<li>';
									 contents+='<div class="saman_lft"><div class="sam_pic"><a href="'+baseUrl+followingData[i].user_name+'">'+thumbnail(followingData[i].profile_picture_width,followingData[i].profile_picture_height,baseUrl+'images/profile_pictures/'+followingData[i].profile_picture,50,50)+'</a></div><div class="sam_txt"><a href="'+baseUrl+followingData[i].user_name+'">'+followingData[i].user_name+'</a></div></div>';
									
									contents+='<div class="fl_line"></div>';
									contents+='</li>';	
												                     
				
							}
							
							if(data['show_more']==1){
								contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadFollowersData(\''+url1+'\',\''+data['page']+'\',\''+divId+'\',\'\',\''+followingType+'\');setSpinner();"></a></li>';
							}
							
						}else{
							contents='<div class="no_video">No data found</div>';
						}
						
						if(page1>1){
							$('#'+divId).append(contents);
						}else{
							$('#'+divId).html(contents);	
						}
					}else{
						var data=eval('('+data+')');
						var followingData=data;
						var totalData=followingData.length;
						if(totalData>0){
							for(var i=0;i<totalData;i++){
								contents+='<li>';
								contents+='<div class="saman_lft"><div class="sam_pic"><a href="'+baseUrl+followingData[i].user_name+'">'+thumbnail(followingData[i].profile_picture_width,followingData[i].profile_picture_height,baseUrl+'images/profile_pictures/'+followingData[i].profile_picture,50,50)+'</a></div><div class="sam_txt"><a href="'+baseUrl+followingData[i].user_name+'">'+followingData[i].user_name+'</a></div></div>';
								
								
								/*if(followingData[i].user_id==null){
									contents+='<div class="saman_rgt" ><div class="following_rg"><a class="follow_user" href="javascript:;" id="'+followingData[i].id+'">Follow</a></div></div>';
								}else{
									if(followingData[i].following_id!=1){
										if(followingData[i].blocked=='yes'){ 
											contents+='<div class="saman_rgt" ><div class="following_rg"><a href="javascript:;">Following</a></div><div class="bloc_btn_rg" id="unblock"><a href="javascript:;" id="'+followingData[i].user_id+'">Unblock</a></div></div>';
										}else{
											contents+='<div class="saman_rgt" ><div class="following_rg"><a href="javascript:;">Following</a></div><div class="bloc_btn_rg" id="block"><a href="javascript:;" id="'+followingData[i].user_id+'">Block</a></div></div>';
										}
									}
								}*/
								contents+='<div class="fl_line"></div>';
								contents+='</li>';					                     
				
							}
						}else{
							contents='<div class="no_video">No data found</div>';
						}
						
						if(page1>1){
							$('#'+divId).append(contents);
						}else{
							$('#'+divId).html(contents);	
						}
					}
					
					
				}
			} catch(e){
				console.log(e);
				contents='<li class="error">There are some error to loading content</li>';
				$('#'+divId).html(contents);
		  }	
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}

/*************************************************
	Load notifications
*************************************************/
function loadNotifications(url1,page1,divId,spinnerId){

	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {page:page1},
 		 success: function(data) {
			
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var notficationData=data['data'];
				var totalData=notficationData.length;
				if(totalData>0){
					if(page1>1){
						$('.show_more_li').remove();
					}
					
					for(var i=0;i<totalData;i++){
						contents+=notficationData[i].message;	
					}	
					if(data['show_more']==1){
						contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadNotifications(\''+url1+'\',\''+data['page']+'\',\''+divId+'\',\'\');$(this).remove();setSpinner();"></a></li>';
					}
					
				}else{
					contents='<div class="no_video">No data found</div>';
				}
				
				if(page1>1){
					$('#'+divId).append(contents);
				}else{
					$('#'+divId).html(contents);	
				}
				currentServerTime=data['currentServerTime'];
				niceTime();
			} catch(e){
				console.log(e);
				contents='<li class="error">There are some error to loading content</li>';
				$('#'+divId).html(contents);
		  }	
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}
/***************************************************
	Load  Search Videos
****************************************************/
function loadSearchVidoes(url1,page1,divId,spinnerId,txt){
	
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		 data: {page:page1,search_video_user:txt},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var videos=data['data'];
				var totalData=videos.length;
				if(totalData>0){
					if(page1>1){
						$('.show_more_li').remove();
						//alert(t);
					}else{
						contents+='<ul>';
					}
					for(var i=0;i<totalData;i++){
						if(i%3==0){
							contents+='<li class="frst" id="flickogram_feeds">';		
						}else{
							contents+='<li id="flickogram_feeds">';		
						}
						contents+='<a href="#"><span class="pic2_ins"><span class="vd_ins">';
						contents+='<span class="user_pic_dt"><span class="user_pd_lft">'+thumbnail(videos[i].profile_picture_width,videos[i].profile_picture_height,baseUrl+'images/profile_pictures/'+videos[i].profile_picture,31,31)+'</span><span class="user_pd_rgt"><span class="user_name">'+videos[i].user_name+'</span><span class="hours"><abbr class="timeago" title="'+videos[i].date_added+'"></abbr></span></span></span>';
						
						//Video Thumbnail
						if(videos[i].video_type=='flickogram'){
							if(videos[i].thumbnail==''){
								contents+='<span class="pic_vd" id="'+videos[i].id+'">'+thumbnail(720,480,baseUrl+'videos_images/no_thumbnail.png',169,120)+'</span>';
							
							
							}else{
								contents+='<span class="pic_vd" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,baseUrl+'videos_images/'+videos[i].thumbnail,169,120)+'</span>';	
							
							
							}
						}else{
								contents+='<span class="pic_vd" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,videos[i].thumbnail,169,120)+'</span>';	
						
						}
						contents+='<span class="pic_kids">'+subStrJs(videos[i].video_title,24)+'</span>';	
						contents+='<span class="rf_ht">';
						if(uId==0){
						contents+='<span class="hrt_pic" title="Like Video" ><span class="hrt_in_pic" id="login"></span><span class="hrt_txt">'+videos[i].likes+'</span></span>';
						}else{
							if(videos[i].already_liked==0){
								contents+='<span class="hrt_pic" title="Like Video"  ><span class="hrt_in_pic" id="'+videos[i].id+'"></span><span class="hrt_txt">'+videos[i].likes+'</span></span>';
							}else{
								contents+='<span class="hrt_pic" title="Like Video"><span class="hrt_in_pic_active"  id="already_liked"></span><span class="hrt_txt">'+videos[i].likes+'</span></span>';
							}
						}
						contents+='<span class="cmnt_pic"><span class="cmnt_in_pic"></span><span class="hrt_txt">'+videos[i].comments+'</span></span>';
						
						if(videos[i].reflicked==0){
							contents+='<span class="rflc_pic" id="'+videos[i].id+'"></span>';
						}
						contents+='</span>';
						contents+='</span></span></a></li>';		
					}
					if(data['show_more']==1){
						contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadPopularVideos(\''+url1+'\',\''+data['page']+'\',\''+divId+'\',\'\',\''+txt+'\');setSpinner();">Show more...</a></li>';
					}
				
				}else{
					contents='<div class="no_video">No videos found</div>';
				}
				
				if(page1>1){
					
					$('#'+divId).append(contents);
				}else{
					contents+='</ul>';
					$('#'+divId).html(contents);	
				}
				currentServerTime=data['currentServerTime'];
				niceTime();
			} catch(e){
				contents='<div class="no_video">There are some error to loading content</div>';
				console.log(e);
				$('#'+divId).html(contents);
		  }
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}
function loadSearchListVideos(url1,page1,divId,spinnerId,txt){
		
	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		data: {page:page1,search_video_user:txt},
 		 success: function(data) {
			var contents='';		 
	   		var error=0;
		 try{
				var data=eval('('+data+')');
				var videos=data['data'];
				var totalData=videos.length;
				if(totalData>0){
					if(page1>1){
						$('.show_more_li').remove();
						contents+='<ul>';
					}else{
						contents+='<ul>';
					}
					for(var i=0;i<totalData;i++){

						contents+='<li id="flickogram_feeds"><div class="main_l_pic"><div class="main_l_ins">';	
						contents+='<div class="main_l_reflick"><div class="main_r_lft"><div class="ref_pic"><a href="#"><span class="dt_pic">'+thumbnail(videos[i].profile_picture_width,videos[i].profile_picture_height,baseUrl+'images/profile_pictures/'+videos[i].profile_picture,34,34)+'</span><span class="otadros"><span class="ota_txt">'+videos[i].user_name+'</span><span class="ota2_txt"><abbr class="timeago" title="'+videos[i].date_added+'"></abbr></span></span></a></div>';
						
						if(videos[i].follow==0 && uId>0){
						//	contents+='<div class="ref_folow"><a href="#">Following</a></div>';
						}
						 contents+='<div class="ref_folow"></div></div><div class="main_r_rgt"><div class="reflick_sep"></div><div class="rflick_txt">';	
						 //Reflick Condition
                 		 if(videos[i].reflicked==0){
							contents+='<a href="javascript:;" id="'+videos[i].id+'">Reflick</a>';
						 }	
						 contents+='</div></div></div>';
						 
                        //Video Thumbnail
						if(videos[i].video_type=='flickogram'){
							if(videos[i].thumbnail==''){
								contents+='<div class="main_video" ><a href="javascript:;" id="'+videos[i].id+'">'+thumbnail(720,480,baseUrl+'videos_images/no_thumbnail.png',549,302)+'</a></div>'; 
							}else{
								contents+='<div class="main_video" ><a href="javascript:;" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,baseUrl+'videos_images/'+videos[i].thumbnail,549,302)+'</a></div>'; 
							}
						
						}else{
							contents+='<div class="main_video" ><a href="javascript:;" id="'+videos[i].id+'">'+thumbnail(videos[i].thumbnail_width,videos[i].thumbnail_height,videos[i].thumbnail,549,302)+'</a></div>'; 	
						}      
                         // main-like
						
						 if(uId==0){
                       		contents+='<div class="main_like"><div class="likes_ht"><a href="javascript:;"><span class="lkht_pic" id="login"></span><span class="lkht_txt">'+videos[i].likes+'</span></a></div>';
						 }else{
							 if(videos[i].already_liked==0){
						 		contents+='<div class="main_like"><div class="likes_ht" ><a href="javascript:;"><span class="lkht_pic" id="'+videos[i].id+'"></span><span class="lkht_txt">'+videos[i].likes+'</span></a></div>';
							 }else{
								 contents+='<div class="main_like"><div class="likes_ht" id="already_liked"><a href="javascript:;"><span class="lkht_pic_active" id="already_liked"></span><span class="lkht_txt">'+videos[i].likes+'</span></a></div>';
							}
						 
						 }
					  	 contents+='<div class="lk_sep"></div>';
                       	 contents+='<div class="cmnt_ht"><a href="#"><span class="lkht_pic"></span><span class="lkht_txt">'+videos[i].comments+'</span></a></div>';
                       	 contents+='<div class="lk_sep"></div>';
                       	 contents+='<div class="main_view"><div class="lk_sep"></div><div class="mn_vie_txt">'+videos[i].views+' views</div></div> </div>';
						
                         contents+='<div class="mn_lk_sep"></div>';
						 /***********************************
						 	Comments For Listing type
						 ************************************/
						 var commentsContent='';
                	     commentsContent+='<div class="ref_cmnt"><ul>';
						 if(uId>0){
                         	commentsContent+='<li><div class="ref_c_ins"><div class="ref_c_pic"><a href="javascript:;">'+thumbnail(userData.profile_picture_width,userData.profile_picture_height,baseUrl+'images/profile_pictures/'+userData.profile_picture,28,28)+'</a></div><div class="ref_c_box" style="width:459px;"><form id="add_video_comments" name="add_video_comments"><input type="hidden" id="vId" value="'+videos[i].id+'"><input type="text" id="comments" name="comments" value="write a comment...." /></form></div><div id="add_comments_spinner1" style="display:none;float:right;"><img src="'+baseUrl+'images/add_video.gif" /></div></div><div class="mn_lk_sep"></div></li>';
						 }
						 var comments=videos[i].user_comments;
						 var allComments=videos[i].total_user_comments;
						 var totalComments=comments.length;
						 if(totalComments>0){
						 	for(var j=0;j<totalComments;j++){
								if(comments[j]!=undefined){
								
								 commentsContent+='<li><div class="ref_c_ins"><div class="ref_c_pic"><a href="javascript:;">'+thumbnail(comments[j].profile_picture_width,comments[j].profile_picture_height,baseUrl+'images/profile_pictures/'+comments[j].profile_picture,31,31)+'</a></div>';
								 commentsContent+='<div class="user_ref"><div class="us_ref_txt"><a href="javascript:;">'+comments[j].user_name+'</a></div><p>'+comments[j].comments+'</p> </div></div><div class="mn_lk_sep"></div></li>';
								}
								
							}
							
							if(allComments>totalComments){
								commentsContent+='<li><div class="ref_c_ins"><div class="user_vw_ref"><a href="javascript:;" id="'+videos[i].id+'">View all '+allComments+' Comments</a></div></div></li>';
							}
						 }
                         commentsContent+='</ul></div>';
						 contents+=commentsContent+'</div></div></li>';
						                     
		
					}
					
					if(data['show_more']==1){
						contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="(\''+url1+'\',\''+data['page']+'\',\''+divId+'\',\'\',\''+txt+'\');setSpinner();$(this).remove();setSpinner();"></a></li>';
					}
					
				}else{
					contents='<li><div class="no_video">No videos found</div></li>';
				}
				
				if(page1>1){
					contents+='</ul>';
					$('#'+divId).append(contents);
				}else{
					$('#'+divId).html(contents);	
				}
				currentServerTime=data['currentServerTime'];
				niceTime();
			} catch(e){
				console.log(e);
				contents='<div class="no_video">There are some error to loading content</div>';
				$('#'+divId).html(contents);
		  }	
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}
function searchUsers(url1,page1,divId,spinnerId,txt){
	

	$.ajax({
 		 url:url1,
 		 dataType: 'text',
		 type:'POST',
  		data: {page:page1,search_video_user:txt},
 		 success: function(data) {
			
			var contents='';		 
	   		var error=0;
		 try{
				
				var data=eval('('+data+')');
				var followingData=data['data'];
				var totalData=followingData.length;
				if(totalData>0){
					if(page1>1){
						$('.show_more_li').remove();
					}else{
						contents+='<ul>';
					}
					for(var i=0;i<totalData;i++){
							
						contents+='<li style="float:left;width:100%;">';
						contents+='<div class="trend-table"><div class="trend-name" style="border:solid 1px;"><a style="" href="'+baseUrl+followingData[i].user_name+'">'+thumbnail(followingData[i].profile_picture_width,followingData[i].profile_picture_height,baseUrl+'images/profile_pictures/'+followingData[i].profile_picture,50,50)+'</a></div><div class="trend-name" style="margin-left:10px;"><a style="color:#000000" href="'+baseUrl+followingData[i].user_name+'">'+followingData[i].user_name+'</a></div><br clear="all"></div>';
						contents+='</li>';					                     
				
					}	
					if(data['show_more']==1){
								contents+='<li style="width:100%;margin-top:10px;" class="show_more_li"><a href="javascript:;"  class="show_more" id="feed_show_more" onclick="loadFollowingsData(\''+url1+'\',\''+data['page']+'\',\''+divId+'\',\'\',\''+followingType+'\');$(this).remove();setSpinner();"></a></li>';
							}
							
				}else{
					contents='<div class="no_video">No data found</div>';
				}
						
				if(page1>1){
					$('#'+divId).append(contents);
				}else{
					contents+='</ul>';
					$('#'+divId).html(contents);	
				}
					
			} catch(e){
				console.log(e);
				contents='<li class="error">There are some error to loading content</li>';
				$('#'+divId).html(contents);
		  }	
    	},
		 beforeSend: function(){
				if(spinnerId!=''){
					showSpinner(spinnerId);
				}
		  },
		
			complete: function(){
			if(spinnerId!=''){
				$('#'+spinnerId).css('display','none');	
			}
		}
		});	
}