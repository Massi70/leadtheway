var emailReg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
var alNumReg = /^([a-zA-Z0-9])$/;
var stringNumber = /^([a-zA-Z0-9]*)$/;
var urlReg=/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

var baseUrl='';
var currentServerTime=0;
var uId=0;
var language='english';
var userData;
function setVariables(data){

	baseUrl=data[0];
	uId=data[1];
	language=data[2];
	uData=eval('('+data[3]+')');
	userData=uData;
	
}
var lang = 0;
var layout = 1;
var elementID = "";

function getNextStateUrduLayout(lastInput, currentInput)
{
	switch(currentInput)
	{
		case "0":return "0";
		case "1":return "1";
		case "2":return "2";
		case "3":return "3";
		case "4":return "4";
		case "5":return "5";
		case "6":return "6";
		case "7":return "7";
		case "8":return "8";
		case "9":return "9";
		case "a":return String.fromCharCode(0x0627);
		case "A":return String.fromCharCode(0x0653);
		case "b":return String.fromCharCode(0x0628);//+String.fromCharCode(0x0627);
		case "B":return String.fromCharCode(0x0613);//+String.fromCharCode(0x0622);
		case "c":return String.fromCharCode(0x0686);
		case "C":return String.fromCharCode(0x062B);
		case "d":return String.fromCharCode(0x062F);
		case "D":return String.fromCharCode(0x0688);
		case "e":return String.fromCharCode(0x0639);
		case "E":return String.fromCharCode(0x0611);
		case "f":return String.fromCharCode(0x0641);
		case "F":return String.fromCharCode(0x0656);
		case "g":return String.fromCharCode(0x06AF);
		case "G":return String.fromCharCode(0x063A);//+String.fromCharCode(0x0623);
		case "h":return String.fromCharCode(0x06BE);
		case "H":return String.fromCharCode(0x062D);
		case "i":return String.fromCharCode(0x06CC);
		case "I":return String.fromCharCode(0x0670);
		case "j":return String.fromCharCode(0x062C);
		case "J":return String.fromCharCode(0x0636);
		case "k":return String.fromCharCode(0x06A9);
		case "K":return String.fromCharCode(0x062E);
		case "l":return String.fromCharCode(0x0644);
		case "L":return String.fromCharCode(0x0612);
		case "m":return String.fromCharCode(0x0645);
		case "M":return String.fromCharCode(0x0658);
		case "n":return String.fromCharCode(0x0646);
		case "N":return String.fromCharCode(0x06BA);
		case "o":return String.fromCharCode(0x06C1);
		case "O":return String.fromCharCode(0x06C3);
		case "p":return String.fromCharCode(0x067E);
		case "P":return String.fromCharCode(0x064F);
		case "q":return String.fromCharCode(0x0642);
		case "Q":return String.fromCharCode(0x06E1);
		case "r":return String.fromCharCode(0x0631);
		case "R":return String.fromCharCode(0x0691);
		case "s":return String.fromCharCode(0x0633);
		case "S":return String.fromCharCode(0x0635);
		case "t":return String.fromCharCode(0x062A);
		case "T":return String.fromCharCode(0x0679);//+String.fromCharCode(0x0625);
		case "u":return String.fromCharCode(0x0621);
		case "U":return String.fromCharCode(0x0657);
		case "v":return String.fromCharCode(0x0637);
		case "V":return String.fromCharCode(0x0638);
		case "w":return String.fromCharCode(0x0648);
		case "W":return String.fromCharCode(0xFDFA);
		case "x":return String.fromCharCode(0x0634);
		case "X":return String.fromCharCode(0x0698);
		case "y":return String.fromCharCode(0x06D2);
		case "Y":return String.fromCharCode(0x0601);
		case "z":return String.fromCharCode(0x0632);
		case "Z":return String.fromCharCode(0x0630);
		case "[":return "]";
		case "]":return "[";
		case "{":return String.fromCharCode(0x0603);
		case "}":return String.fromCharCode(0x060E);
		case "?":return String.fromCharCode(0x061F);
		case "/":return String.fromCharCode(0x0615);
		case ",":return String.fromCharCode(0x060C);
		case "<":return String.fromCharCode(0x0650);
		case ">":return String.fromCharCode(0x064E);
		case ".":return String.fromCharCode(0x06D4);
		case ";":return String.fromCharCode(0x061B);
		case ":":return ":";
		case "'":return String.fromCharCode(0x27); //"'";
		case '"':return String.fromCharCode(0x22); //"\"";
		case "!":return "!";
		case "@":return String.fromCharCode(0x0600);
		case "#":return "/";
		case "$":return String.fromCharCode(0x0626);
		case "%":return String.fromCharCode(0x0615);
		case "^":return String.fromCharCode(0x0610);
		case "&":return String.fromCharCode(0x0654);
		case "*":return String.fromCharCode(0x064C);
		case ")":return "(";
		case "(":return ")";
		case "-":return String.fromCharCode(0x0623);
		case "_":return String.fromCharCode(0x0651);
		case "=":return String.fromCharCode(0x0624);
		case "+":return String.fromCharCode(0x0622);
		case "\\":return String.fromCharCode(0x0602);
		case "|":return String.fromCharCode(0x0614);
		case "~":return String.fromCharCode(0x064B);
		case "`":return String.fromCharCode(0x064D);
		case " ":return " ";
	}
	
	return currentInput;
}

