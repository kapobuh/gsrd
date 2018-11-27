<?php
class ControllerMarketingAmmsale extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('marketing/ammsale');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketing/ammsale');

		$this->getList();
	}

	public function add() {
		$this->load->language('marketing/ammsale');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketing/ammsale');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_marketing_ammsale->addCoupon($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('marketing/ammsale', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('marketing/ammsale');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketing/ammsale');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_marketing_ammsale->editCoupon($this->request->get['coupon_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('marketing/ammsale', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('marketing/ammsale');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketing/ammsale');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $coupon_id) {
				$this->model_marketing_ammsale->deleteCoupon($coupon_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('marketing/ammsale', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';


		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketing/ammsale', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('marketing/ammsale/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('marketing/ammsale/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['ammsales'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$ammsale_total = $this->model_marketing_ammsale->getTotalCoupons();

		$results = $this->model_marketing_ammsale->getCoupons($filter_data);

		foreach ($results as $result) {
			$data['coupons'][] = array(
				'coupon_id'  => $result['coupon_id'],
				'name'       => $result['name'],
				'lastname'    => $result['lastname'],
				'code'    => $result['code'],
				'discount'   => $result['discount'],
				'edit'       => $this->url->link('marketing/ammsale/edit', 'token=' . $this->session->data['token'] . '&coupon_id=' . $result['coupon_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_lastname'] = $this->language->get('column_lastname');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_discount'] = $this->language->get('column_discount');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_date_start'] = $this->language->get('column_date_start');
		$data['column_date_end'] = $this->language->get('column_date_end');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';


		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $ammsale_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('marketing/ammsale', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($ammsale_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($ammsale_total - $this->config->get('config_limit_admin'))) ? $ammsale_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $ammsale_total, ceil($ammsale_total / $this->config->get('config_limit_admin')));

		//$data['sort'] = $sort;
		//$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketing/ammsale_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['ammsale_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		//$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_discount'] = $this->language->get('entry_discount');
		//$data['entry_logged'] = $this->language->get('entry_logged');
		//$data['entry_shipping'] = $this->language->get('entry_shipping');
		//$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_total'] = $this->language->get('entry_total');
		//$data['entry_category'] = $this->language->get('entry_category');
		//$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		//$data['entry_uses_total'] = $this->language->get('entry_uses_total');
		//$data['entry_uses_customer'] = $this->language->get('entry_uses_customer');
		//$data['entry_status'] = $this->language->get('entry_status');

		$data['help_code'] = $this->language->get('help_code');
		$data['help_type'] = $this->language->get('help_type');
		$data['help_logged'] = $this->language->get('help_logged');
		$data['help_total'] = $this->language->get('help_total');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_product'] = $this->language->get('help_product');
		$data['help_uses_total'] = $this->language->get('help_uses_total');
		$data['help_uses_customer'] = $this->language->get('help_uses_customer');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_history'] = $this->language->get('tab_history');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['coupon_id'])) {
			$data['coupon_id'] = $this->request->get['coupon_id'];
		} else {
			$data['coupon_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}

		if (isset($this->error['date_start'])) {
			$data['error_date_start'] = $this->error['date_start'];
		} else {
			$data['error_date_start'] = '';
		}

		if (isset($this->error['date_end'])) {
			$data['error_date_end'] = $this->error['date_end'];
		} else {
			$data['error_date_end'] = '';
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketing/ammsale', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['coupon_id'])) {
			$data['action'] = $this->url->link('marketing/ammsale/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('marketing/ammsale/edit', 'token=' . $this->session->data['token'] . '&coupon_id=' . $this->request->get['coupon_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('marketing/ammsale', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['coupon_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
			$ammsale_info = $this->model_marketing_ammsale->getCoupon($this->request->get['coupon_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($ammsale_info)) {
			$data['name'] = $ammsale_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($ammsale_info)) {
			$data['lastname'] = $ammsale_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['code'])) {
			$data['code'] = $this->request->post['code'];
		} elseif (!empty($ammsale_info)) {
			$data['code'] = $ammsale_info['code'];
		} else {
			$data['code'] = '';
		}

		/*if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($ammsale_info)) {
			$data['type'] = $ammsale_info['type'];
		} else {
			$data['type'] = '';
		}*/

		if (isset($this->request->post['discount'])) {
			$data['discount'] = $this->request->post['discount'];
		} elseif (!empty($ammsale_info)) {
			$data['discount'] = $ammsale_info['discount'];
		} else {
			$data['discount'] = '';
		}

		/*if (isset($this->request->post['logged'])) {
			$data['logged'] = $this->request->post['logged'];
		} elseif (!empty($ammsale_info)) {
			$data['logged'] = $ammsale_info['logged'];
		} else {
			$data['logged'] = '';
		}

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($ammsale_info)) {
			$data['shipping'] = $ammsale_info['shipping'];
		} else {
			$data['shipping'] = '';
		}

		if (isset($this->request->post['total'])) {
			$data['total'] = $this->request->post['total'];
		} elseif (!empty($ammsale_info)) {
			$data['total'] = $ammsale_info['total'];
		} else {
			$data['total'] = '';
		}*/

		/*if (isset($this->request->post['ammsale_product'])) {
			$products = $this->request->post['ammsale_product'];
		} elseif (isset($this->request->get['ammsale_id'])) {
			$products = $this->model_marketing_ammsale->getammsaleProducts($this->request->get['ammsale_id']);
		} else {
			$products = array();
		}*/

		/*$this->load->model('catalog/product');

		$data['ammsale_product'] = array();

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$data['ammsale_product'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}

		if (isset($this->request->post['ammsale_category'])) {
			$categories = $this->request->post['ammsale_category'];
		} elseif (isset($this->request->get['ammsale_id'])) {
			$categories = $this->model_marketing_ammsale->getammsaleCategories($this->request->get['ammsale_id']);
		} else {
			$categories = array();
		}

		$this->load->model('catalog/category');

		$data['ammsale_category'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['ammsale_category'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']
				);
			}
		}*/

		/*if (isset($this->request->post['date_start'])) {
			$data['date_start'] = $this->request->post['date_start'];
		} elseif (!empty($ammsale_info)) {
			$data['date_start'] = ($ammsale_info['date_start'] != '0000-00-00' ? $ammsale_info['date_start'] : '');
		} else {
			$data['date_start'] = date('Y-m-d', time());
		}

		if (isset($this->request->post['date_end'])) {
			$data['date_end'] = $this->request->post['date_end'];
		} elseif (!empty($ammsale_info)) {
			$data['date_end'] = ($ammsale_info['date_end'] != '0000-00-00' ? $ammsale_info['date_end'] : '');
		} else {
			$data['date_end'] = date('Y-m-d', strtotime('+1 month'));
		}

		if (isset($this->request->post['uses_total'])) {
			$data['uses_total'] = $this->request->post['uses_total'];
		} elseif (!empty($ammsale_info)) {
			$data['uses_total'] = $ammsale_info['uses_total'];
		} else {
			$data['uses_total'] = 1;
		}*/

		/*if (isset($this->request->post['uses_customer'])) {
			$data['uses_customer'] = $this->request->post['uses_customer'];
		} elseif (!empty($ammsale_info)) {
			$data['uses_customer'] = $ammsale_info['uses_customer'];
		} else {
			$data['uses_customer'] = 1;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($ammsale_info)) {
			$data['status'] = $ammsale_info['status'];
		} else {
			$data['status'] = true;
		}*/

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketing/ammsale_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'marketing/ammsale')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if ((utf8_strlen($this->request->post['lastname']) < 3) || (utf8_strlen($this->request->post['lastname']) > 128)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['code']) < 2) || (utf8_strlen($this->request->post['code']) > 10)) {
			$this->error['code'] = $this->language->get('error_code');
		}

		$ammsale_info = $this->model_marketing_ammsale->getCouponByCode($this->request->post['code']);

		if ($ammsale_info) {
			if (!isset($this->request->get['coupon_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			} elseif ($ammsale_info['ammsale_id'] != $this->request->get['coupon_id']) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'marketing/ammsale')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function history() {
		$this->load->language('marketing/ammsale');

		$this->load->model('marketing/ammsale');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_amount'] = $this->language->get('column_amount');
		$data['column_date_added'] = $this->language->get('column_date_added');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['histories'] = array();

		$results = $this->model_marketing_ammsale->getCouponHistories($this->request->get['coupon_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['histories'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['customer'],
				'amount'     => $result['amount'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_marketing_ammsale->getTotalCouponHistories($this->request->get['coupon_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('marketing/ammsale/history', 'token=' . $this->session->data['token'] . '&coupon_id=' . $this->request->get['coupon_id'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));

		$this->response->setOutput($this->load->view('marketing/ammsale_history', $data));
	}
}