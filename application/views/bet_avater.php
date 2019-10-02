<div class="mob_bets_avatar">
  <div class="mob_bets_purchase">
    <div class="left_content_left">
      <div class="left_side_pic">
        <div class="left_side_imgbox" id="left_side_imgbox">
          <?php 

			if($user_data['userData']['user_image']){

			echo '<img src="'.base_url().'images/avater/'.$user_data['userData']['user_image'].'" width="145">';

				}else{

	echo '<img src="https://graph.facebook.com/'.$user_id.'/picture/?width=140&height=140"/>';

				}?>
        </div>
        <a href="#" class="left_side_imgbtn" id="change_avater">Change Your Avatar</a></div>
      <div class="bet_notfic">Best Notification</div>
      <a href="#" class="notification_tab">
      <div class="notif_txt">Rank # </div>
      <div class="compare"  style="margin-left:40px;margin-top:-15px;">compare</div>
      </a> <a href="#" class="notification_tab">
      <div class="notif_txt" id="notification" title="notification" style="width:97px;">Notification</div>
      <div class="notif_num">(<?php echo isset($user_notification_count['all_notification']['countNotifiId']) ?  $user_notification_count['all_notification']['countNotifiId'] : 0;?>)</div>
      </a> <a href="#" class="notification_tab">
      <div class="notif_txt" id="notification" title="new_bets" style="width:97px;">New Bets Requests</div>
      <div class="notif_num">(<?php echo isset($user_notification_count['new_bet']['countNotifiId']) ?  $user_notification_count['new_bet']['countNotifiId'] : 0;?>)</div>
      </a> <a href="#" class="notification_tab">
      <div class="notif_txt" id="notification" title="proposed_bets" style="width:97px;">Proposed Bets</div>
      <div class="notif_num">(<?php echo 

	  isset($user_notification_count['proposed_bet']['countNotifiId']) ?  $user_notification_count['proposed_bet']['countNotifiId'] : 0;?>)</div>
      </a> <a href="#" class="notification_tab">
      <div class="notif_txt" id="notification" title="general_bets" style="width:97px;">General Forum Bets</div>
      <div class="notif_num">(
        <?php 

	  echo  isset($user_notification_count['general_bet']['countNotifiId']) ?  $user_notification_count['general_bet']['countNotifiId'] : 0;?>
        )</div>
      </a> </div>
    <div class="mob_purchase_right">
      <h1>Purchase Avatar</h1>
      <div class="purchase_mid">
        <?php 

		foreach($avater as $avaters){?>
        <div class="pic_box"> <img src="<?php echo base_url();?>images/avater/<?php echo $avaters['images'];?>" id="popup_avater<?php echo $avaters['image_id'];?>" />
          <div class="pic_bottm">
            <p><span><?php echo $avaters['name'];?></span>Cost: <?php echo $avaters['cost'];?></p>
            <a href="#_" class="buy_btn"  onClick="buy_avater(<?php echo $avaters['image_id'];?>,<?php echo $avaters['cost'];?>);">Buy Now</a> </div>
        </div>
        <?php }?>
      </div>
    </div>
  </div>
</div>
<script>
$('#total_coins').html('<?php echo $user_coins['user_coins'];?>');
$('img[id^="popup_avater"]').live("click",function(){

	var id = parseInt($(this).attr('id').replace('popup_avater',''));

	alert($('#popup_avater'+id).attr('img'));

	})

</script>
<div class="right_content_box">
  <div class="profile_content">
    <div class="profile_head">Profile</div>
    <ul class="bullets">
      <li>Total Coins (<?php echo $user_coins['user_coins'];?>)</li>
      <li>Total Wins (<?php echo $user_coins['total_win'];?>)</li>
      <li>Total Lost (<?php echo ($lost_bet['lost_bet']-$user_coins['total_win']);?>)</li>
      <li>Total Xp Point (<?php echo $xp_point['xp_point'];?>)</li>
    </ul>
  </div>
  <div class="items">
    <h1>Items</h1>
    <?php 

				 if($my_avater){

				 foreach($my_avater as $myavater){?>
    <div class="house_item"> <img src="<?php echo base_url();?>images/avater/<?php echo $myavater['images'];?>" />
      <p><span><?php echo $myavater['name'];?></span><br />
        Cost: <?php echo $myavater['cost'];?> Coin $</p>
    </div>
    <?php } 

				 }else{?>
    <div style="border-top: 1px solid #7D7D7D;text-align: center; color:#F00;font-family:Arial, Helvetica, sans-serif">No Item available</div>
    <?php }?>
    
    <!--  <div class="house_item">

                    	<a href="#" class="purchase_btn">Purchase Item</a>

                    </div>--> 
    
  </div>
</div>

<!-----Coin range popup----->

<div class="popup_mobs" style="display:none;" id="popup_coinRange">
  <h1>Limit Out Of Range</h1>
  <a href="#_" class="acpt_btn" onclick="hide_CoinPopup();" style="margin-left:95px;">OK</a> </div>

<!-----end Coin range popup-----> 

<!----avater  popup---->

<div id="popBoxAvatar" class="popup"> <a href="#_" class="closePop" onclick="close_popBoxAvatar();"><img src="<?php echo base_url();?>images/cros.png" class="btn_close_rdPop" title="Close Window" alt="Close" /></a>
  <div class="pop_inner">
    <?php 

		$counter=1;

		foreach($user_avaters as $userAvater){?>
    <div class="img_select" id='<?php echo $userAvater['image_id']?>'> <img src="<?php echo base_url();?>images/avater/<?php echo $userAvater['images']?>"  /> </div>
    <?php 

		$counter++;

		} ?>
    <br clear="all" />
    <input type="hidden" name="select_image" id="select_image" />
    <a href="#_" class="pop_btn" id="select_avater">Done</a> <br clear="all" />
  </div>
</div>

<!----End avater  popup---->