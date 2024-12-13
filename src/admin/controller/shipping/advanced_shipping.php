<?php
/**
 * @author Shashakhmetov Talgat <talgatks@gmail.com>
 */
class ControllerShippingAdvancedShipping extends Controller
{
    private $error = array();
    
    public function index()
    {
        $this->language->load('shipping/advanced_shipping');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('setting/setting');
        
        if (isset($this->request->get['store_id'])) {
            $this->data['selected_store_id'] = $this->request->get['store_id'];
        } else {
            $this->data['selected_store_id'] = 0;
        }
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            
            $this->data['selected_store_id'] = $this->request->post['selected_store_id'];
            
            unset($this->request->post['selected_store_id']);
            
            $this->model_setting_setting->editSetting('advanced_shipping', $this->request->post, $this->data['selected_store_id']);
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $this->redirect($this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'] . '&store_id=' . $this->data['selected_store_id'], 'SSL'));
        }
        
        $this->data['heading_title'] = $this->language->get('heading_title');
        
        $this->data['text_add_shipping'] = $this->language->get('text_add_shipping');
        $this->data['text_shipping']     = $this->language->get('text_shipping');
        $this->data['text_shippings']    = $this->language->get('text_shippings');
        
        $this->data['text_select_all']   = $this->language->get('text_select_all');
        $this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
        
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no']  = $this->language->get('text_no');
        
        $this->data['text_enabled']   = $this->language->get('text_enabled');
        $this->data['text_disabled']  = $this->language->get('text_disabled');
        $this->data['text_all_zones'] = $this->language->get('text_all_zones');
        $this->data['text_none']      = $this->language->get('text_none');
        
        $this->data['tab_common']   = $this->language->get('tab_common');
        $this->data['tab_price']    = $this->language->get('tab_price');
        $this->data['tab_weight']   = $this->language->get('tab_weight');
        $this->data['tab_quantity'] = $this->language->get('tab_quantity');
        $this->data['tab_customer'] = $this->language->get('tab_customer');
        
        $this->data['entry_name']              = $this->language->get('entry_name');
        $this->data['entry_cost']              = $this->language->get('entry_cost');
        $this->data['entry_tax_class']         = $this->language->get('entry_tax_class');
        $this->data['entry_geo_zone']          = $this->language->get('entry_geo_zone');
        $this->data['entry_status']            = $this->language->get('entry_status');
        $this->data['entry_sort_order']        = $this->language->get('entry_sort_order');
        $this->data['entry_replace_free']      = $this->language->get('entry_replace_free');
        $this->data['entry_replace_free_help'] = $this->language->get('entry_replace_free_help');
        $this->data['entry_currency']          = $this->language->get('entry_currency');
        $this->data['entry_weight_class']      = $this->language->get('entry_weight_class');
        
        $this->data['entry_customer_group']      = $this->language->get('entry_customer_group');
        $this->data['entry_customer_group_help'] = $this->language->get('entry_customer_group_help');
        
        $this->data['entry_shipping_name'] = $this->language->get('entry_shipping_name');
        $this->data['entry_cost']          = $this->language->get('entry_cost');
        $this->data['entry_description']   = $this->language->get('entry_description');
        
        $this->data['entry_price_range']             = $this->language->get('entry_price_range');
        $this->data['entry_price_range_help']        = $this->language->get('entry_price_range_help');
        $this->data['entry_price_range_description'] = $this->language->get('entry_price_range_description');
        
        $this->data['entry_weight_range']             = $this->language->get('entry_weight_range');
        $this->data['entry_weight_range_help']        = $this->language->get('entry_weight_range_help');
        $this->data['entry_weight_range_description'] = $this->language->get('entry_weight_range_description');
        
        $this->data['entry_quantity_range']             = $this->language->get('entry_quantity_range');
        $this->data['entry_quantity_range_help']        = $this->language->get('entry_quantity_range_help');
        $this->data['entry_quantity_range_description'] = $this->language->get('entry_quantity_range_description');
        
        $this->data['button_save']   = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        
        $this->data['breadcrumbs'] = array();
        
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_shipping'),
            'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
        $this->data['action'] = $this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'], 'SSL');
        
        $this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
        
        $this->data['token'] = $this->session->data['token'];
        
        $this->load->model('localisation/language');
        $this->load->model('localisation/geo_zone');
        $this->load->model('localisation/tax_class');
        $this->load->model('localisation/currency');
        $this->load->model('localisation/weight_class');
        $this->load->model('sale/customer_group');
        
        $this->data['languages'] = $this->model_localisation_language->getLanguages();
        
        $this->data['current_language_id'] = $this->config->get('config_language_id');
        
        $this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
        
        $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
        
        $customer_groups = $this->model_sale_customer_group->getCustomerGroups();
        
        $this->data['customer_groups'][] = array(
            'name' => $this->language->get('text_unregistered'),
            'customer_group_id' => null
        );
        
        foreach ($customer_groups as $key => $value) {
            $this->data['customer_groups'][] = $value;
        }
        
        $this->data['stores'][] = array(
            'store_id' => 0,
            'name' => $this->config->get('config_name') . $this->language->get('text_default'),
            'link' => $this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'] . '&store_id=0', 'SSL')
        );
        
        $this->load->model('setting/store');
        
        $results = $this->model_setting_store->getStores();
        
        foreach ($results as $result) {
            $this->data['stores'][] = array(
                'store_id' => $result['store_id'],
                'name' => $result['name'],
                'link' => $this->url->link('shipping/advanced_shipping', 'token=' . $this->session->data['token'] . '&store_id=' . $result['store_id'], 'SSL')
            );
        }
        
        $this->data['currencies'] = $this->model_localisation_currency->getCurrencies();
        
        $this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
        
        $setting = $this->model_setting_setting->getSetting('advanced_shipping', $this->data['selected_store_id']);
        
        if (isset($this->request->post['advanced_shipping_name'])) {
            $this->data['advanced_shipping_name'] = $this->request->post['advanced_shipping_name'];
        } elseif (isset($setting['advanced_shipping_name'])) {
            $this->data['advanced_shipping_name'] = $setting['advanced_shipping_name'];
        } else {
            $this->data['advanced_shipping_name'] = array();
            foreach ($this->data['languages'] as $key => $value) {
                $this->data['advanced_shipping_name'][$value['language_id']] = $this->language->get('text_module_title');
            }
        }
        
        if (isset($this->request->post['advanced_shipping_data'])) {
            $this->data['advanced_shipping_data'] = $this->request->post['advanced_shipping_data'];
        } elseif (isset($setting['advanced_shipping_data'])) {
            $this->data['advanced_shipping_data'] = $setting['advanced_shipping_data'];
        } else {
            $this->data['advanced_shipping_data'] = array();
        }
        
        if (isset($this->request->post['advanced_shipping_status'])) {
            $this->data['advanced_shipping_status'] = $this->request->post['advanced_shipping_status'];
        } elseif (isset($setting['advanced_shipping_status'])) {
            $this->data['advanced_shipping_status'] = $setting['advanced_shipping_status'];
        } else {
            $this->data['advanced_shipping_status'] = 1;
        }
        
        if (isset($this->request->post['advanced_shipping_sort_order'])) {
            $this->data['advanced_shipping_sort_order'] = $this->request->post['advanced_shipping_sort_order'];
        } elseif (isset($setting['advanced_shipping_sort_order'])) {
            $this->data['advanced_shipping_sort_order'] = $setting['advanced_shipping_sort_order'];
        } else {
            $this->data['advanced_shipping_sort_order'] = 0;
        }
        
        if (isset($this->request->post['advanced_shipping_replace_free'])) {
            $this->data['advanced_shipping_replace_free'] = $this->request->post['advanced_shipping_replace_free'];
        } elseif (isset($setting['advanced_shipping_replace_free'])) {
            $this->data['advanced_shipping_replace_free'] = $setting['advanced_shipping_replace_free'];
        } else {
            $this->data['advanced_shipping_replace_free'] = 1;
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
            'quantity_range' => array(
                0,
                0
            ),
            'weight_class_id' => 0,
            'sort_order' => 0,
            'customer_groups' => array()
        );
        
        foreach ($this->data['advanced_shipping_data'] as $key => $value) {
            foreach ($safe_migration as $key2 => $value2) {
                if (!isset($value[$key2])) {
                    $this->data['advanced_shipping_data'][$key][$key2] = $value2;
                }
            }
        }
        
        $this->template = 'shipping/advanced_shipping.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        
        $this->response->setOutput($this->render());
    }
    
    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'shipping/advanced_shipping')) {
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