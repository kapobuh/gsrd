<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
		<button type="button" id="button-delete" form="form-order" formaction="<?php echo $delete; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
            <div class="row">
                <form action="<?php echo $export_excel; ?>" method="post">
				<div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="input-exportdate-start">Начальная дата</label>
                        <div class="input-group date">
                            <input type="text" name="exportdate_start" value="" placeholder="Начальная дата" data-date-format="YYYY-MM-DD" id="input-exportdate-start" class="form-control" />
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label" for="input-exportdate-end">Конечная дата</label>
                            <div class="input-group date">
                                <input type="text" name="exportdate_end" value="" placeholder="Конечная дата" data-date-format="YYYY-MM-DD" id="input-exportdate-end" class="form-control" />
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                </span>
				            </div>
              	         </div>
                    </div>
                    <div class="col-sm-4">
                        <br/><br/>
                        <button type="submit" id="button-filter" class="btn btn-success"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Выгрузить</button>
                    </div>
					<br/>
				  
					</form>
				  <br />
				  <br />
				  <br />
				  

			  
            </div>
          </div>
        <form method="post" action="" enctype="multipart/form-data" id="form-order">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-center">Номер заказа</td>
				  <td class="text-center">Продукт</td>
				  <td class="text-center">Количество</td>
				  <td class="text-center">Отправитель</td>
				  <td class="text-center">Номер телефона</td>		  
				  <td class="text-center">Дата добавления</td>
				  <td class="text-center">Печать</td>
              <tbody>
                <?php if ($quick_orders) { ?>
                <?php foreach ($quick_orders as $quick_order) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($quick_order['quick_order_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $quick_order['quick_order_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $quick_order['quick_order_id']; ?>" />
                    <?php } ?>
                    <input type="hidden" name="shipping_code[]" value="<?php echo $quick_order['shipping_code']; ?>" /></td>
					
                  <td class="text-center"><?php echo $quick_order['quick_order_id']; ?></td>
                  <td class="text-left"><?php echo $quick_order['product_name']; ?></td>
                  <td class="text-center"><?php echo $quick_order['quantity']; ?></td>
                  <td class="text-center"><?php echo $quick_order['name']; ?></td>
                  <td class="text-center"><?php echo $quick_order['phone']; ?></td>
                  <td class="text-center"><?php echo $quick_order['date_added']; ?></td>
				  <td class="text-center"><a target="_blank" class="btn btn-primary" href="<?php echo $quick_order['invoice']; ?>"><i class="fa fa-print"></i></a></td>

                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=sale/order&token=<?php echo $token; ?>';

	var filter_quick_order_id = $('input[name=\'filter_quick_order_id\']').val();

	if (filter_quick_order_id) {
		url += '&filter_quick_order_id=' + encodeURIComponent(filter_quick_order_id);
	}

	var filter_customer = $('input[name=\'filter_customer\']').val();

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

	var filter_quick_order_status = $('select[name=\'filter_quick_order_status\']').val();

	if (filter_quick_order_status != '*') {
		url += '&filter_quick_order_status=' + encodeURIComponent(filter_quick_order_status);
	}

	var filter_total = $('input[name=\'filter_total\']').val();

	if (filter_total) {
		url += '&filter_total=' + encodeURIComponent(filter_total);
	}

	var filter_date_added = $('input[name=\'filter_date_added\']').val();

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_date_modified = $('input[name=\'filter_date_modified\']').val();

	if (filter_date_modified) {
		url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
	}

	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter_customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_customer\']').val(item['label']);
	}
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
	$('#button-shipping, #button-invoice').prop('disabled', true);

	var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-invoice').prop('disabled', false);
	}

	for (i = 0; i < selected.length; i++) {
		if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
			$('#button-shipping').prop('disabled', false);

			break;
		}
	}
});

$('#button-shipping, #button-invoice').prop('disabled', true);

$('input[name^=\'selected\']:first').trigger('change');

// IE and Edge fix!
$('#button-shipping, #button-invoice').on('click', function(e) {
	$('#form-order').attr('action', this.getAttribute('formAction'));
});

$('#button-delete').on('click', function(e) {
	$('#form-order').attr('action', this.getAttribute('formAction'));
	
	if (confirm('<?php echo $text_confirm; ?>')) {
		$('#form-order').submit();
	} else {
		return false;
	}
});
//--></script> 
  <script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?> 