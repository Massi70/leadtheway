<?php //var_dump($user_data);?>

<div class="notification_box">
  <div id="show_notifi_div">
    <div class="left_content_box">
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
        </a> </div>
      <div class="left_content_right">
        <h1 id="noti_title">Notifications</h1>
        <?php if(count($notification)>0):

						foreach($notification as $notifi){?>
        <div class="notification_content_box">
          <h2>
            <?php if($user_id!==$notifi['user_id']) : echo $notifi['rec_f_name']." ".$notifi['rec_l_name']; else :  echo $notifi['sen_f_name']." ".$notifi['sen_l_name']; endif;?>
            has
            <?php if($notifi['type']=='new_bet'): echo  "proposed"; elseif($notifi['type']=='proposed_bet'): echo "reproposed";  elseif($notifi['type']=='general_bet'): echo "general"; endif;?>
            a bet</h2>
          <p>
            <?php $description = $notifi['question'];echo (strlen($description) > 50) ? substr(strip_tags($description),0,50)."..........." : trim(strip_tags($description)); ?>
            <?php //echo $notifi['question'];?>
          </p>
          <a href="#" class="readmore" <?php if($notifi['status']==0){ ?>  style="color:#DD1321"
		  <?php  } ?> id="<?php echo $notifi['notification_id'];?>" title="<?php echo $title;?>" name="<?php echo $page;?>" rev="<?php echo $notifi['bet_id'];?>"  value="<?php echo $notifi['status'];?>">Readmore</a> </div>
        <?php }else: ?>
        <div class="notification_content_box">
          <h2>No Notification Found</h2>
          <p>There Is no Notification present</p>
        </div>
        <?php endif; ?>
      </div>
      
      <!-- after complete coding  emplement pagning-->
      
      <?php if($notification_count>5):?>
      <div class="pagination" style="float:right;" > <?php echo $paging; ?>
        <div style="clear: both;"> </div>
      </div>
      <?php endif;?>
    </div>
  </div>
  <div class="right_content_box">
    <div class="mob_notif_pic">
      <div class="img_box">
        <?php 

			if($user_data['userData']['user_image']){

			echo '<img src="'.base_url().'images/avater/'.$user_data['userData']['user_image'].'" width="145">';

				}else{

	echo '<img src="https://graph.facebook.com/'.$user_id.'/picture/?width=140&height=140"/>';

				}?>
      </div>
      
      <!-- <a href="#" class="imag_btn">Create Your Avatar</a>--></div>
    
    <!-- <div class="profile_content">

             <div class="profile_head">Profile</div>

             <ul class="bullets">

             	<li>Total Coins (<?php echo $user_data['userData']['user_coins'];?>)</li>

                <li>Total Wins (2)</li>

                <li>Total Lost (3)</li>

                <li>Total Coins (350)</li>

                <li>Experience Point</li>

                <li>Total Wins (2)</li>

             </ul>

            	</div>--> 
    
  </div>
</div>
