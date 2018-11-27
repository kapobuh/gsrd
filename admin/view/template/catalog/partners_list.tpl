<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				
				<a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-success"><i class="fa fa-plus"></i></a>
				<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-partners').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
				<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-partners">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
									<td class="center hidden"><?php echo $column_image; ?></td>
									<td class="text-center" style="width:20%;">Фото</td>
									<td class="left">Описание картинки</td>
									<td class="left"><?php echo $column_status; ?></td>
									<td class="right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($partners) { ?>
								<?php $class = 'odd'; ?>
								<?php foreach ($partners as $partners_story) { ?>
								<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
								<tr class="<?php echo $class; ?>">
									<td align="center">
										<?php if ($partners_story['selected']) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $partners_story['partner_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $partners_story['partner_id']; ?>" />
										<?php } ?>
									</td>
									<td class="center hidden"><img src="<?php echo $partners_story['image']; ?>" alt="<?php echo $partners_story['title']; ?>" style="padding: 1px; border: 1px solid #DDD;" /></td>
									<td class="text-left"><img src="<?php echo $partners_story['image']; ?>" class="img-thumbnail" alt=""/></td>
									<td class="left"><?php echo $partners_story['image_title']; ?></td>
									<td class="left"><?php echo $partners_story['status']; ?></td>
				                	<td class="text-right"><a href="<?php echo $partners_story['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>	
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr class="even">
									<td class="center" colspan="7"><?php echo $text_no_results; ?></td>
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
</div>
<?php echo $footer; ?>