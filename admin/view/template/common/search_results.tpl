<!--script src="view/javascript/psr.js" type="text/javascript"></script-->
<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_inbox_list_search; ?></h3>
			</div>
			<div class="panel-body">
				<h3>Найдено <?php echo ($psrs_count) ? $psrs_count : '0'; ?> поисково-спасательных работ</h3>
				<hr/>
				<div class="row">
					<div class="col-sm-4">
						<h4><b>Использованное оборудование</b></h4>
						<?php if ($equipment_totals) { ?>
						<ul>
							<?php foreach ($equipment_totals as $equipment_total) { ?>
							<li><?php echo $equipment_total['name']; ?> - <?php echo $equipment_total['quantity']; ?></li>
							<?php } ?>
						</ul>
						<?php } else { ?>
						<p>Оборудование не использовалось.</p>
						<?php } ?>
					</div>
					<div class="col-sm-3">
						<h4><b>Пострадавшие: <?php echo ($injured_totals) ? $count_injureds : 0; ?></b></h4>
						<?php if ($injured_totals) { ?>
						<ul>
							<?php foreach ($injured_totals as $injured_total) { ?>
								<li><?php echo $injured_total['type']; ?> - <?php echo $injured_total['quantity']; ?></li>
							<?php } ?>
						</ul>
						<?php } ?>
					</div>

				</div>
				<div class="table-responsive">
					<br/>
					<br/>
					<table class="table table-hover">
					<?php if ($psrs) { ?>
						<tr>
							<th><?php echo $column_name; ?></th>
							<th><?php echo $column_address; ?></th>
							<th><?php echo $column_psp; ?></th>
							<th><?php echo $column_date_added; ?></th>
							<th></th>
						</tr>
						<?php foreach($psrs as $psr) { ?>
						<tr id="psr-item-<?php echo $psr['psr_id']; ?>" class="psr-item">
							<td><span class="psr_link" alt="<?php echo $psr['psr_id']; ?>"><?php echo $psr['name']; ?></span></td>
							<td><?php echo $psr['address']; ?></td>
							<td><?php echo $psr['psp']; ?></td>
							<td><?php echo $psr['date_added']; ?></td>
							<td><a target="_blank" href="<?php echo $psr['edit']; ?>">Редактировать</a></td>
						</tr>
						<?php } ?>
				<?php } else { ?>
						<tr>
							<td>
								<p class="text-center"><?php echo $text_empty2; ?></p>
								<br/>
							</td>
						</tr>
						<?php } ?>
					</table>
					</div>
			</div>
		</div>
<script type="text/javascript">
    /**
     * Информация об одной ПСР
     */
    var admin_token = $('#admin-token').val();
    $('.psr_link').click(function () {
        var psr_id = $(this).attr("alt");
        $.ajax({
            url: '?route=common/search/getPsrInfo&token=' + admin_token,
            type: 'get',
            data: 'psr_id=' + psr_id,
            beforeSend: function(){
                $('#psr_info_modal .modal-content .modal-body').html('Загрузка...');
                $('#psr_info_modal').modal();
            },
            success: function(html) {
                $('#psr_info_modal .modal-content').html(html);
            }
        })

    });
</script>