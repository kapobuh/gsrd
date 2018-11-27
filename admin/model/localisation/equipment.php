<?php
class ModelLocalisationEquipment extends Model {
    public function addEquipment($data) {
        foreach ($data['equipment'] as $language_id => $value) {
            if (isset($equipment_id)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "equipment SET equipment_id = '" . (int)$equipment_id . "', name = '" . $this->db->escape($value['name']) . "'"); echo $this->db->escape($value['name']);
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "equipment SET name = '" . $this->db->escape($value['name']) . "'");

                $equipment_id = $this->db->getLastId();
            }
        }

        $this->cache->delete('equipment');

        return $equipment_id;
    }

    public function editEquipment($equipment_id, $data) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "equipment WHERE equipment_id = '" . (int)$equipment_id . "'");

        foreach ($data['equipment'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "equipment SET equipment_id = '" . (int)$equipment_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }

        $this->cache->delete('equipment');
    }

    public function deleteEquipment($equipment_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "equipment WHERE equipment_id = '" . (int)$equipment_id . "'");

        $this->cache->delete('equipment');
    }

    public function getEquipment($equipment_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "equipment WHERE equipment_id = '" . (int)$equipment_id . "'");

        return $query->row;
    }

    public function getEquipments($data = array()) {
        if ($data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "equipment";

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
            $equipment_data = $this->cache->get('equipment.' . (int)$this->config->get('config_language_id'));

            if (!$equipment_data) {
                $query = $this->db->query("SELECT equipment_id, name FROM " . DB_PREFIX . "equipment' ORDER BY name");

                $equipment_data = $query->rows;

                $this->cache->set('equipment.' . (int)$this->config->get('config_language_id'), $equipment_data);
            }

            return $equipment_data;
        }
    }

    public function getEquipmentDescriptions($equipment_id) {
        $equipment_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "equipment WHERE equipment_id = '" . (int)$equipment_id . "'");

        foreach ($query->rows as $result) {
            $equipment_data[2] = array('name' => $result['name']);
        }

        return $equipment_data;
    }

    public function getTotalEquipments() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "equipment");

        return $query->row['total'];
    }
}