<?php
class ControllerCommonSearch extends Controller {
    public $injured_array = array('1' => 'Спасено', '2' => 'Погибло');

    /**
     * Типы пострадавших для вывода
     * @var array
     */
    public $types_injured_in_incident = array (
        '1' => 'На воде',
        '3' => 'На бытовой основе',
        '4' => 'При пожаре',
        '9' => 'В лесу',
    );

    /**
     * Главная страница поиска информации о ПСР
     */
    public function index() {
        $this->load->model('common/psr');
        $this->load->language('common/search');

        $data = array ();

        $this->document->setTitle($this->language->get('heading_title'));

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_date_start'] = $this->language->get('text_date_start');
        $data['text_date_end'] = $this->language->get('text_date_end');
        $data['text_search'] = $this->language->get('text_search');
        $data['text_searching'] = $this->language->get('text_searching');
        $data['text_empty'] = $this->language->get('text_empty');
        $data['text_period'] = $this->language->get('text_period');
        $data['text_filter'] = $this->language->get('text_filter');
        $data['text_type'] = $this->language->get('text_type');
        $data['text_locality'] = $this->language->get('text_locality');
        $data['text_psp'] = $this->language->get('text_psp');
        $data['button_search'] = $this->language->get('button_search');

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

        $this->load->model('common/lists');
        $data['incident_types'] = $this->model_common_lists->getLists('incident_types');
        $data['psp_types'] = $this->model_common_lists->getLists('psps');
        $data['locality_types'] = $this->model_common_lists->getLists('localitys');
        $data['equipments'] = $this->model_common_lists->getLists('equipments');
        $data['technics'] = $this->model_common_lists->getLists('technics');

        if (isset($this->request->get['date_start'])) {
            $data['date_start'] = $this->session->data['date_start'];
        } else {
            $today = strtotime('-1 month');
            $date_start = date("d.m.Y", $today);
            $data['date_start'] = $date_start;
        } $data['date_start'] = '01.01.2000';

        if (isset($this->session->data['date_end'])) {
            $data['date_end'] = $this->session->data['date_end'];
        } else {
            $today = strtotime('-1 day');
            $date_end = date("d.m.Y", $today);
            $data['date_end'] = $date_end;
        }

        if (isset($this->session->data['incidents'])) {
            $data['incidents'] = $this->session->data['incidents'];
        } else {
            $data['incidents'] = array();
        }

        if (isset($this->session->data['localitys'])) {
            $data['localitys'] = $this->session->data['localitys'];
        } else {
            $data['localitys'] = array();
        }

        if (isset($this->session->data['psps'])) {
            $data['psps'] = $this->session->data['psps'];
        } else {
            $data['psps'] = array();
        }

        $data['token'] = $this->session->data['token'];

        $this->document->addStyle('view/javascript/airdatetimepicker/css/datepicker.min.css');
        $this->document->addScript('view/javascript/airdatetimepicker/js/datepicker.min.js');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('common/search', $data));

    }


    /**
     * Возвращает список ПСР
     * по заданным критериям поиска
     */
    public function getResults()
    {

        if (isset($this->request->post['date_start'])) {
            $this->session->data['date_start'] = $this->request->post['date_start'];
        }

        if (isset($this->request->post['date_end'])) {
            $this->session->data['date_end'] = $this->request->post['date_end'];
        }

        if (isset($this->request->post['incident'])) {
            $this->session->data['incidents'] = $this->request->post['incident'];
        }

        if (isset($this->request->post['locality'])) {
            $this->session->data['localitys'] = $this->request->post['locality'];
        }

        if (isset($this->request->post['incident'])) {
            $incidents = implode(",", $this->request->post['incident']);
        } else {
            $incidents = false;
        }

        if (isset($this->request->post['locality'])) {
            $localitys = implode(",", $this->request->post['locality']);
        } else {
            $localitys = false;
        }

        if (isset($this->request->post['psps'])) {
            $psps = implode(",", $this->request->post['psps']);
        } else {
            $psps = false;
        }

        $date_start = date("Y-m-d", strtotime($this->request->post['date_start']));
        $date_end = date("Y-m-d", strtotime($this->request->post['date_end']));

        $filter_data = array(
            'date_start' => $date_start,
            'date_end' => $date_end,
            'incidents' => $incidents,
            'localitys' => $localitys,
            'psps' => $psps
        );

        $data['token'] = $this->session->data['token'];

        $this->load->model('common/psr');
        $this->load->language('common/inbox');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_inbox_list_search'] = $this->language->get('text_inbox_list_search');
        $data['text_empty2'] = $this->language->get('text_empty2');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_address'] = $this->language->get('column_address');
        $data['column_psp'] = $this->language->get('column_psp');
        $data['column_date_added'] = $this->language->get('column_date_added');

        $results = $this->model_common_psr->getPsrs($filter_data, 1);

        if ($results) {

            $data['psrs_count'] = count($results);

            foreach ($results as $psr) {
                $data['psrs'][] = array(
                    'psr_id' => $psr['psr_id'],
                    'name' => $this->language->get('psr_short_name') . $psr['psr_id'],
                    'address' => $psr['city'] . ", " . $psr['street'] . ", " . $psr['house'],
                    'psp' => $psr['psp_name'],
                    'date_added' => date("d.m.Y", strtotime($psr['date_added'])),
                    'edit' => $this->url->link('common/psr/edit', 'psr_id=' . $psr['psr_id'] . '&token=' . $this->session->data['token'], true)
                );
            }

            // Получаем суммарные данные по результирующему списку
            $all_results = $this->model_common_psr->getPsrs($filter_data, 1, false);

            foreach ($all_results as $result) {
                $psr_ids[] = $result['psr_id'];
            }

            // Пострадавшие
            $injured_totals = $this->model_common_psr->getInjuredTotals($psr_ids);
            if ($injured_totals) {
                $data['count_injureds'] = 0;
                foreach ($injured_totals as $injured_total) {
                    $data['injured_totals'][] = array(
                        'type' => $this->types_injured_in_incident[$injured_total['type_id']],
                        'quantity' => $injured_total['quantity']
                    );
                    $data['count_injureds'] += $injured_total['quantity'];
                }
            } else {
                $data['injured_totals'] = false;
            }


        } else {
            $data['psrs'] = $data['count_injureds'] = $data['injured_totals'] = $data['psrs_count'] = false;

        }

        $this->response->setOutput($this->load->view('common/search_results', $data));
    }


    /**
     * Получаем информацию о ПСР
     */
    public function getPsrInfo() {
        if (isset($this->request->get['psr_id'])) {

            $this->load->model('common/psr');

            $psr_info = $this->model_common_psr->getPsr($this->request->get['psr_id']);

            if ($psr_info) {

                $data['heading_title'] = 'Поисково спасательная работа №' . $psr_info['psr_id'];
                $data['locality'] = $psr_info['locality_name'];
                $data['address'] = $psr_info['street'].', '.$psr_info['house'].', '.$psr_info['appartment'];
                $data['date'] = $psr_info['date_start'] . " - " . $psr_info['date_end'];
                $this->load->model('common/lists');
                $data['type'] = $psr_info['type_name'];

                if ($psr_info['technic']) {
                    $technics_list = $this->model_common_lists->getLists('technics');
                    foreach ($technics_list as $technic_list) {
                        foreach ($psr_info['technic'] as $technic_id) {
                            if ($technic_id['technic_id'] == $technic_list['technic_type_id']) {
                                $data['result_technic'][] = array (
                                    'name' => $technic_list['name'],
                                    'quantity' => $technic_id['quantity']
                                );
                            }
                        }
                    }
                }

                if ($psr_info['equipments']) {
                    $equipments_list = $this->model_common_lists->getLists('equipments');
                    foreach ($equipments_list as $equipment_list) {
                        foreach ($psr_info['equipments'] as $equipment) {
                            if ($equipment == $equipment_list['equipment_id']) {
                                $data['result_equipment'][] = array (
                                    'name' => $equipment_list['name'],
                                    'quantity' => $equipment
                                );
                            }
                        }
                    }
                } else {
                    $data['result_equipment'] = false;
                }

                if ($psr_info['participant']) {

                    $spasatels = 0;

                    foreach ($psr_info['participant'] as $participant) {

                        if ($participant['t'] == '1') {
                            $spasatels = $participant['q'];
                            $temp_type = 'Спасателей: ';
                        } else {
                            $temp_type = 'Общественников: ';
                        }


                        $data['participants'][] = array (
                            't'  =>  $temp_type,
                            'q'  =>  $participant['q']
                        );
                    }

                    $this->load->model('common/helpers');
                    $data['PeopleHoursWorks'] = $this->model_common_helpers->getPeopleHoursWorks($psr_info['date_start'], $psr_info['date_end'], $spasatels);
                }
                //print_r($psr_info['injured']);
                if (!empty($psr_info['injured'])) { // print_r($psr_info['injured']);
                    foreach ($psr_info['injured'] as $injured) {

                        if (!isset($injured['injured_type_id'])) {
                            $data['injureds'] = false;
                            break;
                        }

                        if ($injured['injured_type_id'] == '1') {
                            $temp_type = 'Спасен: ';
                        } else {
                            $temp_type = 'Погиб: ';
                        }
                        $data['injureds'][] = array (
                            'lastname'  => $injured['lastname'],
                            'firstname'  => $injured['firstname'],
                            'birthday'  => date("Y",strtotime($injured['birthday'])),
                            'save_type' => $temp_type
                        );
                    }
                } else {
                    $data['injureds'] = false;
                }

                $data['description'] = html_entity_decode($psr_info['description'], ENT_QUOTES, 'UTF-8');
            }

            $data['psr_id'] = $this->request->get['psr_id'];
            $this->response->setOutput($this->load->view('common/psr_info', $data));

        }
    }

}
