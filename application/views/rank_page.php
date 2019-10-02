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
					$j=0;
					$trClass = 'lgray';
					foreach($users_ranks as $rank){	
						$j++;
						$trClass = $trClass == 'lgray' ? 'lblue' : 'lgray';
						if($j==1 && $rank['user_id']==$user_id){ ?>
        					<tr class="dblue">
          				<? } else{ ?>
        				<tr class="<?php echo $trClass;?>">
          				<? }?>
          <td><?php	$user_name =$rank['first_name']." ".$rank['last_name'];
					 $nLen= strlen($user_name); if($nLen>14): echo $rank['first_name']; else: echo $user_name;
						endif; ?></td>
          <td><?php echo $rank['level']; ?></td>
          <td><?php echo isset($rank['total_bet']) && $rank['total_bet']!='' ? $rank['total_bet'] :'0'; ?></td>
          <td><?php echo isset($rank['bet_win']) && $rank['bet_win']!='' ? $rank['bet_win'] : '0'; ?></td>
          <td><?php echo isset($rank['coins']) && $rank['coins']!='' ? $rank['coins'] : '0' ; ?> coins</td>
          <td><?php echo isset($rank['xp_point']) && $rank['xp_point']!='' ? $rank['xp_point'] : '0'; ?></td>
        </tr>
        <?php }
	   }else{?>
        <tr class="lgray">
          <td colspan="6"> No Data Found</td>
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
