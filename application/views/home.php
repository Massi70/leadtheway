 <img src="<?php echo base_url();?>images/coins-icon.png" id="open_credit_popup" style="margin-left:48px;margin-top:64px; cursor:pointer;"/> <span style="text-decoration:none;color:#FF3;" id="total_coins"><?php echo $user_data['userData']['user_coins'];?></span>
<div class="mob_bets" id="mob_bet">
  <div class="nav_box"> 
    
    <!---- navigation--->
    
    <div class="item_left_tabs">
      <?php  foreach($category as $cat){
					if($cat['category_id']==1){
						$class='class="item_tabs active"';
						}else{
							$class='class="item_tabs"';
							}?>
      <a href="#" <?php echo $class;?> id="change_cate<?php echo $cat['category_id'];?>"><?php echo $cat['category_name'];?></a>
      <?php }?>
      
      <!-- <a href="#" class="item_tabs active">Dating</a>
               <a href="#" class="item_tabs">Beauty</a>
                <a href="#" class="item_tabs">Sports</a>
				<a href="#" class="item_tabs">Cars</a>
				<a href="#" class="item_tabs">Fashion</a>
				<a href="#" class="item_tabs">Parenting</a>
				<a href="#" class="item_tabs">Marriage</a>
				<a href="#" class="item_tabs">Corporate</a>--> 
      
    </div>
    
    <!---- End navigation---> 
    
  </div>
  <div id="allBetDiv">
    <div class="add_item_content">
      <h1>Top Bets of Dating</h1>
      <?php
				if($getAllBets){
				 foreach($getAllBets as $getallbets){?>
      <div class="mob_contents">
      <?php $creator_level=$this->userModel->get_level($getallbets['creater_id'],$getallbets['category_id']);
	  if($creator_level){$creator_rank=$creator_level['level'];}else{$creator_rank=0;}
	  $acceptor_level=$this->userModel->get_level($getallbets['acceptor_id'],$getallbets['category_id']);
	  if($acceptor_level){$acceptor_rank=$acceptor_level['level'];}else{$acceptor_rank=0;}
	  ?>
        <div class="lft_content_mobs">
          <h2>Bet between <?php echo $getallbets['creator_name']; ?> (<?php echo $creator_rank?>) & <?php echo $getallbets['acceptor_name']; ?> (<?php echo $acceptor_rank?>)</h2>
          <!--<p id="detail_bet<?php //echo $getallbets['bet_id']?>" style="cursor:pointer;"><?php //echo $getallbets['question'];?></p>-->
         <p onclick="detail_bet(<?php echo $getallbets['bet_id']?>,<?php echo $getallbets['category_id']?>);" style="cursor:pointer;"><?php echo $getallbets['question'];?></p>
          <!----left green box---->
          
          <div class="green_box">
            <div class="green_box_left" >
              <?php if($getallbets['answer_type']=='Image'){?>
              <p style="text-align:center;cursor: pointer;" onclick="open_detail('<img src=<?php echo base_url();?>images/bet_images/<?php echo $getallbets['my_answer'];?> width=350 />');"><img src="<?php echo base_url();?>images/bet_images/<?php echo $getallbets['my_answer'];?>" class="imagebet"/></p>
              <?php }
						else if($getallbets['answer_type']=='Text'){?>
              <p style="text-align:center;cursor: pointer;" onclick="open_detail('<?php echo $getallbets['my_answer']; ?>');"><?php echo substr($getallbets['my_answer'],0,35); ?></p>
              <?php }
						else{?>
              <p style="text-align:center;cursor: pointer;" onclick="open_video('<?php  echo $getallbets['my_answer'];?>');"> <img src="<?php echo base_url();?>images/1359749761_video-icon.png" style="margin-top:-16px;"/> </p>
              <?php }?>
            </div>
            
            <!------ vote---->
            <div id="myAnswerVote<?php echo $getallbets['bet_id'];?>">
              <?php if($getallbets['vote_answer']=='my_answer'){?>
              <img src="<?php echo base_url();?>images/vote_done.png" class="after_green_box_vote" >
              <?php }else{
				  if($getallbets['creater_id']!=$user_id && $getallbets['acceptor_id']!=$user_id){
				  ?>
              <div class="green_box_vote" onclick="vote(<?php echo $getallbets['bet_id'];?>,<?php echo $getallbets['category_id'];?>,'my_answer');">Vote</div>
              <?php } else{?>
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
              <p style="text-align:center;cursor: pointer;" onclick="open_detail('<img src=<?php echo base_url();?>images/bet_images/<?php echo $getallbets['your_answer'];?> width=350 />');"><img src="<?php echo base_url();?>/images/bet_images/<?php echo $getallbets['your_answer'];?>" class="imagebet"/></p>
              <?php }
						else if($getallbets['answer_type']=='Text'){?>
              <p style="text-align:center;cursor: pointer;" onclick="open_detail('<?php echo $getallbets['your_answer']; ?>');"><?php echo substr($getallbets['your_answer'],0,35); ?></p>
              <?php }
						else{?>
              <p style="text-align:center;cursor: pointer;" onclick="open_video('<?php echo $getallbets['your_answer']; ?>');"> <img src="<?php echo base_url();?>images/1359749761_video-icon.png" style="margin-top:-16px;"/> </p>
              <?php }?>
            </div>
            
            <!------ vote---->
            
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
          <div class="vote_rght"> <img src="<?php echo base_url();?>images/icon.PNG" />
            <?php $total_voter=$this->userModel->getTotalVoter($getallbets['bet_id']);?>
            <p>All Voters</p>
            <span><?php echo $total_voter['total_voter'];?></span> </div>
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
    
    <!----end ----> 
    
  </div>
  <div class="pending_bets" >
    <div class="nav_pendding"> 
    <a href="#" class="pentng_btn btnactive" id="pending_bet<?php echo $category_id;?>">Pending Bets</a>
     <a href="#" class="pentng_btn" id="top_better<?php echo $category_id;?>" style="margin-left:10px;">Top Betters Of Dating</a>
      <div class="search_box">
        <div class="search_inner">
          <input type="text" class="search" id="serach_pending_bet"/>
          <a href="#" class="search_icon"><img src="<?php echo base_url();?>images/search_icon.png" onclick="search_pending_bet(<?php echo $category_id;?>);"/></a> </div>
      </div>
    </div>
    <div class="tablng_content" id="search_data" >
      <table class="tablng_c">
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
            <th>Wager
              <div class="drop"><img src="<?php echo base_url();?>images/drop.png" /></div></th>
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
              <a href="#_" class="acpt_btn" onclick="delete_mybet(<?php echo $bet['bet_id'];?>,<?php echo $category_id;?>,'home');">Yes</a> <a href="#_" class="acpt_btn" onclick="hide_myBetPopup(<?php echo $bet['bet_id'];?>);">No</a> </div>
            
            <!-----end delete popup----->
            
            <?php }else{			?>
            <td><a href="#_" onclick="accept_repropse('<?php echo $bet['bet_id'];?>');">Accept / Re-propse</a></td>
            
            <!----Accept or r-epropose popup----->
            
            <div class="popup_mobs" style="display:none;" id="popup_mobs<?php echo $bet['bet_id'];?>">
              <div class="cross"><img src="<?php echo base_url();?>images/cros.png" onclick="close_accept_repropse(<?php echo $bet['bet_id'];?>);"/></div>
              <h1>Accept or Re-propose Bet</h1>
              <a href="#_" class="acpt_btn" onclick="accept_bet(<?php echo $bet['bet_id'];?>,1);">Accept</a> <a href="#_" class="acpt_btn" onclick="repropse_bet(<?php echo $bet['bet_id'];?>,<?php echo $bet['category_id'];?>);">Re-propose</a> </div>
            
            <!---- End popup----->
            
            <?php } ?>
            <td><?php echo $bet['wager'];?></td>
          </tr>
          <?php }
							}else{?>
          <tr >
            <td colspan="5" style="border-top: 1px solid #7D7D7D; height: 50px;
  text-align: center; color:#F00;font-family:Arial, Helvetica, sans-serif;"> No Bet Available</td>
          </tr>
          <?php }
							
							?>
        </tbody>
      </table>
    </div>

  </div>
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
				$('#pending_bet<?php echo $category_id;?>').addClass('btnactive');
				$('#top_better<?php echo $category_id;?>').removeClass(' btnactive');
			},
			complete:function(){
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