function getQueryParams(qs) {
    qs = qs.split("+").join(" ");
	var count=0;
    var params = {'error':1},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
     //   params[decodeURIComponent(tokens[1])]
       //     = decodeURIComponent(tokens[2]);
			count=1;
    }
    return count;
}
function ajax(pageUrl,divId,FormId,spinnerId){
	
		var countParams= getQueryParams(pageUrl);
		if(countParams==1){
			url1= pageUrl+'&ajax=1';
		}else{
			url1= pageUrl+'?ajax=1'
		}
		var dataVar ='';
		if(FormId!=''){
			dataVar =  $('#'+FormId).serialize();
		}
		$.ajax({
			type: "POST",
			url:url1,
			cache:false,
			data:dataVar,
			success: function(msg){	
					$('#'+divId).html(msg);
				if(spinnerId!=''){	
					$('#'+spinnerId).fadeOut();
				}
			},
			beforeSend: function(){
				if(spinnerId!=''){	
					$('#'+spinnerId).fadeIn();
					showSpinner(spinnerId);
				}
				
			},
			error: function(m){
			//	alert(m);
			},
			complete: function(){
	
			}
		});
}
function simpleAjaxPaging(pageUrl,divId,spinnerId){
		$('#bg-popup').show();
		$('#bg-popup').html('<img src="<?php echo base_url();?>images/ajax-loader.gif" style="top:50%; margin-left:325px;position:relative">');
		var countParams= getQueryParams(pageUrl);
		if(countParams==1){
			url1= pageUrl+'&ajax=1';
		}else{
			url1= pageUrl+'?ajax=1'
		}
		
			$.ajax({
					type: "POST",
					url: url1,
					cache:false,
					success: function(msg){	
							$('#'+divId).html(msg);
							$('#'+spinnerId).fadeOut();
							$('#bg-popup').hide();
							$('#bg-popup').html('');
					},
					beforeSend: function(){
						if(spinnerId!=''){
							
							$('#'+spinnerId).fadeIn();
						}
					},
					complete: function(){
						if(spinnerId!=''){
							$('#'+spinnerId).fadeOut();
						}				
					
					}
				});
			}
