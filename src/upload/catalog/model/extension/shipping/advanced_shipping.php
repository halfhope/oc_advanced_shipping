<?php
/**
 * @author Shashakhmetov Talgat <talgatks@gmail.com>
 */
class ModelExtensionShippingAdvancedShipping extends Model
{
	private $current_language_id;

	function getQuote($address)
	{
		$this->language->load('extension/shipping/advanced_shipping');

		$method_data = array();

		$shippings = $this->config->get('shipping_advanced_shipping_data');

		$this->current_language_id = $this->config->get('config_language_id');

		$quote_data = array();

		$customer_group_id = $this->customer->getGroupId();

		$weight = $this->cart->getWeight();

		$sub_total = $this->cart->getSubTotal();

		foreach ($shippings as $key => $value) {

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $value['geo_zone_id'] . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

			// Geo zone
			if (!$value['geo_zone_id']) {
				$status = true;
			} elseif ($query->num_rows) {
				$status = true;
			} else {
				$status = false;
			}

			// price range
			if (isset($value['price_range'])) {
				$min = $value['price_range'][0];
				$max = $value['price_range'][1];

				if ($min || $max) {
					if ($value['currency'] == $this->session->data['currency']) {
						$price_status = $this->withinRange($sub_total, $min, $max);
					} else {
						$price_status = $this->withinRange($this->currency->convert($sub_total, $this->session->data['currency'], $value['currency']), $min, $max);
					}
				} else {
					$price_status = true;
				}

			} else {
				$price_status = true;
			}

			// weight range
			if (isset($value['weight_range'])) {
				$min = $value['weight_range'][0];
				$max = $value['weight_range'][1];

				if ($min || $max) {
					if ($value['weight_class_id'] == $this->config->get('config_weight_class_id')) {
						$weight_status = $this->withinRange($weight, $min, $max);
					} else {
						$weight_status = $this->withinRange($this->weight->convert($weight, $this->config->get('config_weight_class_id'), $value['weight_class_id']), $min, $max);
					}
				} else {
					$weight_status = true;
				}

			} else {
				$weight_status = true;
			}

			// customer group
			if ((isset($value['customer_groups']) && in_array($customer_group_id, $value['customer_groups'])) || !isset($value['customer_groups']) || empty($value['customer_groups'])) {
				$customer_status = true;
			} else {
				$customer_status = false;
			}

			if ($status && $price_status && $weight_status && $customer_status) {

				$tax_class_id = isset($value['tax_class_id']) ? $value['tax_class_id'] : 0;

				$quote_data['advanced_shipping' . $key] = array(
					'key' => $key,
					'code' => 'advanced_shipping.advanced_shipping' . $key,
					'title' => html_entity_decode($value['name'][$this->current_language_id], ENT_QUOTES, 'UTF-8'),
					'description' => html_entity_decode($value['description'][$this->current_language_id], ENT_QUOTES, 'UTF-8'),
					'cost' => $value['cost'],
					'tax_class_id' => $tax_class_id,
					'text' => $this->currency->format($this->tax->calculate($value['cost'], $tax_class_id, $this->config->get('config_tax')), $this->session->data['currency'])
				);
			}
		}

		$module_title = $this->config->get('advanced_shipping_name');

		if (!empty($quote_data)) {
			$method_data = array(
				'code' => 'advanced_shipping',
				'title' => !empty($module_title[$this->current_language_id]) ? $module_title[$this->current_language_id] : $this->language->get('text_module_title'),
				'quote' => $quote_data,
				'sort_order' => $this->config->get('advanced_shipping_sort_order'),
				'error' => false
			);
		}

		return $method_data;
	}

	private function withinRange($val, $min, $max, $inclusive = true)
	{
		if ($min == 0 && $max == 0) {
			return true;
		} elseif ($min == 0) {
			return $inclusive ? ($val <= $max) : ($val < $max);
		} elseif ($max == 0) {
			return $inclusive ? ($val >= $min) : ($val > $min);
		} else {
			return $inclusive ? ($val >= $min && $val <= $max) : ($val > $min && $val < $max);
		}
	}

}
?>