/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2010 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 254 2010-07-23 05:14:44Z emartin24 $
 */

jQuery(function ($) {
	// Load dialog on page load
	//$('#basic-modal-content').modal();

	// Load dialog on click
	$('.basic-modal .basic').click(function (e) {
		$('#basic-modal-content').modal();

		return true;
	});
	$('.why_birt a').click(function (e) {
		$('.login_bx_ins').html('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac odio in quam vestibulum accumsan. Aliquam sagittis rutrum lobortis. Etiam congue imperdiet consequat. Vestibulum mollis sollicitudin justo id placerat. In hac habitasse platea dictumst. Nulla quis purus ante. Donec tortor tortor, tempus sed porta nec, volutpat eget turpis. Donec eget dolor metus. Mauris semper quam quis nunc dignissim et commodo enim ullamcorper. Nunc nec tellus augue. Aenean rhoncus luctus purus, nec vulputate justo porttitor sit amet. Aliquam vel turpis magna, eget malesuada neque. Aliquam erat volutpat. Vestibulum cursus tellus eu urna elementum convallis.');
		$('.why_birth_pop').modal();
		return true;
	});
	
});