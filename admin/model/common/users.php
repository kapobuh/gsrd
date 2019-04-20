<?php
class ModelCommonUsers extends Model {
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
}
