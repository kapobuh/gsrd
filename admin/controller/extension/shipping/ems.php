<?php
class ControllerExtensionShippingEms extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/ems');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ems', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_free_limit'] = $this->language->get('entry_free_limit');

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
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('shipping/ems', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/shipping/ems', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);
		
		if (isset($this->request->post['ems_cost'])) {
			$data['ems_cost'] = $this->request->post['ems_cost'];
		} else {
			$data['ems_cost'] = $this->config->get('ems_cost');
		}
		
		if (isset($this->request->post['ems_free_limit'])) {
			$data['ems_free_limit'] = $this->request->post['ems_free_limit'];
		} else {
			$data['ems_free_limit'] = $this->config->get('ems_free_limit');
		}

		if (isset($this->request->post['ems_tax_class_id'])) {
			$data['ems_tax_class_id'] = $this->request->post['ems_tax_class_id'];
		} else {
			$data['ems_tax_class_id'] = $this->config->get('ems_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['ems_geo_zone_id'])) {
			$data['ems_geo_zone_id'] = $this->request->post['ems_geo_zone_id'];
		} else {
			$data['ems_geo_zone_id'] = $this->config->get('ems_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['ems_status'])) {
			$data['ems_status'] = $this->request->post['ems_status'];
		} else {
			$data['ems_status'] = $this->config->get('ems_status');
		}

		if (isset($this->request->post['ems_sort_order'])) {
			$data['ems_sort_order'] = $this->request->post['ems_sort_order'];
		} else {
			$data['ems_sort_order'] = $this->config->get('ems_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/ems', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/ems')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}