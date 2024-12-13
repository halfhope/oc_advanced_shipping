<?php
/**
* @author Shashakhmetov Talgat <talgatks@gmail.com>
*/
class ControllerShippingAdvancedShipping extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('shipping/advanced_shipping');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('advanced_shipping', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_add_shipping'] = $this->language->get('text_add_shipping');
		$this->data['text_shipping'] = $this->language->get('text_shipping');
		$this->data['text_shippings'] = $this->language->get('text_shippings');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_cost'] = $this->language->get('entry_cost');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['entry_shipping_name'] = $this->language->get('entry_shipping_name');
		$this->data['entry_cost'] = $this->language->get('entry_cost');
		$this->data['entry_description'] = $this->language->get('entry_description');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->post['advanced_shipping_name'])) {
			$this->data['advanced_shipping_name'] = $this->request->post['advanced_shipping_name'];
		} else {
			$this->data['advanced_shipping_name'] = $this->config->get('advanced_shipping_name');
		}

		if (empty($this->data['advanced_shipping_name'])) {
			$this->data['advanced_shipping_name'] = $this->language->get('text_module_title');
		}

		if (isset($this->request->post['advanced_shipping_cost'])) {
			$this->data['advanced_shipping_cost'] = $this->request->post['advanced_shipping_cost'];
		} else {
			$this->data['advanced_shipping_cost'] = $this->config->get('advanced_shipping_cost');
		}

		if (isset($this->request->post['advanced_shipping_tax_class_id'])) {
			$this->data['advanced_shipping_tax_class_id'] = $this->request->post['advanced_shipping_tax_class_id'];
		} else {
			$this->data['advanced_shipping_tax_class_id'] = $this->config->get('advanced_shipping_tax_class_id');
		}

		if (isset($this->request->post['advanced_shipping_data'])) {
			$this->data['advanced_shipping_data'] = $this->request->post['advanced_shipping_data'];
		} else {
			$this->data['advanced_shipping_data'] = $this->config->get('advanced_shipping_data');
		} 

		if (empty($this->data['advanced_shipping_data'])) {
			$this->data['advanced_shipping_data'] = array();
		}
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->data['current_language_id'] = $this->config->get('config_language_id');
		
		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['advanced_shipping_geo_zone_id'])) {
			$this->data['advanced_shipping_geo_zone_id'] = $this->request->post['advanced_shipping_geo_zone_id'];
		} else {
			$this->data['advanced_shipping_geo_zone_id'] = $this->config->get('advanced_shipping_geo_zone_id');
		}
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['advanced_shipping_status'])) {
			$this->data['advanced_shipping_status'] = $this->request->post['advanced_shipping_status'];
		} else {
			$this->data['advanced_shipping_status'] = $this->config->get('advanced_shipping_status');
		}
		
		if (isset($this->request->post['advanced_shipping_sort_order'])) {
			$this->data['advanced_shipping_sort_order'] = $this->request->post['advanced_shipping_sort_order'];
		} else {
			$this->data['advanced_shipping_sort_order'] = $this->config->get('advanced_shipping_sort_order');
		}				
		if (empty($this->data['advanced_shipping_sort_order'])) {
			$this->data['advanced_shipping_sort_order'] = 0;
		}

		$this->template = 'shipping/advanced_shipping.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/advanced_shipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>