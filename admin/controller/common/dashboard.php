<?php
class ControllerCommonDashboard extends Controller {
	public function index() {
		$this->load->language('common/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');





		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		//$this->response->setOutput($this->load->view('common/dashboard', $data));

        if ($this->user->getGroupid() == PSP_GROUP) {
            $this->response->redirect($this->url->link('common/rescuer', 'token='. $this->session->data['token']));
        } else {
            $this->response->redirect($this->url->link('common/search', 'token='. $this->session->data['token']));
        }

	}
}