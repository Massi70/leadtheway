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

function add_bonus()
{
	$('#module1').toggle("slow");
	$('#module').toggle("slow");
}
$('a[id^="update_bet_bonus"]').live("click",function(){
var id = parseInt($(this).attr('id').replace('update_bet_bonus',''));
top.location="<?php echo base_url();?>index.php/admin/betBonus/updateBetBonus?id="+id;
});
</script>
  <br clear="all" />
    <br clear="all" />

<br><br>
<?php 
if($update_data==''){?>
<a href="#_" onClick="add_bonus();">Add Bonus Point</a>

<div class="module" id="module" style="display:none;">
    <h2><span>Add Bonus Points</span></h2>
    <div class="module-table-body">
      <form action="<?php echo base_url()?>admin/betBonus/add_bet_bonus"  method="post">
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
     Bet Quantity
      </td>
      <td><input type="text" name="bet_quan"></td>
      </tr>
       <tr><td>
     Xp Point
      </td>
      <td><input type="text" name="xp_point"></td>
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
              <th width="10%"  style="background-image:none !important">Bet Quantity</th>
              <th width="10%"  style="background-image:none !important">Xp Point</th>
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
              <td class="align-center"><?php echo $val['bet_quentity'] ; ?> </td>
              <td class="align-center"><?php echo $val['xp_point'] ; ?> </td>
              <td class="align-center"><a href="#_" id="update_bet_bonus<?php echo $val['bonus_ex_id'] ?>" >Update</a></td>
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
    <h2><span>Update Bonus Points</span></h2>
    <div class="module-table-body">
      <form action="<?php echo base_url()?>admin/betBonus/update_bet_bonus"  method="post">
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
     Bet Quantity
      </td>
      <td><input type="text" name="bet_quan" value="<?php echo $update_data['bet_quentity'];?>"></td>
      </tr>
       <tr><td>
     Xp Point
      </td>
      <td><input type="text" name="xp_point" value="<?php echo $update_data['xp_point'];?>"></td>
      </tr>
      <tr><td>
      <input type="submit" name="submit" value="submit">
      <input type="hidden" name="bonus_id" value="<?php echo $update_data['bonus_ex_id'];?>">
      </td></tr>
     </table>
      </form>
     
    <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
	
	<?php }?>
