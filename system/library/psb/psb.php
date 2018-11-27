<?php
namespace psb;
class Psb {
	protected $params;
	private $data = array();
	
	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
	}
	
	public function getForm($trtype, $order_id, $from_account = false) {
		
		// Параметры подключения
		$this->params = include(DIR_SYSTEM.'/library/psb/config.php');	
		
		$nonce = strtoupper(dechex(rand(999999999999999999, 9999999999999999999))).strtoupper(dechex(rand(999999999999999999, 9999999999999999999)));
		
		// Если заказ оплачивается через ЛК, возвращаем клиента на страницу заказа
		if ($from_account) {
			$backref = $this->params['site'].'/index.php?route=account/order/info&order_id='.$order_id[3].$order_id[4].$order_id[5];
		} else {
			$backref = $this->params['backref'];
		}
		
		// Формируем строку для HMAC
		$hmac_data = strlen($this->getOrderTotal($order_id)).$this->getOrderTotal($order_id);
		$hmac_data.= strlen(strtoupper($this->session->data['currency'])).strtoupper($this->session->data['currency']);
		$hmac_data.= strlen($order_id).$order_id;
		$hmac_data.= strlen($this->config->get('config_name')).$this->config->get('config_name');
		$hmac_data.= strlen($this->params['merchant']).$this->params['merchant'];
		$hmac_data.= strlen($this->params['terminal']).$this->params['terminal'];
		$hmac_data.= strlen($this->config->get('config_email')).$this->config->get('config_email');
		$hmac_data.= strlen($trtype).$trtype;
		$hmac_data.= strlen(gmdate("YmdHis")).gmdate("YmdHis");
		$hmac_data.= strlen($nonce).strtoupper($nonce);
		$hmac_data.= strlen($backref).$backref;
		
		$hmac = hash_hmac('sha1', $hmac_data, pack('H*', $this->params['key']));
		
		return array (
			'amount'		=>	$this->getOrderTotal($order_id), //$this->cart->getTotal(),
			'currency'		=> 	$this->session->data['currency'],
			'order'			=>	$order_id,
			'desc'			=>	$this->params['desc'].$order_id,
			'terminal'		=>	$this->params['terminal'],
			'trtype'		=>	$trtype,
			'merch_name'	=>	$this->config->get('config_name'),
			'merchant'		=>	$this->params['merchant'],
			'email'			=>	$this->config->get('config_email'),
			'timestamp'		=>	gmdate("YmdHis"),
			'nonce'			=>	$nonce,
			'backref'		=>	$backref,
			'p_sign'		=> 	$hmac
		);
		
	}
	
	
	// Запрос типа запроса (тестовый/боевой)
	public function getAction($test) {
		// Параметры подключения
		$this->params = include(DIR_SYSTEM.'library/psb/config.php');	
		if ($test) {
			return $this->params['link_test'];
		} else {
			return $this->params['link'];
		}
		
	}
	
	public function getOrderTotal($order_id) {
		$query = $this->db->query("SELECT total FROM ".DB_PREFIX."order WHERE order_id = '".$order_id."'");
		
		return $query->row['total'];
	}
	
}