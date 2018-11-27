<?php
class ModelLocalisationPsp extends Model {
    public function addPsp($data) {
        foreach ($data['psp'] as $language_id => $value) {
            if (isset($psp_id)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "psp SET psp_id = '" . (int)$psp_id . "', name = '" . $this->db->escape($value['name']) . "'"); echo $this->db->escape($value['name']);
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "psp SET name = '" . $this->db->escape($value['name']) . "'");

                $psp_id = $this->db->getLastId();
            }
        }

        $this->cache->delete('psp');

        return $psp_id;
    }

    public function editPsp($psp_id, $data) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "psp WHERE psp_id = '" . (int)$psp_id . "'");

        foreach ($data['psp'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "psp SET psp_id = '" . (int)$psp_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }

        $this->cache->delete('psp');
    }

    public function deletePsp($psp_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "psp WHERE psp_id = '" . (int)$psp_id . "'");

        $this->cache->delete('psp');
    }

    public function getPsp($psp_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "psp WHERE psp_id = '" . (int)$psp_id . "'");

        return $query->row;
    }

    public function getPsps($data = array()) {
        if ($data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "psp";

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
            $psp_data = $this->cache->get('psp.' . (int)$this->config->get('config_language_id'));

            if (!$psp_data) {
                $query = $this->db->query("SELECT psp_id, name FROM " . DB_PREFIX . "psp' ORDER BY name");

                $psp_data = $query->rows;

                $this->cache->set('psp.' . (int)$this->config->get('config_language_id'), $psp_data);
            }

            return $psp_data;
        }
    }

    public function getPspDescriptions($psp_id) {
        $psp_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "psp WHERE psp_id = '" . (int)$psp_id . "'");

        foreach ($query->rows as $result) {
            $psp_data[2] = array('name' => $result['name']);
        }

        return $psp_data;
    }

    public function getTotalPsps() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "psp");

        return $query->row['total'];
    }
}