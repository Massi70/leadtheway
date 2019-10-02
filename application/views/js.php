<script type='text/javascript' src="<?php echo base_url();?>js/jquery.min.js"></script>
<script type='text/javascript' src="<?php echo base_url();?>js/jquery-1.3.2.min.js"></script>
<script>
function close_popup()
{
$('#close_popup').hide();
$('#bg-popup').hide();
$('#bg-popup').html('');
}
/*function open_popup()
{
$('#close_popup').show();
$('#bg-popup').show();
}*/
function create_bet()
{
	//ajax-loader_round.gif
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	$('#bg-popup').show();
$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/create_bet/',
		beforeSubmit:function(){
		
			},
		complete:function(){
			},
		success:function(data){
			$('#mob_bet').html(data);
			$('#bg-popup').hide();
			$('#bg-popup').html('');
			$('#home_li').addClass("first first_z").removeClass("active");
			$('#myBet_li').addClass("second_z").removeClass("active");
			$('#createBet_li').addClass("active");
			}
		});	
}
/*function enableSelectBoxes(){
				$('div.selectBox').each(function(){
					$(this).children('span.selected').html($(this).children('div.selectOptions').children('span.selectOption:first').html());
					$(this).attr('value',$(this).children('div.selectOptions').children('span.selectOption:first').attr('value'));
					
					$(this).children('span.selected,span.selectArrow').click(function(){
						if($(this).parent().children('div.selectOptions').css('display') == 'none'){
							$(this).parent().children('div.selectOptions').css('display','block');
						}
						else
						{
							$(this).parent().children('div.selectOptions').css('display','none');
						}
					});
					
					$(this).find('span.selectOption').click(function(){
						$(this).parent().css('display','none');
						$(this).closest('div.selectBox').attr('value',$(this).attr('value'));
						$(this).parent().siblings('span.selected').html($(this).html());
					});
				});				
			}*/
function submit_form()
{
		if($('#title').val()==''){
			$('#main-popup').show();
			$('#popupnew').html('Please Enter any title');
			$('#bg-popup').show();
		}else if($('#category').val()=='' || $('#category').val()=='Select'){
			$('#main-popup').show();
			$('#popupnew').html('Please select any category');
			$('#bg-popup').show();
		}else if($('#question').val()==''){
			$('#main-popup').show();
			$('#popupnew').html('Please Enter question');
			$('#bg-popup').show();
		}else if($('#answer_type').val()==''){
			$('#main-popup').show();
			$('#popupnew').html('Please select answer type');
			$('#bg-popup').show();
		}else if($('#answer_type').val()=='Text' && $('#my_ans').val()==''){
			$('#main-popup').show();
			$('#popupnew').html('Please enter answer');
			$('#bg-popup').show();
		}else if($('#answer_type').val()=='Text' && $('#you_ans').val()==''){
				$('#main-popup').show();
				$('#popupnew').html('Please enter other answer');
				$('#bg-popup').show();
		}else if($('#answer_type').val()=='Text' && ($('#my_ans').val()==$('#you_ans').val())){
				$('#main-popup').show();
				$('#popupnew').html('Both answer are same');
				$('#bg-popup').show();
		}else if($('#answer_type').val()=='Image' && $('#my_image').val()==''){
			$('#main-popup').show();
			$('#popupnew').html('Please upload image');
			$('#bg-popup').show();
		}else if($('#answer_type').val()=='Image' && $('#your_image').val()==''){
				$('#main-popup').show();
				$('#popupnew').html('Please upload other image');
				$('#bg-popup').show();
		}else if($('#answer_type').val()=='Video' && $('#my_video').val()==''){
			$('#main-popup').show();
			$('#popupnew').html('Please upload video');
			$('#bg-popup').show();
		}else if($('#answer_type').val()=='Video' && $('#your_video').val()==''){
				$('#main-popup').show();
				$('#popupnew').html('Please upload other video');
				$('#bg-popup').show();
		}else if($.trim($('#wager').val())==''){
			$('#main-popup').show();
			$('#popupnew').html('Please enter your wager');
			$('#bg-popup').show();
		//}else if($('#wager').val() > $('#coins').val()){
		}else if(parseInt($('#coins').val()) < parseInt($('#wager').val())){
			$('#main-popup').show();
			$('#popupnew').html('Your wager amount is grater then your coins');
			$('#bg-popup').show();
		}else if(parseInt($('#wager').val())<100){
			$('#main-popup').show();
			$('#popupnew').html('You \'\ll start beting from 100 coins');
			$('#bg-popup').show();
		}else if($('#timelimit').val()==''){
			$('#main-popup').show();
			$('#popupnew').html('Please select time limit');
			$('#bg-popup').show();
		}else if($('#expire').val()==''){
			$('#main-popup').show();
			$('#popupnew').html('Please select expire limit');
			$('#bg-popup').show();
		}else{	
				FB.ui({method: 'apprequests',
				  message: 'My Great Request',
				  max_recipients:1
				}, requestCallback);
				
		}
}
//// for responce 
function requestCallback(response) {
				// Handle callback here
					var data = $('form[name="bet_form"]').serialize();
				$.ajax({
					type:"POST",
					url:"<?php echo base_url();?>index/submit_bet/"+response.to,
					data:data,
					beforeSend:function(){
			
					},
					complete:function(){
					
					},
					success:function(result){
						//$('#bet_form').reset();
						//$('#main-popup').show();
//						$('#bg-popup').show();
//						$('#popupnew').html('Bet Submit Successfully!');
//						//.wait(3000);
//						 setTimeout(function () {
//     							//alert($(this).attr("id"));
//						 }, 10000);
//						
//						$('#main-popup').hide();
//						$('#popupnew').html('');
//						$('#bg-popup').hide();
						
						
						$('#mob_bet').html(result);
						$('#home_li').addClass("first first_z active");
						$('#myBet_li').addClass("second_z").removeClass("active");
						$('#createBet_li').removeClass("active");
						/*document.getElementById('bet_form').reset();
						$('#popup_mobs').hide();
						$('#bg-popup').hide();
						$('.selected').html('Select');
						$('#question_image').html('');
						$('#question_video').html('');*/
						
						//$('#success_msg').show();
						//$('#close_popup').hide();
						//$('#bg-popup').hide();
						
						
					}
					});
				
				} 
