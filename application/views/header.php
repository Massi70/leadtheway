<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="<?php echo base_url();?>css/style.css?v=<?php echo time();?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/core.js?v=<?php echo time();?>"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php $this->load->view('js');?>
<script src="<?php echo ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");?>://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.innerfade.js"></script>
 <div id="fb-root"></div>
<script>
		FB.init({
				 appId  : '<?php echo FB_APP_ID; ?>',
				 status : true, // check login status
				 cookie : true, // enable cookies to allow the server to access the session
				 xfbml  : true  // parse XFBML
			   });
  	//setTimeout(function(){FB.Canvas.setAutoGrow();}, 2000);
	//FB.Canvas.setSize({height:800});
	FB.Canvas.setAutoGrow();
	//FB.Canvas.setSize({height:600});
	//FB.Canvas.setAutoGrow();
</script>
</head>
<body>
<div style="background:none repeat scroll 0 0 #090E2D;">
<div class="wrapper">

<div class="header">
    	<div class="logo"><img src="<?php echo base_url();?>images/logo.png" /></div>
    	<ul class="banner">
		<?php  foreach($banner_image as $adds){?>
      <!-- <img src="<?php echo base_url();?>images/banner.jpg" />-->
      <li> <img src="<?php echo base_url();?>images/adds/<?php echo $adds['add_image'];?>" width="505" height="135"/></li>
        <?php }?>
        </ul>
    </div>
    <div class="middle_content">
<div class="tabMenu">
            <ul style="list-style:none;">
                <li class="first first_z active" id="home_li"><a href="#" id="home" >HOME</a><span></span></li>
                <li class="second_z" id="myBet_li"><a href="#" id="my_bet" >MY BETS</a><span></span></li>
                <li id="createBet_li"><a href="#" onClick="create_bet();">CREATE BET</a><span></span></li>
               </ul>
        </div>
<div style="margin:100px 0 -30px 300px; clear:both; display:none; position:absolute; top:495px; z-index:25; left:0px;" id="paging_spinner"><img border="0" src="<?php echo base_url();?>images/ajax-loader.gif?v=1"></div>
			<?php /*?><div class="mobs_bets_menu">
            	<a href="#_" class="menu_ntif" id="home" >Home</a>
                <a href="#_" class="menu_ntif" style="margin-left:60px;" id="my_bet">My Bets </a>
             <!-- <a href="#_" class="menu_ntif" style="margin-left:50px;" onClick="open_popup();">Create Bet</a>-->
             <a href="#_" class="menu_ntif" style="margin-left:50px;" onClick="create_bet();">Create Bet</a>
            </div><?php */?>
<script type="text/javascript">
	$(document).ready(
				function(){
					$('ul.banner').innerfade({
						speed: 1000,
						timeout: 7000,
						type: 'random_start',
						containerheight: '1.5em'
					});
				});
</script>