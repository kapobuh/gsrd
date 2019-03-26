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
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h5>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-3 text-right">
						<h3><?php echo $text_period; ?></h3>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control datepicker-here" placeholder="<?php echo $text_date_start; ?>" value="<?php echo $date_start; ?>" autocomplete="off" data-date-format="dd.mm.yyyy" name="date_start"/>
					</div>
					<div class="col-sm-3">
						<input type="text" autocomplete="off" data-date-format="dd.mm.yyyy" class="form-control datepicker-here" placeholder="<?php echo $text_date_end; ?>" value="<?php echo $date_end; ?>" name="date_end" />
					</div>
					<div class="col-sm-2">
						<div class="btn btn-primary" id="search_btn">Поиск</div>
					</div>
					<div class="col-sm-2 col-sm-offset-4">
						<button id="filters_btn" class="btn btn-default"><i class="fa fa-caret-down" aria-hidden="true"></i>
							 <?php echo $text_filter; ?></button>
					</div>
				</div>
				<br/>
				<div class="row">

					<div class="col-sm-4">
						<legend><?php echo $text_locality; ?></legend>
						<div class="well well-sm" style="height: 150px; overflow: auto;">
							<?php foreach ($locality_types as $locality_type) { ?>
							<div class="checkbox">
								<label>
									<?php if (in_array($locality_type['locality_id'], $localitys)) { ?>
									<input type="checkbox" name="locality[]" value="<?php echo $locality_type['locality_id']; ?>" checked />
									<?php } else { ?>
									<input type="checkbox" name="locality[]" value="<?php echo $locality_type['locality_id']; ?>" />
									<?php } ?>
									<?php echo $locality_type['name']; ?>
								</label>

							</div>
							<?php } ?>
						</div>
					</div>

					<div class="col-sm-4">
						<legend><?php echo $text_psp; ?></legend>
						<div class="well well-sm" style="height: 150px; overflow: auto;">
							<?php foreach ($psp_types as $psp_type) { ?>
							<div class="checkbox">
								<label>
									<?php if (in_array($psp_type['psp_id'], $psps)) { ?>
									<input type="checkbox" name="psps[]" value="<?php echo $psp_type['psp_id']; ?>" checked />
									<?php } else { ?>
									<input type="checkbox" name="psps[]" value="<?php echo $psp_type['psp_id']; ?>" />
									<?php } ?>
									<?php echo $psp_type['name']; ?>
								</label>

							</div>
							<?php } ?>
						</div>
					</div>

					<div class="col-sm-4">
						<legend><?php echo $text_type; ?></legend>
						<div class="well well-sm" style="height: 150px; overflow: auto;">
							<?php foreach ($incident_types as $incident_type) { ?>
							<div class="checkbox">
								<label>
									<?php if (in_array($incident_type['incidenttype_id'], $incidents)) { ?>
									<input type="checkbox" name="incidents[]" value="<?php echo $incident_type['incidenttype_id']; ?>" checked />
									<?php } else { ?>
									<input type="checkbox" name="incident[]" value="<?php echo $incident_type['incidenttype_id']; ?>" />
									<?php } ?>
									<?php echo $incident_type['name']; ?>
								</label>

							</div>
							<?php } ?>
						</div>
					</div>



					<!--div class="col-sm-3">
						<legend>Оборудование</legend>
						<div class="well well-sm" style="height: 150px; overflow: auto;">
							<?php foreach ($equipments as $equipment) { ?>
							<div class="checkbox">
								<label>
									<?php if (in_array($equipment['equipment_id'], $equipments)) { ?>
									<input type="checkbox" name="equipments[]" value="<?php echo $equipment['equipment_id']; ?>" checked />
									<?php } else { ?>
									<input type="checkbox" name="equipments[]" value="<?php echo $equipment['equipment_id']; ?>" />
									<?php } ?>
									<?php echo $equipment['name']; ?>
								</label>

							</div>
							<?php } ?>
						</div>
					</div>

					<div-- class="col-sm-2">
						<legend>Используемая техника</legend>
						<div class="well well-sm" style="height: 150px; overflow: auto;">
							<?php foreach ($technics as $technic) { ?>
							<div class="checkbox">
								<label>
									<?php if (in_array($technic['technic_type_id'], $technics)) { ?>
									<input type="checkbox" name="technics[]" value="<?php echo $technic['technic_type_id']; ?>" checked />
									<?php } else { ?>
									<input type="checkbox" name="technics[]" value="<?php echo $technic['technic_type_id']; ?>" />
									<?php } ?>
									<?php echo $technic['name']; ?>
								</label>

							</div>
							<?php } ?>
						</div>
					</div-->

				</div>

				<div id="results" class="row">
					<div class="col-sm-12 content">
						<br/>
						<p class="text_empty text-center">Неверно указан период.</p>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div id="psr_info_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="added_message" aria-hidden="true">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title" id="myModalLabel"></h3>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть окно</button>
				<!--a href="/cart" type="button" class="btn btn-success"></a-->
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#search_btn").click(function(){
			if (($('input[name="date_start"]').val().length < 8) || ( ($('input[name="date_end"]')).val().length < 8)) {
				$('#results .content').html('<br/><p class="text_empty text-center">Неверно указан период.</p>');
                $('.text_empty').fadeIn('');
            } else {
                $.ajax({
					url:  '?route=common/search/getResults&token=<?php echo $token; ?>',
					type: 'post',
					data: $('input[type="text"], input[type="checkbox"]:checked'),
					beforeSend: function () {
						$('#results .content').html('<p class="text-center">Идет поиск...</p><p style="margin-top:-20px;" class="text-center"><img style="width:80px;" src="view/image/loading.gif" alt=""/></p>');
                    },
					success: function(html) {
                        $('#results .content').html(html);
                    }
				})
			}
		})
    })
</script>
<?php echo $footer; ?>