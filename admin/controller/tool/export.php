<?php

require_once(DIR_SYSTEM.'library/PHPExcel.php');

class ControllerToolExport extends Controller {
	private $error = array();
	
	public function index() {
	
	}
    
	// Выгрузка закзаов
	public function orders() {
		$this->load->model('tool/export');
		$xls = new PHPExcel();
		$xls->setActiveSheetIndex(0);  
		$orders = array();
		
		
		// Только наборы
		if ((isset($this->request->post['export_promo']))) {
			$promo_code = true;
		} else {
			$promo_code = false;		
		}
		
		// Только наборы
		if ((isset($this->request->post['nabors_only']))) {
			$nabors_only = true;
		} else {
			$nabors_only = false;		
		}
		
		$date_start = $this->request->post['exportdate_start'];
		$date_end = $this->request->post['exportdate_end'];
		
		$filter_data = array(
				'date_start' => $date_start,
				'date_end'   => $date_end
			);
		
		if ($promo_code) {
			$orders = $this->model_tool_export->getCouponOrders($filter_data);
		} elseif ($nabors_only) {
			$orders = $this->model_tool_export->getNaborOrders($filter_data);
		} else {
			$orders = $this->model_tool_export->getOrders($filter_data);
		}
		
		if ($orders) {
		
        $sheet = $xls->getActiveSheet();	
		
		$sheet->getColumnDimension('A')->setWidth(15);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setWidth(20);
		$sheet->getColumnDimension('E')->setWidth(20);
		$sheet->getColumnDimension('F')->setWidth(20);
		$sheet->getColumnDimension('G')->setWidth(20);
		$sheet->getColumnDimension('H')->setWidth(50);
		$sheet->getColumnDimension('I')->setWidth(15);
		$sheet->getColumnDimension('J')->setWidth(95);
			
		if ($promo_code) {
			$sheet->getColumnDimension('K')->setWidth(20);
		}
			
		$i=1;
			
			$xls->getActiveSheet()->setCellValue('A'.$i, 'Номер заказа');
			$xls->getActiveSheet()->setCellValue('B'.$i, 'Дата заказа');
			$xls->getActiveSheet()->setCellValue('C'.$i, 'Покупатель');
			$xls->getActiveSheet()->setCellValue('D'.$i, 'Город');
			$xls->getActiveSheet()->setCellValue('E'.$i, 'Статус заказа');
			$xls->getActiveSheet()->setCellValue('F'.$i, 'Сумма без доставки');
			$xls->getActiveSheet()->setCellValue('G'.$i, 'Стоимость доставки');
			$xls->getActiveSheet()->setCellValue('H'.$i, 'Способ доставки');
			$xls->getActiveSheet()->setCellValue('I'.$i, 'Итого');
			$xls->getActiveSheet()->setCellValue('J'.$i, 'Продукты');
			
			if ($promo_code) {
				$xls->getActiveSheet()->setCellValue('K'.$i, 'Промокод');
			}
			
			$style_data = array ( 'fill' => array(
									'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
									'color'=>array(
										'rgb' => '4472C4'
									)),

									'font'=> array(
									'bold' => true,
									'color'=>array(
										'rgb' => 'FFFFFF'
									))					
								);
			
			$sheet->getStyle('A1:K1')->applyFromArray($style_data);
			
			foreach($orders as $order) {
				$i++;
				
				$sheet->getRowDimension($i)->setRowHeight(-1); 
				
				$sheet->getStyle("A{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle("B{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle("F{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle("G{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle("I{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle("K{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				
				$sheet->getStyle("J{$i}")->getAlignment()->setWrapText(true);
				
				$xls->getActiveSheet()->setCellValue('A'.$i, $order['order_id']);
				$xls->getActiveSheet()->setCellValue('B'.$i, date($this->language->get('date_format_short'), strtotime($order['date_added'])));
				$xls->getActiveSheet()->setCellValue('C'.$i, $order['klient']);
				$xls->getActiveSheet()->setCellValue('D'.$i, $order['city']);
				$xls->getActiveSheet()->setCellValue('E'.$i, $order['order_status']);
				$xls->getActiveSheet()->setCellValue('F'.$i, (int)$order['subtotal']);
				$xls->getActiveSheet()->setCellValue('G'.$i, (int)$order['shipping']);
				$xls->getActiveSheet()->setCellValue('H'.$i, $order['typetotal']);
				$xls->getActiveSheet()->setCellValue('I'.$i, (int)$order['total']);
				$xls->getActiveSheet()->setCellValue('J'.$i, $order['products']);
				
				
				if ($promo_code) {
					$chars = ['Купон (',')'];
					$promo_title = str_replace($chars, '', $order['promocode']);
					$xls->getActiveSheet()->setCellValue('K'.$i, $promo_title);
				}
				
				
			}
			
	        $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel5'); 
			
			if (!$promo_code) {
				$filename = 'Orders_'.date($this->language->get('date_format_short'), strtotime($date_start)).' - '.date($this->language->get('date_format_short'), strtotime($date_end)).'.xls';
			} else {
				$filename = 'Orders_'.date($this->language->get('date_format_short'), strtotime($date_start)).' - '.date($this->language->get('date_format_short'), strtotime($date_end)).'.xls';
			}
			
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"'); 
			header('Cache-Control: max-age=0'); 

			$objWriter->save('php://output'); 
			unset($orders);
			exit();
		} else {
			echo '<br/><p style="text-align:center">Prover`te datu.</p><p style="text-align:center">Net zakazov dlya vigruzki. </p><p style="text-align:center"><button onclick="history.back()">Nazad</button></p>';
			unset($orders);
			
		}
	}
	
	
	// Email`s для рассылки
	public function newsletter() {
			$this->load->model('tool/export');
			$xls = new PHPExcel();
			$xls->setActiveSheetIndex(0);  
			$emails = array();

			$emails = $this->model_tool_export->getEmails();

			if ($emails) {

			$sheet = $xls->getActiveSheet();
			$sheet->getColumnDimension('A')->setWidth(50);
			$i=0;
		
			foreach($emails as $email) {
				$i++;
				$xls->getActiveSheet()->setCellValue('A'.$i, $email['email']);
			}
			
	        $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel5'); 
				
			$today = date("Y-m-d");
			
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="Emails_'.date($this->language->get('date_format_short'), strtotime($today)).'.xls"'); 
			header('Cache-Control: max-age=0'); 

			$objWriter->save('php://output'); 
			exit();
		} else {
			echo '<br/><p style="text-align:center">Error.</p><p style="text-align:center"><button onclick="history.back()">Nazad</button></p>';
			
		}
	}
    
    public function quick_orders() {
        
        $this->load->model('tool/export');
		$xls = new PHPExcel();
		$xls->setActiveSheetIndex(0);  
		$orders = array();
        
        $filter_data = array(
                'date_start' => $this->request->post['exportdate_start'],
                'date_end'   => $this->request->post['exportdate_end']
            );
        
        $orders = $this->model_tool_export->getQuickOrders($filter_data);
        
        if ($orders) {
            
             $sheet = $xls->getActiveSheet();	
            
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(75);
            $sheet->getColumnDimension('C')->setWidth(10);
            $sheet->getColumnDimension('D')->setWidth(30);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(20);

            $i=1;

            $xls->getActiveSheet()->setCellValue('A'.$i, 'Номер заказа');
            $xls->getActiveSheet()->setCellValue('B'.$i, 'Продукт');
            $xls->getActiveSheet()->setCellValue('C'.$i, 'Количество');
            $xls->getActiveSheet()->setCellValue('D'.$i, 'Отправитель');
            $xls->getActiveSheet()->setCellValue('E'.$i, 'Номер телефона');
            $xls->getActiveSheet()->setCellValue('F'.$i, 'Дата добавления');
            
            $sheet->getStyle('A1:K1')->applyFromArray(array ( 'fill' => array(
                                        'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
                                        'color'=>array(
                                            'rgb' => '4472C4'
                                        )),

                                        'font'=> array(
                                        'bold' => true,
                                        'color'=>array(
                                            'rgb' => 'FFFFFF'
                                        ))					
                                    ));
            
            foreach($orders as $order) {
				$i++;
				
				$sheet->getRowDimension($i)->setRowHeight(-1); 
                
                $sheet->getStyle("A{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("D{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("E{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("F{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$xls->getActiveSheet()->setCellValue('A'.$i, $order['quick_order_id']);
                $xls->getActiveSheet()->setCellValue('B'.$i, $order['product']);
                $xls->getActiveSheet()->setCellValue('C'.$i, $order['quantity']);
                $xls->getActiveSheet()->setCellValue('D'.$i, $order['name']);
                $xls->getActiveSheet()->setCellValue('E'.$i, $order['phone']);
                $xls->getActiveSheet()->setCellValue('F'.$i, date($this->language->get('date_format_short'), strtotime($order['date_added'])));
            
            }
            
            $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel5');
            
            $filename = 'Quick_orders_'.date($this->language->get('date_format_short'), strtotime($this->request->post['exportdate_start'])).' - '.date($this->language->get('date_format_short'), strtotime($this->request->post['exportdate_end'])).'.xls';

		    header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"'); 
			header('Cache-Control: max-age=0'); 

			$objWriter->save('php://output'); 
			unset($orders);
			exit();
            
        } else {
            echo '<br/><p style="text-align:center">Prover`te datu.</p><p style="text-align:center">Net zakazov dlya vigruzki. </p><p style="text-align:center"><button onclick="history.back()">Nazad</button></p>';
			unset($orders);
        }
        
    }
}
