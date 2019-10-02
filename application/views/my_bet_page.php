<?php 


$count=$offSet+1;

foreach($my_bets as $mybets){?>

                <div class="mob_contents">

                <div class="content_num"><?php echo $count;?></div>

 <?php	 $creator_level=$this->userModel->get_level($mybets['creater_id'],$mybets['category_id']);
          if($creator_level){$creator_rank=$creator_level['level'];}else{$creator_rank=0;}  
		 $acceptor_level=$this->userModel->get_level($mybets['acceptor_id'],$mybets['category_id']);
		 if($acceptor_level){$acceptor_rank=$acceptor_level['level'];}else{$acceptor_rank=0;}
          ?>
					<div class="lft_content_mobs">

                   	 <h2>Bet between <?php echo $mybets['creator_name']; ?> (<?php echo $creator_rank?>) & <?php echo $mybets['acceptor_name']; ?> (<?php echo $acceptor_rank?>)</h2>	

                     <p><?php echo $mybets['question'];?></p>

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

							 <p style="text-align:center;cursor: pointer;" onclick="open_video('<?php  echo $mybets['my_answer'];?>');">

                            <img src="<?php echo base_url();?>images/1359749761_video-icon.png" style="margin-top:-8px;"/>

                             </p>

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

							 <p style="text-align:center;cursor: pointer;" onclick="open_video('<?php  echo $mybets['your_answer'];?>');">

                            <img src="<?php echo base_url();?>images/1359749761_video-icon.png" style="margin-top:-8px;"/>

                             </p>

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