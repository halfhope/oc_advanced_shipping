<?php
/**
* @author Shashakhmetov Talgat <talgatks@gmail.com>
*/
class ModelShippingAdvancedShipping extends Model {
	private $current_language_id;

	function getQuote($address) {
		$this->language->load('shipping/advanced_shipping');

		$method_data = array();

		$shippings = $this->config->get('advanced_shipping_data');

		$this->current_language_id = $this->config->get('config_language_id');

		$quote_data = array();

		foreach ($shippings as $key => $value) {

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$value['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

			if (!$value['geo_zone_id']) {
				$status = true;
			}elseif ($query->num_rows) {
				$status = true;
			}else{
				$status = false;
			}

			if ($status) {
	      		$quote_data['advanced_shipping' . $key] = array(
	        		'key'         =>  $key,
	        		'code'         => 'advanced_shipping.advanced_shipping' . $key,
	        		'title'        => html_entity_decode($value['name'][$this->current_language_id], ENT_QUOTES, 'UTF-8'),
	        		'description'  => html_entity_decode($value['description'][$this->current_language_id], ENT_QUOTES, 'UTF-8'),
	        		'cost'         => $value['cost'],
	        		'tax_class_id' => $value['tax_class_id'],
					'text'         => $this->currency->format($this->tax->calculate($value['cost'], $value['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
	      		);
			}
		}

		$module_title = $this->config->get('advanced_shipping_name');

		if (!empty($quote_data)) {
	  		$method_data = array(
	    		'code'       => 'advanced_shipping',
	    		'title'      => !empty($module_title[$this->current_language_id]) ? $module_title[$this->current_language_id] : $this->language->get('text_module_title'),
	    		'quote'      => $quote_data,
				'sort_order' => $this->config->get('advanced_shipping_sort_order'),
	    		'error'      => false
	  		);
		}

		return $method_data;
	}
}
?>