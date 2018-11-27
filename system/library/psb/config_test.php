<?php 
// Данные для запросов в ПСБ
// C50E41160302E0F5D6D59F1AA3925C45 test key
// 790367686219999  test merchant
// 79036801 test terminal
return array ( 
		'site'		=> 'https://norwegianfishoil.ru',
		'terminal' 	=> '79036801',
		'merchant' 	=> '790367686219999',
		'key'		=> 'C50E41160302E0F5D6D59F1AA3925C45',
		'backref'	=> 'https://norwegianfishoil.ru/index.php?route=checkout/prompay/success',
		'link_test'	=> 'https://test.3ds.payment.ru/cgi-bin/cgi_link', //test
		'link'		=> 'https://3ds.payment.ru/cgi-bin/cgi_link',
		'desc'		=> 'NFO Оплата заказа №'
	);
?>