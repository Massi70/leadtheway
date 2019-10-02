<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

|--------------------------------------------------------------------------

| File and Directory Modes

|--------------------------------------------------------------------------

|

| These prefs are used when checking and setting modes when working

| with the file system.  The defaults are fine on servers with proper

| security, but you may wish (or even need) to change the values in

| certain environments (Apache running a separate process for each

| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should

| always be used to set the mode correctly.

|

*/

define('FILE_READ_MODE', 0644);

define('FILE_WRITE_MODE', 0666);

define('DIR_READ_MODE', 0755);

define('DIR_WRITE_MODE', 0777);

/*

|--------------------------------------------------------------------------

| File Stream Modes

|--------------------------------------------------------------------------

|

| These modes are used when working with fopen()/popen()

|

*/

define('FOPEN_READ',							'rb');

define('FOPEN_READ_WRITE',						'r+b');

define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care

define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care

define('FOPEN_WRITE_CREATE',					'ab');

define('FOPEN_READ_WRITE_CREATE',				'a+b');

define('FOPEN_WRITE_CREATE_STRICT',				'xb');

define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/* End of file constants.php */

/* Location: ./application/config/constants.php */

//App Constants

define('APP_NAME','Lead The Way');

define('LIMIT',20);

define('GRAPH_URL','//graph.facebook.com/');

define('FB_APP_ID','131322923702574'); /* facebook application id */

define('FB_COOKIE',false); /* false or true */

define('FB_APP_SECRET','2815a5cea5b1a452698d241c29b9f49a'); /* facebook application secret */

//define('FB_REDIRECT_URL','http://developer.avenuesocial.com/azeemsal/bet_onit/facebook2/redirect/'); /* facebook redirect url */

//define('REDIRECT_URL','http://apps.facebook.com/bet_onit/'); /* facebook redirect url */

define('FILE_UPLOAD',false); /* facebook redirect url */

define('FB_PERMS','email');
define('SERVICE_LOG',true);

?>