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


}
