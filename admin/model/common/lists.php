<?php
class ModelCommonLists extends Model {
    public function getIncidentTypes() {
        $query = $this->db->query("SELECT * FROM ". DB_PREFIX. "incident_type");
        return $query->rows;
    }

    public function getLocalitys() {
        $query = $this->db->query("SELECT * FROM ". DB_PREFIX. "locality");
        return $query->rows;
    }

    public function getEquipments() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "equipment");
        return $query->rows;
    }

    public function getTechnics() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "technic");
        return $query->rows;
    }

    public function getInjureds() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "injured");
        return $query->rows;
    }

    public function getParticipants() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "participant");
        return $query->rows;
    }

    public function getPsps() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "psp");
        return $query->rows;
    }

    public function getInboxCount() {
        $query = $this->db->query("SELECT COUNT(psr_id) as total FROM " . DB_PREFIX . "psr WHERE moderated = '0'");
        return $query->row['total'];
    }
}
