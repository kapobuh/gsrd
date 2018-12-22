<?php
class ControllerCommonSearch extends Controller {
    public $injured_array = array('1' => 'Спасено', '2' => 'Погибло');

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

        $data['incident_types'] = $this->getLists('incident_types');
        $data['psp_types'] = $this->getLists('psps');
        $data['locality_types'] = $this->getLists('localitys');

        if (isset($this->request->get['date_start'])) {
            $data['date_start'] = $this->session->data['date_start'];
        } else {
            $today = strtotime('-1 month');
            $date_start = date("d.m.Y", $today);
            $data['date_start'] = $date_start;
        }

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

        //$data['ajax_action'] = $this->url->link('common/search/getResults', 'token=' . $this->session->data['token']);
        $data['token'] = $this->session->data['token'];

        $this->document->addStyle('view/javascript/airdatetimepicker/css/datepicker.min.css');
        $this->document->addScript('view/javascript/airdatetimepicker/js/datepicker.min.js');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('common/search', $data));

    }

    public function getLists($type) {
        $this->load->model('common/lists');

        $result_data = array();

        switch ($type) {

            case "psps":
                //Виды ЧС
                $psps = $this->model_common_lists->getPsps();
                if ($psps) {
                    foreach ($psps as $psp) {
                        $result_data[] = array (
                            'psp_id' => $psp['psp_id'],
                            'name'       => $psp['name']
                        );
                    }
                } else {
                    $result_data = false;
                }
                break;

            case "incident_types":
                //Виды ЧС
                $incident_types = $this->model_common_lists->getIncidentTypes();
                if ($incident_types) {
                    foreach ($incident_types as $incident_type) {
                        $result_data[] = array (
                            'incidenttype_id' => $incident_type['incidenttype_id'],
                            'name'       => $incident_type['name']
                        );
                    }
                } else {
                    $result_data = false;
                }
                break;

            case "localitys":
                //Города и районы
                $localitys = $this->model_common_lists->getLocalitys();
                if ($localitys) {
                    foreach ($localitys as $locality) {
                        $result_data[] = array (
                            'locality_id' => $locality['locality_id'],
                            'name'       =>  $locality['name'],
                            'type'       =>  $locality['type'],
                        );
                    }
                } else {
                    $result_data = false;
                }
                break;

            case "equipments":
                //Оборудование
                $equipments = $this->model_common_lists->getEquipments();
                if ($equipments) {
                    foreach ($equipments as $equipment) {
                        $result_data[] = array (
                            'equipment_id' => $equipment['equipment_id'],
                            'name'       =>  $equipment['name']
                        );
                    }
                } else {
                    $result_data = false;
                }
                break;

            case "technics":
                //Техника
                $technics = $this->model_common_lists->getTechnics();
                if ($technics) {
                    foreach ($technics as $technic) {
                        $result_data[] = array (
                            'technic_type_id' => $technic['technic_id'],
                            'name'       =>  $technic['name']
                        );
                    }
                } else {
                    $result_data = false;
                }
                break;

            case "injureds":
                //Типы спасения
                $injureds = $this->model_common_lists->getInjureds();
                if ($injureds) {
                    foreach ($injureds as $injured) {
                        $result_data[] = array (
                            'injured_type_id' => $injured['injured_id'],
                            'name'       =>  $injured['name']
                        );
                    }
                } else {
                    $result_data = false;
                }
                break;

            case "participants":
                //Типы участника ПСР
                $participants = $this->model_common_lists->getParticipants();
                if ($participants) {
                    foreach ($participants as $participant) {
                        $result_data[] = array (
                            'participant_type_id' => $participant['participant_id'],
                            'name'       =>  $participant['name']
                        );
                    }
                } else {
                    $result_data = false;
                }
                break;

            default: $result_data = false;
        }

        return $result_data;

    }
    
    public function getResults () {


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

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $date_start = date("Y-m-d", strtotime($this->request->post['date_start']));
            $date_end = date("Y-m-d", strtotime($this->request->post['date_end']));

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

            $filter_data = array (
                'date_start' => $date_start,
                'date_end'   => $date_end,
                'incidents'  => $incidents,
                'localitys'  => $localitys,
                'psps'       => $psps
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

                $injured_totals = $this->model_common_psr->getInjuredsTotal('injured_totals', $filter_data);

                if ($injured_totals) {
                    foreach ($injured_totals as $injured_total) {
                        $data['injured_totals'][] = array (
                            'name'      =>  $this->injured_array[$injured_total['injured_type_id']],
                            'quantity'  =>  $injured_total['quantity']
                        );
                    }
                } else {
                    $data['injured_totals'] = false;
                }

                foreach ($results as $psr) {
                    $data['psrs'][] = array (
                        'psr_id'          =>  $psr['psr_id'],
                        'name'            =>  $this->language->get('psr_short_name'). $psr['psr_id'],
                        'address'         =>  $psr['city'] . ", " . $psr['street'] . ", " . $psr['house'],
                        'psp'             =>  $psr['psp_name'],
                        'date_added'      =>  date("d.m.Y", strtotime($psr['date_added']))
                    );
                }
            } else {
                $data['psrs'] = false;
                $data['injured_totals'] = false;
            }

            $this->response->setOutput($this->load->view('common/search_results', $data));

        }

    }

    public function getPsrInfo() {
        if (isset($this->request->get['psr_id'])) {

            $this->load->model('common/psr');

            $psr_info = $this->model_common_psr->getPsr($this->request->get['psr_id']);

            if ($psr_info) {

                $data['heading_title'] = 'Поисково спасательная работа №' . $psr_info['psr_id'];

                $data['locality'] = $psr_info['locality_name'];
                $data['address'] = $psr_info['street'].', '.$psr_info['house'].', '.$psr_info['appartment'];
                $data['date'] = $psr_info['date_start']. " - " . $psr_info['date_end'];

                $data['type'] = $psr_info['type_name'];

                if ($psr_info['technic']) {
                    $technics_list = $this->getLists('technics');
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
                    $equipments_list = $this->getLists('equipments');
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
                    foreach ($psr_info['participant'] as $participant) {

                        if ($participant['t'] == '1') {
                            $temp_type = 'Спасателей: ';
                        } else {
                            $temp_type = 'Общественников: ';
                        }


                        $data['participants'][] = array (
                            't'  =>  $temp_type,
                            'q'  =>  $participant['q']
                        );
                    }
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
                            'birthday'  => date("d.m.Y",strtotime($injured['birthday'])),
                            'save_type' => $temp_type
                        );
                    }
                } else {
                    $data['injureds'] = false;
                }


                $data['description'] = html_entity_decode($psr_info['description'], ENT_QUOTES, 'UTF-8');


            }

            $this->response->setOutput($this->load->view('common/psr_info', $data));

        }
    }






}
