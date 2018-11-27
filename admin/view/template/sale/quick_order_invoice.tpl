<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="all" />
</head>
<body style="height:auto">
<div class="container" style="margin-top:200px;">
  <div style="page-break-after: always; background:#fff;">
  <br/>
    <!--h1 class="text-center"><img src="view/image/nfologo.png" alt="" style="position:absolute;left:0;top:0;width:100%"/></h1-->
	<br/>
	<h2 class="text-center center-block" style="width:95%;"><?php echo $order_type;?> №<?php echo $order_id; ?></h2>
	<h4 class="text-center center-block" style="width:95%;"><?php echo $date_added; ?></h4>
    <hr/>
	<p class="center-block" style="width:95%;"><b>Пoкупатель: </b><?php echo $name; ?></p>
	<p class="center-block" style="width:95%;"><b>Телефон: </b><?php echo $phone; ?></p>
	
	<p class="center-block" style="width:95%;"><b>Продукт: </b><?php echo $product; ?></p>
	<p class="center-block" style="width:95%;"><b>Количество: </b><?php echo $quantity ?></p>

	
  <!--div><img src="view/image/schet-bg.png" alt="" style="@page { margin:0; } margin:0; z-index:-9990; position:absolute; right:0; left:0; bottom: 0; width:100%;"/></div-->
</div>
</div>
</body>
</html>