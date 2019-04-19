		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_inbox_list_search; ?></h3>
			</div>
			<div class="panel-body">
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
						<tr class="psr-item">
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
		<script>
			$(document).ready(function () {

            })
		</script>