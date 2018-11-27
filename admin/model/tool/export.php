<?php
class ModelToolExport extends Model {
	public function getOrders($data) {
		$query = $this->db->query("SELECT
			o.order_id, 
			o.date_added,
			CONCAT (o.firstname, ' ', o.lastname) as klient,
			o.payment_city as city,
			os.name as order_status,
			(SELECT GROUP_CONCAT(CONCAT (`name`, ' x', `quantity`) SEPARATOR '\n') FROM ". DB_PREFIX ."order_product op WHERE op.order_id = o.order_id) as products,
			(SELECT `value` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'sub_total') as subtotal,
			(SELECT `value` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'shipping') as shipping,
			(SELECT `value` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'total') as total,
			(SELECT `title` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'shipping') as typetotal
			FROM
			". DB_PREFIX ."order o INNER JOIN ". DB_PREFIX ."order_status os ON o.order_status_id = os.order_status_id
			WHERE date_added >= '".$data['date_start']." 00:00:00'  AND date_added <= '".$data['date_end']." 23:59:59'"
								 );
		
		if ($query->num_rows) {
			return $query->rows;
		} else {
			return false;
		}
		
	}
	
	public function getCouponOrders($data) {
		$query = $this->db->query("SELECT
			o.order_id, 
			o.date_added,
			CONCAT (o.firstname, ' ', o.lastname) as klient,
			o.payment_city as city,
			os.name as order_status,
			(SELECT GROUP_CONCAT(CONCAT (`name`, ' x', `quantity`) SEPARATOR '\n') FROM ". DB_PREFIX ."order_product op WHERE op.order_id = o.order_id) as products,
			(SELECT `value` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'sub_total') as subtotal,
			(SELECT `title` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'coupon') as 'promocode',
			(SELECT `value` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'shipping') as shipping,
			(SELECT `value` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'total') as total,
			(SELECT `title` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'shipping') as typetotal
			FROM
			". DB_PREFIX ."order o INNER JOIN ". DB_PREFIX ."order_status os ON o.order_status_id = os.order_status_id
			WHERE date_added >= '".$data['date_start']." 00:00:00'  AND date_added <= '".$data['date_end']." 23:59:59' AND EXISTS (SELECT `title` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'coupon')"
								 );
		
		if ($query->num_rows) {
			return $query->rows;
		} else {
			return false;
		}
		
	}
	
	public function getNaborOrders($data) {
		$query = $this->db->query("SELECT
			o.order_id, 
			o.date_added,
			CONCAT (o.firstname, ' ', o.lastname) as klient,
			o.payment_city as city,
			os.name as order_status,
			(SELECT GROUP_CONCAT(CONCAT (`name`, ' x', `quantity`) SEPARATOR '\n') FROM ". DB_PREFIX ."order_product op WHERE op.order_id = o.order_id) as products,
			(SELECT `value` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'sub_total') as subtotal,
			(SELECT `value` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'shipping') as shipping,
			(SELECT `value` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'total') as total,
			(SELECT `title` FROM ". DB_PREFIX ."order_total ot WHERE ot.order_id = o.order_id AND `code` = 'shipping') as typetotal
			FROM
			". DB_PREFIX ."order o INNER JOIN ". DB_PREFIX ."order_status os ON o.order_status_id = os.order_status_id
			WHERE date_added >= '".$data['date_start']." 00:00:00'  AND date_added <= '".$data['date_end']." 23:59:59' AND o.order_id IN (SELECT order_id FROM ". DB_PREFIX ."order_product op1 WHERE op1.order_id = o.order_id AND op1.product_id IN (267,268,269,270,271,265,264,266,263))"
								 );
		if ($query->num_rows) {
			return $query->rows;
		} else {
			return false;
		}
		
	}
    
    public function getEmails() {
		$query = $this->db->query("SELECT DISTINCT email FROM ". DB_PREFIX ."order WHERE order_status_id <> 0 AND email NOT LIKE '%@norvegianfishoil.ru%' AND email NOT LIKE '%@norwegianfishoil.ru%'");
		
		if ($query->num_rows) {
			return $query->rows;
		} else {
			return false;
		}
		
	}
    
    public function getQuickOrders($data) {
        $sql = "SELECT qo.quick_order_id, pd.meta_h1 as product, qo.quantity, qo.name, qo.phone, qo.date_added
                FROM ".DB_PREFIX."quick_order qo LEFT JOIN  ".DB_PREFIX."product_description pd ON qo.product_id = pd.product_id
                WHERE qo.date_added BETWEEN '".$data['date_start']." 00:00:00' AND '".$data['date_end']." 23:59:59'
                ORDER BY date_added";
        $query = $this->db->query($sql);
		
		if ($query->num_rows) {
			return $query->rows;
		} else {
			return false;
		}
    } 


}