function submit_repropse(cat_id)
{
 // Handle callback here
	var form = $('form[name="repropse_form"]');
	
	if($('#title',form).val()==''){
		$('#bet_oppup_msg').html('Please Enter any title');
		$('#title',form).focus();
	}else if($('#category',form).val()=='' || $('#category').val()=='Select'){
		$('#bet_oppup_msg').html('Please select any category');
	}else if($('#question',form).val()==''){
		$('#bet_oppup_msg').html('Please Enter question');
		$('#question',form).focus();	
	}else if($('#answer_type',form).val()==''){
		$('#bet_oppup_msg').html('Please select answer type');
	}else if($('#answer_type',form).val()=='Text' && $('#my_ans',form).val()==''){
		$('#bet_oppup_msg').html('Please enter answer');
		$('#my_ans',form).focus();		
	}else if($('#answer_type',form).val()=='Text' && $('#you_ans',form).val()==''){
		$('#bet_oppup_msg').html('Please enter other answer');
		$('#you_ans',form).focus();			
	}else if($('#answer_type').val()=='Text' && ($('#my_ans').val()==$('#you_ans').val())){
				$('#main-popup').show();
				$('#popupnew').html('Both answer are same');
				$('#bg-popup').show();
	}else if($('#answer_type',form).val()=='Image' && $('#my_image',form).val()==''){
		$('#bet_oppup_msg').html('Please upload image');
		
	}else if($('#answer_type',form).val()=='Image' && $('#your_image',form).val()==''){
		$('#bet_oppup_msg').html('Please upload other image');
			
	}else if($('#answer_type',form).val()=='Video' && $('#my_video',form).val()==''){
		$('#bet_oppup_msg').html('Please upload video');
			
	}else if($('#answer_type',form).val()=='Video' && $('#your_video',form).val()==''){
		$('#bet_oppup_msg').html('Please upload other video');
				
	}else if($('#wager',form).val()==''){
		$('#bet_oppup_msg').html('Please enter your wager');
		$('#wager',form).focus();		
	}else if($('#coins',form).val() < $('#wager',form).val()){
		$('#bet_oppup_msg').html('Your wager amount is grater then your coins');
		$('#wager',form).focus();	
	}else if($('#wager',form).val()<100){
		$('#bet_oppup_msg').html('You \'\ll start beting from 100 coins');
		$('#wager',form).focus();	
	}else if($('#timelimit',form).val()==''){
		$('#bet_oppup_msg').html('Please select time limit');
		
	}else if($('#expire',form).val()==''){
		$('#bet_oppup_msg').html('Please select expire limit');
		
	}else{	
			
			var data = form.serialize();
			$.ajax({
				type:"POST",
				url:"<?php echo base_url();?>index/submit_repropse_bet/",
				data:data,
				beforeSend:function(){
				},
				complete:function(){
				
				},
				success:function(result){
					//$('#bet_form').reset();
				//	document.getElementById('repropse_form').reset();
				//	$('.selected').html('Select');
				//	$('#question_image').html('');
				//	$('#question_video').html('');
					//$('#success_msg').show();
					$('#close_popup').hide();
					$('#bg-popup').hide();
					$('#mob_bet').html(result);
					$('#change_cate'+cat_id).removeClass("item_tabs").addClass("item_tabs active");
				}
				});
		}
	//alert(cat_id);
}
function enableSelectBoxes(){
$('div.selectBox').each(function(){
var loadHtml='';
var loadValue='';
loadHtml=$(this).children('div.selectOptions').find('span.selectedOption').html();
if(loadHtml==null){
loadHtml=$(this).children('div.selectOptions').children('span.selectOption:first').html();
loadValue=$(this).children('div.selectOptions').children('span.selectOption:first').attr('value')
}else{
loadValue=$(this).children('div.selectOptions').find('span.selectedOption').attr('value');
}
$(this).children('span.selected').html(loadHtml);
$(this).attr('value',loadValue);
$(this).children('span.selected,span.selectArrow').click(function(e){
e.stopPropagation();
$('div.selectOptions').slideUp();
if($(this).parent().children('div.selectOptions').css('display') == 'none'){
$(this).parent().children('div.selectOptions').slideDown();
}
else
{
$(this).parent().children('div.selectOptions').slideUp();
}
show=1;
});
$(this).find('span.selectOption').click(function(){
$(this).parent().slideUp();
$(this).closest('div.selectBox').attr('value',$(this).attr('value'));
$(this).parent().siblings('span.selected').html($(this).html());
});
});
}
function accept_repropse(id,wage)
{
	var total_coins = $('#total_coins').html();
	
	if(wage<=total_coins){
		$('#main-popup').show();
		$('#popupnew').html('You coin is less then this  bet wage');
	}else{
		$('#popup_mobs'+id).show();
	}
	$('#bg-popup').show();
}
function delete_bet(id)
{
	$('#popup_deleteBet'+id).show();
	$('#bg-popup').show();
	
}	
function hide_myBetPopup(id)
{
	$('#popup_deleteBet'+id).hide();
	$('#bg-popup').hide();
}
function delete_mybet(bet_id,cat_id,type)
{	
$('#popup_deleteBet'+bet_id).hide();
$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/deleteMyBet/'+cat_id,
		data:"bet_id="+bet_id+"&type="+type,
		beforeSubmit:function(){
	
			},
		complete:function(){
			
			},
		success:function(data){
			$('#mob_bet').html(data);
			$('#bg-popup').hide();
			if(type=='home'){
			$('#change_cate'+cat_id).removeClass("item_tabs").addClass("item_tabs active");
			}else{
			$('#mybet_change_cate'+cat_id).removeClass("item_tabs").addClass("item_tabs active");
				}
			}
		});
}	
function close_accept_repropse(id)
{
	$('#popup_mobs'+id).hide();
	$('#bg-popup').hide();
}	
function accept_bet(bet_id,cat_id)
{
	$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/acceptBet/'+cat_id,
		data:"bet_id="+bet_id,
		beforeSubmit:function(){
		$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50px;">');
			},
		complete:function(){
			$('#popup_mobs').hide();
			},
		success:function(data){
			$('#mob_bet').html(data);
			$('#bg-popup').hide();
			$('#change_cate'+cat_id).removeClass("item_tabs").addClass("item_tabs active");
			}
		});
		}	
