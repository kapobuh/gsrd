<?php
class ModelCommonPsr extends Model {
    /**
     * Сохраняет информацию о ПСР
     * @param $data
     */
	public function addPsr($data) {
	    $this->db->query("INSERT INTO " . DB_PREFIX ."address 
	                      SET 
	                        locality_id = '". (int)$data['locality'] ."', 
	                        street= '" . $this->db->escape($data['street']) . "',
	                        house = '" . $this->db->escape($data['house']) . "',
	                        appartment = '" . $this->db->escape($data['appartment']) . "' ");

	    $address_id = $this->db->getLastId();

	    $date_start = date("Y-m-d H:i:s",strtotime($data['date_start']));
        $date_end = date("Y-m-d H:i:s",strtotime($data['date_end']));

	    $this->db->query("INSERT INTO " . DB_PREFIX . "psr 
	                      SET 
	                        type_id = '".(int)$data['type_id']."', 
	                        psp_id = '" . (int)$data['psp_id'] . "', 
	                        address_id = '".(int)$address_id."', 
	                        date_start = '". $date_start ."', 
	                        date_end = '". $date_end ."', 
	                        description = '" . $this->db->escape($data['description']) . "', 
	                        moderated = '".(int)$data['moderated']."',
	                        status = '" . ACTIVE_STATUS_PSR . "',
	                        date_added = NOW()");

	    $psr_id = $this->db->getLastId();

	    $participant = json_encode($data['participant']);

	    if (!empty($data['equipment'])) {
	        $equpment_update = ", equipment = '".implode('_', $data['equipment'])."' ";
        } else {
            $equpment_update = "";
        }

	    $this->db->query("UPDATE " . DB_PREFIX . "psr 
	                      SET participants = '". $participant . "' " . $equpment_update . " 
	                      WHERE psr_id = '".(int)$psr_id."'");

	    // Техника
	    if (!empty($data['technic'])) {
            foreach ($data['technic'] as $technic) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "psr_technics 
                                  SET 
                                    psr_id = '". (int)$psr_id. "', 
                                    technic_id = '" . (int)$technic['technic_id'] . "', 
                                    quantity = '" . $technic['quantity'] . "'");
            }
        }


        // Пострадавшие
        if (!empty($data['injured'])) {
            foreach ($data['injured'] as $injured) {
                $birthday = $injured['birthday'] . '-01-01 00:00:00';
                $this->db->query("INSERT INTO " . DB_PREFIX . "psr_injured 
                                  SET 
                                    psr_id = '". (int)$psr_id. "', 
                                    injured_type_id = '" . (int)$injured['type'] . "', 
                                    lastname = '" . $injured['lastname'] . "', 
                                    firstname = '" . $injured['firstname'] . "', 
                                    birthday = '" . $birthday . "'");
            }
        }
    }

    /**
     * Вовзращает информацию об 1 ПСР
     * @param $psr_id
     * @return array|bool
     */
    public function getPsr($psr_id) {
	    $query = $this->db->query("SELECT 
                                    psr.psr_id, 
                                    psr.type_id, 
                                    psr.psp_id, 
                                    a.locality_id as locality, 
                                    a.street, 
                                    a.house, 
                                    a.appartment, 
                                    psr.date_start, 
                                    psr.date_end, 
                                    psr.participants as participant, 
                                    psr.equipment, 
                                    psr.description, 
                                    l.parent_id as parent_id 
                                   FROM nfo_psr psr 
                                    LEFT JOIN nfo_address a ON psr.address_id = a.address_id 
                                    INNER JOIN nfo_locality l ON a.locality_id = l.locality_id 
                                   WHERE psr.psr_id = '" . (int)$psr_id . "'");

        $technic_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "psr_technics WHERE psr_id = '" . $psr_id . "'");
        if ($technic_query->num_rows) {
            $technic = $technic_query->rows;
        } else {
            $technic = array(array ('technic_id' => '0', 'quantity' => '1'));
        }

	    $injured_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "psr_injured WHERE psr_id = '" . $psr_id . "'");
	    if ($injured_query->num_rows) {
	        $injured = $injured_query->rows;
        } else {
	        $injured = array(array ('type_id' => '0', 'lastname' => '', 'firstname' => '', 'birthday' => ''));
        }

        foreach (json_decode($query->row['participant']) as $paticipant) {
            $participants[] = array (
                't' => $paticipant->t,
                'q' => $paticipant->q
            );
        }

        if ($query->num_rows) {

            $locality_name_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "locality 
                                                     WHERE locality_id = '" . (int)$query->row['locality'] . "'");

            $type_name_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "incident_type  
                                                 WHERE incidenttype_id = '" . (int)$query->row['type_id'] . "'");

            if ($query->row['parent_id']) {
                $locality_type_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "locality
                                                         WHERE locality_id = '" . (int)$query->row['parent_id'] . "'");
                $locality_name = $locality_type_query->row['name'] . ', ' . $locality_name_query->row['name'];
            } else {
                $locality_name = $locality_name_query->row['name'];
            }

            return array(
                'psr_id' => $query->row['psr_id'],
                'type_id' => $query->row['type_id'],
                'locality' => $query->row['locality'],
                'psp_id' => $query->row['psp_id'],
                'street' => $query->row['street'],
                'house' => $query->row['house'],
                'appartment' => $query->row['appartment'],
                'date_start' => date("d.m.Y H:i", strtotime($query->row['date_start'])),
                'date_end' => date("d.m.Y H:i", strtotime($query->row['date_end'])),
                'participant' => $participants,
                'equipments' => explode("_", $query->row['equipment']),
                'technic' => $technic,
                'injured' => $injured,
                'description' => $query->row['description'],
                'type_name' => (isset($type_name_query->row['name'])) ? $type_name_query->row['name'] : '',
                'locality_name' => $locality_name
            );
        } else {
            return false;
        }
    }

    /**
     * Получает список ПСР
     * @param $filter_data
     * @param $limits - false для суммарных данных
     * @param int $moderated
     * @return mixed
     */
    public function getPsrs($filter_data , $moderated = 1, $limits = true) {

	    $sql = "SELECT psr.psr_id, l.name as city, a.street, a.house, a.appartment, psp.name as psp_name, psr.date_added
                FROM " . DB_PREFIX . "psr psr
                LEFT JOIN " . DB_PREFIX . "address a ON psr.address_id = a.address_id
                LEFT JOIN " . DB_PREFIX . "psp psp ON psr.psp_id = psp.psp_id
                INNER JOIN " . DB_PREFIX . "locality l ON a.locality_id = l.locality_id
                WHERE psr.moderated = '" . (int)$moderated . "'
                 AND psr.status = '" . ACTIVE_STATUS_PSR . "'";

        if (!empty($filter_data['incidents'])) {
            $sql.= " AND psr.type_id IN (" . $this->db->escape($filter_data['incidents']) . ")";
        }

        if (!empty($filter_data['localitys'])) {
            $sql.= " AND a.locality_id IN (" . $this->db->escape($filter_data['localitys']) . ")";
        }

        if (!empty($filter_data['psps'])) {
            $sql.= " AND psr.psp_id IN (" . $this->db->escape($filter_data['psps']) . ")";
        }

	    if (!empty($filter_data['date_start'])) {
	        $sql.= " AND date_start BETWEEN '".$this->db->escape($filter_data['date_start'])."' AND '".$this->db->escape($filter_data['date_end'])."'";
        }

        $query = $this->db->query($sql);

	    return $query->rows;
    }


    /**
     * Обновляет данные о ПСР
     * @param $data
     * @param $psr_id
     */
    public function editPsr($data, $psr_id) {
        $current_address_id = $this->getPsrAddressId($psr_id);
        if ($current_address_id === 0) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE address_id = '" . $current_address_id . "'");
        }

        $this->db->query("INSERT INTO " . DB_PREFIX ."address 
                            SET 
                            locality_id = '". (int)$data['locality'] ."', 
                            street= '" . $this->db->escape($data['street']) . "',
	                        house = '" . $this->db->escape($data['house']) . "', 
	                        appartment = '" . $this->db->escape($data['appartment']) . "' ");

        $address_id = $this->db->getLastId();

        $date_start = date("Y-m-d H:i:s",strtotime($data['date_start']));
        $date_end = date("Y-m-d H:i:s",strtotime($data['date_end']));

        $this->db->query("UPDATE " . DB_PREFIX . "psr 
                            SET 
                                type_id = '".(int)$data['type_id']."', 
                                address_id = '" . (int)$address_id . "', 
                                psp_id = '" . (int)$data['psp_id'] . "', 
                                date_start = '". $date_start ."', 
                                date_end = '". $date_end ."', 
                                description = '" . $this->db->escape($data['description']) . "', 
                                moderated = '".(int)$data['moderated']."' 
                            WHERE psr_id = '" . (int)$psr_id . "'");

        $participant = json_encode($data['participant']);

        if (!empty($data['equipment'])) {
            $equpment_update = ", equipment = '".implode('_', $data['equipment'])."' ";
        } else {
            $equpment_update = ", equipment = '' ";
        }

        $this->db->query("UPDATE " . DB_PREFIX . "psr SET participants = '". $participant . "' " . $equpment_update . " WHERE psr_id = '".(int)$psr_id."'");

        if (!empty($data['technic'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "psr_technics WHERE psr_id = '" . (int)$psr_id . "'");
            foreach ($data['technic'] as $technic) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "psr_technics 
                                    SET 
                                      psr_id = '". (int)$psr_id. "', 
                                      technic_id = '" . (int)$technic['technic_id'] . "', 
                                      quantity = '" . $technic['quantity'] . "'");
            }
        }

        if (!empty($data['injured'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "psr_injured WHERE psr_id = '" . (int)$psr_id . "'");
            foreach ($data['injured'] as $injured) {
                $birthday = date("Y-m-d H:i:s",strtotime($injured['birthday']));
                $this->db->query("INSERT INTO " . DB_PREFIX . "psr_injured 
                                    SET 
                                     psr_id = '". (int)$psr_id. "', 
                                     injured_type_id = '" . (int)$injured['type'] . "', 
                                     lastname = '" . $injured['lastname'] . "', 
                                     firstname = '" . $injured['firstname'] . "', 
                                     birthday = '" . $birthday . "'");
            }
        }
	}

    /**
     * Возвращает id адреса поисково-спасательной работы
     * @param $psr_id
     * @return int
     */
    public function getPsrAddressId($psr_id) {
        $query = $this->db->query("SELECT address_id FROM " . DB_PREFIX . "psr WHERE psr_id = '" . (int)$psr_id. "'");
        return ($query->num_rows) ? $query->row['address_id'] : 0;
    }

    /**
     * Помечает ПСР как удаленный
     * @param $psr_id
     * @return bool
     */
    public function deletePsr($psr_id) {
	    $query = $this->db->query("UPDATE " . DB_PREFIX . "psr 
	                               SET `status` = " . DELETED_STATUS_PSR . " 
	                               WHERE psr_id = '".(int)$psr_id."'");
	    return ($query) ? true : false;
    }

    /**
     * Возвращает суммарные данные по пострадавшим в ПСР
     * @param $psr_ids - список пср для поиска
     * @return mixed
     */
    public function getInjuredTotals($psr_ids) {

        $sql = "SELECT i.injured_type_id, p.type_id, COUNT(i.psr_injured_id) as quantity
                 FROM " . DB_PREFIX . "psr_injured i
                 LEFT JOIN " . DB_PREFIX . "psr p ON i.psr_id = p.psr_id
                WHERE p.psr_id IN (" . implode(",",$psr_ids) . ")
                GROUP BY p.type_id";

        $query = $this->db->query($sql);

        return ($query->num_rows) ? $query->rows : null;
    }

    /**
     * Возвращает суммарные данные по использованному оборудованию в ПСР
     * @param $psr_ids - список пср для поиска
     * @return array|null
     */
    public function getEquipmentTotals($psr_ids) {

        $sql = "SELECT equipment FROM " . DB_PREFIX . "psr
                WHERE psr_id IN (" . implode(",",$psr_ids) . ")";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $str = '';
            $totals = array();
            foreach ($query->rows as $psr_equipment) {
                $str .= $psr_equipment['equipment'] . "_";
            }
            $str = substr($str, 0, -1);
            $equipment_ids = explode("_", $str);
            $equipment_ids_counts = array_count_values($equipment_ids);

            $this->load->model('common/lists');
            foreach ($this->model_common_lists->getLists('equipments') as $equipment_item) {
                if (isset($equipment_ids_counts[$equipment_item['equipment_id']])) {
                    $totals[] = array (
                        'name' => $equipment_item['name'],
                        'quantity' => $equipment_ids_counts[$equipment_item['equipment_id']]
                    );
                }
            }
            return $totals;
        } else {
            return null;
        }
    }

}
