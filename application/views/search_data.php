<?php if(@$top_better!='top_better'){?>
<table class="tablng_c">
                    	<thead>
                        	<tr>
                            <th>Bet by <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
                            <th>Bet <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
                            <th>Expiration <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
                            <th>Action <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
                            <th>Wager <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
                          
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
						if($getbets){
						foreach($getbets as $bet){?>
                        	<tr class="even">
                            	<td><?php echo $bet['user_name'];?></td>
                                <td><?php echo $bet['question'];?></td>
                                <td><?php echo date('d-M-Y',strtotime($bet['datetime']."+".$bet['expiration'] ."day")); ?></td>
                                <?php  if($bet['creater_id']==$user_id){?>
                               <td><a href="#_" onclick="delete_bet('<?php echo $bet['bet_id'];?>','<?php echo $category_id;?>');">Delete Bet</a></td>
                               <!-----delete popup----->
                              <div class="popup_mobs" style="display:none;" id="popup_deleteBet<?php echo $bet['bet_id'];?>">
                        <h1>Are You Sure You Want To Delete Bet</h1>
                    <a href="#_" class="acpt_btn" onclick="delete_mybet(<?php echo $bet['bet_id'];?>,<?php echo $category_id;?>,'home');">Yes</a>
                    <a href="#_" class="acpt_btn" onclick="hide_myBetPopup(<?php echo $bet['bet_id'];?>);">No</a>
                        </div>
                        	  <!-----end delete popup----->
							   <?php }else{			?>
                                <td><a href="#_" onclick="accept_repropse('<?php echo $bet['bet_id'];?>');">Accept / Re-propse</a></td>
                              <!----Accept or r-epropose popup----->                  
     							   <div class="popup_mobs" style="display:none;" id="popup_mobs<?php echo $bet['bet_id'];?>">
    	<div class="cross"><img src="<?php echo base_url();?>images/cros.png" onclick="close_accept_repropse(<?php echo $bet['bet_id'];?>);"/></div>
        <h1>Accept or Re-propose Bet</h1>
        <a href="#_" class="acpt_btn" onclick="accept_bet(<?php echo $bet['bet_id'];?>,1);">Accept</a>
        <a href="#_" class="acpt_btn" onclick="repropse_bet(<?php echo $bet['bet_id'];?>,<?php echo $bet['category_id'];?>);">Re-propose</a>
    </div>
   				 			 <!---- End popup-----> 
                                <?php } ?>
                                <td><?php echo $bet['wager'];?></td>
                            </tr>
                            <?php }
							}else{?><tr >
                           	<td colspan="5" style="border-top: 1px solid #7D7D7D; height: 50px;
  text-align: center; color:#F00;font-family:Arial, Helvetica, sans-serif;"> No Bet Available</td>
                            </tr>
							<?php }
							
							?>
                           
                        </tbody>
                    </table>
                    <?php }else{?>
 
					<table class="tablng_c" width="100%">
                    	<thead>
                        	<tr>
                            <th>Rank No  <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
                            <th>User Name <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
                            <th>Total Bet<div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th> 
                            <th>Win Bet<div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
                          
                          
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
						if($gettopbets){
							$count=1;
						foreach($gettopbets as $topbet){?>
                        	<tr class="even">
                            	<td><?php echo $count;?></td>
                                <td><?php echo $topbet['user_name'];?></td>
                                 <td><?php echo $topbet['total_bet'];?></td>
                                <td><?php echo $topbet['win_bet'];?></td>
                            </tr>
                            <?php
							$count++; }
							}else{?><tr >
                           	<td colspan="5" style="border-top: 1px solid #7D7D7D; height: 50px;
  text-align: center; color:#F00;font-family:Arial, Helvetica, sans-serif;"> No Rank Available</td>
                            </tr>
							<?php }
							
							?>
                           
                        </tbody>
                    </table>

					
					<?php }?>