		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_inbox_list_search; ?></h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">

					<div class="row">
						<div class="col-sm-3">
							<p><b>Пострадавшие</b></p>
							<?php if ($injured_totals) { ?>
								<ul>
								<?php foreach ($injured_totals as $injured_total) { ?>
									<li><?php echo $injured_total['name']; ?> <?php echo $injured_total['quantity']; ?></li>
								<?php } ?>
								</ul>
							<?php } else { ?>
							<ul class="list-unstyled" style="padding: 0;margin: 0;">
								<li>Нет</li>
							</ul>
							<?php } ?>
						</div>
					</div>

					<br/>
					<br/>
					<table class="table table-hover">
					<?php if ($psrs) { ?>

						<tr>
							<!--th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th-->
							<th><?php echo $column_name; ?></th>
							<th><?php echo $column_address; ?></th>
							<th><?php echo $column_psp; ?></th>
							<th><?php echo $column_date_added; ?></th>
							<th></th>
						</tr>

						<?php foreach($psrs as $psr) { ?>
						<tr class="psr-item">
							<!--td class="text-center">
								<input type="checkbox" name="selected[]" value="<?php echo $psr['psr_id']; ?>" />
							</td-->
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

				<div class="row">
					<!--div class="col-sm-6 text-left"><?php echo $pagination; ?></div-->
					<!--div class="col-sm-6 text-right"><?php echo $results; ?></div-->
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function () {
				$('.psr_link').click(function () {
					$.ajax({
						url: '?route=common/search/getPsrInfo&token=<?php echo $token; ?>',
						type: 'get',
						data: 'psr_id=' + $(this).attr("alt"),
						beforeSend: function(){
                            $('#psr_info_modal .modal-content .modal-body').html('Загрузка...');
                            $('#psr_info_modal').modal();
						},
						success: function(html) {
                            $('#psr_info_modal .modal-content .modal-body').html(html);
						}
					})

                })
            })
		</script>