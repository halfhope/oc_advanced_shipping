<?php
/**
 * @author Shashakhmetov Talgat <talgatks@gmail.com>
 */
class ControllerExtensionShippingAdvancedShipping extends Controller
{
	private $error = array();

	public function index()
	{
		$this->language->load('extension/shipping/advanced_shipping');

		$this->document->setTitle($this->language->get('heading_title'));

		//CKEditor
		$data['ckeditor'] = $this->config->get('config_editor_default');

		if ($data['ckeditor']) {
			$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
			$this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
		} else {
			$this->document->addScript('view/javascript/summernote/summernote.js');
			$this->document->addScript('view/javascript/summernote/opencart.js');
			$this->document->addStyle('view/javascript/summernote/summernote.css');
		}


		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('shipping_advanced_shipping', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping/advanced_shipping', 'user_token=' . $this->session->data['user_token'], 'SSL'));
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
		$data['text_shipping']     = $this->language->get('text_shipping');
		$data['text_shippings']    = $this->language->get('text_shippings');

		$data['text_select_all']   = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['text_enabled']   = $this->language->get('text_enabled');
		$data['text_disabled']  = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none']      = $this->language->get('text_none');

		$data['tab_common']   = $this->language->get('tab_common');
		$data['tab_price']    = $this->language->get('tab_price');
		$data['tab_weight']   = $this->language->get('tab_weight');
		$data['tab_customer'] = $this->language->get('tab_customer');

		$data['entry_name']         = $this->language->get('entry_name');
		$data['entry_cost']         = $this->language->get('entry_cost');
		$data['entry_tax_class']    = $this->language->get('entry_tax_class');
		$data['entry_geo_zone']     = $this->language->get('entry_geo_zone');
		$data['entry_status']       = $this->language->get('entry_status');
		$data['entry_sort_order']   = $this->language->get('entry_sort_order');
		$data['entry_currency']     = $this->language->get('entry_currency');
		$data['entry_weight_class'] = $this->language->get('entry_weight_class');

		$data['entry_customer_group']      = $this->language->get('entry_customer_group');
		$data['entry_customer_group_help'] = $this->language->get('entry_customer_group_help');

		$data['entry_shipping_name'] = $this->language->get('entry_shipping_name');
		$data['entry_cost']          = $this->language->get('entry_cost');
		$data['entry_description']   = $this->language->get('entry_description');
		$data['entry_price_range']   = $this->language->get('entry_price_range');
		$data['entry_price_range_help']   = $this->language->get('entry_price_range_help');
		$data['entry_weight_range']  = $this->language->get('entry_weight_range');
		$data['entry_weight_range_help']  = $this->language->get('entry_weight_range_help');

		$data['button_save']   = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping/advanced_shipping', 'user_token=' . $this->session->data['user_token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('extension/shipping/advanced_shipping', 'user_token=' . $this->session->data['user_token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'], 'SSL');

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');
		$this->load->model('localisation/geo_zone');
		$this->load->model('localisation/tax_class');
		$this->load->model('localisation/currency');
		$this->load->model('localisation/weight_class');
		$this->load->model('customer/customer_group');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['current_language_id'] = $this->config->get('config_language_id');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$customer_groups = $this->model_customer_customer_group->getCustomerGroups();

		//add unregistered users
		$data['customer_groups'][] = array(
			'name' => $this->language->get('text_unregistered'),
			'customer_group_id' => null
		);

		foreach ($customer_groups as $key => $value) {
			$data['customer_groups'][] = $value;
		}
		// end add
		// getCurrencies
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		$data['shipping_advanced_shipping_name'] = array();

		if (isset($this->request->post['shipping_advanced_shipping_name'])) {
			$data['shipping_advanced_shipping_name'] = $this->request->post['shipping_advanced_shipping_name'];
		} else {
			$data['shipping_advanced_shipping_name'] = $this->config->get('shipping_advanced_shipping_name');
		}

		if (empty($data['shipping_advanced_shipping_name'])) {
			$data['shipping_advanced_shipping_name'][$data['current_language_id']] = $this->language->get('text_module_title');
		}

		if (isset($this->request->post['shipping_advanced_shipping_cost'])) {
			$data['shipping_advanced_shipping_cost'] = $this->request->post['shipping_advanced_shipping_cost'];
		} else {
			$data['shipping_advanced_shipping_cost'] = $this->config->get('shipping_advanced_shipping_cost');
		}

		if (isset($this->request->post['shipping_advanced_shipping_data'])) {
			$data['shipping_advanced_shipping_data'] = $this->request->post['shipping_advanced_shipping_data'];
		} else {
			$data['shipping_advanced_shipping_data'] = $this->config->get('shipping_advanced_shipping_data');
		}

		if (empty($data['shipping_advanced_shipping_data'])) {
			$data['shipping_advanced_shipping_data'] = array();
		}

		if (isset($this->request->post['shipping_advanced_shipping_status'])) {
			$data['shipping_advanced_shipping_status'] = $this->request->post['shipping_advanced_shipping_status'];
		} else {
			$data['shipping_advanced_shipping_status'] = $this->config->get('shipping_advanced_shipping_status');
		}

		if (isset($this->request->post['shipping_advanced_shipping_sort_order'])) {
			$data['shipping_advanced_shipping_sort_order'] = $this->request->post['shipping_advanced_shipping_sort_order'];
		} else {
			$data['shipping_advanced_shipping_sort_order'] = $this->config->get('shipping_advanced_shipping_sort_order');
		}
		if (empty($data['shipping_advanced_shipping_sort_order'])) {
			$data['shipping_advanced_shipping_sort_order'] = 0;
		}

		$safe_migration = array(
			'price_range' => array(
				0,
				0
			),
			'currency' => 0,
			'weight_range' => array(
				0,
				0
			),
			'weight_class_id' => 0,
			'customer_groups' => array()
		);

		foreach ($data['shipping_advanced_shipping_data'] as $key => $value) {
			foreach ($safe_migration as $key2 => $value2) {
				if (!isset($value[$key2])) {
					$data['shipping_advanced_shipping_data'][$key][$key2] = $value2;
				}
			}
		}

		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');

		foreach ($data['languages'] as $key => $language) {
			$data['languages'][$key]['html_image'] = '<img src="language/' . $language['code'] . '/' . $language['code'] . '.png" title="' . $language['name'] . '" />';
		}

		$this->response->setOutput($this->load->view('extension/shipping/advanced_shipping', $data));

	}

	protected function validate()
	{
		if (!$this->user->hasPermission('modify', 'extension/shipping/advanced_shipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (count($this->request->post, COUNT_RECURSIVE) >= ini_get('max_input_vars')) {
			$this->error['warning'] = $this->language->get('error_max_input_vars');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>