function accept_mybet(bet_id,cat_id)
{
	$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/acceptMyBet/'+cat_id,
		data:"bet_id="+bet_id,
		beforeSubmit:function(){
		$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50px;">');
			},
		complete:function(){
			$('#popup_mobs').hide();
			},
		success:function(data){
			$('#mob_bet').html(data);
			$('#bg-popup').hide();
			$('#mybet_change_cate'+cat_id).removeClass("item_tabs").addClass("item_tabs active");
			}
		});
		}
function open_detail(data)
{
	$('#main-popup').show();
	$('#popupnew').html(data);
	$('#bg-popup').show();
}	
function close_detail()
{
	$('#main-popup').hide();
	$('#bg-popup').hide();
}	
function open_video(data)
{
	$('#main-popup').show();
	$('#popupnew').html('<object width="300" height="300" pluginspage="http://www.apple.com/quicktime/download" data="<?php echo base_url();?>images/bet_images/'+ data + '" type="video/quicktime"><param name="autoplay" value="true"><param name="scale" value="tofit"><param name="controller" value="true"><param name="enablejavascript" value="true"><param name="src" value="<?php echo base_url();?>images/bet_images/'+ data + '"><param name="loop" value="false"></object>');
	$('#bg-popup').show();
}
$('a[id^="change_cate"]').live("click",function() {
	var id = parseInt($(this).attr('id').replace('change_cate',''));
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/acceptBet/'+id,
		beforeSubmit:function(){
		//$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50px;">');
			},
		complete:function(){
			},
		success:function(data){
			$('#mob_bet').html(data);
			$('#bg-popup').hide();
			$('#bg-popup').html('');
			$('#change_cate'+id).removeClass("item_tabs").addClass("item_tabs active");
			}
		});
	
});
/*$('p[id^="detail_bet"]').live("click",function() {
	var id = parseInt($(this).attr('id').replace('detail_bet',''));*/
