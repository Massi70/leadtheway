<script type="text/javascript" src="<?php echo base_url();?>js/formElem.js"></script>
<script>
function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9]/ig, "");
}

function register(){
		var name=$('#registerForm #name');
		var email=$('#registerForm #email');
		var nationality=$('#registerForm #nationality');
		var gender=$('#gender');
		var phoneNo=$('#registerForm #phone_no');
		var nicNo=$('#registerForm #nic_no');
		var address=$('#registerForm #address');
		var city=$('#registerForm #city');
		var country=$('#registerForm #country');
		var password=$('#registerForm #password');

		var month=$('#registerForm #month').val();
		var year=$('#registerForm #year').val();
		var date=$('#registerForm #date').val();
		
		var mobileCode=$('#registerForm #mobile_no1');
		var mobileNo=$('#registerForm #mobile_no2');
		$('#error_msg').css('visibility','hidden');
		if(trim(name.val())==''){
			name.focus();
			$('#error_msg').html('Please enter your name');
			$('#error_msg').css('visibility','');
			return false;
		}else if(trim(email.val())==''){
			email.focus();
			$('#error_msg').html('Please enter email');
			$('#error_msg').css('visibility','');
			return false;
		}else if(trim(email.val()) !='' &&  validateEmailAddress(email.val())==false){
			email.focus();
			$('#error_msg').html('Please enter valid email address');
				$('#error_msg').css('visibility','');
			return false;
		}else if(trim(password.val())==''){
			password.focus();
			$('#error_msg').html('Please enter password');
			$('#error_msg').css('visibility','');
			return false;
		}else if(trim(nationality.val())==''){
			nationality.focus();
			$('#error_msg').html('Please select your nationality');
			$('#error_msg').css('visibility','');
			return false;
		}else if(month=='' || year=='' || date==''){
			$('#error_msg').html('Please select your valid date of birth');
			$('#error_msg').css('visibility','');
			return false;
		}else if(trim(gender.val())==''){
			gender.focus();
			$('#error_msg').html('Please enter your gender');
			$('#error_msg').css('visibility','');
			return false;
		}else if(trim(nicNo.val())==''){
			nicNo.focus();
			$('#error_msg').html('Please enter National ID Number');
			$('#error_msg').css('visibility','');
			return false;
		}else if(trim(address.val())==''){
			address.focus();
			$('#error_msg').html('Please enter your address');
			$('#error_msg').css('visibility','');
			return false;
		}else if(trim(city.val())==''){
			city.focus();
			$('#error_msg').html('Please enter your city');
			$('#error_msg').css('visibility','');
			return false;
		}else if(trim(country.val())==''){
			country.focus();
			$('#error_msg').html('Please enter your country');
			$('#error_msg').css('visibility','');
			return false;
		}else if(trim(mobileCode.val())=='' || trim(mobileCode.val())=='Code'){
			mobileCode.focus();
			$('#error_msg').html('Please enter mobile code');
			$('#error_msg').css('visibility','');
			return false;
		}else if(trim(mobileNo.val())=='' || trim(mobileNo.val())=='Mobile Number'){
			mobileNo.focus();
			$('#error_msg').html('Please enter mobile number');
			$('#error_msg').css('visibility','');
			return false;
		}else if($('#terms_and_conditions').attr('checked')==false){
			$('#error_msg').html('You must agree the terms and conditions.');
			$('#error_msg').css('visibility','');
			return false;
		}else{
			var dataVar =  $('#registerForm ').serialize();
			$.ajax({
						type: "POST",
						url:baseUrl+'index/register',
						cache:false,
						data:dataVar,
						success: function(msg){	
						if(msg=='Email Failure'){
							$('#error_msg').html('Email address you entered already exists.');
							$('#error_msg').css('visibility','');
						}else if(msg=='Nic Failure'){
							$('#error_msg').html('National ID Number you entered already exists.');
								$('#error_msg').css('visibility','');
						}else if(msg=='Success'){
							window.location.replace(baseUrl+'index/index2');
						}else{
							$('#testDiv').html(msg);
						}	
					}
					});
			
			
		}
	}
	$(document).ready(function(){
		$('.signupPopup').css('left',( ($(window).width() - $('.signupPopup').width() ) / 2)+$(window).scrollLeft() + "px");
		$('#registerForm').submit(function(){
				register();
				return false;
				
		});
		$('#overlay2').show();
		$('#year').click(function(){
			if($(this).val()=='Year'){
				$(this).val('');	
			}
		});
		$('#month').click(function(){
			if($(this).val()=='Month'){
				$(this).val('');	
			}
		});
		$('#date').click(function(){
			if($(this).val()=='Day'){
				$(this).val('');	
			}
		});
		$('#year').blur(function(){
			if($(this).val()==''){
				$(this).val('Year');	
			}
		});
		$('#month').blur(function(){
			if($(this).val()==''){
				$(this).val('Month');	
			}
		});
		$('#date').blur(function(){
			if($(this).val()==''){
				$(this).val('Day');	
			}
		});
		
		$('#mobile_no1').click(function(){
			if($(this).val()=='Country Code'){
				$(this).val('');	
			}
		});
		$('#mobile_no1').blur(function(){
			if($(this).val()==''){
				$(this).val('Country Code');	
			}
		});
		$('#mobile_no2').click(function(){
			if($(this).val()=='Mobile Number'){
				$(this).val('');	
			}
		});
		$('#mobile_no2').blur(function(){
			if($(this).val()==''){
				$(this).val('Mobile Number');	
			}
		});
	});
