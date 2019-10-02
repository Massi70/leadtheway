<form action="<?php echo $this->config->item('base_url');?>admin/content/update" method="post" enctype="multipart/form-data">
<div class="container_12">
  <div class="module">
    <h2><span>Edit Content</span></h2>
    <div class="module-table-body">    
      <table id="myTable" class="tablesorter"  >
        <tbody>
          <tr >
            <td style="width: 50%;"><strong>Page</strong></td>
            <td><?php echo $data['content_type'];?></td>
          </tr>
          <tr>
            <td><strong>Title</strong></td>
            <td><input  type="text" class="input-medium" name="title" id="title" value="<?php echo $data['title'];?>" style="width: 25%;" /></td>
          </tr>
          <tr>
            <td ><strong>content</strong></td>
            <td ><textarea name="desciption" class="input-medium" id="wysiwyg" crows="5" cols="60"><?php echo $data['description'];?></textarea></td>
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
<input type="submit" class="submit-green" name="button" id="button" value="Save Content" />
</div>
</form>