function detail_bet(bet_id,cat_id){
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/detailBet/'+bet_id+'/'+cat_id,
		beforeSubmit:function(){
		//$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50px;">');
			},
		complete:function(){
			},
		success:function(data){
			$('#mob_bet').html(data);
			$('#bg-popup').hide();
			$('#bg-popup').html('');
			}
		});
}
//});
$('#home').live("click",function(){
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/acceptBet/1',
		beforeSubmit:function(){
		//$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50px;">');
			},
		complete:function(){
			},
		success:function(data){
			$('#mob_bet').html(data);
			$('#bg-popup').hide();
			$('#bg-popup').html('');
			$('#change_cate1').removeClass("item_tabs").addClass("item_tabs active");
			$('#home_li').addClass("first first_z active");
			$('#myBet_li').addClass("second_z").removeClass("active");
			$('#createBet_li').removeClass("active");
			}
		});
	});
	
$('#my_bet').live("click",function(){
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/myBet',
		beforeSubmit:function(){
			},
		complete:function(){
			},
		success:function(data){
			$('#mob_bet').html(data);
			$('#bg-popup').hide();
			$('#bg-popup').html('');
			$('#mybet_change_cate1').removeClass("item_tabs").addClass("item_tabs active");
			$('#home_li').addClass("first first_z").removeClass("active");
			$('#myBet_li').addClass("second_z active");
			$('#createBet_li').removeClass("active");
			}
		});
	});	
$('a[id^="mybet_change_cate"]').live("click",function() {
	var id = parseInt($(this).attr('id').replace('mybet_change_cate',''));
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
		$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/myBet?cat_id='+id,
		beforeSubmit:function(){
			},
		complete:function(){
			},
		success:function(data){
			$('#mob_bet').html(data);
			$('#bg-popup').hide();
			$('#bg-popup').html('');
			$('#mybet_change_cate'+id).removeClass("item_tabs").addClass("item_tabs active");
			}
		});
	
});
	