</script>

<div class="wrapper globalMargin">
  <div class="BottleImg" style="top:350px;"><img src="<?php echo base_url()?>images/web/bottle.png" /></div>
  <div class="MachineImg" style="top:380px;"><img src="<?php echo base_url()?>images/web/machine.png" /></div>
  
</div>
<div class="signupPopup" style="top:70px;">
   <span class="pb-Close" style="top:22px;right:-10px;"><a href="<?php echo base_url()?>"><img src="<?php echo base_url();?>images/closeButt.png" /></a></span>
    <form id="registerForm" name="registerForm" method="post">
      <h1>Sign Up</h1>
     
      <div class="su-Form" style="margin-top:10px !important">
        <ul>
          <li>
            <label>Full Name</label>
            <div class="fld"><span class="left"></span>
              <input type="text" size="40" id="name" name="name" maxlength="140" />
              <span class="right"></span></div>
          </li>
          <li>
            <label>Email</label>
            <div class="fld"><span class="left"></span>
              <input type="text" size="40"  id="email" name="email" maxlength="50" />
              <span class="right"></span></div>
          </li>
         			<li>
            <label>Password</label>
            <div class="fld"><span class="left"></span>
              <input type="password" size="40"  id="password" name="password" maxlength="50" />
              <span class="right"></span></div>
          </li>
       				<li>
                    	<label>Nationality</label>
                         <div class="fld"><span class="left"></span> <div class="select">
              <select name="nationality" id="nationality" class="country">
                <option value="" selected="selected">Select</option>
                  <option value="Saudi Arabia">Saudi Arabia</option>
                 <option value="Kuwait">Kuwait</option>
                 <option value="Bahrain">Bahrain</option>
                 <option value="Qatar">Qatar</option>
                 <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="Afghanistan">Afghanistan</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antarctica">Antarctica</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Aruba">Aruba</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermuda">Bermuda</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Bouvet Island">Bouvet Island</option>
                <option value="Brazil">Brazil</option>
                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                <option value="Brunei Darussalam">Brunei Darussalam</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Cape Verde">Cape Verde</option>
                <option value="Cayman Islands">Cayman Islands</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Christmas Island">Christmas Island</option>
                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo">Congo</option>
                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                <option value="Cook Islands">Cook Islands</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Cote D'ivoire">Cote D'ivoire</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                <option value="Faroe Islands">Faroe Islands</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="French Guiana">French Guiana</option>
                <option value="French Polynesia">French Polynesia</option>
                <option value="French Southern Territories">French Southern Territories</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Greece">Greece</option>
                <option value="Greenland">Greenland</option>
                <option value="Grenada">Grenada</option>
                <option value="Guadeloupe">Guadeloupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-bissau">Guinea-bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                <option value="Korea, Republic of">Korea, Republic of</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macao">Macao</option>
                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Martinique">Martinique</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mayotte">Mayotte</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                <option value="Moldova, Republic of">Moldova, Republic of</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="Netherlands Antilles">Netherlands Antilles</option>
                <option value="New Caledonia">New Caledonia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Niue">Niue</option>
                <option value="Norfolk Island">Norfolk Island</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Pitcairn">Pitcairn</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Reunion">Reunion</option>
                <option value="Romania">Romania</option>
                <option value="Russian Federation">Russian Federation</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saint Helena">Saint Helena</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                <option value="Swaziland">Swaziland</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                <option value="Thailand">Thailand</option>
                <option value="Timor-leste">Timor-leste</option>
                <option value="Togo">Togo</option>
                <option value="Tokelau">Tokelau</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                <option value="Uruguay">Uruguay</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Viet Nam">Viet Nam</option>
                <option value="Virgin Islands, British">Virgin Islands, British</option>
                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                <option value="Wallis and Futuna">Wallis and Futuna</option>
                <option value="Western Sahara">Western Sahara</option>
                <option value="Yemen">Yemen</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>
              </select>
               </div><span class="right"></span></div>
                    </li>
        			<li>
            <label>Date of Birth</label>
            <div class="fld"><span class="left"></span>
              <div class="select">
                <select id="year" name="year" class="dob" >
                  <option value="">Year</option>
                  <?php for($i=(date('Y')-10); $i>1919; $i--) { ?>
                  <option value="<?php echo $i ;?>"><?php echo $i;?></option>
                  <?php }?>
                </select>
              </div>
              <span class="right"></span></div>
            <div class="fld marg"><span class="left"></span>
              <div class="select">
                <select id="month" name="month"  class="dob">
                  <option value="">Month</option>
                  <?php for($d=1; $d<=12; $d++) { ?>
                  <option value="<?php echo $d ;?>"><?php echo $d;?></option>
                  <?php }?>
                </select>
              </div>
              <span class="right"></span></div>
            <div class="fld"><span class="left"></span>
              <div class="select">
                <select id="date" name="date" class="dob">
                  <option value="">Day</option>
                  <?php for($d=1; $d<=31; $d++) { ?>
                  <option value="<?php echo $d ;?>"><?php echo $d;?></option>
                  <?php }?>
                </select>
              </div>
              <span class="right"></span></div>
          </li>
                    <li>
            <label>Gender</label>
            <div class="fld"></span> <span class="left"></span>
              <div class="select">
                <select id="gender" name="gender">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <span class="right"></span> </div>
           
          </li>
                	<li>
                    	<label style="line-height:20px;">National<br /> ID Number</label>
                        <div class="fld"><span class="left"></span><input type="text" size="40" value="" id="nic_no" name="nic_no" maxlength="40"  /><span class="right"></span></div>
                    </li> 
                	<li>
                    	<label>Address</label>
                        <div class="fld"><span class="left"></span><input type="text" size="40" value="" id="address" name="address" maxlength="100" /><span class="right"></span></div>
                    </li> 
                	<li>
                    	<label>City</label>
                        <div class="fld"><span class="left"></span><input type="text" size="40" value="" id="city" name="city" maxlength="40" /><span class="right"></span></div>
                    </li> 
                	<li>
            <label>Country</label>
            <div class="fld"><span class="left"></span> <div class="select">
              <select name="country" id="country" class="country">
                <option value="" selected="selected">Select</option>
                  <option value="Saudi Arabia">Saudi Arabia</option>
                 <option value="Kuwait">Kuwait</option>
                 <option value="Bahrain">Bahrain</option>
                 <option value="Qatar">Qatar</option>
                 <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="Afghanistan">Afghanistan</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antarctica">Antarctica</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Aruba">Aruba</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermuda">Bermuda</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Bouvet Island">Bouvet Island</option>
                <option value="Brazil">Brazil</option>
                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                <option value="Brunei Darussalam">Brunei Darussalam</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Cape Verde">Cape Verde</option>
                <option value="Cayman Islands">Cayman Islands</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Christmas Island">Christmas Island</option>
                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo">Congo</option>
                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                <option value="Cook Islands">Cook Islands</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Cote D'ivoire">Cote D'ivoire</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                <option value="Faroe Islands">Faroe Islands</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="French Guiana">French Guiana</option>
                <option value="French Polynesia">French Polynesia</option>
                <option value="French Southern Territories">French Southern Territories</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Greece">Greece</option>
                <option value="Greenland">Greenland</option>
                <option value="Grenada">Grenada</option>
                <option value="Guadeloupe">Guadeloupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-bissau">Guinea-bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                <option value="Korea, Republic of">Korea, Republic of</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macao">Macao</option>
                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Martinique">Martinique</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mayotte">Mayotte</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                <option value="Moldova, Republic of">Moldova, Republic of</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="Netherlands Antilles">Netherlands Antilles</option>
                <option value="New Caledonia">New Caledonia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Niue">Niue</option>
                <option value="Norfolk Island">Norfolk Island</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Pitcairn">Pitcairn</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Reunion">Reunion</option>
                <option value="Romania">Romania</option>
                <option value="Russian Federation">Russian Federation</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saint Helena">Saint Helena</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                <option value="Swaziland">Swaziland</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                <option value="Thailand">Thailand</option>
                <option value="Timor-leste">Timor-leste</option>
                <option value="Togo">Togo</option>
                <option value="Tokelau">Tokelau</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                <option value="Uruguay">Uruguay</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Viet Nam">Viet Nam</option>
                <option value="Virgin Islands, British">Virgin Islands, British</option>
                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                <option value="Wallis and Futuna">Wallis and Futuna</option>
                <option value="Western Sahara">Western Sahara</option>
                <option value="Yemen">Yemen</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>
              </select>
               </div><span class="right"></span></div>
          </li>                
          			<li>
                    	<label>Mobile Number</label>
                        <div class="fld" style="margin-right:14px;"><span class="left"></span><input type="text" size="10" id="mobile_no1" name="mobile_no1" maxlength="4" value="Country Code" onKeyUp="numericFilter(this);" />
                        <span class="right"></span></div>
                        <div class="fld"><span class="left"></span><input type="text" size="20" id="mobile_no2" name="mobile_no2" maxlength="20" value="Mobile Number"  onKeyUp="numericFilter(this);"/><span class="right"></span></div>
                    </li>
        </ul>
         <div id="error_msg" style="color: red;font-weight: bold;height: 15px; margin: 18px auto 0;padding: 0;text-align: center;width: 400px;font-size:13px; position:relative; top:-20px;"></div>
        <div class="terms">
                	<input type="checkbox" class="styled"  id="terms_and_conditions"/><span class="form-new-span" style="line-height:30px;"> I agree with the <a href="javascript:;" id="header_terms1">terms &amp; conditions</a></span>
                </div>
                <div class="terms">
                	<input type="checkbox" class="styled" id="newsletter" name="newsletter" checked="checked"/> <span class="form-new-span">I want to receive weekly updates through email</span>
                </div>
        <input type="submit" id="submit" name="submit" value="Next" class="next" style="border:none;cursor:pointer;" />
      </div>
    </form>
  </div>