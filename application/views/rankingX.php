<style>
.rank{
}
</style>
<div class="nav_box">
            	<div class="item_left_tabs rank">
                 <?php  foreach($category as $cat){
					if($cat['category_id']==$category_id){
						$class='class="item_tabs active"';
						}else{
							$class='class="item_tabs"';
							}
						if($cat['category_id']!=9 || $cat['category_name']!='All'){
							
							?>
      <a href="#" <?php echo $class;?>  id="rank_change_cate<?php echo $cat['category_id'];?>"><?php echo $cat['category_name'];?></a>
      <?php } }?>
            </div>
            	
        </div>
        <div id="rankDiv">
        	<div class="ranking_content">
            	<table class="ranking" cellpadding="0" cellspacing="0">
                	
                    
                    <thead>
                    	<tr>
                        	<th>Name</th>
                            <th>Rank Number</th>
                            <th>Total Bets</th>
                            <th>Wins</th>
                            <th>Coins</th>
                            <th>Xp Points</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php  if($users_Count>0){
						
							$i=0;
							$j=0;
							$trClass = 'lgray';
							$rankVar=$offSet;
							$rankVarAll=$offSet;
							foreach($my_ranks as $rank){	
							    $rankVar++;
								if($rank['user_id']==$user_id){
							
					?>
                    	<tr class="dblue">
                        	<td><?php 
							$userName = $rank['first_name']." ".$rank['last_name'];
							
							$nLen= strlen($userName); if($nLen>14){ echo $rank['first_name'];}else{ echo $userName;} ?></td>
                            <td><?php echo $rankVar; ?></td>
                            <td><?php echo isset($rank['total_bet']) && $rank['total_bet']!='' ? $rank['total_bet'] :'0'; ?></td>
                            <td><?php echo isset($rank['bet_win']) && $rank['bet_win']!='' ? $rank['bet_win'] : '0'; ?></td>
                            <td><?php echo isset($rank['coins']) && $rank['coins']!='' ? $rank['coins'] : '0' ; ?> coins</td>
                            <td><?php echo isset($rank['xp_point']) && $rank['xp_point']!='' ? $rank['xp_point'] : '0'; ?></td>
                        </tr>
                      
                      <?php  }
							$i++;
							}
							
							
							
							foreach($users_ranks as $rank){	
									 $j++;
									$rankVarAll++;
									
									?><?php if($rank['user_id']!=$user_id){
										$trClass = $trClass == 'lgray' ? 'lblue' : 'lgray';
										
										?>
                    	<tr class="<?php echo $trClass;?>">
                        	
                            
                            <td><?php $nLen= strlen($rank['user_name']); if($nLen>14){ echo $rank['first_name'];}else{
								echo $rank['user_name'];
							} ?></td>
                            <td><?php echo $rankVarAll; ?></td>
                            <td><?php echo isset($rank['total_bet']) && $rank['total_bet']!='' ? $rank['total_bet'] :'0'; ?></td>
                            <td><?php echo isset($rank['bet_win']) && $rank['bet_win']!='' ? $rank['bet_win'] : '0'; ?></td>
                            <td><?php echo isset($rank['coins']) && $rank['coins']!='' ? $rank['coins'] : '0' ; ?> coins</td>
                            <td><?php echo isset($rank['xp_point']) && $rank['xp_point']!='' ? $rank['xp_point'] : '0'; ?></td>
                        
                        </tr>
                      <?php }?>
                      <?php
							}
					   }else{?>
                        <tr class="dblue">
                        	<td colspan="6"></td>
                        </tr>
                        <?php }?>
                        
                    </tbody>
                </table>
            </div>
            
            <?php  if($users_Count>0){?>  
             <div class="pagination" style="float:right;" > <?php echo $paging; ?>
    <div style="clear: both;"> </div>
  </div>
  <?php }?>
  </div>
  
  <script>
  </script>
 