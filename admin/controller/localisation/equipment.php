<?php
class ControllerLocalisationEquipment extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('localisation/equipment');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('localisation/equipment');

        $this->getList();
    }

    public function add() {
        $this->load->language('localisation/equipment');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('localisation/equipment');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localisation_equipment->addEquipment($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('localisation/equipment', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('localisation/injured');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('localisation/equipment');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localisation_equipment->editEquipment($this->request->get['equipment_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('localisation/equipment', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('localisation/equipment');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('localisation/equipment');

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $equipment_id) {
                $this->model_localisation_equipment->deleteEquipment($equipment_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('localisation/equipment', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getList();
    }

    protected function getList() {

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('localisation/equipment', 'token=' . $this->session->data['token'] . $url, true)
        );

        $data['add'] = $this->url->link('localisation/equipment/add', 'token=' . $this->session->data['token'] . $url, true);
        $data['delete'] = $this->url->link('localisation/equipment/delete', 'token=' . $this->session->data['token'] . $url, true);

        $data['equipments'] = array();

        $filter_data = array(
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $equipment_total = $this->model_localisation_equipment->getTotalEquipments();

        $results = $this->model_localisation_equipment->getEquipments($filter_data);

        foreach ($results as $result) {
            $data['equipments'][] = array(
                'equipment_id' => $result['equipment_id'],
                'name'       => $result['name'],
                'edit'       => $this->url->link('localisation/equipment/edit', 'token=' . $this->session->data['token'] . '&equipment_id=' . $result['equipment_id'] . $url, true)
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_name'] = $this->language->get('column_name');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('localisation/order_status', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);

        $url = '';

        $pagination = new Pagination();
        $pagination->total = $equipment_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('localisation/equipment', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($equipment_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($equipment_total - $this->config->get('config_limit_admin'))) ? $equipment_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $equipment_total, ceil($equipment_total / $this->config->get('config_limit_admin')));

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('localisation/equipment_list', $data));
    }

    protected function getForm() {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['equipment_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        $data['entry_name'] = $this->language->get('entry_name');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('localisation/equipment', 'token=' . $this->session->data['token'] . $url, true)
        );

        if (!isset($this->request->get['equipment_id'])) {
            $data['action'] = $this->url->link('localisation/equipment/add', 'token=' . $this->session->data['token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('localisation/equipment/edit', 'token=' . $this->session->data['token'] . '&equipment_id=' . $this->request->get['equipment_id'] . $url, true);
        }

        $data['cancel'] = $this->url->link('localisation/equipment', 'token=' . $this->session->data['token'] . $url, true);

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['equipment'])) {
            $data['equipment'] = $this->request->post['equipment'];
        } elseif (isset($this->request->get['equipment_id'])) {
            $data['equipment'] = $this->model_localisation_equipment->getEquipmentDescriptions($this->request->get['equipment_id']);
        } else {
            $data['equipment'] = array();
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('localisation/equipment_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'localisation/equipment')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['equipment'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }
        }

        return !$this->error;
    }


}
