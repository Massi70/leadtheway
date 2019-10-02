<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Admin::&nbsp;<?php echo APP_NAME; ?></title>
        <!-- CSS Reset -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/admin/reset.css" />
        <!-- Fluid 960 Grid System - CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/admin/grid.css" />
        <!-- IE Hacks for the Fluid 960 Grid System -->
        <!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css"  /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/ie.css"  /><![endif]-->
        <!-- Main stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/admin/styles.css"  />
        <!-- WYSIWYG editor stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.wysiwyg.css?d=<?php echo time();?>"  />
        <!-- Table sorter stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/admin/tablesorter.css?d=<?php echo time();?>"  />
        <!-- Thickbox stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/admin/thickbox.css?d=<?php echo time();?>"  />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/admin/theme-blue.css"  />
        <!--<link rel="stylesheet" type="text/css" href="css/theme-red.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="css/theme-yellow.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="css/theme-green.css" media="screen" />-->
        <!--<link rel="stylesheet" type="text/css" href="css/theme-graphite.css" media="screen" />-->
        <!-- JQuery engine script-->
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.3.2.min.js" ></script>
        <!-- JQuery WYSIWYG plugin script -->
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.wysiwyg.js?d=<?php echo time();?>" ></script>
        <!-- JQuery tablesorter plugin script-->
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.tablesorter.min.js" ></script>
        <!-- JQuery pager plugin script for tablesorter tables -->
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.tablesorter.pager.js" ></script>
        <!-- JQuery password strength plugin script -->
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.pstrength-min.1.2.js" ></script>
        <!-- JQuery thickbox plugin script -->
        <script type="text/javascript" src="<?php echo base_url();?>js/thickbox.js" ></script>
        <!-- Initiate WYIWYG text area -->
    	<script type="text/javascript" src="<?php echo base_url();?>js/core.js?d=<?php echo time();?>" ></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/form_validate.js?d=<?php echo time();?>" ></script>
        <script type="text/javascript">
			$(function()
			{
			$('#wysiwyg').wysiwyg(
			{
			controls : {
			separator01 : { visible : true },
			separator03 : { visible : true },
			separator04 : { visible : true },
			separator00 : { visible : true },
			separator07 : { visible : false },
			separator02 : { visible : false },
			separator08 : { visible : false },
			insertOrderedList : { visible : true },
			insertUnorderedList : { visible : true },
			undo: { visible : true },
			redo: { visible : true },
			justifyLeft: { visible : true },
			justifyCenter: { visible : true },
			justifyRight: { visible : true },
			justifyFull: { visible : true },
			subscript: { visible : true },
			superscript: { visible : true },
			underline: { visible : true },
            increaseFontSize : { visible : false },
            decreaseFontSize : { visible : false }
			}
			} );
			});
        </script>
        <!-- Initiate tablesorter script -->
        
        <style>
        .active{
			color:#000;
			font-weight:bold;
			font-size:14px;
			text-decoration:underline;
		}
		.paginations-blue{
			float:left;
			color: #0072BC;
			font-weight: normal;	
			margin-right:10px;
		}
	 	.paginations-blue a:link{
			background-color: #F5F5F5;
			border: 1px solid #EBEBEB;
			margin-left: 2px;
			padding: 2px 7px;
			text-decoration: none;
			width: 22px;
			cursor:pointer
			
		}
		.paginations-blue a:visited{
			background-color: #F5F5F5;
			border: 1px solid #EBEBEB;	
			margin-left: 2px;
			padding: 2px 7px;
			text-decoration: none;
			width: 22px;
			cursor:pointer
		}
		.paginations-blue a:hover{
			background-color: #DDEEFF;
			border: 1px solid #BBDDFF;
			margin-left: 2px;
			padding: 2px 7px;
			text-decoration: none;
			width: 22px;
			cursor:pointer
		}
		.paginations-blue .active{
			background-color: #DDEEFF !important;
			border: 1px solid #BBDDFF !important;
			margin-left: 2px;
			padding: 2px 7px;
			text-decoration: none;
			width: 22px;
			cursor:pointer
		}
        </style>
        </head>
        <body style="width:100% !important;">
        <div id="spinner" style="background: none repeat scroll 0 0 #3EBF6F;border: 2px solid #fff;color: #FFFFFF;display: none;font-size: 12px;font-weight: bold;padding: 15px 3px;position: fixed;text-align: center;width: 230px;z-index:1200" >