function showSpinner(dialogId){
		$('#'+dialogId).css("top", ( ($(window).height() - ($('#'+dialogId).height() ) ) / 2)+$(window).scrollTop() + "px");
		
		$('#'+dialogId).css("left", ( ($(window).width() - $('#'+dialogId).width() ) / 2)+$(window).scrollLeft()-100 + "px");
		$('#'+dialogId).css("z-index",'1200');
		$('#'+dialogId).show('slow'); 
	}
function setNavigation(prefix,totalnav,idtoactive,actClass) {
	for(var i=0;i<=totalnav;i++) {
		$('#'+prefix+i).removeClass(actClass);	
	}
	$('#'+prefix+idtoactive).addClass(actClass);
}
function showPopUp(dialogId){
	$('#'+dialogId).css("top", ( ($(window).height() - ($('#'+dialogId).height() + ($('#'+dialogId).height()/1.5)) ) / 2)+$(window).scrollTop() + "px");
	 $('#'+dialogId).css("left", ( (750 - $('#'+dialogId).width() ) / 2)+$(window).scrollLeft() + "px");
	$('#'+dialogId).fadeIn();
}
function _setClass(j){
	for(var i=0; i<10; i++){
		if(i==j){
			$('#link_'+i).addClass('act');
		}else{
			$('#link_'+i).removeClass('act');
			$('#link_'+i).addClass('');
		}
	}
}
function showDiv(divId){
	$('#'+divId).fadeIn();
}
function hideDiv(divId){
	$('#'+divId).fadeOut();
}
function thumbnail(imgWidth,imgHeight,picUrl,width,height){
		var factor = Math.min ( width /imgWidth, height / imgHeight);
		if(imgWidth>width){
			imgWidth1=Math.round(imgWidth*factor);
		}else{
			imgWidth1=imgWidth;
		}
		
		
		if(imgHeight>height){	
			imgHeight1=Math.round(imgHeight*factor);
		}else{
			imgHeight1=imgHeight;
		}
		
		if(imgHeight1<height){
			margin=Math.floor((height-imgHeight1)/2);
		}else{
			margin=0;
		}	
		
		var img="<img src='"+picUrl+"' style='margin:"+margin+"px 0px;' width='"+imgWidth1+"' height='"+imgHeight1+"' />";
		return img;
	}

function htmlentities(txt){
		txt=$('<div/>').text(txt).html();	
		return txt; 
}
function trim(txt){
		txt=$.trim(txt)	
		return txt; 
}
function urlDecode(str){
    str=str.replace(new RegExp('\\+','g'),' ');
    return unescape(str);
}
function getUserData(){
       var data=[];
       //alert($('#user_amount').html());
	  // console.log($('#gogo_credits').find('cufon cufontext').html());
       data['gogo_credits']=$('#gogo_credits').find('cufon cufontext').html();
	   data['gogo_credits']=Number(data['gogo_credits'].replace(/[^0-9\.]+/g,""));
	   return data;
}
function validateEmailAddress(emaiAddress){
	if(emailReg.test(emaiAddress) ==false){
		return false;
	}else{
		return true;
	}
}
function subStrJs(text,charLength){
	if(text.length>charLength){
		return text.substring(0,(charLength-4)) + '....';
	}else{
		return text;
	}
}
function setSpinner(){
	$('.show_more_li').html('Loading....');
}	
/******************************
	Nice Time Functions
*****************************/
function niceTime(){
	var nDate=new Date();
	var dDate=nDate.getHours()+" "+nDate.getMinutes()+' '+nDate.getSeconds();
	$('abbr.timeago').each(function(index) {
			var date2=$(this).attr('title');
			var date1=date2;
			if(date1>0){
				//Set Server Time on page load in this function
				if(parseInt(currentServerTime)>parseInt(date1)){
					var str='';
					var timePast=currentServerTime-date1;
					
					//Calculate Years
					var years=Math.floor(timePast/(86400*365));
					//Calculate Months
					var months=Math.floor(timePast/(86400*30));
					//Calculate Days
					var days=Math.floor(timePast/86400);
					//Calculate Hours
					var hours=Math.floor(timePast/3600);
					//Calculate Hours
					var minutes=Math.floor(timePast/60);
					
					
					if(years>0){
						if(years==1){
							str=years+' year ago.';
						}else{
							str=years+' years ago.';
						}
					}else if(months>0){
						if(months==1){
							str=months+' month ago.';
						}else{
							str=months+' months ago.';
						}	
					}else if(days>0){
						if(days==1){
							str=days+' day ago.';
						}else{
							str=days+' days ago.';
						}	
					}else if(hours>0){
						if(hours==1){
							str=hours+' hour ago.';
						}else{
							str=hours+' hours ago.';
						}	
					}else if(minutes>0){
						if(minutes==1){
							str=minutes+' minute ago.';
						}else{
							str=minutes+' minutes ago.';
						}	
					}else{
						if(timePast==1){
							str=timePast+' second ago.';
						}else{
							str=timePast+' seconds ago.';
						}	
					}
					$(this).html(str);
				}
			}
	});
	currentServerTime=parseInt(currentServerTime)+60;
}
/**************************************
		Sign up Functions
*************************************/
function nextPreviousSteps(mode){
		if(mode=='next'){
			console.log("To Hide"+step);
			$('#step'+step).hide();
			step=parseInt(step)+1;
				console.log("To Show"+step)
			$('#step'+step).show();
		}else{
			console.log("To Hide"+step);
			$('#step'+step).hide();
			step=step-1;
			console.log("To Show"+step);
			$('#step'+step).show();
		}
	}
