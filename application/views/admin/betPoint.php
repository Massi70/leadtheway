<script>
$(document).ready(function(){
	$('#form1').submit(function(){
	
		if(trim($(this).find('#key').val())!=''){
			
			ajax('<?php echo base_url();?>admin/bet/?t=1','main_div','form1','spinner');
			return false;
		}
		return false;
	});
});

function add_bet_point()
{
	$('#module1').toggle("slow");
	$('#module').toggle("slow");
}
$('a[id^="update_bet_point"]').live("click",function(){
var id = parseInt($(this).attr('id').replace('update_bet_point',''));
top.location="<?php echo base_url();?>index.php/admin/betPoint/updateBetPoint?id="+id;
});
</script>
  <br clear="all" />
    <br clear="all" />

<br><br>
<?php 
if($update_data==''){?>
<a href="#_" onClick="add_bet_point();">Add Bet Point</a>

<div class="module" id="module" style="display:none;">
    <h2><span>Add Bonus Points</span></h2>
    <div class="module-table-body">
      <form action="<?php echo base_url()?>admin/betPoint/add_bet_point"  method="post">
      <table>
      <tr><td>
     Starting coins
      </td>
      <td><input type="text" name="start_coin"></td>
      </tr>
     <tr><td>
    Ending coins
      </td>
      <td><input type="text" name="end_coin"></td>
      </tr>
       <tr><td>
    Win Xp Point
      </td>
      <td><input type="text" name="win_point"></td>
      </tr>
       <tr><td>
    Loss Xp Point
      </td>
      <td><input type="text" name="loss_point"></td>
      </tr>
      <tr><td>
      <input type="submit" name="submit" value="submit">
      </td></tr>
     </table>
      </form>
     
    <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 

  
  <div class="module" id="module1">
    <h2><span>Bets</span></h2>
    <div class="module-table-body">
      <form action="">
        <table width="100%" height="111" class="tablesorter" id="myTable">
          <thead>
            <tr>
              <th width="2%" style="width:2%;background-image:none !important" >#</th>
              <th width="10%"  style="background-image:none !important">From Coins</th>
              <th width="10%"  style="background-image:none !important">To Coins</th>
              <th width="10%"  style="background-image:none !important">Win Xp Point</th>
              <th width="10%"  style="background-image:none !important">Loss Xp Point</th>
              <th width="10%"  style="background-image:none !important">Action</th>
              
            </tr>
          </thead>
          <tbody>
            <?php 
					if(is_array($data) && count($data)>0){
						$i=1;
						foreach($data as $val){ 
					?>
            <tr>
              <td class="align-center"><?php echo $i; ?></td>
              <td class="align-center"><?php echo $val['from_coins'] ; ?> </td>
              <td class="align-center"><?php echo $val['to_coins'] ; ?> </td>
              <td class="align-center"><?php echo $val['win_xp_point'] ; ?> </td>
              <td class="align-center"><?php echo $val['loss_xp_point'] ; ?> </td>
              <td class="align-center"><a href="#_" id="update_bet_point<?php echo $val['win_poi_id'] ?>" >Update</a></td>
            </tr>
            
            <?php $i++; 
						}
					
					}else{
						
						?>
						 <tr>
              <td colspan="6">No data found</td>
              
            </tr>
						<?php
					}	
			?>
          </tbody>
        </table>
      </form>
      <div class="pagination" style="float:right;" > <?php echo $paging; ?>
    <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  </div>
  <!-- End .module -->
<?php }else{?>
	<div class="module" id="module" >
    <h2><span>Update Bet Points</span></h2>
    <div class="module-table-body">
      <form action="<?php echo base_url()?>admin/betPoint/update_bet_point"  method="post">
      <table>
      <tr><td>
     Starting coins
      </td>
      <td><input type="text" name="start_coin" value="<?php echo $update_data['from_coins'];?>"></td>
      </tr>
     <tr><td>
    Ending coins
      </td>
      <td><input type="text" name="end_coin" value="<?php echo $update_data['to_coins'];?>"></td>
      </tr>
       <tr><td>
    Win Xp Point
      </td>
      <td><input type="text" name="win_point" value="<?php echo $update_data['win_xp_point'];?>"></td>
      </tr>
       <tr><td>
    Loss Xp Point
      </td>
      <td><input type="text" name="loss_point" value="<?php echo $update_data['loss_xp_point'];?>"></td>
      </tr>
      <tr><td>
      <input type="submit" name="submit" value="submit">
      <input type="hidden" name="bet_id" value="<?php echo $update_data['win_poi_id'];?>">
      </td></tr>
     </table>
      </form>
     
    <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
	
	<?php }?>
