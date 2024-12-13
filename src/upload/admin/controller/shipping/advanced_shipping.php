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

			$this->response->redirect($this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('heading_title');

		$data['text_add_shipping'] = $this->language->get('text_add_shipping');
		$data['text_shipping'] = $this->language->get('text_shipping');
		$data['text_shippings'] = $this->language->get('text_shippings');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['entry_shipping_name'] = $this->language->get('entry_shipping_name');
		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_description'] = $this->language->get('entry_description');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$data['action'] = $this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');
		$this->load->model('localisation/geo_zone');
		$this->load->model('localisation/tax_class');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['current_language_id'] = $this->config->get('config_language_id');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$data['advanced_shipping_name'] = array();

		if (isset($this->request->post['advanced_shipping_name'])) {
			$data['advanced_shipping_name'] = $this->request->post['advanced_shipping_name'];
		} else {
			$data['advanced_shipping_name'] = $this->config->get('advanced_shipping_name');
		}

		if (empty($data['advanced_shipping_name'])) {
			$data['advanced_shipping_name'][$data['current_language_id']] = $this->language->get('text_module_title');
		}

		if (isset($this->request->post['advanced_shipping_cost'])) {
			$data['advanced_shipping_cost'] = $this->request->post['advanced_shipping_cost'];
		} else {
			$data['advanced_shipping_cost'] = $this->config->get('advanced_shipping_cost');
		}

		if (isset($this->request->post['advanced_shipping_data'])) {
			$data['advanced_shipping_data'] = $this->request->post['advanced_shipping_data'];
		} else {
			$data['advanced_shipping_data'] = $this->config->get('advanced_shipping_data');
		}

		if (empty($data['advanced_shipping_data'])) {
			$data['advanced_shipping_data'] = array();
		}

		if (isset($this->request->post['advanced_shipping_status'])) {
			$data['advanced_shipping_status'] = $this->request->post['advanced_shipping_status'];
		} else {
			$data['advanced_shipping_status'] = $this->config->get('advanced_shipping_status');
		}

		if (isset($this->request->post['advanced_shipping_sort_order'])) {
			$data['advanced_shipping_sort_order'] = $this->request->post['advanced_shipping_sort_order'];
		} else {
			$data['advanced_shipping_sort_order'] = $this->config->get('advanced_shipping_sort_order');
		}
		if (empty($data['advanced_shipping_sort_order'])) {
			$data['advanced_shipping_sort_order'] = 0;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if (version_compare('2.2', VERSION) <= 0) {

			foreach ($data['languages'] as $key => $language) {
				$data['languages'][$key]['html_image'] = '<img src="language/' . $language['code'] . '/' . $language['code'] . '.png" title="' . $language['name'] . '" />';
	  		}

			$this->response->setOutput($this->load->view('shipping/advanced_shipping', $data));
		}else{
			foreach ($data['languages'] as $key => $language) {
				$data['languages'][$key]['html_image'] = '<img src="view/image/flags/' . $language['image'] . '" title="' . $language['name'] . '" />';
	  		}

			$this->response->setOutput($this->load->view('shipping/advanced_shipping.tpl', $data));
		}

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