function activateNavigation(){
		$('div.con_lft_ins ul span.sign_txt').each(function(index) {
			var txt=$(this).html();
			txt = txt.split('').reverse().join('');
			number=parseInt(txt);	
			if(number>0){
				if(step==number){
					$(this).parent().addClass('active');
				}else{
					$(this).parent().removeClass('active');
				}
			}
		});	
	}

function base64_encode(data) {
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
        ac = 0,
        enc = "",
        tmp_arr = []; 
    if (!data) {
        return data;
    }
     data = this.utf8_encode(data + '');
 
    do { // pack three octets into four hexets
        o1 = data.charCodeAt(i++);
        o2 = data.charCodeAt(i++);        o3 = data.charCodeAt(i++);
 
        bits = o1 << 16 | o2 << 8 | o3;
 
        h1 = bits >> 18 & 0x3f;        h2 = bits >> 12 & 0x3f;
        h3 = bits >> 6 & 0x3f;
        h4 = bits & 0x3f;
 
        // use hexets to index into b64, and append result to encoded string        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
    } while (i < data.length);
 
    enc = tmp_arr.join('');
        var r = data.length % 3;
    
    return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}
function utf8_encode (argString) {
    // Encodes an ISO-8859-1 string to UTF-8  
    // 
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/utf8_encode    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: sowberry
    // +    tweaked by: Jack
    // +   bugfixed by: Onno Marsman    // +   improved by: Yves Sucaet
    // +   bugfixed by: Onno Marsman
    // +   bugfixed by: Ulrich
    // +   bugfixed by: Rafal Kukawski
    // *     example 1: utf8_encode('Kevin van Zonneveld');    // *     returns 1: 'Kevin van Zonneveld'
    if (argString === null || typeof argString === "undefined") {
        return "";
    }
     var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
    var utftext = "",
        start, end, stringl = 0;
 
    start = end = 0;    stringl = string.length;
    for (var n = 0; n < stringl; n++) {
        var c1 = string.charCodeAt(n);
        var enc = null;
         if (c1 < 128) {
            end++;
        } else if (c1 > 127 && c1 < 2048) {
            enc = String.fromCharCode((c1 >> 6) | 192) + String.fromCharCode((c1 & 63) | 128);
        } else {            enc = String.fromCharCode((c1 >> 12) | 224) + String.fromCharCode(((c1 >> 6) & 63) | 128) + String.fromCharCode((c1 & 63) | 128);
        }
        if (enc !== null) {
            if (end > start) {
                utftext += string.slice(start, end);            }
            utftext += enc;
            start = end = n + 1;
        }
    } 
    if (end > start) {
        utftext += string.slice(start, stringl);
    }
     return utftext;
}
	