Loading....
</div>
        
<!-- Header -->
<div id="header"> 
       <!-- Header. Status part --> 
          <div id="header-status">
		<div class="container_12">
			<div class="grid_8"> &nbsp; </div>
			<div class="grid_4">
            <?php
            	if($this->session->userdata(APP_NAME.'_admin')!=false){
			?>
             <a  href="<?php echo base_url();?>admin/index/logout/" id="logout"> Logout </a> 
             <?php } ?>
             </div>
		</div>
		<div style="clear:both;"></div>
	</div>
          <!-- End #header-status --> 
          <!-- Header. Main part -->
          <div id="header-main">
               
   			 <div class="container_12">
              <div class="grid_12">
        <div id="logo">
        <?php
            	if($this->session->userdata(APP_NAME.'_admin')!=false){
			?>
                  <ul id="nav">
            <li <?php 
			if($pageName == 'index') echo 'id="current"';?> ><a href="<?php echo base_url();?>index.php/admin/">Dashboard</a></li>
            <li <?php if($pageName == 'users') echo 'id="current"';?>><a href="<?php echo base_url();?>index.php/admin/users/">User</a></li>
             <li <?php if($pageName == 'bets') echo 'id="current"';?>><a href="<?php echo base_url();?>index.php/admin/bet/">Bet</a></li>
              <li <?php if($pageName == 'Add') echo 'id="current"';?>><a href="<?php echo base_url();?>index.php/admin/addBanner/">Advertisment Banner</a></li>
              <li <?php if($pageName == 'betBonus') echo 'id="current"';?>><a href="<?php echo base_url();?>index.php/admin/betBonus/">Bet Bonus Xp Points</a></li>
              <li <?php if($pageName == 'betPoint') echo 'id="current"';?>><a href="<?php echo base_url();?>index.php/admin/betPoint/">Bet Xp Points</a></li>
               <li <?php if($pageName == 'voterBonus') echo 'id="current"';?>><a href="<?php echo base_url();?>index.php/admin/voterBonus/">Voter Points</a></li>
            
           <!-- <li <?php //if($pageName == 'content') echo 'id="current"';?>><a href="<?php // echo base_url();?>admin/content/">Content Management</a></li>-->
              <?php /*?><li <?php if($pageName == 'recipes') echo 'id="current"';?>><a href="<?php echo base_url();?>admin/recipes/">Recipes Management</a></li>
              <li <?php if($pageName == 'winner') echo 'id="current"';?>><a href="<?php echo base_url();?>admin/recipes/winner">Announce winner</a></li>
              <li <?php if($pageName == 'cWinner') echo 'id="current"';?>><a href="<?php echo base_url();?>admin/recipes/conformWinner">Confirm Winner</a></li><?php */?>
              
          <?php /*?>  <li <?php if($pageName == 'video') echo 'id="current"';?>><a href="<?php echo base_url();?>admin/video/">Video Management</a></li>
            <li <?php if($pageName == 'Add') echo 'id="current"';?>><a href="<?php echo base_url();?>admin/add/">Add Management</a></li><?php */?>
      
            	
           
          </ul>
          <?php
				}
			?>
                </div>
        <!-- End. #Logo --> 
      </div>
              <!-- End. .grid_12-->
              <div style="clear: both;"></div>
            </div>
    <!-- End. .container_12 --> 
			  </div>
          <!-- End #header-main -->
          <div style="clear: both;"></div>
        </div>
        
<!-- End #header -->
<div class="container_12" id="main_div">
