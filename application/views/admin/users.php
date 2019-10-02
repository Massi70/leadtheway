<script>
$(document).ready(function(){
	$('#form1').submit(function(){
	
		if(trim($(this).find('#key').val())!=''){
			
			ajax('<?php echo base_url();?>admin/users/?t=1','main_div','form1','spinner');
			return false;
		}
		return false;
	});
});
</script>
<div id="test_div" style="width:0px;height:0px;"></div>
<div class="grid_12">
  <?php if(isset($msg)) echo $msg; ?>
  
  <!-- Button -->
  <div class="float-right" style="margin-top:20px;"> 
  <span id="download_spinner" style="display:none;">Please Wait...</span>
 <!-- <a href="javascript:;" onclick="simpleAjaxPaging('<?php echo base_url();?>admin/users/downloadCsv/','test_div','','download_spinner',0);" class="button"> <span>Download CSV</span> </a>-->
  </div>
  <br clear="all" />
    <br clear="all" />
    <div style="float:left">Total Users (<strong> <?php echo $totalUsers?></strong> )</div>
  <div align="right">
<form id="form1" action="" name="form1" method="post">
<b>Search User (By email address or user name): </b>
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
              <th width="2%" style="width:2%;background-image:none !important" >#</th>
              <th width="19%"  style="background-image:none !important">Profile Picture</th>
              <th width="79%"  style="background-image:none !important">User Details</th>
              
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
              <td class="align-center"><!--<img src="//graph.facebook.com/<?php echo $val['fb_id']?>/picture/?width=100&height=100" />-->
              <div style="padding:45px">
            <?php   //if($val['user__id']>0){
						?>
        <img src="//graph.facebook.com/<?php echo $val['user_id'];?>/picture?type=square"   />
        <?php
						//}else{
						//	echo thumbnail(BASEPATH_PATH."/images/user_pictures/".$val['picture'],68,60,base_url()."images/user_pictures/".$val['picture'],'header');	
						//}
              ?>
              </div>
              </td>
              <td>
			  <strong>Name:</strong><?php echo $val['user_name'] ; ?>
              <br clear="all" />
              <strong>Email:</strong><?php echo $val['user_email']; ?>
                <br clear="all" />
                 <strong>Gender:</strong><?php echo $val['user_gender']; ?>
                 <br clear="all" />
                 <strong>Birthday:</strong><?php echo $val['user_birthdaydate']; ?>
                <br clear="all" />
				<strong>Joined Date : </strong><?php echo date("F jS, Y",strtotime($val['joined_date']));?> 
               </td>
            
              
              
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
</div>
