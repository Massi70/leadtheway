<style>
a.notification_tab {
	background: url("images/notification_tab_bg.JPG") repeat-x scroll center top transparent;
	border-left: 1px solid #C4C4C4;
	border-radius: 0 0 4px 4px;
	border-right: 1px solid #C4C4C4;
	color: #FFFFFF;
	float: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	padding: 8px 0 10px 5px;
	position: relative;
	text-align: center;
	width: 142px;
}
.bet_notfic {
	background: none repeat scroll 0 0 #AF1026;
	border-radius: 8px 8px 0 0;
	color: #FFFFFF;
	float: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	margin-top: 15px;
	padding: 3px 10px 5px;
	position: relative;
	text-align: center;
	width: 128px;
}
.notification_tab .notif_num {
	color: #000000;
	float: right;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	width: 30px;
}
</style>

<div class="lft_content_mobs">
  <div class="leftmobs_content_pic">
    <div class="img_box_mobs" style="width:145px;height:145px;overflow:hidden">
      <?php if($user_data['userData']['user_image']){

			echo '<img src="'.base_url().'images/avater/'.$user_data['userData']['user_image'].'" width="145">';

				}else{

	echo '<img src="https://graph.facebook.com/'.$user_id.'/picture/?width=140&height=140"/>';

				}?>
    </div>
    <a href="#_" class="imag_btn" id="edit_avator">Edit Avatar</a> <br/>
    <br/>
  </div>
  <div class="left_content_left">
    <div class="bet_notfic">Best Notification</div>
    <a href="#" class="notification_tab">
    <div class="notif_txt" id="notification" title="Notification">Notification</div>
    <div class="notif_num">(<?php echo $user_notification_count['all_notification']['countNotifiId'];?>)</div>
    </a> <a href="#" class="notification_tab">
    <div class="notif_txt" id="notification" title="New Bets Requests" >New Bets Requests</div>
    <div class="notif_num">(<?php echo $user_notification_count['new_bet']['countNotifiId'];?>)</div>
    </a> <a href="#" class="notification_tab">
    <div class="notif_txt" id="notification" title="Proposed Bets">Proposed Bets</div>
    <div class="notif_num">(<?php echo $user_notification_count['proposed_bet']['countNotifiId'];?>)</div>
    </a> <a href="#" class="notification_tab">
    <div class="notif_txt" id="notification" title="General Forum Bets">General Forum Bets</div>
    <div class="notif_num">(<?php echo $user_notification_count['general_bet']['countNotifiId'];?>)</div>
    </a></div>
  <br clear="all" />
  <div class="profile_lft">Profile</div>
  <div class="profile_lft_tabs">
    <div class="left_contnt">Total Coins:</div>
    <div class="right_num_cont"><?php echo $user_coins['user_coins'];?></div>
  </div>
  <div class="profile_lft_tabs">
    <div class="left_contnt">Total Wins:</div>
    <div class="right_num_cont"><?php echo $user_coins['total_win'];?></div>
  </div>
  <div class="profile_lft_tabs">
    <div class="left_contnt">Total Lost:</div>
    <div class="right_num_cont"><?php echo ($lost_bet['lost_bet']-$user_coins['total_win']);?></div>
  </div>
  <div class="profile_lft_tabs">
    <div class="left_contnt">Total Xp Points:</div>
    <div class="right_num_cont"><?php echo $xp_point['xp_point'];?></div>
  </div>
