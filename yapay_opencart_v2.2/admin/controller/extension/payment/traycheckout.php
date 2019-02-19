<?php
class ControllerExtensionPaymentTrayCheckout extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language( 'payment/traycheckout' );
		
		$this->document->setTitle( $this->language->get('heading_title' ) );
		
		$this->load->model( 'setting/setting' );
		
		if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			
			$this->model_setting_setting->editSetting('traycheckout', $this->request->post );
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/payment','token=' . $this->session->data['token'], 'SSL'));
		}
		
        $langs = array(
                'heading_title', 'text_enabled', 'text_disabled', 'text_all_zones', 'text_none', 'text_yes', 'text_no',  
                'button_cancel', 'button_save', 'entry_token', 'entry_suffix', 'entry_order_status',
                'entry_order_pending', 'entry_order_cancel', 'entry_order_failed','entry_order_processing',
	        	'entry_order_process_alert', 'entry_order_processed', 'entry_geo_zone', 'entry_sandbox_attention',
	        	'entry_sandbox',  'entry_status', 'entry_sort_order', 'entry_update_status_alert',
	        	'help_token',  'help_suffix', 'help_order_pending', 'help_order_processing',
	        	'help_order_cancel',  'help_order_failed', 'help_order_processed', 'help_order_process_alert',
	        	'help_update_status_alert',  'help_sandbox_attention', 'help_sandbox'
        );

        foreach($langs as $value) {
            $data[$value] = $this->language->get($value);
        }
		
		
		if(isset( $this->error ['warning'] )) {
			$data['error_warning'] = $this->error ['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if(isset( $this->error ['token'] )) {
			$data['error_token'] = $this->error ['token'];
		} else {
			$data['error_token'] = '';
		}
		
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),  
				'text'      => $this->language->get('text_home'),
				'separator' => false
		);
		
		$data['breadcrumbs'][] = array(
				'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
				'text'      => $this->language->get('text_payment'),
				'separator' => ' :: '
		);
		
		$data['breadcrumbs'][] = array(
				'href'      => $this->url->link('extension/payment/traycheckout', 'token=' . $this->session->data['token'], 'SSL'),
				'text'      => $this->language->get('heading_title'),
				'separator' => ' :: '
		);
		
		$data['action'] = $this->url->link('extension/payment/traycheckout', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		
		if(isset( $this->request->post['traycheckout_token'] )) {
			$data['traycheckout_token'] = $this->request->post['traycheckout_token'];
		} else {
			$data['traycheckout_token'] = $this->config->get( 'traycheckout_token' );
		}
		
		if(isset( $this->request->post['traycheckout_suffix'] )) {
			$data['traycheckout_suffix'] = $this->request->post['traycheckout_suffix'];
		} else {
			$data['traycheckout_suffix'] = $this->config->get( 'traycheckout_suffix' );
		}
		
		if(isset( $this->request->post['traycheckout_update_status_alert'] )) {
			$data['traycheckout_update_status_alert'] = $this->request->post['traycheckout_update_status_alert'];
		} else {
			$data['traycheckout_update_status_alert'] = $this->config->get( 'traycheckout_update_status_alert' );
		}
		
		if(isset( $this->request->post['traycheckout_order_pending'] )) {
			$data['traycheckout_order_pending'] = $this->request->post['traycheckout_order_pending'];
		} else {
			$data['traycheckout_order_pending'] = $this->config->get( 'traycheckout_order_pending' );
		}
		
		if(isset( $this->request->post['traycheckout_order_processing'] )) {
			$data['traycheckout_order_processing'] = $this->request->post['traycheckout_order_processing'];
		} else {
			$data['traycheckout_order_processing'] = $this->config->get( 'traycheckout_order_processing' );
		}
		
		if(isset( $this->request->post['traycheckout_order_processed'] )) {
			$data['traycheckout_order_processed'] = $this->request->post['traycheckout_order_processed'];
		} else {
			$data['traycheckout_order_processed'] = $this->config->get( 'traycheckout_order_processed' );
		}
		
		if(isset( $this->request->post['traycheckout_order_cancel'] )) {
			$data['traycheckout_order_cancel'] = $this->request->post['traycheckout_order_cancel'];
		} else {
			$data['traycheckout_order_cancel'] = $this->config->get( 'traycheckout_order_cancel' );
		}
		
		if(isset( $this->request->post['traycheckout_order_failed'] )) {
			$data['traycheckout_order_failed'] = $this->request->post['traycheckout_order_failed'];
		} else {
			$data['traycheckout_order_failed'] = $this->config->get( 'traycheckout_order_failed' );
		}
		
		$this->load->model( 'localisation/order_status' );
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if(isset( $this->request->post['traycheckout_geo_zone_id'] )) {
			$data['traycheckout_geo_zone_id'] = $this->request->post['traycheckout_geo_zone_id'];
		} else {
			$data['traycheckout_geo_zone_id'] = $this->config->get( 'traycheckout_geo_zone_id' );
		}
		
		$this->load->model( 'localisation/geo_zone' );
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if(isset( $this->request->post ['traycheckout_status'] )) {
			$data['traycheckout_status'] = $this->request->post['traycheckout_status'];
		} else {
			$data['traycheckout_status'] = $this->config->get( 'traycheckout_status' );
		}
		
		if(isset( $this->request->post['traycheckout_sandbox'] )) {
			$data['traycheckout_sandbox'] = $this->request->post['traycheckout_sandbox'];
		} else {
			$data['traycheckout_sandbox'] = $this->config->get( 'traycheckout_sandbox' );
		}
		
		if(isset( $this->request->post['traycheckout_sort_order'] )) {
			$data['traycheckout_sort_order'] = $this->request->post['traycheckout_sort_order'];
			var_dump($data['traycheckout_sort_order']);
		} else {
			$data['traycheckout_sort_order'] = $this->config->get( 'traycheckout_sort_order' );
		}
		
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/traycheckout.tpl', $data));
		//$this->response->setOutput( $this->render( TRUE ), $this->config->get( 'config_compression' ) );
	}
	
	private function validate() {
		
		if(! $this->request->post['traycheckout_token']) {
			$this->error['token'] = $this->language->get( 'error_token' );
		}
		
		if(! $this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>