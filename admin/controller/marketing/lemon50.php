<?php
class ControllerMarketingLemon50 extends Controller {
	private $error = array();

	public function index() {
		
        $this->document->setTitle('Скидка 50% на лимон');

		$this->load->model('marketing/marketing');

		$this->getForm();
	}

	public function edit() {
		$this->load->language('marketing/marketing');

		$this->document->setTitle('Скидка 50% на лимон');

		$this->load->model('marketing/marketing');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
            $this->model_marketing_marketing->editSecondDiscLemon($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	protected function getForm() {
		$data['heading_title'] = 'Скидка 50% на лимон';

		$data['entry_status'] = 'Статус';

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = '';

        $data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['action'] = $this->url->link('marketing/lemon50/edit', 'token=' . $this->session->data['token'] . $url, true);

		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'] . $url, true);

		$data['token'] = $this->session->data['token'];

		$data['store'] = HTTP_CATALOG;

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		}  else {
			$data['status'] = $this->config->get('seconddisc_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketing/lemon50', $data));
	}

}