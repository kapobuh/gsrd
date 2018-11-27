<?php
class ControllerCommonColumnLeft extends Controller {
	public function index() {
		if (isset($this->request->get['token']) && isset($this->session->data['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$this->load->language('common/column_left');
	
			$this->load->model('user/user');
	
			$this->load->model('tool/image');
	
			$user_info = $this->model_user_user->getUser($this->user->getId());
	
			if ($user_info) {
				$data['firstname'] = $user_info['firstname'];
				$data['lastname'] = $user_info['lastname'];
	
				$data['user_group'] = $user_info['user_group'];
	
				if (is_file(DIR_IMAGE . $user_info['image'])) {
					$data['image'] = $this->model_tool_image->resize($user_info['image'], 45, 45);
				} else {
					$data['image'] = '';
				}
			} else {
				$data['firstname'] = '';
				$data['lastname'] = '';
				$data['user_group'] = '';
				$data['image'] = '';
			}			
		
			// Create a 3 level menu array
			// Level 2 can not have children
			
			// Menu
           // if ($this->user->hasPermission('access', 'common/psr/add')) {
            if ($this->user->getGroupId() == ADMIN_GROUP) {


            $data['menus'][] = array(
                    'id' => 'menu-search',
                    'icon' => 'fa-search',
                    'name' => $this->language->get('text_search'),
                    'href' => $this->url->link('common/search', 'token=' . $this->session->data['token'], true),
                    'children' => array()
                );
            }

            //if ($this->user->hasPermission('access', 'common/psr/add')) {
                $data['menus'][] = array(
                    'id' => 'menu-psr-add',
                    'icon' => 'fa-plus',
                    'name' => $this->language->get('text_add_psr'),
                    'href' => $this->url->link('common/psr/add', 'token=' . $this->session->data['token'], true),
                    'children' => array()
                );
            //}

            $this->load->model('common/lists');
            $count_inbox = $this->model_common_lists->getInboxCount();
            if ($count_inbox) {
                $total_inbox = ' <b>('.$count_inbox.')</b>';
            } else {
                $total_inbox = '';
            }

            if ($this->user->hasPermission('access', 'common/inbox')){
            $data['menus'][] = array(
                'id' => 'menu-psr-inbox',
                'icon' => 'fa-list',
                'name' => $this->language->get('text_inbox_psr') . $total_inbox,
                'href' => $this->url->link('common/inbox', 'token=' . $this->session->data['token'], true),
                'children' => array()
            );
            }
			
			// Catalog
			$catalog = array();
			
			
	
			// Extension
			$extension = array();
			
			
			// System
			$system = array();
			
			
			// Users
			$user = array();
			
			if ($this->user->hasPermission('access', 'user/user')) {
				$user[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => $this->url->link('user/user', 'token=' . $this->session->data['token'], true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'user/user_permission')) {	
				$user[] = array(
					'name'	   => $this->language->get('text_user_group'),
					'href'     => $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], true),
					'children' => array()		
				);	
			}
			
		
			if ($user) {
				$system[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => '',
					'children' => $user		
				);
			}
			
			// Localisation
			$localisation = array();
			
			
            if ($this->user->hasPermission('access', 'localisation/psp')) {
                $localisation[] = array(
                    'name'	   => $this->language->get('text_psp'),
                    'href'     => $this->url->link('localisation/psp', 'token=' . $this->session->data['token'], true),
                    'children' => array()
                );
            }

            if ($this->user->hasPermission('access', 'localisation/incident_type')) {
                $localisation[] = array(
                    'name'	   => $this->language->get('text_incident_type'),
                    'href'     => $this->url->link('localisation/incident_type', 'token=' . $this->session->data['token'], true),
                    'children' => array()
                );
            }

            if ($this->user->hasPermission('access', 'localisation/technic')) {
                $localisation[] = array(
                    'name'	   => $this->language->get('text_technic'),
                    'href'     => $this->url->link('localisation/technic', 'token=' . $this->session->data['token'], true),
                    'children' => array()
                );
            }

            

            if ($this->user->hasPermission('access', 'localisation/participant')) {
                $localisation[] = array(
                    'name'	   => $this->language->get('text_participant'),
                    'href'     => $this->url->link('localisation/participant', 'token=' . $this->session->data['token'], true),
                    'children' => array()
                );
            }

            if ($this->user->hasPermission('access', 'localisation/equipment')) {
                $localisation[] = array(
                    'name'	   => $this->language->get('text_equipment'),
                    'href'     => $this->url->link('localisation/equipment', 'token=' . $this->session->data['token'], true),
                    'children' => array()
                );
            }

            if ($this->user->hasPermission('access', 'localisation/locality')) {
                $localisation[] = array(
                    'name'	   => $this->language->get('text_locality'),
                    'href'     => $this->url->link('localisation/locality', 'token=' . $this->session->data['token'], true),
                    'children' => array()
                );
            }

            if ($localisation) {
				$system[] = array(
					'name'	   => $this->language->get('text_localisation'),
					'href'     => '',
					'children' => $localisation	
				);
			}
			
		
		    if ($system) {
				$data['menus'][] = array(
					'id'       => 'menu-system',
					'icon'	   => 'fa-cog', 
					'name'	   => $this->language->get('text_system'),
					'href'     => '',
					'children' => $system
				);
			}
			
			
			// Stats
			$data['text_complete_status'] = $this->language->get('text_complete_status');
			$data['text_processing_status'] = $this->language->get('text_processing_status');
			$data['text_other_status'] = $this->language->get('text_other_status');
	
			$this->load->model('sale/order');
	
			
			return $this->load->view('common/column_left', $data);
		}
	}
}