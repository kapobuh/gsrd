<?php
class ModelCatalogPartners extends Model {

	public function addPartners($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "partners SET status = '" . (int)$data['status'] . "'");
	
		$partner_id = $this->db->getLastId();
	
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "partners SET image = '" . $this->db->escape($data['image']) . "' WHERE partner_id = '" . (int)$partner_id . "'");
		}
		
		if (isset($data['image_title'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "partners SET image_title = '" . $this->db->escape($data['image_title']) . "' WHERE partner_id = '" . (int)$partner_id . "'");
		}
		
		if (isset($data['link'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "partners SET link = '" . $this->db->escape($data['link']) . "' WHERE partner_id = '" . (int)$partner_id . "'");
		}
		
		if (isset($data['sort_order'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "partners SET sort_order = '" . $this->db->escape($data['sort_order']) . "' WHERE partner_id = '" . (int)$partner_id . "'");
		}
	
	
		$this->cache->delete('partners');
	}

	public function editPartners($partner_id, $data) {
		
		echo (int)$data['status'];
		
		
		$this->db->query("UPDATE " . DB_PREFIX . "partners SET status = '" . (int)$data['status'] . "' WHERE partner_id = '" . (int)$partner_id . "'");
		
		if (isset($data['status'])) {
			//$this->db->query($sql);
		}

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "partners SET image = '" . $this->db->escape($data['image']) . "' WHERE partner_id = '" . (int)$partner_id . "'");
		}
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "partners SET image = '" . $this->db->escape($data['image']) . "' WHERE partner_id = '" . (int)$partner_id . "'");
		}
		
		if (isset($data['image_title'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "partners SET image_title = '" . $this->db->escape($data['image_title']) . "' WHERE partner_id = '" . (int)$partner_id . "'");
		}
		
		if (isset($data['link'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "partners SET link = '" . $this->db->escape($data['link']) . "' WHERE partner_id = '" . (int)$partner_id . "'");
		}
		
		if (isset($data['sort_order'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "partners SET sort_order = '" . $this->db->escape($data['sort_order']) . "' WHERE partner_id = '" . (int)$partner_id . "'");
		}
	
		$this->cache->delete('partners');
	}

	public function deletePartners($partner_id) { 
		$this->db->query("DELETE FROM " . DB_PREFIX . "partners WHERE partner_id = '" . (int)$partner_id . "'");
	
		$this->cache->delete('partners');
	}

	public function getPartnersList($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "partners p";

			$sort_data = array(
				'nd.title',
				'n.date_added'
			);

			$sql .= " ORDER BY p.sort_order";
			

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
			$partners_data = $this->cache->get('partners.' . (int)$this->config->get('config_language_id'));

			if (!$partners_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "partners n LEFT JOIN " . DB_PREFIX . "partners_description nd ON (n.partner_id = nd.partner_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY nd.title");

				$partners_data = $query->rows;

				$this->cache->set('partners.' . (int)$this->config->get('config_language_id'), $partners_data);
			}

			return $partners_data;
		}
	}
	
	public function getPartner($partner_id) { 

     	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "partners WHERE partner_id = '".(int)$partner_id."'");
	
		if ($query->rows) {
			return $query->rows;
		} else {
			return false;
		}
	}


	public function getTotalPartners() { 

     	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "partners");
	
		return $query->row['total'];
	}

	public function setPartnersListUrl($url) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'information/partners'");
		if ($query) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information/partners'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'information/partners', `keyword` = '" . $this->db->escape($url) . "'");
		}else{
			$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'information/partners', `keyword` = '" . $this->db->escape($url) . "'");
		}
	}

	public function getPartnersListUrl($query) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->db->escape($query) . "'");
			if($query->rows){
				return $query->row['keyword'];
			}else{
				return false;
			}
	}
}
?>