function repropse_bet(bet_id,cat_id)
{
	$('#popup_mobs'+bet_id).hide();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
$.ajax({
		type:"POST",
		url:"<?php echo base_url();?>index/repropse/",
		data:"bet_id="+bet_id+"&cat_id="+cat_id,
		beforeSend:function(){
		
		},
		complete:function(){
		
		},
		success:function(result){
		$('#re-propose').html(result);			
		}
		});	
}
$('#question_type .selectOption').live("click",function(e) {
		//e.preventDefault();
		if($(this).text()=='Text')
		{
			$('#question_text').show();
			$('#question_image').hide();
			$('#question_video').hide();
			$('#my_image').val('');
			$('#your_image').val('');
			$('#my_vdo').val('');
			$('#you_vdo').val('');
			$('#files').html('');
			$('#youFiles').html('');
			$('#myVideofiles').html('');
			$('#yourVideofiles').html('');
			$('#answer_type').val('Text');
		}else if($(this).text()=='Image')
		{
			$('#question_image').show();
			$('#question_text').hide();
			$('#question_video').hide();
			$('#my_ans').val('');
			$('#you_ans').val('');
			$('#my_vdo').val('');
			$('#you_vdo').val('');
			$('#myVideofiles').html('');
			$('#yourVideofiles').html('');
			$('#answer_type').val('Image');
		}else if($(this).text()=='Video'){
			$('#question_video').show();
			$('#question_image').hide();
			$('#question_text').hide();
			$('#my_ans').val('');
			$('#you_ans').val('');
			$('#my_img').val('');
			$('#you_img').val('');
			$('#youFiles').html('');
			$('#myVideofiles').html('');
			$('#answer_type').val('Video');
			}
	});
	
$('#select_category .selectOption').live("click",function(e) {
		//e.preventDefault();
		//alert($('#abc').attr('value'));
$('#category').val($(this).text());
	});
	
$('#time_limit .selectOption').live("click",function(e) {
		//e.preventDefault();
		$('#timelimit').val($(this).text());
	});
	
$('#expiration .selectOption').live("click",function(e) {
		//e.preventDefault();
		$('#expire').val($(this).text());
});
function vote(bet_id,cat_id,type)
{
	$.ajax({
		type:"POST",
		url:"<?php echo base_url();?>index/vote/",
		data:"bet_id="+bet_id+"&cat_id="+cat_id+"&answer_type="+type,
		beforeSend:function(){
		
		},
		complete:function(){
		
		},
		success:function(result){
			if(result==1){
			if(type=='my_answer'){
	$('#myAnswerVote'+bet_id).html('<img src="<?php echo base_url();?>images/vote_done.png" class="after_green_box_vote">');
	          }else{
	$('#yourAnswerVote'+bet_id).html('<img src="<?php echo base_url();?>images/vote_done.png" class="after_green_box_vote" >');
		}
			}
		}
		});	
} 
function vote_detail(bet_id,cat_id,type)
{
	$.ajax({
		type:"POST",
		url:"<?php echo base_url();?>index/vote/",
		data:"bet_id="+bet_id+"&cat_id="+cat_id+"&answer_type="+type,
		beforeSend:function(){
		
		},
		complete:function(){
		
		},
		success:function(result){
			if(result==1){
			if(type=='my_answer'){
	$('#myAnswerVote'+bet_id).html('<img src="<?php echo base_url();?>images/vote_tick.png" class="after_green_box_vote_down">');
	          }else{
	$('#yourAnswerVote'+bet_id).html('<img src="<?php echo base_url();?>images/vote_tick.png" class="after_green_box_vote_down" >');
		}
			}
		}
		});	
} 
$('#edit_avator').live('click',function(){
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	$.ajax({
		type:"POST",
		url:"<?php echo base_url();?>index/edit_avator/",
		beforeSend:function(){
		
		},
		complete:function(){
		
		},
		success:function(result){
		$('#mob_bet').html(result);	
		$('#bg-popup').hide();
		$('#bg-popup').html('');		
		}
		});	
	});
function buy_avater(id,cost){
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	$.ajax({
		type:"POST",
		url:"<?php echo base_url();?>index/buy_avater/"+id,
		data:"cost="+cost,
		beforeSend:function(){
		
		},
		complete:function(){
		
		},
		success:function(result){
		if(result!=0){
		$('#mob_bet').html(result);
		$('#bg-popup').hide();
		$('#bg-popup').html('');
		}else{
		$('#popup_coinRange').show();
		}
				
		}
		});	
	}
function hide_CoinPopup()
{
$('#bg-popup').hide();
$('#bg-popup').html('');
$('#popup_coinRange').hide();	
}
	
$('a[id^="pending_bet"]').live("click",function(){
var cat_id = parseInt($(this).attr('id').replace('pending_bet',''));
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
		$.ajax({
			type:"post",
			url:"<?php echo base_url();?>index/pending_bet",
			data:"category_id="+cat_id,
			beforeSend:function(){
			},
			complete:function(){
				$('#pending_bet'+cat_id).addClass('btnactive');
				$('#top_better'+cat_id).removeClass(' btnactive');
				},
			success:function(result){
				$('#search_data').html(result);
				$('#bg-popup').hide();
				$('#bg-popup').html('');
				}
			})
	});	
