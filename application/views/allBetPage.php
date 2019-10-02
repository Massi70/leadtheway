<div class="add_item_content">

            	<h1>Top Bets of Dating</h1>

                <?php

				if($getAllBets){

				 foreach($getAllBets as $getallbets){?>     

                <div class="mob_contents">

					<div class="lft_content_mobs">

                   	 <h2>Bet between <?php echo $getallbets['creator_name']; ?> (8) & <?php echo $getallbets['acceptor_name']; ?> (12)</h2>	

                     <p id="detail_bet<?php echo $getallbets['bet_id']?>" style="cursor:pointer;"><?php echo $getallbets['question'];?></p>

                    <!----left green box---->

                     <div class="green_box">

                       	<div class="green_box_left" >

                        <?php if($getallbets['answer_type']=='Image'){?>

                        <p style="text-align:center;cursor: pointer;" onclick="open_detail('<img src=<?php echo base_url();?>images/bet_images/<?php echo $getallbets['my_answer'];?> width=350 />');"><img src="<?php echo base_url();?>images/bet_images/<?php echo $getallbets['my_answer'];?>" style="max-height:33px; max-width:50px;"/></p>

                        <?php }

						else if($getallbets['answer_type']=='Text'){?>

                        <p style="text-align:center;cursor: pointer;" onclick="open_detail('<?php echo $getallbets['my_answer']; ?>');"><?php echo substr($getallbets['my_answer'],0,35); ?></p>

						<?php }

						else{?>

							 <p style="text-align:center;cursor: pointer;" onclick="open_video('<?php  echo $getallbets['my_answer'];?>');">

                            <img src="<?php echo base_url();?>images/1359749761_video-icon.png" style="margin-top:-8px;"/>

                             </p>

							<?php }?>

                        </div>

                        <!------ vote---->

                     <?php /*?>   <div id="myAnswerVote<?php echo $getallbets['bet_id'];?>">

                     	<?php if($getallbets['vote_answer']=='my_answer'){?>

                        <img src="<?php echo base_url();?>images/vote_tck2.png" class="after_green_box_vote" >

                        <?php }else{?>

                        <div class="green_box_vote" onclick="vote(<?php echo $getallbets['bet_id'];?>,<?php echo $getallbets['category_id'];?>,'my_answer');">vote</div>

                        <?php } ?>

                        </div><?php */?>
                        <div id="myAnswerVote<?php echo $getallbets['bet_id'];?>">

            <?php if($getallbets['vote_answer']=='my_answer'){?>

            <img src="<?php echo base_url();?>images/vote_done.png" class="after_green_box_vote" >

            <?php }else{

			if($getallbets['creater_id']!=$user_id && $getallbets['acceptor_id']!=$user_id){

				?>

            <div class="green_box_vote" onclick="vote(<?php echo $getallbets['bet_id'];?>,<?php echo $getallbets['category_id'];?>,'my_answer');">Vote</div>

            <?php  } else{?>

		 <div class="green_box_vote" >vote</div>

				  <?php }

			}?>

          </div>

                          <!------End  vote---->

                     </div>

                     <span>To</span>

                 

                       <!----Right green box---->

                     <div class="green_box" style="float:right">

                     	<div class="green_box_left">

                        <?php if($getallbets['answer_type']=='Image'){?>

                        <p style="text-align:center;cursor: pointer;" onclick="open_detail('<img src=<?php echo base_url();?>images/bet_images/<?php echo $getallbets['your_answer'];?> width=350 />');"><img src="<?php echo base_url();?>/images/bet_images/<?php echo $getallbets['your_answer'];?>" style="max-height:33px; max-width:50px;"/></p>

                        <?php }

						else if($getallbets['answer_type']=='Text'){?>

                        <p style="text-align:center;cursor: pointer;" onclick="open_detail('<?php echo $getallbets['your_answer']; ?>');"><?php echo substr($getallbets['your_answer'],0,35); ?></p>

						<?php }

						else{?>

							<p style="text-align:center;cursor: pointer;" onclick="open_video('<?php echo $getallbets['your_answer']; ?>');">

                            <img src="<?php echo base_url();?>images/1359749761_video-icon.png" style="margin-top:-8px;"/>

                             </p>

							<?php }?>

                        </div>

                     	<!------ vote---->

                    <?php /*?>    <div  id="yourAnswerVote<?php echo $getallbets['bet_id'];?>">

                     	<?php if($getallbets['vote_answer']=='your_answer'){?>

                        <img src="<?php echo base_url();?>images/vote_tck2.png" class="after_green_box_vote" >

                        <?php }else{?>

                        <div class="green_box_vote" onclick="vote(<?php echo $getallbets['bet_id'];?>,<?php echo $getallbets['category_id'];?>,'your_answer');">vote</div>

                        <?php } ?>

                        </div><?php */?>
                                  <div  id="yourAnswerVote<?php echo $getallbets['bet_id'];?>">

            <?php if($getallbets['vote_answer']=='your_answer'){?>

            <img src="<?php echo base_url();?>images/vote_done.png" class="after_green_box_vote" >

            <?php }else{

			 if($getallbets['creater_id']!=$user_id && $getallbets['acceptor_id']!=$user_id){

				?>

            <div class="green_box_vote" onclick="vote(<?php echo $getallbets['bet_id'];?>,<?php echo $getallbets['category_id'];?>,'your_answer');">Vote</div>

            <?php }else{?>

		<div class="green_box_vote" >vote</div>

				  <?php }

			}?>

          </div>

                          <!------End  vote---->



                     </div>

                     <!----end ---->

                    </div>

					<div class="right_content_mobs">

                    	<div class="coins_content"><?php echo $getallbets['wager'];?></div>

                        <div class="vote_rght">

                        <img src="<?php echo base_url();?>images/icon.PNG" />

                      <?php $total_voter=$this->userModel->getTotalVoter($getallbets['bet_id']);?>

                        <p>All Voters</p>

                        <span><?php echo $total_voter['total_voter'];?></span>

                        </div>

                    </div>

				</div>

                <?php } 

				}else{?>

					<div style="text-align:center;margin-top:100px;color:#F00;font-family:Arial, Helvetica, sans-serif;">No Bet Avialable</div>

					<?php }?>

               

                

            </div>

            <!-----pagination--->

             <?php if($getAllBetsCount>0):?>

               

                 <div class="pagination" style="float:right;" > <?php echo $paging; ?>

    <div style="clear: both;"> </div>

  </div>

                <?php endif;?>