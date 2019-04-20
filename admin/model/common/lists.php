<?php
class ModelCommonLists extends Model {
    public function getIncidentTypes() {
        $query = $this->db->query("SELECT * FROM ". DB_PREFIX. "incident_type ORDER BY `name`");
        return $query->rows;
    }

    public function getLocalitys() {
        $query = $this->db->query("SELECT * FROM ". DB_PREFIX. "locality l WHERE  l.type IN ('".DISTRICT_LOCALITY_TYPE."','".CITY_LOCALITY_TYPE."')  ORDER BY `name`");
        return $query->rows;
    }

    public function getEquipments() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "equipment ORDER BY `name`");
        return $query->rows;
    }

    public function getTechnics() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "technic ORDER BY `name`");
        return $query->rows;
    }

    public function getInjureds() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "injured ORDER BY `name`");
        return $query->rows;
    }

    public function getParticipants() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "participant ORDER BY `name`");
        return $query->rows;
    }

    public function getPsps() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "psp ORDER BY `name`");
        return $query->rows;
    }

    public function getInboxCount() {
        $query = $this->db->query("SELECT COUNT(psr_id) as total FROM " . DB_PREFIX . "psr WHERE moderated = '0'");
        return $query->row['total'];
    }

    public function getDistrictList() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "locality WHERE `type` = 'R'");
        return $query->rows;
    }


    public function getLists($type) {

        switch ($type) {

            case "psps":
                //Виды ЧС
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "psp ORDER BY `name`");
                if ($query->num_rows) {
                    foreach ($query->rows as $psp) {
                        $result_data[] = array (
                            'psp_id' => $psp['psp_id'],
                            'name' => $psp['name']
                        );
                    }
                } else {
                    $result_data = false;
                }
                break;

            case "incident_types":
                //Виды ЧС
                $query = $this->db->query("SELECT * FROM ". DB_PREFIX. "incident_type ORDER BY `name`");
                if ($query->num_rows) {
                    foreach ($query->rows as $incident_type) {
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
                $query = $this->db->query("SELECT * FROM ". DB_PREFIX. "locality l WHERE  l.type IN ('".DISTRICT_LOCALITY_TYPE."','".CITY_LOCALITY_TYPE."')  ORDER BY `name`");
                if ($query->num_rows) {
                    foreach ($query->rows as $locality) {
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
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "equipment ORDER BY `name`");
                if ($query->num_rows) {
                    foreach ($query->rows as $equipment) {
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
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "technic ORDER BY `name`");
                if ($query->num_rows) {
                    foreach ($query->rows as $technic) {
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
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "injured ORDER BY `name`");
                if ($query->num_rows) {
                    foreach ($query->rows as $injured) {
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
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "participant ORDER BY `name`");
                if ($query->num_rows) {
                    foreach ($query->rows as $participant) {
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