$('a[id^="top_better"]').live("click",function(){
var cat_id = parseInt($(this).attr('id').replace('top_better',''));
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
		$.ajax({
			type:"post",
			url:"<?php echo base_url();?>index/top_better",
			data:"category_id="+cat_id,
			beforeSend:function(){
			},
			complete:function(){
				$('#pending_bet'+cat_id).removeClass('btnactive');
				$('#top_better'+cat_id).addClass(' btnactive');
				},
			success:function(result){
				$('#search_data').html(result);
				$('#bg-popup').hide();
				$('#bg-popup').html('');
				}
			})
	});	
	
$('#change_avater').live('click',function(){
	$('#bg-popup').show();
	$('#popBoxAvatar').show();
	});	
	
function close_popBoxAvatar()
	{
		$('#popBoxAvatar').hide();
		$('#bg-popup').hide();
	}
$('.img_select').live('click',function(){
	var id=$(this).attr('id');
	$('#select_image').val($(this).attr('id'));
	$('.img_select').removeClass('active_avater_pop');
	$('#'+id).addClass('active_avater_pop');
	});
/*$('#all_notification').live('click',function(){
	var title = $(this).attr('title');
	//alert(title);
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
		$.ajax({
			type:"post",
			url:"<?php echo base_url();?>index/open_notification",
			beforeSend:function(){
			},
			complete:function(){
				},
			success:function(result){
				$('#mob_bet').html(result);
				$('#bg-popup').hide();
				$('#bg-popup').html('');
				}
			})
});*/
$('#notification').live('click',function(){
	var title = $(this).attr('title');
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
		$.ajax({
			type:"post",
			url:"<?php echo base_url();?>index/open_notification/?title="+title,
			beforeSend:function(){
			},
			complete:function(){
				},
			success:function(result){
				$('#mob_bet').html(result);
				$('#noti_title').html(title);
				$('#bg-popup').hide();
				$('#bg-popup').html('');
				}
			})
});
/////  show notification afer  read detail
$('.read_ok').live('click',function(){
 	var notification_id = $(this).attr('id');
	var title = $(this).attr('title');
	var page = $(this).attr('name');
	var bet_id = $(this).attr('rev');
	var status = $(this).attr('value');
	$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/open_notification/?notification_id='+notification_id+'&title='+title+'&page='+page+'&bet_id='+bet_id+'&status='+status,//
//	$('#bg-popup').show();
//	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
//		$.ajax({
//			type:"post",
//			url:"<?php echo base_url();?>index/open_notification/?title="+title,
			beforeSend:function(){
			},
			complete:function(){
				},
			success:function(result){
				$('#mob_bet').html(result);
				$('#bg-popup').hide();
				$('#bg-popup').html('');
				$('#read-popup #popupnew').html('');
				$('#read-popup').hide();
				}
			});
});
$("#select_avater").live('click',function(){
	val=$('#select_image').val();
	if(val!=''){
	$.ajax({
		url:"<?php echo base_url();?>index/avater_change/"+val,
		type:"POST",
		beforeSend:function(){
			$('#popBoxAvatar').hide();
			$('#bg-popup').hide();
			},
			complete:function(){
				},
				success:function(result){
					$('#left_side_imgbox').html('<img src="<?php echo base_url();?>images/avater/'+result+'">');
					
					}
		});
	}
	});
	
$(".compare").live('click',function(){
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	$.ajax({
		url:"<?php echo base_url();?>compare/compare_ranking",
		type:"POST",
		beforeSend:function(){
			
			},
			complete:function(){
				},
				success:function(result){
				$('#mob_bet').html(result);
				$('#bg-popup').hide();
				$('#bg-popup').html('');	
					
					}
		});
	});

$(".checkRank").live('click',function(){
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	$.ajax({
		url:"<?php echo base_url();?>compare/compare_ranking",
		type:"POST",
		beforeSend:function(){
			
			},
			complete:function(){
				},
				success:function(result){
				$('#mob_bet').html(result);
				$('#bg-popup').hide();
				$('#bg-popup').html('');	
					
					}
		});
	});

