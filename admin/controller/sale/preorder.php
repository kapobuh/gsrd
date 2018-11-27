<?php
class ControllerSalePreorder extends Controller {
	private $error = array();

	public function index() {
		
		$this->load->language('sale/order');

		$this->document->setTitle('Предзаказы');

		$this->load->model('sale/order');

		$this->getList();
	}

	public function delete() {
		$this->load->language('sale/order');

		$this->document->setTitle('Предзаказы');

		$this->load->model('sale/order');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $quick_order_id) {
				$this->model_sale_order->deleteQuickOrder($quick_order_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			$this->response->redirect($this->url->link('sale/preorder', 'token=' . $this->session->data['token'] . $url, true));
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
			'text' => 'Предзаказы',
			'href' => $this->url->link('sale/preorder', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['invoice'] = $this->url->link('sale/preorder/invoice', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->url->link('sale/preorder/delete', 'token=' . $this->session->data['token'], true);

		$data['quick_orders'] = array();

		$filter_data = array(
			'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_sale_order->getTotalPreOrders($filter_data);

		$results = $this->model_sale_order->getPreOrders($filter_data);

		foreach ($results as $result) {
			
			$product_name = $this->model_sale_order->getQuickProduct($result['product_id']);
			
			$data['quick_orders'][] = array(
				'quick_order_id'    => $result['quick_order_id'],
				'name'              => $result['name'],
				'product_name'      => $product_name,
				'phone'             => $result['phone'],
				'quantity'          => $result['quantity'],
				'date_added'        => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'invoice'           => $this->url->link('sale/quick_order/invoice', 'token=' . $this->session->data['token'] . '&quick_order_id=' . $result['quick_order_id'].'&preorder=1' . $url, true)
			);
		}

		$data['heading_title'] = 'Предзаказы';

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		
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

		
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/preorder_list', $data));
	}
    

}
