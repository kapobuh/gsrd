<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">

	</div>
	<div id="center_main_block" class="container-fluid">
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
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_inbox_list; ?></h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
					<?php if ($psrs) { ?>

						<tr>
							<th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
							<th><?php echo $column_name; ?></th>
							<th><?php echo $column_address; ?></th>
							<th><?php echo $column_psp; ?></th>
							<th><?php echo $column_date_added; ?></th>
						</tr>

						<?php foreach($psrs as $psr) { ?>
						<tr>
							<td class="text-center">
								<input type="checkbox" name="selected[]" value="<?php echo $psr['psr_id']; ?>" />
							</td>
							<td><a href="<?php echo $psr['href']; ?>"><?php echo $psr['name']; ?></a></td>
							<td><?php echo $psr['address']; ?></td>
							<td><?php echo $psr['psp']; ?></td>
							<td><?php echo $psr['date_added']; ?></td>
						</tr>
						<?php } ?>

				<?php } else { ?>

						<tr>
							<td>
								<p class="text-center"><?php echo $text_empty; ?></p>
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
	</div>
</div>
<?php echo $footer; ?>