$('#open_credit_popup').live("click",function(){
		$('#bg-popup').show();
		$('#creadit_popup').show();
		})
		
		
// fb credits////
$('#coinsDiv').live("click",function(){
    buy();
});
// The dialog only opens if you've implemented the
  // Credits Callback payments_get_items.
  function buy() {
    var obj = {
      method: 'pay',
      action: 'buy_item',
      // You can pass any string, but your payments_get_items must
      // be able to process and respond to this data.
      order_info: {'item_id': $('input[name="package"]').val()},
      dev_purchase_params: {'oscif': true}
    };
    FB.ui(obj, js_callback);
  }
  // This JavaScript callback handles FB.ui's return data and differs
  // from the Credits Callbacks.
  var js_callback = function(data) {
    if (data['order_id']) {
      // Facebook only returns an order_id if you've implemented
      // the Credits Callback payments_status_update and settled
      // the user's placed order.
      // Notify the user that the purchased item has been delivered
      // without a complete reload of the game.
      write_callback_data(
                "<br><b>Transaction Completed!</b> </br></br>"
                + "Data returned from Facebook: </br>"
                + "Order ID: " + data['order_id'] + "</br>"
                + "Status: " + data['status']);
    } else if (data['error_code']) {
      // Appropriately alert the user.
      write_callback_data(
                "<br><b>Transaction Failed!</b> </br></br>"
                + "Error message returned from Facebook:</br>"
                + data['error_code'] + " - "
                + data['error_message']);
    } else {
      // Appropriately alert the user.
      write_callback_data("<br><b>Transaction failed!</b>");
    }
  };
  function write_callback_data(str) {
    document.getElementById('fb-ui-return-data').innerHTML=str;
  }
/////end fb credit/////
$('input[id^="package_opt"]').live("click",function(){
	var cat_id = parseInt($(this).attr('id').replace('package_opt',''));
var cat_id = $("#package_opt"+cat_id).val();
	$('#package').val(cat_id);
	});		
	
$('#close_creadit_popup').live("click",function(){
	$.ajax({
		url:"<?php echo base_url();?>index/getUserCoin",
		type:"POST",
		beforeSend:function(){},
		complete:function(){},
		success:function(result){
			$('#bg-popup').hide();
			$('#creadit_popup').hide();
			$('#total_coins').html(result);
			}
		})
	});
	
$('.readmore').live("click",function(){
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	var notification_id = $(this).attr('id');
	var title = $(this).attr('title');
	var page = $(this).attr('name');
	var bet_id = $(this).attr('rev');
	var status = $(this).attr('value');
	$.ajax({
		type:"post",
		url:'<?php echo base_url();?>index/readNotification/?notification_id='+notification_id+'&title='+title+'&page='+page+'&bet_id='+bet_id+'&status='+status,
		beforeSubmit:function(){
		//$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50px;">');
			},
		complete:function(){
			},
		success:function(data){
			$('#read-popup #popupnew').html(data);
			$('#read-popup').show();
			
			}
		});
	});
	
// rank
$('a[id^="rank_change_cate"]').live("click",function() {
	var id = parseInt($(this).attr('id').replace('rank_change_cate',''));
	$('#bg-popup').show();
	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
	$.ajax({
		type:"post",
		url:'<?php echo base_url();?>compare/compare_ranking/?category_id='+id,
		beforeSubmit:function(){
		//$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50px;">');
			},
		complete:function(){
			},
		success:function(data){
			$('#mob_bet').html(data);
			$('#bg-popup').hide();
			$('#bg-popup').html('');
			$('#rank_change_cate'+id).removeClass("item_tabs").addClass("item_tabs active");
			}
		});
	
});

function search_pending_bet(id)
{
		value=$('#serach_pending_bet').val();
		if($.trim(value)!=''){
		$('#bg-popup').show();
		$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
		$.ajax({
			type:"post",
			url:"<?php echo base_url();?>index/search_bet",
			data:"value="+value+"&category_id="+id,
			beforeSend:function(){
				$('#pending_bet'+id).addClass('btnactive');
				$('#top_better'+id).removeClass(' btnactive');
			},
			complete:function(){
				},
			success:function(result){
				$('#search_data').html(result);
				$('#bg-popup').hide();
				$('#bg-popup').html('');
				}
			})
		}else{
			alert("Please enter text first");
			}
}
</script>