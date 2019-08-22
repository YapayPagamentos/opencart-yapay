<?php
require_once ('tc/Address.php');

class ControllerExtensionPaymentTrayCheckout extends Controller {
	
	public function index() {

		$this->language->load ( 'payment/traycheckout' );
		$this->load->model ( 'localisation/zone' );
		$this->load->model ( 'checkout/order' );
		
		$langs = array( 'text_confirm_order', 'text_payment', 'text_wait' );
                
        foreach ($langs as $value) {
            $data[$value] = $this->language->get($value);
        }

        
		$data['button_confirm'] = $this->language->get ( 'button_confirm' );
		$data['text_payment'] = $this->language->get ( 'text_payment' );
		$data['text_wait'] = $this->language->get ( 'text_wait' );
		
		$data['action'] = $this->urlPost ();
		$data['token_account'] = $this->config->get ( 'traycheckout_token' );
        $data['free'] = "OPENCART_v2.3";
		$data['shipping_total'] = 0;
		$data['products'] = array ();
		
		$order_info = $this->model_checkout_order->getOrder ( $this->session->data ['order_id'] );
		
		foreach ( $this->cart->getProducts () as $product ) {
			$option_data = array ();
			
			foreach ( $product ['option'] as $option ) {
				$option_data [] = array ('name' => $option ['name'], 'shipping_price' => $option ['value'] );
			}
			
			$data['products'] [] = array ('product_id' => $product ['product_id'], 
												'name' => $product ['name'], 
												'model' => $product ['model'], 
												'value' => $this->currency->convert ( $product ['price'], 
															  $this->config->get ( 'config_currency' ), 
															  $order_info ['currency_code'] ), 
												'quantity' => $product ['quantity'], 
												'option' => $option_data );
		}

		
		$data['discount_total'] = 0;
		$total = $this->currency->format ( $order_info ['total'] - $this->cart->getSubTotal (), $order_info ['currency_code'], false, false );
		
		if ($total > 0) {
			$data['products'] [] = Array ('product_id' => 'extra_amount', 'name' => $this->language->get ( 'text_shipping_tax' ), 'model' => '', 'value' => $total, 'quantity' => 1, 'option' => array () );
		} else if ($total < 0) {
			$data['discount_total'] = $total * (- 1);
		}
		
		$data['email'] = html_entity_decode ( $order_info ['email'], ENT_QUOTES, 'UTF-8' );
		$data['number_contact'] = html_entity_decode ( $order_info ['telephone'], ENT_QUOTES, 'UTF-8' );
		$data['type_contact'] = "H";
		
		$suffix = $this->config->get ( 'traycheckout_suffix' );
		$data['order_number'] = ($suffix != "") ? $this->session->data ['order_id'] . "_" . $suffix : $this->session->data ['order_id'];

		$data['url_notification'] = $this->url->link ( 'extension/payment/traycheckout/notification' );
		$data['url_sucess'] = $this->url->link ( 'extension/payment/traycheckout/callback' );
		$data['url_process'] = $this->url->link ( 'extension/payment/traycheckout/callback' );
		
		//$tc_log("Um pause 3");
		$type_address = ($this->cart->hasShipping ()) ? 'shipping' : 'payment';
		
		$data['shipping_type'] = ($order_info ['shipping_method']) ? html_entity_decode ( $order_info ['shipping_method'], ENT_QUOTES, 'UTF-8' ) : "";
		
		$zone = $this->model_localisation_zone->getZone ( $order_info [$type_address . '_zone_id'] );
		
		$data['name'] = html_entity_decode ( $order_info [$type_address . '_firstname'] . ' ' . $order_info [$type_address . '_lastname'], ENT_QUOTES, 'UTF-8' );
		
		$Address = new Address();
		list ( $street, $number, $completion ) = $Address->getAddress( html_entity_decode ( $order_info [$type_address . '_address_1'], ENT_QUOTES, 'UTF-8' ) );
		$data['street'] = html_entity_decode ( $order_info [$type_address . '_address_1'], ENT_QUOTES, 'UTF-8' );

		/*Inicio da busca dos custom fields de CPF, número e complemento */

		$this->load->model('account/custom_field');

		$default_group = $this->config->get('config_customer_group_id');
		
        if(isset($customer['customer_group_id'])){
            $default_group = $customer['customer_group_id'];
        }

		$custom_fields = $this->model_account_custom_field->getCustomFields($default_group);

        foreach($custom_fields as $custom_field){
            if($custom_field['location'] == 'account'){
                if(strpos(strtolower($custom_field['name']), 'cpf') !== false) {
                    $data['cpf'] = $order_info['custom_field'][$custom_field['custom_field_id']];
                }
            }elseif($custom_field['location'] == 'address'){
                if(strpos(strtolower($custom_field['name']), 'numero') !== false || strpos(strtolower($custom_field['name']), 'número') !== false){
                    $data['number'] = $order_info['payment_custom_field'][$custom_field['custom_field_id']];
                }elseif(strpos(strtolower($custom_field['name']), 'complemento') !== false ){
                    $data['completion'] = $order_info['payment_custom_field'][$custom_field['custom_field_id']];
                }
            }
        }

		/*Fim da busca dos custom fields de CPF, número e complemento */


		$data['neighborhood'] = html_entity_decode ( $order_info [$type_address . '_address_2'], ENT_QUOTES, 'UTF-8' );
		$data['city'] = html_entity_decode ( $order_info [$type_address . '_city'], ENT_QUOTES, 'UTF-8' );
		$data['postal_code'] = preg_replace ( "/[^0-9]/", '', $order_info [$type_address . '_postcode'] );


		if (isset ( $zone ['code'] )) {
			$data['state'] = html_entity_decode ( $zone ['code'], ENT_QUOTES, 'UTF-8' );
		}

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['continue'] = $this->url->link('checkout/success');



		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/payment/traycheckout.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/payment/traycheckout.tpl', $data);
		} else {
			return $this->load->view('/extension/payment/traycheckout.tpl', $data);
		}
	
	}
		
	public function confirm () {

		if ($this->session->data['payment_method']['code'] == 'traycheckout') {
			$this->load->model( 'checkout/order' );
		
			$this->model_checkout_order->addOrderHistory( $this->session->data ['order_id'], $this->config->get ( 'traycheckout_order_pending' ) );
		}
	}
	
	public function callback() {
		
		$this->response->redirect($this->url->link('checkout/success', '', 'SSL'));
		//$this->redirect( $this->url->link( 'checkout/success' ) );
	
	}
			
	public function notification() {
		
		$transaction_token = $_POST['token_transaction'];
		//$order_number_conf = $this->getOrderNumber( $_POST['transaction']['order_number']);
		
		$transaction = $this->getResult($transaction_token );
		$order_number = $this->getOrderNumber ( $transaction ['order_number'] );
		
		//if ($order_number != $order_number_conf) {
		//	$this->httpError ( "Pedido: $order_number_conf não corresponte com a pedido consultado: $order_number!" );
		//}
		
		$this->load->model ( 'checkout/order' );
		$order = $this->model_checkout_order->getOrder( $order_number );
		
		if ($transaction ['price_original'] != $order['total']) {
			$this->httpError ( 'Total pago à Tray é diferente do valor original.' );
		}
		
		$update_status_alert = ($this->config->get ( 'traycheckout_update_status_alert' )) ? true : false;
		
		$comment = (isset ( $transaction ['status_id'] )) ? $transaction ['status_id'] : "";
		$comment .= (isset ( $transaction ['status_name'] )) ? " - " . $transaction ['status_name'] : "";
		echo "Pedido: $order_number - $comment - ID: " . $transaction ['transaction_id'];
		
		$status_id = $transaction ['status_id'];
		
		switch ($status_id) {
			case ('4') :
				if ($order ['order_status_id'] != $this->config->get( 'traycheckout_order_pending' )) {
					$this->model_checkout_order->addOrderHistory( $order_number, $this->config->get ( 'traycheckout_order_pending' ), $comment, $update_status_alert );
				}
				break;
			case ('5') :
			case ('87') :

				if ($order ['order_status_id'] != $this->config->get ( 'traycheckout_order_processing' )) {

					$this->model_checkout_order->addOrderHistory( $order_number, $this->config->get ( 'traycheckout_order_processing' ), $comment, $update_status_alert );
				}
				break;
			case '6' :
				if ($order ['order_status_id'] != $this->config->get ( 'traycheckout_order_processed' )) {
					$this->model_checkout_order->addOrderHistory( $order_number, $this->config->get ( 'traycheckout_order_processed' ), $comment, $update_status_alert );
				}
				break;
			case '7' :
			case '24' :
			case '89' :
				if ($order ['order_status_id'] != $this->config->get ( 'traycheckout_order_cancel' )) {
					$this->model_checkout_order->addOrderHistory( $order_number, $this->config->get ( 'traycheckout_order_cancel' ), $comment, $update_status_alert );
				}
				break;
			case '88' :
				//em recuperação
				$this->model_checkout_order->addOrderHistory( $order_number, $this->config->get ( 'traycheckout_order_failed' ), $comment, $update_status_alert );
				break;
		}
	
	}
	
	private function getOrderNumber($order) {
		
		$suffix = $this->config->get ( 'traycheckout_suffix' );
		
		if (($suffix != "")) {
			$order_exploded = explode ( '_', $order );
			return $order_exploded [0];
		} else {
			return $order;
		}
	
	}
	
	private function getResult($transaction_token) {
		
		$url = $this->urlGetByToken ();
		
		$request = array ("token" => trim ( $transaction_token ), "type_response" => "J" );
		
		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $request );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
		curl_setopt ( $ch, CURLOPT_FORBID_REUSE, 1 );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array ('Connection: Close' ) );
		
		if (! ($res = curl_exec ( $ch ))) {
			$this->httpError ( "Falha no curl: $urlPost" );
			curl_close ( $ch );
			exit ();
		}
		
		$httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		if ($httpCode != "200") {
			$this->httpError ( "Não foi possível conectar em: $urlPost" );
		}
		curl_close ( $ch );
		$arrResponse = json_decode ( $res, TRUE );
		return $arrResponse ['data_response'] ['transaction'];
		
	}
	
	/**
	 * Métod de retorno que indica algum erro de processamento - utilizado para notification
	 */
	private function httpError($msg) {
		
		header ( "HTTP/1.1 202 " );
		echo $msg;
		exit ();
		
	}
	
	private function urlGetByToken() {
		
		if (( int ) $this->config->get ( 'traycheckout_sandbox' ) == 1)
			$url = 'https://api.intermediador.sandbox.yapay.com.br/api/v1/transactions/get_by_token';
		else
			$url = 'https://api.intermediador.yapay.com.br/api/v1/transactions/get_by_token';
		
		return $url;
		
	}
	
	private function urlPost() {
		
		if (( int ) $this->config->get ( 'traycheckout_sandbox' ) == 1)
			$url = 'https://tc.intermediador.sandbox.yapay.com.br/payment/transaction';
		else
			$url = 'https://tc.intermediador.yapay.com.br/payment/transaction';
		
		return $url;
		
	}
}
?>