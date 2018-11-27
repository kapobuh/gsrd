<?php

/*
@author
@link    http://www.simpleopencart.com
*/

class ControllerExtensionShippingShoplogisticscourier extends Controller {
    private $error = array();

    private function load_language($path) {
        $language = $this->language;
        if (isset($language) && method_exists($language, 'load')) {
            $this->language->load($path);
            unset($language);
            return;
        }

        $load = $this->load;
        if (isset($load) && method_exists($load, 'language')) {
            $this->load->language($path);
            unset($load);
            return;
        }
    }

    public function index() {
        $this->load_language('extension/shipping/shoplogisticscourier');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->model_setting_setting->editSetting('shoplogisticscourier', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true));
        }

        $data['heading_title']       = $this->language->get('heading_title');

        $data['text_enabled']        = $this->language->get('text_enabled');
        $data['text_disabled']       = $this->language->get('text_disabled');
        $data['text_yes']            = $this->language->get('text_yes');
        $data['text_no']             = $this->language->get('text_no');
        $data['text_edit']             = $this->language->get('text_edit');



        $data['entry_api_id'] = $this->language->get('entry_api_id');
        $data['entry_from_city_code_id'] = $this->language->get('entry_from_city_code_id');
        $data['entry_weight'] = $this->language->get('entry_weight');
        $data['entry_num'] = $this->language->get('entry_num');
        $data['entry_partner'] = $this->language->get('entry_partner');

        $data['entry_status']        = $this->language->get('entry_status');
        $data['entry_sort_order']    = $this->language->get('entry_sort_order');

        $data['text_titlem']    = $this->language->get('text_titlem');

        $data['button_save']         = $this->language->get('button_save');
        $data['button_cancel']       = $this->language->get('button_cancel');

        $data['tab_general']         = $this->language->get('tab_general');

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
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping/shoplogisticscourier', 'token=' . $this->session->data['token'], true)
		);



        $data['action'] = HTTPS_SERVER . 'index.php?route=extension/shipping/shoplogisticscourier&token=' . $this->session->data['token'];

        $data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/shipping&token=' . $this->session->data['token'];

        if (isset($this->request->post['shoplogisticscourier_api_id'])) {
            $data['shoplogisticscourier_api_id'] = $this->request->post['shoplogisticscourier_api_id'];
        } else {
            $data['shoplogisticscourier_api_id'] = $this->config->get('shoplogisticscourier_api_id');
        }

        if (isset($this->request->post['shoplogisticscourier_from_city_code_id'])) {
            $data['shoplogisticscourier_from_city_code_id'] = $this->request->post['shoplogisticscourier_from_city_code_id'];
        } else {
            $data['shoplogisticscourier_from_city_code_id'] = $this->config->get('shoplogisticscourier_from_city_code_id');
        }

        if (isset($this->request->post['shoplogisticscourier_weight'])) {
            $data['shoplogisticscourier_weight'] = $this->request->post['shoplogisticscourier_weight'];
        } else {
            $data['shoplogisticscourier_weight'] = $this->config->get('shoplogisticscourier_weight');
        }

        if (isset($this->request->post['shoplogisticscourier_num'])) {
            $data['shoplogisticscourier_num'] = $this->request->post['shoplogisticscourier_num'];
        } else {
            $data['shoplogisticscourier_num'] = $this->config->get('shoplogisticscourier_num');
        }

        if (isset($this->request->post['shoplogisticscourier_partner'])) {
            $data['shoplogisticscourier_partner'] = $this->request->post['shoplogisticscourier_partner'];
        } else {
            $data['shoplogisticscourier_partner'] = $this->config->get('shoplogisticscourier_partner');
        }

        if (isset($this->request->post['shoplogisticscourier_status'])) {
            $data['shoplogisticscourier_status'] = $this->request->post['shoplogisticscourier_status'];
        } else {
            $data['shoplogisticscourier_status'] = $this->config->get('shoplogisticscourier_status');
        }

        if (isset($this->request->post['shoplogisticscourier_sort_order'])) {
            $data['shoplogisticscourier_sort_order'] = $this->request->post['shoplogisticscourier_sort_order'];
        } else {
            $data['shoplogisticscourier_sort_order'] = $this->config->get('shoplogisticscourier_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/shoplogisticscourier', $data));

    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/shoplogisticscourier')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
?>