/**************************************
		Login Functions
*************************************/	
function linkAccount(){
	
	 FB.login(function(response) {
   if (response.authResponse) {
	   var accessToken=response.authResponse.accessToken;
   	 FB.api('/me', function(response) {
		console.log(response);
		var userId=response.id;
		var dataVar={fbId:userId,accessToken:accessToken};
		$.ajax({
			type: "POST",
			url:baseUrl+'index.php/index/addFacebookAccount/',
			cache:false,
			data:dataVar,
			success: function(msg){	
				console.log(msg);
				if(msg=='Success'){
					$('#fbAccount').html('<a>Linked</a>');
				}else{
					$('#signup_error_msg').html('Facebook account you are linking is already linked with another account.');
					$('#signup_error_msg').show();
				}	
			}
		})
     });
   } else {
    	 console.log('User cancelled login or did not fully authorize.');
   }
 }, {scope: 'email,user_photos'});
	
	}
function linkAccountFollowings(type){
	
	 FB.login(function(response) {
   if (response.authResponse) {
	   var accessToken=response.authResponse.accessToken;
   	 FB.api('/me', function(response) {
		console.log(response);
		var userId=response.id;
		var dataVar={fbId:userId,accessToken:accessToken};
		$.ajax({
			type: "POST",
			url:baseUrl+'index.php/index/addFacebookAccount/',
			cache:false,
			data:dataVar,
			success: function(msg){	
				console.log(msg);
				if(msg=='Success'){
					if(type=='followers'){
					loadFollowersData(baseUrl+'followers/getFollowers',1,'following_data','spinner','facebook_followings','');
					}else{
					loadFollowingsData(baseUrl+'followings/getFollowings',1,'following_data','spinner','facebook_followings','');
					}
				}else{
					$('#following_data li.error').html('The account you have logged in is already assosited with another user.');
				}	
			}
		})
     });
   } else {
    	 console.log('User cancelled login or did not fully authorize.');
   }
 }, {scope: 'email,user_photos'});
	
	}	
function login(){
		var email=$('#loginForm #email').val();
		var password=$('#loginForm #password').val();
	
		$('#signup_error_msg1').hide();
		if(trim(email)=='' || trim(email)=='username / email'){
			
			$('#signup_error_msg1').html('Please enter name/email');
			$('#signup_error_msg1').show();
			return false;
		}
		if(trim(password)=='' || password=='password'){
			$('#signup_error_msg1').html('Please enter password');
			$('#signup_error_msg1').show();
			return false;
		}
		var dataVar =  $('#loginForm').serialize();
		$.ajax({
			type: "POST",
			url:baseUrl+'index.php/index/login/',
			cache:false,
			data:dataVar,
			success: function(msg){	
			
				if(msg=='Success'){
					window.location.replace(baseUrl);
				}else{
					$('#signup_error_msg1').html('Oops! It appears the log in information you provided is incorrect. Please try again.');
					$('#signup_error_msg1').show();
				}	
			}
		});
		return false;
	}
	
	
/*********************************
	Alert Function
**********************************/	
function alertMessage(divId,alertDivId,message){
	$('#'+alert_message).html(message);
	$('#'+divId).modal();
	return true;
}
function searchByHashTag(hashTagId){
		
		if(userLising=='thumbnail'){
			loadSearchVidoes(baseUrl+'home/searchVideosUsers',1,'video_content','spinner',hashTagId);
		}else{
			loadSearchListVideos(baseUrl+'home/searchVideosUsers',1,'video_content','spinner',hashTagId);
		}
	}
	