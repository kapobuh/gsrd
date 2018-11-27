<?php
class ControllerCommonPsr extends Controller {
    private $error = array();

	public function index() {
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->language('common/psr');

        $this->getForm();
    }

    public function add() {

        $this->load->language('common/psr');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateFrom())) {

            $this->load->model('common/psr');

            if ($this->user->getGroupId() === ADMIN_GROUP) {
                $this->request->post['moderated'] = 1;
            } else {
                $this->request->post['moderated'] = 0;
            }

            $this->model_common_psr->addPsr($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success_addpsr');

            $this->response->redirect($this->url->link('common/psr/add', 'token=' . $this->session->data['token'], true));

        } else {
            $this->getForm();
        }


    }

    public function edit() {

        $this->load->language('common/psr');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateFrom())) {

            $this->load->model('common/psr');

            if ($this->user->getGroupId() === ADMIN_GROUP) {
                $this->request->post['moderated'] = 1;
            } else {
                $this->request->post['moderated'] = 0;
            }

            $this->model_common_psr->editPsr($this->request->post, $this->request->get['psr_id']);

            $this->session->data['success'] = $this->language->get('text_success_addpsr');

            $this->response->redirect($this->url->link('common/psr/add', 'token=' . $this->session->data['token'], true));

        } else {
            $this->getForm();
        }


    }

	public function getForm() {

	    $data = array();

	    $data['text_type_psr'] = $this->language->get('text_type_psr');
        $data['text_psp'] = $this->language->get('text_psp');
        $data['text_locality'] = $this->language->get('text_locality');
        $data['text_address'] = $this->language->get('text_address');
        $data['text_street'] = $this->language->get('text_street');
        $data['text_house'] = $this->language->get('text_house');
        $data['text_appartment'] = $this->language->get('text_appartment');
        $data['text_date'] = $this->language->get('text_date');
        $data['text_date_start'] = $this->language->get('text_date_start');
        $data['text_date_end'] = $this->language->get('text_date_end');
        $data['text_participants'] = $this->language->get('text_participants');
        $data['text_equipment'] = $this->language->get('text_equipment');
        $data['text_technic'] = $this->language->get('text_technic');
        $data['text_injured'] = $this->language->get('text_injured');
        $data['text_add'] = $this->language->get('text_add');
        $data['text_add_line'] = $this->language->get('text_add_line');
        $data['text_lastname'] = $this->language->get('text_lastname');
        $data['text_firstname'] = $this->language->get('text_firstname');
        $data['text_birthday'] = $this->language->get('text_birthday');
        $data['text_description'] = $this->language->get('text_description');
        $data['text_save_button'] = $this->language->get('text_save_button');
        $data['text_none_injured'] = $this->language->get('text_none_injured');

        if (!isset($this->request->get['psr_id'])) {
            $data['action'] = $this->url->link('common/psr/add/', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('common/psr/edit/', 'token=' . $this->session->data['token'] . '&psr_id=' .$this->request->get['psr_id'], true);
        }

        $this->load->controller('common/functions');

        $data['incident_types'] = $this->getLists('incident_types');
        $data['localitys'] = $this->getLists('localitys');
        $data['equipment_types'] = $this->getLists('equipments');
        $data['technic_types'] = $this->getLists('technics');
        $data['injured_types'] = $this->getLists('injureds');
        $data['participant_types'] = $this->getLists('participants');

        if ($this->user->getGroupId() != PSP_GROUP) {
            $data['psps'] = $this->getLists('psps');
        } else {
            $data['psps'] = $this->getUserPsp($this->user->getId());
        }

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

        if (isset($this->error['street'])) {
            $data['error_street'] = $this->error['street'];
        } else {
            $data['error_street'] = false;
        }

        if (isset($this->error['house'])) {
            $data['error_house'] = $this->error['house'];
        } else {
            $data['error_house'] = array();
        }

        if (isset($this->error['date'])) {
            $data['error_date'] = $this->error['date'];
        } else {
            $data['error_date'] = array();
        }

        if (isset($this->error['participant'])) {
            $data['error_participant'] = $this->error['participant'];
        } else {
            $data['error_participant'] = false;
        }

        if (isset($this->error['technic'])) {
            $data['error_technic'] = $this->error['technic'];
        } else {
            $data['error_technic'] = false;
        }

        if (isset($this->error['description'])) {
            $data['error_description'] = $this->error['description'];
        } else {
            $data['error_description'] = false;
        }

        if (isset($this->error['injured'])) {
            $data['error_injured'] = $this->error['injured'];
        } else {
            $data['error_injured'] = false;
        }

        if (isset($this->request->get['psr_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->load->model('common/psr');
            $psr_info = $this->model_common_psr->getPsr($this->request->get['psr_id']);
        }

        if (isset($this->request->post['psp_id'])) {
            $data['psp_id'] = $this->request->post['psp_id'];
        } elseif (!empty($psr_info)) {
            $data['psp_id'] = $psr_info['psp_id'];
        } else {
            $data['psp_id'] = $this->getUserPsp();
        }

        if (isset($this->request->post['locality'])) {
            $data['locality_id'] = $this->request->post['locality'];
        } elseif (!empty($psr_info)) {
            $data['locality_id'] = $psr_info['locality'];
        } else {
            $data['locality_id'] = '0';
        }

        if (isset($this->request->post['type_id'])) {
            $data['type_id'] = $this->request->post['type_id'];
        } elseif (!empty($psr_info)) {
            $data['type_id'] = $psr_info['type_id'];
        } else {
            $data['type_id'] = '0';
        }

        if (isset($this->request->post['locality'])) {
            $data['locality'] = $this->request->post['locality'];
        } elseif (!empty($psr_info)) {
            $data['locality'] = $psr_info['locality'];
        } else {
            $data['locality'] = '0';
        }

        if (isset($this->request->post['street'])) {
            $data['street'] = $this->request->post['street'];
        } elseif (!empty($psr_info)) {
            $data['street'] = $psr_info['street'];
        } else {
            $data['street'] = '';
        }

        if (isset($this->request->post['house'])) {
            $data['house'] = $this->request->post['house'];
        } elseif (!empty($psr_info)) {
            $data['house'] = $psr_info['house'];
        } else {
            $data['house'] = '';
        }

        if (isset($this->request->post['appartment'])) {
            $data['appartment'] = $this->request->post['appartment'];
        } elseif (!empty($psr_info)) {
            $data['appartment'] = $psr_info['appartment'];
        } else {
            $data['appartment'] = '';
        }

        if (isset($this->request->post['date_start'])) {
            $data['date_start'] = $this->request->post['date_start'];
        } elseif (!empty($psr_info)) {
            $data['date_start'] = $psr_info['date_start'];
        } else {
            $data['date_start'] = '';
        }

        if (isset($this->request->post['date_end'])) {
            $data['date_end'] = $this->request->post['date_end'];
        } elseif (!empty($psr_info)) {
            $data['date_end'] = $psr_info['date_end'];
        } else {
            $data['date_end'] = '';
        }

        if (isset($this->request->post['participant'])) {
            $data['participants'] = $this->request->post['participant'];
        } elseif (!empty($psr_info)) {
            $data['participants'] = $psr_info['participant'];
        } else {
            $data['participants'] = array( array ('t' => '0', 'q' => '1'));
        }

        if (isset($this->request->post['equipment'])) {
            $data['equipments'] = $this->request->post['equipment'];
        } elseif (!empty($psr_info)) {
            $data['equipments'] = $psr_info['equipments'];
        } else {
            $data['equipments'] = array();
        }

        if (isset($this->request->post['technic'])) {
            $data['technics'] = $this->request->post['technic'];
        } elseif (!empty($psr_info)) {
            $data['technics'] = $psr_info['technic'];
        } else {
            $data['technics'] = array(array ('type_id' => '0', 'quantity' => '1'));
        }

        if (isset($this->request->post['injured'])) {
            $data['injureds'] = $this->request->post['injured'];
        } elseif (!empty($psr_info)) {
            $data['injureds'] = $psr_info['injured'];
        } else {
            $data['injureds'] = array(array ('type_id' => '0', 'lastname' => '', 'firstname' => '', 'birthday' => ''));
        }

        if (isset($this->request->post['none_injured'])) {
            $data['none_injured'] = $this->request->post['none_injured'];
        } else {
            $data['none_injured'] = false;
        }

        if (isset($this->request->post['description'])) {
            $data['description'] = $this->request->post['description'];
        } elseif (!empty($psr_info)) {
            $data['description'] = $psr_info['description'];
        } else {
            $data['description'] = '';
        }

        $this->document->addStyle('view/javascript/airdatetimepicker/css/datepicker.min.css');
        $this->document->addScript('view/javascript/airdatetimepicker/js/datepicker.min.js');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('common/psr_form', $data));


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

	public function validateFrom() {
        if (!$this->user->hasPermission('modify', 'common/psr')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['street']) < 3) || (utf8_strlen($this->request->post['street']) > 255)) {
            $this->error['street'] = $this->language->get('error_street');
        }

        if ((utf8_strlen($this->request->post['house']) < 1) || (utf8_strlen($this->request->post['house']) > 255)) {
            $this->error['house'] = $this->language->get('error_house');
        }

        if ((utf8_strlen($this->request->post['date_start']) < 3) || (utf8_strlen($this->request->post['date_start']) > 255)) {
            $this->error['date'] = $this->language->get('error_date');
        }

        if ((utf8_strlen($this->request->post['date_end']) < 3) || (utf8_strlen($this->request->post['date_end']) > 255)) {
            $this->error['date'] = $this->language->get('error_date');
        }

        if (utf8_strlen($this->request->post['description']) < 3) {
            $this->error['description'] = $this->language->get('error_description');
            echo utf8_strlen($this->request->post['description']);
        }

        $have_spasatel = false;
        foreach ($this->request->post['participant'] as $participant) {

            if (($participant['q'] == '0') and ($participant['t'] == SPASATEL_TYPE)) {
                $this->error['participant'] = $this->language->get('error_participant');
            }

            if ($participant['t'] == SPASATEL_TYPE) {
                $have_spasatel = true;
            }
        }

        if (!$have_spasatel) {
            $this->error['participant'] = $this->language->get('error_participant');
        }

        if (!isset($this->request->post['none_injured'])) {
            foreach ($this->request->post['injured'] as $injured) {
                if ((utf8_strlen($injured['firstname']) < 2) || (utf8_strlen($injured['firstname']) > 255)) {
                    $this->error['injured'] = $this->language->get('error_injured');
                }

                if ((utf8_strlen($injured['lastname']) < 2) || (utf8_strlen($injured['lastname']) > 255)) {
                    $this->error['injured'] = $this->language->get('error_injured');
                }

                if ((utf8_strlen($injured['birthday']) < 2) || (utf8_strlen($injured['birthday']) > 255)) {
                    $this->error['injured'] = $this->language->get('error_injured');
                }
            }
        }

        return !$this->error;


    }

    public function getUserPsp() {
	    $this->load->model('common/users');

	    $result = $this->model_common_users->getUserPsp($this->user->getId());

	    return $result;
    }

}
