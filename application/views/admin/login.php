<script>
  $(document).ready(function(){
	$("#login").validate();
  });
  </script>
  <div class="error" style=" color: red;
    font-weight: bold;
    margin: 0 auto;
    width: 400px;">
  <?php 
  if(isset($msg)) echo $msg;?></div>
<div class="grid_6" style="margin:0 300px;">
	<div class="module">
		<h2><span>Login</span></h2>
		<div class="module-body">
			<form name="login" id="login" method="post" action="<?php echo base_url().'admin/index/login/';?>"  >
			 <input type="hidden" name="loginDo" id="loginDo"  />

				<p>User name
				  <input type="text" class="input-medium required" name="user_name" id="user_name"  />
				</p>
				<p>Password &nbsp; 
				  <input type="password" class="input-medium required" name="password" id="password" />
				</p>
                <input class="submit-green" type="submit" value="Login" />
			</form>
		</div>
		<!-- End .module-body -->
	</div>
	<!-- End .module -->

</div>