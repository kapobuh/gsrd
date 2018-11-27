<?php
class ModelExtensionShippingShoplogisticscourier extends Model {
	function getQuote($address) {

		$this->language->load('extension/shipping/shoplogisticscourier');

		if ($this->config->get('shoplogisticscourier_status') == 1) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$quote_data = array();

			$weight = $this->cart->getWeight();

			if ($weight == 0) $weight = $this->config->get('shoplogisticscourier_weight');
			if ($weight == 0) $weight = 1;

            $city = $address['city'];
            if ($address['zone'] != '') $city .= ',' . $address['zone'];


			$xml = '<?xml version="1.0"?>';
            $xml .= "<request>";
            $xml .= "<function>get_delivery_price</function>";
            $xml .= "<api_id>".$this->config->get('shoplogisticscourier_api_id')."</api_id>";
            $xml .= "<from_city>".$this->config->get('shoplogisticscourier_from_city_code_id')."</from_city>";
            $xml .= "<to_city>".$city."</to_city>";
            $xml .= "<pickup_place>0</pickup_place>";
            $xml .= "<weight>".$weight."</weight>";
            $xml .= "<num>".$this->config->get('shoplogisticscourier_num')."</num>";
            $xml .= "<tarifs_type>1</tarifs_type>";
            $xml .= "<price_options>1</price_options>";
            $xml .= "<order_price>".$this->cart->getTotal()."</order_price>";
            $xml .= "<delivery_partner>".$this->config->get('shoplogisticscourier_partner')."</delivery_partner>";
            $xml .= "</request>";

			$res = $this->sendRequest($xml);

			try {
              $xml = new SimpleXMLElement($res);
            } catch (Exception $e) {
               return $method_data;
            }

			$price = (float)$xml->price;

			if ($xml->error_code > 0)
			  {
			  	return $method_data;
			  }


      		$title_text = $this->language->get('text_title');
      		$quote_data['shoplogisticscourier'] = array(
        		'code'         => 'shoplogisticscourier.shoplogisticscourier',
        		'title'        => $title_text,
        		'cost'         => $price,
        		'tax_class_id' => 0,
				'text'         => $this->currency->format($price, $this->session->data['currency'])

      		);

      		$method_data = array(
        		'code'       => 'shoplogisticscourier',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('shoplogisticscourier_sort_order'),
        		'error'      => false
      		);
		}

		return $method_data;
	}
  private function sendRequest($xml)
  {

  	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://client-shop-logistics.ru/index.php?route=deliveries/api');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($curl, CURLOPT_POSTFIELDS, 'xml='.urlencode(base64_encode($xml)));
    curl_setopt($curl, CURLOPT_USERAGENT, 'Opera 10.00');
    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }

}
?>