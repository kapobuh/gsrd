<?php
class ModelLocalisationInjured extends Model {
    public function addInjured($data) {
        foreach ($data['injured'] as $language_id => $value) {
            if (isset($injured_id)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "injured SET injured_id = '" . (int)$injured_id . "', name = '" . $this->db->escape($value['name']) . "'"); echo $this->db->escape($value['name']);
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "injured SET name = '" . $this->db->escape($value['name']) . "'");

                $injured_id = $this->db->getLastId();
            }
        }

        $this->cache->delete('injured');

        return $injured_id;
    }

    public function editInjured($injured_id, $data) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "injured WHERE injured_id = '" . (int)$injured_id . "'");

        foreach ($data['injured'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "injured SET injured_id = '" . (int)$injured_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }

        $this->cache->delete('injured');
    }

    public function deleteInjured($injured_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "injured WHERE injured_id = '" . (int)$injured_id . "'");

        $this->cache->delete('injured');
    }

    public function getInjured($injured_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "injured WHERE injured_id = '" . (int)$injured_id . "'");

        return $query->row;
    }

    public function getInjureds($data = array()) {
        if ($data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "injured";

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
            $injured_data = $this->cache->get('injured.' . (int)$this->config->get('config_language_id'));

            if (!$injured_data) {
                $query = $this->db->query("SELECT injured_id, name FROM " . DB_PREFIX . "injured' ORDER BY name");

                $injured_data = $query->rows;

                $this->cache->set('injured.' . (int)$this->config->get('config_language_id'), $injured_data);
            }

            return $injured_data;
        }
    }

    public function getInjuredDescriptions($injured_id) {
        $injured_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "injured WHERE injured_id = '" . (int)$injured_id . "'");

        foreach ($query->rows as $result) {
            $injured_data[2] = array('name' => $result['name']);
        }

        return $injured_data;
    }

    public function getTotalInjureds() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "injured");

        return $query->row['total'];
    }
}