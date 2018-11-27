<?php
class Sms {
	private $link;
	private $login;
	private $pass;
	private $service;
	private $spaceforce;
	private $space;

	public function __construct($registry) {
		$this->config = $registry->get('config');
		
		$this->link = 'https://sms.e-vostok.ru';
		$this->login = $this->config->get('sms_login');
		$this->pass = $this->config->get('sms_password');
		$this->service = $this->config->get('sms_service');
		$this->spaceforce = $this->config->get('sms_spaceforce');
		$this->space = $this->config->get('sms_space');
	}

	public function send($text = 'TEST', $num = '+79670777794') {
		
		$url = $this->link;
		$url.= '/smsout.php?login='.$this->login.'&password='.$this->pass;
		$url.= '&service='.$this->service.'&space_force='.$this->spaceforce.'&space='.$this->space;
		$url.= '&subno='.urlencode($num).'&text='.urlencode($text);

		file_get_contents($url);
			
	}
	
	public function checkBalance() {
		
		$url = $this->link;
		$url.= '/checkbalance.php?login='.$this->login.'&password='.$this->pass;
		$url.= '&service='.$this->service;

		$res = file_get_contents($url);
		
		return $res;
			
	}
}