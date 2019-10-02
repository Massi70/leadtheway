<div class="bets_mobs">
                	<div class="head_mobs">
                    	<h1>Bet Detail</h1>
                        <div class="mobs_vote_rght">
                        	<div class="coins_content"><?php echo $detailbets['wager']; ?></div>
                      <?php $total_voter=$this->userModel->getTotalVoter($detailbets['bet_id']);?>
                            <div class="all_voters">All Voters: <?php echo $total_voter['total_voter'];?></div>
                        </div>
                   </div>
            <?php $creator_level=$this->userModel->get_level($detailbets['creater_id'],$detailbets['category_id']);
			 if($creator_level){$creator_rank=$creator_level['level'];}else{$creator_rank=0;}
	 			 $acceptor_level=$this->userModel->get_level($detailbets['acceptor_id'],$detailbets['category_id']);
		 if($acceptor_level){$acceptor_rank=$acceptor_level['level'];}else{$acceptor_rank=0;}
	 		 ?>
               	<div class="lft_content_mobs">
                   	 <h2>Bet between <?php echo $detailbets['creator_name']; ?> (<?php echo $creator_rank?>) & <?php echo $detailbets['acceptor_name']; ?> (<?php echo $acceptor_rank?>)</h2>	
                     <p><?php echo $detailbets['question'];?></p>
                    <!----left green box---->
                     <div class="green_box">
                       	<div class="green_box_left" >
                        <?php if($detailbets['answer_type']=='Image'){?>
                        <p style="text-align:center;" onclick="open_detail('<img src=<?php echo base_url();?>images/bet_images/<?php echo $detailbets['my_answer'];?> width=350 />');"><img src="<?php echo base_url();?>images/bet_images/<?php echo $detailbets['my_answer'];?>" width="28"/></p>
                        <?php }
						else if($detailbets['answer_type']=='Text'){?>
                        <p style="text-align:center;" onclick="open_detail('<?php echo $detailbets['my_answer']; ?>');"><?php echo $detailbets['my_answer']; ?></p>
						<?php }
						else{?>
							 <p style="text-align:center;" onclick="open_video('<?php  echo $detailbets['my_answer'];?>');">
                            <img src="<?php echo base_url();?>images/1359749761_video-icon.png" style="margin-top:-8px;"/>
                             </p>
							<?php }?>
                        </div>
                     	 <!------ vote---->
                        <div id="myAnswerVote<?php echo $detailbets['bet_id'];?>">
                     	<?php if($detailbets['vote_answer']=='my_answer'){?>
                        <img src="<?php echo base_url();?>images/vote_tck2.png" class="after_green_box_vote_down" >
                        <?php }else{
				if($detailbets['creater_id']!=$user_id && $detailbets['acceptor_id']!=$user_id){
				  ?>
                        <div class="green_box_vote" onclick="vote_detail(<?php echo $detailbets['bet_id'];?>,<?php echo $detailbets['category_id'];?>,'my_answer');">Vote</div>
                        <?php } else{?>
		 <div class="green_box_vote" >vote</div>
				  <?php } }?>
                        </div>
                          <!------End  vote---->
                     </div>
                     <span>To</span>
                 
                       <!----Right green box---->
                     <div class="green_box" style="float:right">
                     	<div class="green_box_left">
                        <?php if($detailbets['answer_type']=='Image'){?>
                        <p style="text-align:center;" onclick="open_detail('<img src=<?php echo base_url();?>images/bet_images/<?php echo $detailbets['your_answer'];?> width=350 />');"><a href="#_"><img src="<?php echo base_url();?>/images/bet_images/<?php echo $detailbets['your_answer'];?>" width="28"/></a></p>
                        <?php }
						else if($detailbets['answer_type']=='Text'){?>
                        <p style="text-align:center;" onclick="open_detail('<?php echo $detailbets['your_answer']; ?>');"><?php echo $detailbets['your_answer']; ?></p>
						<?php }
						else{?>
							<p style="text-align:center;" onclick="open_video('<?php  echo $detailbets['your_answer'];?>');">
                            <img src="<?php echo base_url();?>images/1359749761_video-icon.png" style="margin-top:-8px;"/>
                             </p>
							<?php }?>
                        </div>
                     	<!------ vote---->
                        <div  id="yourAnswerVote<?php echo $detailbets['bet_id'];?>">
                     	<?php if($detailbets['vote_answer']=='your_answer'){?>
                        <img src="<?php echo base_url();?>images/vote_tck2.png" class="after_green_box_vote_down" >
                        <?php }else{
				if($detailbets['creater_id']!=$user_id && $detailbets['acceptor_id']!=$user_id){
				  ?>
                        <div class="green_box_vote" onclick="vote_detail(<?php echo $detailbets['bet_id'];?>,<?php echo $detailbets['category_id'];?>,'your_answer');">Vote</div>
                        <?php }else{?>
		 <div class="green_box_vote" >vote</div>
				  <?php }} ?>
                        </div>
                          <!------End  vote---->
                     </div>
                     <!----end ---->
                    </div>
                    
                    <!--<div class="btn_box">
                    	<a href="#" class="submit">Submit</a>
                        <a href="#" class="cancel">cancel</a>
                    </div>-->
                </div>
          <div class="mob_vote_right">
              <h1>Top Betters</h1>
                <div class="tbl_rght">
                <table class="mob_vote" cellpadding="0" cellspacing="0">
                	<thead>
                    <tr>
                    	<th>Name</th>
                        <th>Bets</th>
                        <th>Wins</th>
                       
                        </tr>
                        <tbody>
                        <?php 
						if($gettopbets){
						foreach($gettopbets as $topbets){?>
                        	<tr>
                            	<td><?php echo $topbets['user_name'];?></td>
                                <td><?php echo $topbets['total_bet'];?></td>
                                <td><?php echo $topbets['win_bet'];?></td>
                            </tr>
                            <?php } }else{?>
								<tr><td colspan="3">No Top Better Available</td></tr>
								<?php }?>
                        </tbody>
                    </thead>
                </table>
                </div>
            </div>

