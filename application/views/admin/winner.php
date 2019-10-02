<script>
$(document).ready(function(){
	$('#form1').submit(function(){
		if(trim($(this).find('#key').val())!=''){
			ajax('<?php echo base_url();?>admin/recipes/winner/?status=<?php echo $status?>&weekId=<?php echo $id; ?>','main_div','form1','spinner');
			return false;
		}
		return false;
	});
});
</script>
<div id="test_div" style="width:0px;height:0px;"></div>
<div class="grid_12">
  <?php if(isset($msg)) echo $msg; ?>
  <br/>
  <!-- Button -->
  <div class="float-right" style="margin-top:20px;"> 
  <span id="download_spinner" style="display:none;">Please Wait...</span>
 
  </div>
  <?php
  foreach($weeks as $wk){
	  ?>
      <a class="button" href="<?php echo base_url();?>admin/recipes/winner/<?php echo $wk['id']; ?>" <?php  if($wk['id']==$weekId){ echo 'style="font-weight:bold;color:#0063BE;"';}?>><span><?php echo $wk['title']; ?></span></a>
      <?php } ?>
   <br clear="all" />
   <div style="float:left">Total Users (<strong> <?php echo $totalUsers;?></strong> )</div>
  <div align="right">

<form id="form1" action="" name="form1" method="post">
<b>Search User (By user name or email): </b>
<input type="text" id="key" class="input-short required" name="key" value="<?php echo $search;?>"  />
<input type="submit" name="Submit" value="Search" class="submit-green" />
</form>
</div>

  <!-- Example table -->
  <div class="module">
    <h2><span>Users</span></h2>
    <div class="module-table-body">
      <form action="">
        <table width="100%" height="111" class="tablesorter" id="myTable">
          <thead>
            <tr>
              <th width="5%" style="width:2%;background-image:none !important" >#</th>
            <!--  <th width="48%"  style="background-image:none !important">Recipe Details</th>-->
              <th width="95%"  style="background-image:none !important">User Details</th>
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
                          <td><div style="float:left;width:70px;height:50px;margin:0 20px 0px 0px;text-align:center;border:solid 1px #000;">
              <?php   if($val['fb_id']>0){
						?>
        <img src="//graph.facebook.com/<?php echo $val['fb_id'];?>/picture/?width=60&height=50"   />
        <?php
						}else{
							echo thumbnail(BASEPATH_PATH."/images/user_pictures/".$val['picture'],58,50,base_url()."images/user_pictures/".$val['picture'],'header');	
						}?>
              </div>
           	 <div style="float:left;">
                 <strong>Name:</strong><?php echo $val['name']; ?>
                 <br clear="all" />
                 <strong>Email:</strong><?php echo $val['email']; ?>
                 <br clear="all" />
                 <strong>National Identification No:</strong><?php echo $val['nic_no']; ?>
                 <br clear="all" />
                 <strong>Phone Number:</strong><?php echo $val['phone_no']; ?>
 
                 <br clear="all" />
                 <strong>Address:</strong><?php echo $val['address']; ?>
                 <br clear="all" />
                 <strong>City:</strong><?php echo $val['city']; ?>
                 <br clear="all" />
                 <strong>Country:</strong><?php echo $val['country']; ?><br clear="all" />                 
                 <?php 
				 if($winnerTotal<3){
				 
				// if(isset($weekId) == "" && isset($userId) == ""){ 
				 
				 	if($val['winnerId']>0){ ?>
                    <span style="color:#060;">Announced winner</span>
                 
                 <?php }else{ ?>  <strong>
                 
                       <a href="<?php echo base_url();?>admin/recipes/winner/<?php echo $weekId; ?>/?user_id=<?php echo $val['id']; ?>&announce=1"> Announce winner</a></strong> <?php } } 
				 //} ?>
                 </div>
                 
               </td>
               
            </tr>
            <?php $i++; 
						}
					
					}else{
						
						?>
						 <tr>
             			 <td colspan="2">No data found</td>
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
</div>
