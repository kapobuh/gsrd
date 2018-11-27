<?php
class ControllerCatalogPartners extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/partners');

		$this->load->model('catalog/partners');
		
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('setting/setting');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting(partners, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('catalog/partners', 'token=' . $this->session->data['token'], true));
	
		}
	
		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/partners');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/partners');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_partners->addPartners($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/partners', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/partners');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/partners');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) { //&& $this->validateForm()) {
			//echo $this->request->post['status'];
			$this->model_catalog_partners->editPartners($this->request->get['partner_id'], $this->request->post);

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
			
			

			$this->response->redirect($this->url->link('catalog/partners', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}
	
	public function delete() {
		$this->load->language('catalog/partners');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/partners');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $partner_id) {
				$this->model_catalog_partners->deletePartners($partner_id);
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

			$this->response->redirect($this->url->link('catalog/partners', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	private function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'nd.title';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		$this->load->language('catalog/partners');

		$this->load->model('catalog/partners');

		$data['heading_title'] = $this->language->get('heading_title');
	
		$data['text_list'] = $this->language->get('text_list');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_no_results'] = $this->language->get('text_no_results');
	
		$data['column_image'] = $this->language->get('column_image');		
		$data['column_title'] = $this->language->get('column_title');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_viewed'] = $this->language->get('column_viewed');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');		
	
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_setting'] = $this->language->get('button_setting');
	
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
	
		$data['breadcrumbs'] = array();
	
		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);
	
		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('catalog/partners', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);
	
		$data['add'] = $this->url->link('catalog/partners/add', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->url->link('catalog/partners/delete', 'token=' . $this->session->data['token'], true);
		$data['setting'] = $this->url->link('catalog/partners/setting', 'token=' . $this->session->data['token'], true);
	
		$partners_total = $this->model_catalog_partners->getTotalPartners();
	
		$this->load->model('tool/image');
	
		$data['partners'] = array();
	
			$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$results = $this->model_catalog_partners->getPartnersList($filter_data);
	
    	foreach ($results as $result) {
		
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 190, 60);
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', 110, 110);
			}
		
			$data['partners'][] = array(
				'partner_id'     	=> $result['partner_id'],
				'link'       	=> $result['link'],
				'image'      	=> $image,
				'image_title'      	=> $result['image_title'],
				'status'     	=> ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'    	=> isset($this->request->post['selected']) && in_array($result['partner_id'], $this->request->post['selected']),
				'edit'      	=> $this->url->link('catalog/partners/edit', 'token=' . $this->session->data['token'] . '&partner_id=' . $result['partner_id'], true)
			);
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('catalog/partners', 'token=' . $this->session->data['token'] . '&sort=nd.title' . $url, true);
		$data['sort_date_added'] = $this->url->link('catalog/partners', 'token=' . $this->session->data['token'] . '&sort=n.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $partners_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/partners', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($partners_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($partners_total - $this->config->get('config_limit_admin'))) ? $partners_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $partners_total, ceil($partners_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
	
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('catalog/partners_list', $data));

	}

	private function getForm() { 

		$this->load->language('catalog/partners');
	
		$this->load->model('catalog/partners');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$data['heading_title'] = $this->language->get('heading_title');
	
		$data['text_form'] = !isset($this->request->get['partner_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
    	$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
	
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['column_date_added'] = $this->language->get('column_date_added');
	
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_annonce'] = $this->language->get('entry_annonce');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_h1'] = $this->language->get('entry_meta_h1');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_status'] = $this->language->get('entry_status');
	
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
	
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');

		$data['help_keyword'] = $this->language->get('help_keyword');		
	
		$data['token'] = $this->session->data['token'];
	
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
	
		$data['breadcrumbs'] = array();
	
		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);
	
		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('catalog/partners', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);
	
		if (!isset($this->request->get['partner_id'])) {
			$data['action'] = $this->url->link('catalog/partners/add', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('catalog/partners/edit', 'token=' . $this->session->data['token'] . '&partner_id=' . $this->request->get['partner_id'], true);
		}
	
		$data['cancel'] = $this->url->link('catalog/partners', 'token=' . $this->session->data['token'], true);
	
		if ((isset($this->request->get['partner_id'])) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$partners_infs = $this->model_catalog_partners->getPartner($this->request->get['partner_id']);
		
		}   else {
		$partners_infs = false;
	}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('tool/image');
		
		if ($partners_infs) {
		foreach ($partners_infs as $partner_info) {
		
			//$this->load->model('setting/store');
		
		
		
			if (isset($this->request->post['status'])) {
				$data['status'] = $this->request->post['status'];
			} elseif (isset($partner_info)) {
				$data['status'] = $partner_info['status'];
			} 
		
			if (isset($this->request->post['image'])) {
				$data['image'] = $this->request->post['image'];
			} elseif (!empty($partner_info)) {
				$data['image'] = $partner_info['image'];
			} 
			
			if (isset($this->request->post['link'])) {
				$data['link'] = $this->request->post['link'];
			} elseif (!empty($partner_info)) {
				$data['link'] = $partner_info['link'];
			} 
			
			if (isset($this->request->post['sort_order'])) {
				$data['sort_order'] = $this->request->post['sort_order'];
			} elseif (!empty($partner_info)) {
				$data['sort_order'] = $partner_info['sort_order'];
			} 
			
			if (isset($this->request->post['image_title'])) {
				$data['image_title'] = $this->request->post['image_title'];
			} elseif (!empty($partner_info)) {
				$data['image_title'] = $partner_info['image_title'];
			}

			

			if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
			} elseif (!empty($partner_info) && is_file(DIR_IMAGE . $partner_info['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($partner_info['image'], 100, 100);
			} 
		
		}
	} else {
		
		
		$data['status'] = '';
		$data['image'] = '';
		$data['link'] = '';
		$data['sort_order'] = '';
		$data['image_title'] = '';
		$data['status'] = '1';
		$data['status'] = '1';
		$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			
	}
		
		

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

	
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('catalog/partners_form', $data));

	}
	public function setting() {
		$this->load->language('catalog/partners');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('catalog/partners');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSetting()) {
			$this->model_setting_setting->editSetting('partners_setting', $this->request->post);
				if (isset($this->request->post['partners_url'])) {
					$this->model_catalog_partners->setpartnersListUrl($this->request->post['partners_url']);
				}	
			$this->session->data['success'] = $this->language->get('text_success');

			$this->cache->delete('partners_setting');

			$this->response->redirect($this->url->link('catalog/partners', 'token=' . $this->session->data['token'], true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['thumb'])) {
			$data['error_thumb'] = $this->error['thumb'];
		} else {
			$data['error_thumb'] = '';
		}

		if (isset($this->error['popup'])) {
			$data['error_popup'] = $this->error['popup'];
		} else {
			$data['error_popup'] = '';
		}

		if (isset($this->error['description_limit'])) {
			$data['error_limit'] = $this->error['description_limit'];
		} else {
			$data['error_limit'] = '';
		}		

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['entry_thumb'] = $this->language->get('entry_thumb');
		$data['entry_popup'] = $this->language->get('entry_popup');
		$data['entry_share'] = $this->language->get('entry_share');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_partners_url'] = $this->language->get('entry_partners_url');

		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');

		$data['action'] = $this->url->link('catalog/partners/setting', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('catalog/partners', 'token=' . $this->session->data['token'], true);
	
		$data['breadcrumbs'] = array();
	
		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);
	
		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('catalog/partners', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('catalog/partners/setting', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('text_partners_setting'),
			'separator' => ' :: '
		);	

		if (isset($this->request->post['partners_setting'])) {
			$partners_setting = $this->request->post['partners_setting'];
		} elseif ($this->config->get('partners_setting')) {
			$partners_setting = $this->config->get('partners_setting');
		} else {
			$partners_setting = array();
		}

		if (isset($partners_setting['partners_thumb_width'])) {
			$data['partners_thumb_width'] = $partners_setting['partners_thumb_width'];
		} else {
			$data['partners_thumb_width'] = '';
		}	

		if (isset($partners_setting['partners_thumb_height'])) {
			$data['partners_thumb_height'] = $partners_setting['partners_thumb_height'];
		} else {
			$data['partners_thumb_height'] = '';
		}	

		if (isset($partners_setting['partners_popup_width'])) {
			$data['partners_popup_width'] = $partners_setting['partners_popup_width'];
		} else {
			$data['partners_popup_width'] = '';
		}	

		if (isset($partners_setting['partners_popup_height'])) {
			$data['partners_popup_height'] = $partners_setting['partners_popup_height'];
		} else {
			$data['partners_popup_height'] = '';
		}	

		if (isset($partners_setting['description_limit'])) {
			$data['description_limit'] = $partners_setting['description_limit'];
		} else {
			$data['description_limit'] = '';
		}

		if (isset($partners_setting['partners_share'])) {
			$data['partners_share'] = $partners_setting['partners_share'];
		} else {
			$data['partners_share'] = '';
		}								

		$partners_url = $this->model_catalog_partners->getpartnersListUrl('information/partners');

		if($partners_url){
			$data['partners_url'] = $partners_url;
		}else{
			$data['partners_url'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('catalog/partners_setting', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/partners')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		/*foreach ($this->request->post['partners_description'] as $language_id => $value) {
			if ((strlen($value['title']) < 3) || (strlen($value['title']) > 355)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
				
			}
		
			if (strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
		}
	*/
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/partners')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		return !$this->error;
	}

	protected function validateSetting() {
		if (!$this->user->hasPermission('modify', 'catalog/partners')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$partners_setting = $this->request->post['partners_setting'];

		if (!$partners_setting['partners_thumb_width'] || !$partners_setting['partners_thumb_height']) {
			$this->error['thumb'] = $this->language->get('error_thumb');
		}
	
		if (!$partners_setting['partners_popup_width'] || !$partners_setting['partners_popup_height']) {
			$this->error['popup'] = $this->language->get('error_popup');
		}

		if (!$partners_setting['description_limit']) {
			$this->error['description_limit'] = $this->language->get('error_description_limit');
		}		
	
		return !$this->error;
	}
}
?>