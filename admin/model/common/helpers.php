<?php
class ModelCommonHelpers extends Model {
    /**
     * Возвращает список Поиско-спасательных подразделений,
     * доступных пользователю
     * @param $user_id
     * @return mixed
     */
	public function getUserPsp($user_id) {
	    $query = $this->db->query("SELECT * FROM " . DB_PREFIX ."psp_user WHERE user_id = '".(int)$user_id."'");
	    if ($query->num_rows) {
	        return $query->row['psp_id'];
        }
    }

    /**
     * Возвращает Село по id района
     * @param $district_id
     * @return mixed
     */
    public function getSeloByDistrict($district_id) {
        $query = $this->db->query("SELECT `name`, locality_id as `selo_id` 
                                   FROM " . DB_PREFIX . "locality
                                   WHERE parent_id = '".(int)$district_id."' 
                                   AND `type` = '" . SELO_LOCALITY_TYPE . "'");
        return($query->rows);
    }


    /**
     * Возвращает значение человека/часов работы по формуле
     * @param $date_start
     * @param $date_end
     * @param $spasatels
     * @return float|int
     */
    public function getPeopleHoursWorks($date_start, $date_end, $spasatels) {
        $d1 = strtotime($date_start);
        $d2 = strtotime($date_end);
        $diff = $d2 - $d1;
        return (($diff/60) * $spasatels) / 8 / 60;
    }
}
