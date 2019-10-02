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
<?php print_r($message);?>
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
    <div style="float:left">Total Bets (<strong> <?php echo $totalAdds?></strong> )</div>
 <!-- <div align="right">
<form id="form1" action="" name="form1" method="post">
<b>Search User (By Title or Question): </b>
<input type="text" id="key" class="input-short required" name="key" value="<?php echo $search;?>"  />
<input type="submit" name="Submit" value="Search" class="submit-green" />
</form>
</div>-->
<br><br>
<a href="#_" onClick="image_upload();">Image Upload</a>
<?php if($message=='error'){?>
<div style="text-align:center; color: red;" id="error_msg">The image you are attempting to upload exceedes the maximum height or width.</div>
<?php } ?>
<div class="module" id="module" style="display:none;">
    <h2><span>Image Upload</span></h2>
    <div class="module-table-body">
      <form action="<?php echo base_url()?>admin/addBanner/upload_banner" enctype="multipart/form-data" method="post">
      <table>
      <tr><td>
      <input type="file" name="file" >
      </td></tr>
     <tr><td>The image you are upload the maximum height=680 or width=135.</td></tr>
      <tr><td>
      <input type="submit" name="submit" value="Submit">
      </td></tr>
     </table>
      </form>
     
    <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  </div>
  <!-- Example table -->
  <div class="module" id="module1">
    <h2><span>Bets</span></h2>
    <div class="module-table-body">
      <form action="">
        <table width="100%" height="111" class="tablesorter" id="myTable">
          <thead>
            <tr>
              <th width="2%" style="width:2%;background-image:none !important" >#</th>
              <th width="50%"  style="background-image:none !important">Image</th>
              <th width="30%"  style="background-image:none !important">Status</th>
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
              <td class="align-center"><img src="<?php echo base_url();?>images/adds/<?php echo $val['add_image'];?>" style="width:150px;"/> </td>
              <td class="align-center">
			  <div style="cursor:pointer;color:#0063BE;" id="change_status<?php echo $val['adds_id'] ; ?>" onClick="change_status(<?php echo $val['adds_id'] ; ?>);" ><?php echo $val['status'] ; ?></div>
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
<script>
function image_upload()
{
	$('#module1').toggle("slow");
	$('#module').toggle("slow");
	$('#error_msg').hide();
}
function change_status(id)
{
	$.ajax({
		url:"<?php echo base_url();?>admin/addBanner/change_status/"+id,
		type:"POST",
		beforeSend:function(){},
		complete:function(){},
		success:function(result){
			$('#change_status'+id).html(result);
			}
		})
}
</script>
