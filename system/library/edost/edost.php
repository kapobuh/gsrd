<?php
namespace edost;
class Edost {
	protected $params;
	private $data = array();
	
	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
	}
	
	
	
}