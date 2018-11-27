<?php
class ControllerExtensionModuleSms extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/sms');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			//print_r($this->request->post);
			$this->model_setting_setting->editSetting('sms', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_login'] = $this->language->get('entry_login');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_service'] = $this->language->get('entry_service');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_spaceforce'] = $this->language->get('entry_spaceforce');
		$data['entry_space'] = $this->language->get('entry_space');
		$data['entry_ordersms'] = $this->language->get('entry_ordersms');
		
		$data['error_space'] = $this->language->get('error_space');
		$data['error_login'] = $this->language->get('error_login');
		$data['error_password'] = $this->language->get('error_password');
		
	

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Модули', //$this->language->get('text_shipping'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/module/sms', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);
		
		if (isset($this->request->post['sms_login'])) {
			$data['sms_login'] = $this->request->post['sms_login'];
		} else {
			$data['sms_login'] = $this->config->get('sms_login');
		} 
		
		if (isset($this->request->post['sms_password'])) {
			$data['sms_password'] = $this->request->post['sms_password'];
		} else {
			$data['sms_password'] = $this->config->get('sms_password');
		}

		if (isset($this->request->post['sms_service'])) {
			$data['sms_service'] = $this->request->post['sms_service'];
		} else {
			$data['sms_service'] = $this->config->get('sms_service');
		}


		if (isset($this->request->post['sms_spaceforce'])) {
			$data['sms_spaceforce'] = $this->request->post['sms_spaceforce'];
		} else {
			$data['sms_spaceforce'] = $this->config->get('sms_spaceforce');
		}
		
		if (isset($this->request->post['sms_space'])) {
			$data['sms_space'] = $this->request->post['sms_space'];
		} else {
			$data['sms_space'] = $this->config->get('sms_space');
		}


		if (isset($this->request->post['sms_status'])) {
			$data['sms_status'] = $this->request->post['sms_status'];
		} else {
			$data['sms_status'] = $this->config->get('sms_status');
		}
		
		if (isset($this->request->post['sms_ordersms'])) {
			$data['sms_ordersms'] = $this->request->post['sms_ordersms'];
		} else {
			$data['sms_ordersms'] = $this->config->get('sms_ordersms');
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/sms', $data));
	}

protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/flat2')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}