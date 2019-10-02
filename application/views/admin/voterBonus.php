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
$('a[id^="update_voter_point"]').live("click",function(){
var id = parseInt($(this).attr('id').replace('update_voter_point',''));
top.location="<?php echo base_url();?>index.php/admin/voterBonus/updateVoterPoint?id="+id;
});
</script>
  <br clear="all" />
    <br clear="all" />

<br><br>
<?php 
if($update_data==''){?>

  <div class="module" id="module1">
    <h2><span>Voter Bonus Point</span></h2>
    <div class="module-table-body">
      <form action="">
        <table width="100%" height="111" class="tablesorter" id="myTable">
          <thead>
            <tr>
              <th width="2%" style="width:2%;background-image:none !important" >#</th>
              <th width="10%"  style="background-image:none !important">Bonus Point</th>
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
              <td class="align-center"><?php echo $val['bonus_point'] ; ?> </td>
              <td class="align-center"><a href="#_" id="update_voter_point<?php echo $val['voter_b_point_id'] ?>" >Update</a></td>
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
      <form action="<?php echo base_url()?>admin/voterBonus/update_voter_point"  method="post">
      <table>
      <tr><td>
     Starting coins
      </td>
      <td><input type="text" name="bonus_point" value="<?php echo $update_data['bonus_point'];?>"></td>
      </tr>
     

      <tr><td>
      <input type="submit" name="submit" value="submit">
      <input type="hidden" name="id" value="<?php echo $update_data['voter_b_point_id'];?>">
      </td></tr>
     </table>
      </form>
     
    <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
	
	<?php }?>
