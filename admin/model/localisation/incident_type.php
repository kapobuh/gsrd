<?php
class ModelLocalisationIncidentType extends Model {
    public function addIncidenttype($data) {
        foreach ($data['incidenttype'] as $language_id => $value) {
            if (isset($incidenttype_id)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "incident_type SET incidenttype_id = '" . (int)$incidenttype_id . "', name = '" . $this->db->escape($value['name']) . "'"); 
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "incident_type SET name = '" . $this->db->escape($value['name']) . "'");

                $incidenttype_id = $this->db->getLastId();
            }
        }

        $this->cache->delete('incidenttype');

        return $incidenttype_id;
    }

    public function editIncidenttype($incidenttype_id, $data) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "incident_type WHERE incidenttype_id = '" . (int)$incidenttype_id . "'");

        foreach ($data['incidenttype'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "incident_type SET incidenttype_id = '" . (int)$incidenttype_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }

        $this->cache->delete('incidenttype');
    }

    public function deleteIncidenttype($incidenttype_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "incident_type WHERE incidenttype_id = '" . (int)$incidenttype_id . "'");

        $this->cache->delete('incidenttype');
    }

    public function getIncidenttype($incidenttype_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "incident_type WHERE incidenttype_id = '" . (int)$incidenttype_id . "'");

        return $query->row;
    }

    public function getIncidenttypes($data = array()) {
        if ($data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "incident_type";

            $sql .= " ORDER BY name";

            if (isset($data['order']) && ($data['order'] == 'DESC')) {
                $sql .= " DESC";
            } else {
                $sql .= " ASC";
            }

            if (isset($data['start']) || isset($data['limit'])) {
                if ($data['start'] < 0) {
                    $data['start'] = 0;
                }

                if ($data['limit'] < 1) {
                    $data['limit'] = 20;
                }

                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            }

            $query = $this->db->query($sql);

            return $query->rows;
        } else {
            $incidenttype_data = $this->cache->get('incidenttype.' . (int)$this->config->get('config_language_id'));

            if (!$incidenttype_data) {
                $query = $this->db->query("SELECT incidenttype_id, name FROM " . DB_PREFIX . "incident_type' ORDER BY name");

                $incidenttype_data = $query->rows;

                $this->cache->set('incidenttype.' . (int)$this->config->get('config_language_id'), $incidenttype_data);
            }

            return $incidenttype_data;
        }
    }

    public function getIncidenttypeDescriptions($incidenttype_id) {
        $incidenttype_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "incident_type WHERE incidenttype_id = '" . (int)$incidenttype_id . "'");

        foreach ($query->rows as $result) {
            $incidenttype_data[2] = array('name' => $result['name']);
        }

        return $incidenttype_data;
    }

    public function getTotalIncidenttypes() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "incident_type");

        return $query->row['total'];
    }
}