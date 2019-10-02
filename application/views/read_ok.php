<style>
.read_ok{
	position: absolute;
    right: 7px;
    top: 45px;
}
</style>

<?php  foreach($notification as $notifi){ ?>
                   			 <div class="notification_content_box">
                    	<h2><?php if($user_id!==$notifi['user_id']) : echo $notifi['rec_f_name']." ".$notifi['rec_l_name']; else :  echo $notifi['sen_f_name']." ".$notifi['sen_l_name']; endif;?> has <?php if($notifi['type']=='new_bet'): echo  "proposed"; elseif($notifi['type']=='proposed_bet'): echo "reproposed";  elseif($notifi['type']=='general_bet'): echo "general"; endif;?> a bet</h2>
                        <p>
						<?php echo $notifi['question']; ?>
						
						<?php //echo $notifi['question'];?></p>
                        <a href="#" class="read_ok" id="<?php echo $notifi['notification_id'];?>" title="<?php echo $title;?>" name="<?php echo $page;?>" rev="<?php echo $notifi['bet_id'];?>" value="<?php echo $notifi['status'];?>" ><img src="<?php echo base_url();?>images/ok_button.PNG" /></a>
                    </div>
                    <?php  } ?>
     