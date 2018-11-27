<?php
class ControllerCommonFunctions extends Controller {

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
}
