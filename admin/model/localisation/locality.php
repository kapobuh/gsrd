<?php
class ModelLocalisationLocality extends Model {
    public function addLocality($data) {
        foreach ($data['locality'] as $language_id => $value) {
            if (isset($locality_id)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "locality SET locality_id = '" . (int)$locality_id . "', name = '" . $this->db->escape($value['name']) . "', type = '" . $this->db->escape($value['type']) . "'");

                if ((isset($data['district_id']) and ($data['type'] =='S'))) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "vilage_district SET `vilage_id` = '" . $locality_id . "', locality_id = '" . (int)($data['district_id']) . "'");
                }

            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "locality SET name = '" . $this->db->escape($value['name']) . "', type = '" . $this->db->escape($value['type']) . "'");

                $locality_id = $this->db->getLastId();

                if ((isset($data['district_id']) and ($data['type'] =='S'))) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "vilage_district SET `vilage_id` = '" . $locality_id . "', locality_id = '" . (int)($data['district_id']) . "'");
                }
            }


        }

        $this->cache->delete('locality');

        return $locality_id;
    }

    public function editLocality($locality_id, $data) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "locality WHERE locality_id = '" . (int)$locality_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "vilage_district WHERE locality_id = '" . (int)$locality_id . "'");

        foreach ($data['locality'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "locality SET locality_id = '" . (int)$locality_id . "', name = '" . $this->db->escape($value['name']) . "', type = '" . $this->db->escape($value['type']) . "'");

            if ((isset($data['district_id']) and ($value['type'] =='S'))) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "vilage_district SET `vilage_id` = '" . $locality_id . "', locality_id = '" . (int)($data['district_id']) . "'");
            }
        }

        $this->cache->delete('locality');
    }

    public function deleteLocality($locality_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "locality WHERE locality_id = '" . (int)$locality_id . "'");

        $this->cache->delete('locality');
    }

    public function getLocality($locality_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "locality WHERE locality_id = '" . (int)$locality_id . "'");

        return $query->row;
    }

    public function getLocalitys($data = array()) {
        if ($data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "locality l WHERE l.type IN ('".DISTRICT_LOCALITY_TYPE."','".CITY_LOCALITY_TYPE."')";

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
            $locality_data = $this->cache->get('locality.' . (int)$this->config->get('config_language_id'));

            if (!$locality_data) {
                $query = $this->db->query("SELECT locality_id, name, type FROM " . DB_PREFIX . "locality' ORDER BY name");

                $locality_data = $query->rows;

                $this->cache->set('locality.' . (int)$this->config->get('config_language_id'), $locality_data);
            }

            return $locality_data;
        }
    }

    public function getLocalityDescriptions($locality_id) {
        $locality_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "locality WHERE locality_id = '" . (int)$locality_id . "'");

        foreach ($query->rows as $result) {
            $locality_data[2] = array('name' => $result['name']);
            $locality_data[] = array('type' => $result['type']);
        }

        return $locality_data;
    }

    public function getTotalLocalitys() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "locality l WHERE l.type IN ('".DISTRICT_LOCALITY_TYPE."','".CITY_LOCALITY_TYPE."')");

        return $query->row['total'];
    }

    public function getLocalityDistrict($locality_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vilage_district WHERE vilage_id = '" . (int)$locality_id . "'");

        if ($query->num_rows) {
            return array (
                'vilage_id' => $query->row['locality_id']
            );
        } else {
            return false;
        }
    }
}