<?php
class ControllerSaleQuickorder extends Controller {
	private $error = array();

	public function index() {
		
		ini_set("display_errors",1);
        error_reporting(E_ALL);


		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getList();
	}

	public function delete() {
		$this->load->language('sale/order');

		$this->document->setTitle('Быстрые заказы');

		$this->load->model('sale/order');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $quick_order_id) {
				$this->model_sale_order->deleteQuickOrder($quick_order_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			$this->response->redirect($this->url->link('sale/quick_order', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
	
	protected function getList() {
		
		ini_set("display_errors",1);
	error_reporting(E_ALL);
		
		
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
			'href' => $this->url->link('sale/quick_order', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['invoice'] = $this->url->link('sale/quick_order/invoice', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->url->link('sale/quick_order/delete', 'token=' . $this->session->data['token'], true);
        $data['export_excel'] = $this->url->link('tool/export/quick_orders', 'token=' . $this->session->data['token'], true);

        
		$data['quick_orders'] = array();

		$filter_data = array(
			'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_sale_order->getTotalQuickOrders($filter_data);

		$results = $this->model_sale_order->getQuickOrders($filter_data);

		foreach ($results as $result) {
			
			$product_name = $this->model_sale_order->getQuickProduct($result['product_id']);
			
			$data['quick_orders'][] = array(
				'quick_order_id'      => $result['quick_order_id'],
				'name'      => $result['name'],
				'product_name'      => $product_name,
				'phone'      => $result['phone'],
				'quantity'      => $result['quantity'],
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'invoice'          => $this->url->link('sale/quick_order/invoice', 'token=' . $this->session->data['token'] . '&quick_order_id=' . $result['quick_order_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_invoice_print'] = $this->language->get('button_invoice_print');
		$data['button_shipping_print'] = $this->language->get('button_shipping_print');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_ip_add'] = $this->language->get('button_ip_add');

		$data['token'] = $this->session->data['token'];

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

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/quick_order', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/quick_order_list', $data));
	}
	
    public function invoice() {
		$this->load->language('sale/order');

		$data['title'] = $this->language->get('text_invoice');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		$order_id = $this->request->get['quick_order_id'];

		$this->load->model('sale/order');

		$this->load->model('setting/setting');

		$order_info = $this->model_sale_order->getQuickOrder($order_id);
		
		if (isset($this->request->get['preorder'])) {
            $data['order_type'] = 'Предзаказ';
        } else {
            $data['order_type'] = 'Быстрый заказ';
        }
		
		if ($order_info) {
			$data['name'] = $order_info['name'];
			$data['order_id'] = $order_info['quick_order_id'];
			$data['phone'] = $order_info['phone'];
			$data['quantity'] = $order_info['quantity'];
			$data['product'] = $order_info['product_name'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
		}

		$this->response->setOutput($this->load->view('sale/quick_order_invoice', $data));
	}
	
}
