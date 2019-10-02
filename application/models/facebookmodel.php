<?php

/*

 * Copyright 2011 Facebook, Inc.

 *

 * Licensed under the Apache License, Version 2.0 (the "License"); you may

 * not use this file except in compliance with the License. You may obtain

 * a copy of the License at

 *

 *     http://www.apache.org/licenses/LICENSE-2.0

 *

 * Unless required by applicable law or agreed to in writing, software

 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT

 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the

 * License for the specific language governing permissions and limitations

 * under the License.

 */

class FacebookModel extends CI_Model {

	private static $_config;

    public function __construct(){

        parent::__construct();

        $profile = null;

        // Create our Application instance (replace this with your appId and secret).

        $this->_config = array(

                        'appId'  => FB_APP_ID,

                        'secret' => FB_APP_SECRET,

						'cookie'=>FB_COOKIE,

                        'fileUpload' => FILE_UPLOAD,

						'redirectUrl' => FB_REDIRECT_URL,

						'scope'=>FB_PERMS // Indicates if the CURL based @ syntax for file uploads is enabled.

                    );

        $this->load->library('Facebook', $this->_config);

    }

	public function authenticate(){

		if($_SERVER['HTTP_HOST']=='localhost'){

			$userId =1600554126;

		}else{

        	$userId = $this->facebook->getUser();

		}

		$profile = null;

        if($userId>0){

			$this->load->model('UserModel');

            $userData=$this->UserModel->getUserData($userId);

			if(is_array( $userData) && count( $userData)>0){

				$userdata=array('user_data'=>$userData,'check_user'=>'already');

				return $userdata;

			}else{

				$fbData = $this->facebook->api('/me?fields=id,name,link,email,first_name,last_name,gender,birthday');

			

				$year=explode("/",@$fbData['birthday']);

				//list($month,$day,$year) = explode("/",@$fbData['birthday']);
	
				$userData=array('user_name'=>$fbData['name'],'first_name'=>$fbData['first_name'],'last_name'=>$fbData['last_name'],'user_email'=>$fbData['email'],'user_id'=>$fbData['id'],'user_gender'=>$fbData['gender'],'user_accesstoken'=>$this->facebook->getAccessToken(),'joined_date'=>date("Y-m-d H:i:s"),'user_coins'=>'1000','user_birthdaydate' => @$year[2]."-".@$year[0]."-".@$year[1] );

				$this->UserModel->createUser($userData);

				$userdata=array('user_data'=>$userData,'check_user'=>'first');

				return $userdata;

			}

        }else{

			 $loginUrl = $this->facebook->getLoginUrl($this->_config);

			echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";

			exit();

		}

	}

	

	public function getSignedRequest(){

        return $this->facebook->getSignedRequest();

	}

	

	public function postStatus($uid,$attachment){

       // $uid='1698233221';

		try {

				$post = $this->facebook->api('/'.$uid.'/feed', 'post',$attachment);

				print_r($pp); //show the tagged post ID

				var_dump($post);

		}catch(exception $e)

			{

				var_dump($e);

				exit;

			}

	}

	

	public function getUserFbData(){

	 	$userId = $this->facebook->getUser();

		if($userId>0){

			$fbData = $this->facebook->api('/me?fields=id,name,link,email,first_name,last_name');

			return $fbData;

		}else{

			return $userId; 

		}

	}

	

	public function getFriends($userId){

	 	$accessToken=$this->getAccessToken();

		$fbData = $this->facebook->api('/'.$userId.'/friends?access_token='.$accessToken);

		return $fbData;

	

	}

	

	public function getAccessToken(){

		return $this->facebook->getAccessToken();

	}

	

	function post_on_wall($user_id,$attachment)

	{

			try

			{

			$arr = $this->facebook->api('/'.$user_id.'/feed','post',$attachment);

			return $arr;

			}

			catch(exception $e)

			{

			}

	}

	

	function getUsersPicture($user_id){

			$friends_ = file_get_contents('https://graph.facebook.com/'.$user_id.'/picture?type=large');

			$friends_data = json_decode($friends_);

			print_r($friends_data);

			exit;

			return $friends_data->picture->data->url;

		}

	

}

?>