</div>
<div class="mob_bets_main">
  <div class="nav_box">
    <div class="item_left_tabs">
      <?php 

					$category_name='';

				  foreach($category as $cat){

					if($cat['category_id']==$category_id)

					{

						$category_name=$cat['category_name'];

					}	?>
      <a href="#"  class="item_tabs" id="mybet_change_cate<?php echo $cat['category_id'];?>"><?php echo $cat['category_name'];?></a>
      <?php }?>
    </div>
  </div>
  <div class="bets_content_in">
    <h1>Top Bets of <?php echo $category_name;?></h1>
    <?php 
				if($my_bets){

				$count=1; ?>
    <div id="allbet_Div">
      <?php foreach($my_bets as $mybets){?>
      <div class="mob_contents">
        <div class="content_num"><?php echo $count;?></div>
        <?php 
		 $creator_level=$this->userModel->get_level($mybets['creater_id'],$mybets['category_id']);
          if($creator_level){$creator_rank=$creator_level['level'];}else{$creator_rank=0;}  
		 $acceptor_level=$this->userModel->get_level($mybets['acceptor_id'],$mybets['category_id']);
		 if($acceptor_level){$acceptor_rank=$acceptor_level['level'];}else{$acceptor_rank=0;}
              ?>
        <div class="lft_content_mobs">
          <h2>Bet between <?php echo $mybets['creator_name']; ?> (<?php echo $creator_rank?>) & <?php echo $mybets['acceptor_name']; ?> (<?php echo $acceptor_rank?>)</h2>
          
          <!--<p id="detail_bet<?php echo $mybets['bet_id']?>" style="cursor:pointer;"><?php echo $mybets['question'];?></p>-->
          
          <p onclick="detail_bet(<?php echo $mybets['bet_id']?>,<?php echo $mybets['category_id']?>);" style="cursor:pointer;"><?php echo $mybets['question'];?></p>
          <div class="green_box_main">
            <div class="green_box">
              <div class="green_box_left">
                <?php if($mybets['answer_type']=='Image'){?>
                <p style="text-align:center;cursor: pointer;" onclick="open_detail('<img src=<?php echo base_url();?>images/bet_images/<?php echo $mybets['my_answer'];?> width=350 />');"><img src="<?php echo base_url();?>images/bet_images/<?php echo $mybets['my_answer'];?>" style="max-height:33px; max-width:50px;"/></p>
                <?php }

						else if($mybets['answer_type']=='Text'){?>
                <p style="text-align:center;cursor: pointer;" onclick="open_detail('<?php echo $mybets['my_answer']; ?>');"><?php echo $mybets['my_answer']; ?></p>
                <?php }

						else{?>
                <p style="text-align:center;cursor: pointer;" onclick="open_video('<?php  echo $mybets['my_answer'];?>');"> <img src="<?php echo base_url();?>images/1359749761_video-icon.png" style="margin-top:-8px;"/> </p>
                <?php }?>
              </div>
              <div class="green_box_vote">vote (<?php echo isset($mybets['my_answer_vote']) ?  $mybets['my_answer_vote'] : 0;?>)</div>
            </div>
            <span>VS</span>
            <div class="green_box" style="float:right">
              <div class="green_box_left">
                <?php if($mybets['answer_type']=='Image'){?>
                <p style="text-align:center;cursor: pointer;" onclick="open_detail('<img src=<?php echo base_url();?>images/bet_images/<?php echo $mybets['your_answer'];?> width=350 />');"><img src="<?php echo base_url();?>images/bet_images/<?php echo $mybets['your_answer'];?>" style="max-height:33px; max-width:50px;"/></p>
                <?php }

						else if($mybets['answer_type']=='Text'){?>
                <p style="text-align:center;cursor: pointer;" onclick="open_detail('<?php echo $mybets['your_answer']; ?>');"><?php echo $mybets['your_answer']; ?></p>
                <?php }

						else{?>
                <p style="text-align:center;cursor: pointer;" onclick="open_video('<?php  echo $mybets['your_answer'];?>');"> <img src="<?php echo base_url();?>images/1359749761_video-icon.png" style="margin-top:-8px;"/> </p>
                <?php }?>
              </div>
              <?php ?>
              <div class="green_box_vote">vote (<?php echo isset($mybets['your_answer_vote']) ? $mybets['your_answer_vote'] : 0;?>)</div>
            </div>
          </div>
        </div>
        <div class="coins_content_mobs">
          <div class="coins_content"><?php echo $mybets['wager'];?></div>
        </div>
      </div>
      <?php

				$count++;

				 }?>
      <?php if($my_bets_count>0):?>
      <div class="pagination" style="float:right;" > <?php echo $paging; ?>
        <div style="clear: both;"> </div>
      </div>
      <?php endif;?>
    </div>
    <?php 	}else{?>
    <div style="text-align:center;margin-top:135px;color:#F00;font-family:Arial, Helvetica, sans-serif;">No Bet Available</div>
    <?php }?>
  </div>
