<?php
class ControllerCommonInbox extends Controller {

	public function index() {

        $this->load->language('common/inbox');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

    public function getList() {

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

	    $this->load->language('common/inbox');

	    $data['heading_title'] = $this->language->get('heading_title');
        $data['text_inbox_list'] = $this->language->get('text_inbox_list');
        $data['text_empty'] = $this->language->get('text_empty');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_address'] = $this->language->get('column_address');
        $data['column_psp'] = $this->language->get('column_psp');
        $data['column_date_added'] = $this->language->get('column_date_added');

	    $this->load->model('common/psr');

        $results = $this->model_common_psr->getPsrs(array(), 0);

	    if ($results) {
	        foreach ($results as $result) {
	            $data['psrs'][] = array (
	                'psr_id'          =>  $result['psr_id'],
                    'name'            =>  $this->language->get('psr_short_name'). $result['psr_id'],
                    'address'         =>  $result['city'] . ", " . $result['street'] . ", " . $result['house'],
                    'psp'             =>  $result['psp_name'],
                    'date_added'      =>  $result['date_added'],
                    'href'            =>  $this->url->link('common/psr/edit', 'token=' . $this->session->data['token'] .  '&psr_id=' . $result['psr_id'])
                );
            }
        } else {
	        $data['psrs'] = false;
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('common/inbox_psrs', $data));

    }


}
