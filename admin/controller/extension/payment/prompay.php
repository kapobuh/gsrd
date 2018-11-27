<?php
class ControllerExtensionPaymentPrompay extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/payment/prompay');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('prompay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_testing'] = $this->language->get('entry_testing');
		
		
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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/prompay', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/prompay', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

				
		if (isset($this->request->post['prompay_status'])) {
			$data['prompay_status'] = $this->request->post['prompay_status'];
		} else {
			$data['prompay_status'] = $this->config->get('prompay_status');
		}
		
		if (isset($this->request->post['prompay_sort_order'])) {
			$data['prompay_sort_order'] = $this->request->post['prompay_sort_order'];
		} else {
			$data['prompay_sort_order'] = $this->config->get('prompay_sort_order');
		}
		
		if (isset($this->request->post['prompay_sort_order'])) {
			$data['prompay_testing'] = $this->request->post['prompay_testing'];
		} else {
			$data['prompay_testing'] = $this->config->get('prompay_testing');
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/prompay', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/prompay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}