</div>
<div class="pending_bets" >
  <div class="nav_pendding"> <a href="#" class="pentng_btn btnactive" id="pending_bet<?php echo $category_id;?>">Pending Bets</a> <a href="#" class="pentng_btn" id="top_better<?php echo $category_id;?>" style="margin-left:10px;">Top Betters Of <?php echo $category_name;?></a>
    <div class="search_box">
      <div class="search_inner">
        <input type="text" class="search" id="serach_pending_bet"/>
        <a href="#" class="search_icon"><img src="<?php echo base_url();?>images/search_icon.png" onclick="search_pending_bet(<?php echo $category_id;?>);"/></a> </div>
    </div>
  </div>
  <div class="tablng_content"  id="search_data">
    <table class="tablng_c" >
      <thead>
        <tr>
          <th>Bet by
            <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
          <th>Bet
            <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
          <th>Expiration
            <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
          <th>Action
            <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
          <th>Coins
            <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
        </tr>
      </thead>
      <tbody >
        <?php if($getbets){

						foreach($getbets as $bet){?>
        <tr class="even">
          <td><?php echo $bet['user_name'];?></td>
          <td><?php echo $bet['question'];?></td>
          <td><?php echo date('d-M-Y',strtotime($bet['datetime']."+".$bet['expiration'] ."day")); ?></td>
          <?php 

								if($bet['creater_id']==$user_id){?>
          <td><a href="#_" onclick="delete_bet('<?php echo $bet['bet_id'];?>','<?php echo $category_id;?>');">Delete Bet</a></td>
          
          <!-----delete popup----->
          
          <div class="popup_mobs" style="display:none;" id="popup_deleteBet<?php echo $bet['bet_id'];?>">
            <h1>Are You Sure You Want To Delete Bet</h1>
            <a href="#_" class="acpt_btn" onclick="delete_mybet(<?php echo $bet['bet_id'];?>,<?php echo $category_id;?>,'my_bet');">Yes</a> <a href="#_" class="acpt_btn" onclick="hide_myBetPopup(<?php echo $bet['bet_id'];?>);">No</a> </div>
          
          <!-----end delete popup----->
          
          <?php }else{?>
          <td><a href="#_" onclick="accept_repropse('<?php echo $bet['bet_id'];?>');">Accept / Re-propse</a></td>
          
          <!----Accept or r-epropose popup----->
          
          <div class="popup_mobs" style="display:none;" id="popup_mobs<?php echo $bet['bet_id'];?>">
            <div class="cross"><img src="<?php echo base_url();?>images/cros.png" onclick="close_accept_repropse(<?php echo $bet['bet_id'];?>);"/></div>
            <h1>Accept or Re-propose Bet</h1>
            <a href="#_" class="acpt_btn" onclick="accept_mybet(<?php echo $bet['bet_id'];?>,<?php echo $category_id;?>);">Accept</a> <a href="#_" class="acpt_btn" onclick="repropse_bet(<?php echo $bet['bet_id'];?>,<?php echo $bet['category_id'];?>);">Re-propose</a> </div>
          
          <!---- End popup----->
          
          <?php }?>
          <td><?php echo $bet['wager'];?></td>
        </tr>
        <?php }

							}else{?>
        <tr >
          <td colspan="5" style="border-top: 1px solid #7D7D7D; height: 50px;

  text-align: center; color:#F00;font-family:Arial, Helvetica, sans-serif"> No Bet Available</td>
        </tr>
        <?php }

							

							?>
      </tbody>
    </table>
  </div>
</div>
<script>

$('#serach_pending_bet').keypress(function(e){

	if(e.keyCode==13){

	$('#bg-popup').show();

	$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');

		value=$('#serach_pending_bet').val();

		$.ajax({

			type:"post",

			url:"<?php echo base_url();?>index/search_bet",

			data:"value="+value+"&category_id=<?php echo $category_id;?>",

			beforeSend:function(){

			},

			complete:function(){

				$('#pending_bet<?php echo $category_id;?>').addClass('btnactive');

				$('#top_better<?php echo $category_id;?>').removeClass(' btnactive');

				},

			success:function(result){

				$('#search_data').html(result);

				$('#bg-popup').hide();

				$('#bg-popup').html('');

				}

			})

		}

	});

</script> 