<form action="<?php echo $this->config->item('base_url');?>admin/add/update" method="post" enctype="multipart/form-data">
<div class="container_12">
  <div class="module">
    <h2><span>Edit Content</span></h2>
    <div class="module-table-body">    
      <table id="myTable" class="tablesorter"  >
        <tbody>
          <tr >
            <td style="width: 20%;"><strong>Src</strong></td>            
            <td>
            <?php $type = $data['type'];
			if($type=="other"){ $other = 'selected="selected"';}else{ $google = 'selected="selected"';}
			?>
            <select name="type" id="type" onchange="showtr(this.value);" class="input-short">
            <option value="other" <?php echo $other; ?>>Other</option>
            <option value="google" <?php echo $google; ?>>Google</option>
            </select>
            </td>
          </tr>
          <tr >
            <td><strong>Position</strong></td>
            <td>
            <?php $position = $data['position'];
			if($position == "RightTop"){ $right = 'selected="selected"';}else{ $bottom = 'selected="selected"';}
			?>
			<select name="position" class="input-short">
            <option value="RightTop" <?php echo $right; ?>>RightTop</option>
            <option value="bottom" <?php echo $bottom; ?>>Bottom</option>
            </select>
			</td>
          </tr>
          <tr>
            <td><strong>Title</strong></td>
            <td><input  type="text" class="input-medium" name="title" id="title" value="<?php echo $data['title'];?>" style="width: 25%;" /></td>
          </tr>
          <tr id="content_other" style="display:none">
            <td ><strong>File</strong></td>
            <td >
            <img src="<?php echo $this->config->item('base_url').'images/'.$data['thumbnail'];?>" width="150px" height="150px" />
            <br />
            <input name="image" type="file" /></td>
          </tr>
          <tr id="content_google" style="display:none">
            <td ><strong>Code</strong></td>
            <td ><textarea name="description" class="input-medium" crows="5" cols="60" id="description"><?php echo $data['thumbnail'];?></textarea></td>
          </tr>
        </tbody>
      </table>
      <div style="clear: both"></div>
    </div>
    
    <div style="clear: both"></div>
  </div>
  <!-- End .module-table-body -->
</div>
</div>
<div style="clear: both"></div>
<div align="center">
<input type="hidden" id="id" name="id" value="<?php echo $data['id'];?>">
<input type="submit" class="submit-green" name="button" id="button" value="Save Add" />
</div>
</form>
<script type="text/javascript">
function showtr(thisvalue){
	if(thisvalue == "google"){
		$('#content_google').show();
		$('#content_other').hide();
	}
	if(thisvalue == "other"){
		$('#content_other').show();
		$('#content_google').hide();
	}
}
$(document).ready(function (){
	if($('#type').val() == "google"){
	  $('#content_google').show();
	  $('#content_other').hide();
	}
	else{
	$('#content_other').show();
	$('#content_google').hide();
	}
	
	});
</script>