<?php
class ModelLocalisationTechnic extends Model {
    public function addTechnic($data) {
        foreach ($data['technic'] as $language_id => $value) {
            if (isset($technic_id)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "technic SET technic_id = '" . (int)$technic_id . "', name = '" . $this->db->escape($value['name']) . "'"); echo $this->db->escape($value['name']);
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "technic SET name = '" . $this->db->escape($value['name']) . "'");

                $technic_id = $this->db->getLastId();
            }
        }

        $this->cache->delete('technic');

        return $technic_id;
    }

    public function editTechnic($technic_id, $data) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "technic WHERE technic_id = '" . (int)$technic_id . "'");

        foreach ($data['technic'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "technic SET technic_id = '" . (int)$technic_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }

        $this->cache->delete('technic');
    }

    public function deleteTechnic($technic_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "technic WHERE technic_id = '" . (int)$technic_id . "'");

        $this->cache->delete('technic');
    }

    public function getTechnic($technic_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "technic WHERE technic_id = '" . (int)$technic_id . "'");

        return $query->row;
    }

    public function getTechnics($data = array()) {
        if ($data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "technic";

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
            $technic_data = $this->cache->get('technic.' . (int)$this->config->get('config_language_id'));

            if (!$technic_data) {
                $query = $this->db->query("SELECT technic_id, name FROM " . DB_PREFIX . "technic' ORDER BY name");

                $technic_data = $query->rows;

                $this->cache->set('technic.' . (int)$this->config->get('config_language_id'), $technic_data);
            }

            return $technic_data;
        }
    }

    public function getTechnicDescriptions($technic_id) {
        $technic_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "technic WHERE technic_id = '" . (int)$technic_id . "'");

        foreach ($query->rows as $result) {
            $technic_data[2] = array('name' => $result['name']);
        }

        return $technic_data;
    }

    public function getTotalTechnics() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "technic");

        return $query->row['total'];
    }
}