<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">

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
				<h3 class="panel-title"><i class="fa fa-list"></i> ПСР за сегодня</h3>
			</div>
			<div class="panel-body">
				<!--form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-partners"-->
					<div class="table-responsive">
						<?php if ($psrs) { ?>

						<?php } else { ?>

						<tr>
							<td>
								<p class="text-center">Нет добавленной информации о ПСР за сегодня.</p>
								<br/>
								<p class="text-center"><a href="<?php echo $add; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Внести информацию</a></p>
							</td>
						</tr>

						<?php } ?>
					</div>
				<!--/form-->
				<div class="row">
					<!--div class="col-sm-6 text-left"><?php echo $pagination; ?></div-->
					<!--div class="col-sm-6 text-right"><?php echo $results; ?></div-->
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>