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
    <div style="float:left">Total Bets (<strong> <?php echo $totalBet?></strong> )</div>
  <div align="right">
<form id="form1" action="" name="form1" method="post">
<b>Search User (By Title or Question): </b>
<input type="text" id="key" class="input-short required" name="key" value="<?php echo $search;?>"  />
<input type="submit" name="Submit" value="Search" class="submit-green" />
</form>
</div>
  <!-- Example table -->
  <div class="module">
    <h2><span>Bets</span></h2>
    <div class="module-table-body">
      <form action="">
        <table width="100%" height="111" class="tablesorter" id="myTable">
          <thead>
            <tr>
              <th width="2%" style="width:2%;background-image:none !important" >#</th>
              <th width="10%"  style="background-image:none !important">Title</th>
              <th width="10%"  style="background-image:none !important">Question</th>
              <th width="10%"  style="background-image:none !important">Creater name</th>
              <th width="10%"  style="background-image:none !important">Acceptor Name</th>
              <th width="10%"  style="background-image:none !important">Category</th>
              <th width="10%"  style="background-image:none !important">Wager</th>
              
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
              <td class="align-center"><?php echo $val['title'] ; ?> </td>
              <td class="align-center"><?php echo $val['question'] ; ?> </td>
              <td class="align-center"><?php echo $val['creater_name'] ; ?> </td>
              <td class="align-center"><?php echo $val['acceptor_name'] ; ?> </td>
              <td class="align-center"><?php echo $val['category_name'] ; ?> </td>
              <td class="align-center"><?php echo $val['wager'] ; ?> </td>
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
