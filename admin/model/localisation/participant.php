<?php
class ModelLocalisationParticipant extends Model {
    public function addParticipant($data) {
        foreach ($data['participant'] as $language_id => $value) {
            if (isset($participant_id)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "participant SET participant_id = '" . (int)$participant_id . "', name = '" . $this->db->escape($value['name']) . "'"); echo $this->db->escape($value['name']);
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "participant SET name = '" . $this->db->escape($value['name']) . "'");

                $participant_id = $this->db->getLastId();
            }
        }

        $this->cache->delete('participant');

        return $participant_id;
    }

    public function editParticipant($participant_id, $data) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "participant WHERE participant_id = '" . (int)$participant_id . "'");

        foreach ($data['participant'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "participant SET participant_id = '" . (int)$participant_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }

        $this->cache->delete('participant');
    }

    public function deleteParticipant($participant_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "participant WHERE participant_id = '" . (int)$participant_id . "'");

        $this->cache->delete('participant');
    }

    public function getParticipant($participant_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "participant WHERE participant_id = '" . (int)$participant_id . "'");

        return $query->row;
    }

    public function getParticipants($data = array()) {
        if ($data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "participant";

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
            $participant_data = $this->cache->get('participant.' . (int)$this->config->get('config_language_id'));

            if (!$participant_data) {
                $query = $this->db->query("SELECT participant_id, name FROM " . DB_PREFIX . "participant' ORDER BY name");

                $participant_data = $query->rows;

                $this->cache->set('participant.' . (int)$this->config->get('config_language_id'), $participant_data);
            }

            return $participant_data;
        }
    }

    public function getParticipantDescriptions($participant_id) {
        $participant_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "participant WHERE participant_id = '" . (int)$participant_id . "'");

        foreach ($query->rows as $result) {
            $participant_data[2] = array('name' => $result['name']);
        }

        return $participant_data;
    }

    public function getTotalParticipants() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "participant");

        return $query->row['total'];
    }
}