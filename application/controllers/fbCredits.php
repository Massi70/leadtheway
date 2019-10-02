<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FbCredits extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	/**
	Method	:	__construct
	Reason	:	for loading default helpers/libraries/models
	**/
	public function __construct()
	{
        parent::__construct();
		// load models
		$this->load->model('facebookmodel');
		// Validate request is from Facebook and parse contents for use.
		$request = $this->_parse_signed_request($this->input->post('signed_request'), FB_APP_SECRET);
		$response = '';
		
		$request_type = $this->input->post('method');
			
			
		if ($request_type == 'payments_get_items') {
			// Get order info from Pay Dialog's order_info.
			// Assumes order_info is a JSON encoded string.
			$order_info = json_decode($request['credits']['order_info'], true);
			
			// Get item id.
			 $item_id = $order_info['item_id'];
			
			// Simulutates item lookup based on Pay Dialog's order_info.
			if ($item_id == 'pkg1') {
				$item1 = array(
					'data' => $item_id,
					'title' => '1000 Coins',
					'description' => 'Spend cash in some game.',
					// Price must be denominated in credits.
					'price' => 50,
					'image_url' => base_url().'images/images.jpg',
				);
				
				// Construct response.
				$response = array( 'content' => array( 0 => $item1 ), 'method' => $request_type );
			}
			if ($item_id == 'pkg2') {
				$item1 = array(
					'data' => $item_id,
					'title' => '2500 Coins',
					'description' => 'Spend cash in some game.',
					// Price must be denominated in credits.
					'price' => 100,
					'image_url' => base_url().'images/images.jpg'
				);
				
				// Construct response.
				$response = array( 'content' => array( 0 => $item1 ), 'method' => $request_type );
			}
			if ($item_id == 'pkg3') {
				$item1 = array(
					'data' => $item_id,
					'title' => '7500 Coins',
					'description' => 'Spend cash in some game.',
					// Price must be denominated in credits.
					'price' => 200,
					'image_url' => base_url().'images/images.jpg'
				);
				
				// Construct response.
				$response = array( 'content' => array( 0 => $item1 ), 'method' => $request_type );
			}
			/*if ($item_id == 'pkg4') {
				$item1 = array(
					'data' => $item_id,
					'title' => '1500 Coins',
					'description' => 'Spend cash in some game.',
					// Price must be denominated in credits.
					'price' => 200,
					'image_url' => base_url().'images/images.jpg'
				);
				
				// Construct response.
				$response = array( 'content' => array( 0 => $item1 ), 'method' => $request_type );
			}
			if ($item_id == 'pkg5') {
				$item1 = array(
					'data' => $item_id,
					'title' => '2000 Coins',
					'description' => 'Spend cash in some game.',
					// Price must be denominated in credits.
					'price' => 200,
					'image_url' => base_url().'images/images.jpg'
				);
				
				// Construct response.
				$response = array( 'content' => array( 0 => $item1 ), 'method' => $request_type );
			}*/
			
			// Response must be JSON encoded.
			$response = json_encode($response);			
		}
		else if ($request_type == "payments_status_update") {
			// Get order details.
			$order_details = json_decode($request['credits']['order_details'], true);
			
		
			
			
			// Determine if this is an earned currency order.
			$item_data = json_decode($order_details['items'][0]['data'], true);
			$earned_currency_order = (isset($item_data['modified'])) ? $item_data['modified'] : null;
			
			// Get order status.
			$current_order_status = $order_details['status'];
			
			if ($current_order_status == 'placed') {
				// Fulfill order based on $order_details unless...
				
				if ($earned_currency_order) {
					// Fulfill order based on the information below...
					// URL to the application's currency webpage.
					$product = $earned_currency_order['product'];
					// Title of the application currency webpage.
					$product_title = $earned_currency_order['product_title'];
					// Amount of application currency to deposit.
					$product_amount = $earned_currency_order['product_amount'];
					// If the order is settled, the developer will receive this
					// amount of credits as payment.
					$credits_amount = $earned_currency_order['credits_amount'];
				}
				
			$next_order_status = 'settled';
			
			// Construct response.
			$response = array(
				'content' => array(
					'status' => $next_order_status,
					'order_id' => $order_details['order_id']
				),
				'method' => $request_type
			);
			
			// Response must be JSON encoded.
			$response = json_encode($response);
		
		} else if ($current_order_status == 'disputed') {
			// 1. Track disputed item orders.
			// 2. Investigate user's dispute and resolve by settling or refunding the order.
			// 3. Update the order status asychronously using Graph API.
			
		} else if ($current_order_status == 'refunded') {
			// Track refunded item orders initiated by Facebook. No need to respond.
		
		} else if ($current_order_status == 'settled') {
			
			// Verify that the order ID corresponds to a purchase you've fulfilled, then…
			
			// Get order details.
			$order_details = json_decode($request['credits']['order_details'], true);
			
			
			
			// load models
			////$this->load->model('fb_payment_model');
			$this->load->model('usermodel');
			
			/*$data = array(
				'fb_user_id' => $order_details['buyer'],
				'fb_order_id' => $order_details['order_id'],
				'fb_credits' => $order_details['items'][0]['price'],
				'fb_status' => $order_details['status'],
				'title' => $order_details['items'][0]['title'],
				'items_data' => json_encode($order_details['items'][0]),
				'datetime' => local_to_gmt()			
			);
			/////$this->fb_payment_model->insert($data);*/

			$add_coins = 0;
			if($order_details['items'][0]['data'] == 'pkg1') { $add_coins = 1000; }
			if($order_details['items'][0]['data'] == 'pkg2') { $add_coins = 2500; }
			if($order_details['items'][0]['data'] == 'pkg3') { $add_coins = 7500; }
			if($order_details['items'][0]['data'] == 'pkg4') { $add_coins = 1500; }
			if($order_details['items'][0]['data'] == 'pkg5') { $add_coins = 2000; }
			
			if($order_details['status'] == "settled" && $add_coins > 0) {
				
				// add user coins
				$fb_user = $this->usermodel->getUserCoin($order_details['buyer']);
				 $fb_user['user_coins'] += $add_coins;
				$this->usermodel->update_coin($order_details['buyer'],$fb_user['user_coins']);
			}
			
		
			 //save raw_data
			
			
		

			// Construct response.
			$response = array(
				'content' => array(
					'status' => 'settled',
					'order_id' => $order_details['order_id']
				),
				'method' => $request_type
			);
			
			// Response must be JSON encoded.
			$response = json_encode($response);
		
		} else {
			// Track other order statuses.
		}
	}
		// Send response.
		echo $response;
    }
	
	private $_assignData = array(
		'pDir' => '',
		'dir' => 'popup/'
	);
	private $_headerData = array();
	private $_footerData = array();
	private $_response = '';
	
	/**
	Method	:	index (default method)
	Reason	:	index page - user hauls
	**/
	public function index()
	{
		return;
	}
	
	
	// These methods are documented here:
	// https://developers.facebook.com/docs/authentication/signed_request/
	private function _parse_signed_request($signed_request, $secret) {
	  list($encoded_sig, $payload) = explode('.', $signed_request, 2);
	
	  // decode the data
	  $sig = $this->_base64_url_decode($encoded_sig);
	  $data = json_decode($this->_base64_url_decode($payload), true);
	
	  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
		error_log('Unknown algorithm. Expected HMAC-SHA256');
		return null;
	  }
	
	  // check sig
	  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
	  if ($sig !== $expected_sig) {
		error_log('Bad Signed JSON signature!');
		return null;
	  }
	
	  return $data;
	}
	
	private function _base64_url_decode($input) {
	  return base64_decode(strtr($input, '-_', '+/'));
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */