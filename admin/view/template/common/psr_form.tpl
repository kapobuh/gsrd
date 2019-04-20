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
				<h5 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_add; ?></h5>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

					<?php if (gettype($psps) == 'array') { ?>
					<div class="form-group required">
						<label class="text-right col-sm-3" class="control-label" for="input-psp">
							<?php echo $text_psp; ?>
						</label>
						<div class="col-sm-9">
							<select name="psp_id" class="form-control">

									<?php foreach($psps as $psp) { ?>
										<?php if ($psp['psp_id'] == $psp_id) { ?>
											<option value="<?php echo $psp['psp_id']; ?>" selected><?php echo $psp['name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $psp['psp_id']; ?>"><?php echo $psp['name']; ?></option>
										<?php } ?>
									<?php } ?>

							</select>
						</div>
					</div>
					<?php } else { ?>
					<input type="hidden" name="psp_id" value="<?php echo $psps; ?>" />
					<?php } ?>

					<div class="form-group required">
						<label class="col-sm-3 control-label text-right" for="input-type"><?php echo $text_type_psr; ?></label>
						<div class="col-sm-9">
							<select class="form-control" name="type_id">
								<?php if ($incident_types) { ?>
									<?php foreach ($incident_types as $incident_type) { ?>
										<?php if ($incident_type['incidenttype_id'] == $type_id) { ?>
										<option selected value="<?php echo $incident_type['incidenttype_id']; ?>"><?php echo $incident_type['name']; ?></option>
									<?php } else { ?>
								<option value="<?php echo $incident_type['incidenttype_id']; ?>"><?php echo $incident_type['name']; ?></option>
									<?php } ?>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-3 control-label text-right" for="input-type"><?php echo $text_locality; ?></label>
						<div class="col-sm-9">
							<select class="form-control" name="locality" id="locality_list">
								<?php if ($localitys) { ?>
									<?php foreach ($localitys as $locality) { ?>
										<?php if ($locality['locality_id'] == $locality_id) { ?>
										<option alt="<?php echo $locality['type']; ?>" value="<?php echo $locality['locality_id']; ?>" selected><?php echo $locality['name']; ?></option>
										<?php } else { ?>
										<option alt="<?php echo $locality['type']; ?>" value="<?php echo $locality['locality_id']; ?>"><?php echo $locality['name']; ?></option>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="form-group required" id="sela-list">
						<label class="col-sm-3 control-label text-right" for="input-type">Село</label>
						<div class="col-sm-9">
							<select class="form-control" name="selo">

							</select>
						</div>
					</div>


					<div class="form-group required">
						<label class="col-sm-3 control-label text-right" for="input-type"><?php echo $text_address; ?></label>
						<div class="col-sm-3">
							<input class="form-control" placeholder="<?php echo $text_street; ?>" name="street" value="<?php echo $street; ?>"/>
							<?php if ($error_street) { ?>
								<div class="text-danger"><?php echo $error_street; ?></div>
							<?php } ?>
						</div>
						<div class="col-xs-12 visible-xs"><br/></div>
						<div class="col-sm-2">
							<input class="form-control" placeholder="<?php echo $text_house; ?>" name="house" value="<?php echo $house; ?>"/>
							<?php if ($error_house) { ?>
							<div class="text-danger"><?php echo $error_house; ?></div>
							<?php } ?>
						</div>
						<div class="col-xs-12 visible-xs"><br/></div>
						<div class="col-sm-2">
							<input class="form-control" placeholder="<?php echo $text_appartment; ?>" name="appartment" value="<?php echo $appartment; ?>"/>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-3 control-label text-right" for="input-type"><?php echo $text_date; ?></label>
						<div class="col-sm-3">
							<input data-timepicker="true" autocomplete="off" type="text" class="form-control datepicker-here" placeholder="<?php echo $text_date_start; ?>" name="date_start" value="<?php echo $date_start; ?>" data-date-format="dd.mm.yyyy"/>
							<?php if ($error_date) { ?>
							<div class="text-danger"><?php echo $error_date; ?></div>
							<?php } ?>
						</div>
						<div class="col-xs-12 visible-xs"><br/></div>
						<div class="col-sm-3">
							<input data-timepicker="true" autocomplete="off" type="text" class="form-control datepicker-here" placeholder="<?php echo $text_date_end; ?>" name="date_end" value="<?php echo $date_end; ?>" data-date-format="dd.mm.yyyy"/>
							<?php if ($error_date) { ?>
							<div class="text-danger"><?php echo $error_date; ?></div>
							<?php } ?>
						</div>

					</div>

					<!-- Участники ПСР -->
					<div class="form-group col-sm-12" id="participants_block">
					<?php $participant_row = 0; ?>
					<?php foreach ($participants as $participant) { ?>
					<div class="form-group required"  id="participant_block_<?php echo $participant_row; ?>">
							<?php if ($participant_row === 0) { ?>
							<label class="col-sm-3 control-label text-right" for="input-type"><?php echo $text_participants; ?></label>
							<?php } else { ?>
						<label class="col-sm-3 control-label text-right" for="input-type"> </label>
							<?php } ?>
						<div class="col-sm-3">
								<select id="participant-list" name="participant[<?php echo $participant_row; ?>][t]" class="form-control">
									<?php if ($participant_types) { ?>
										<?php foreach ($participant_types as $participant_type) { ?>
											<?php if ($participant_type['participant_type_id'] == $participant['t']) { ?>
												<option value="<?php echo $participant_type['participant_type_id']; ?>"
	selected><?php echo $participant_type['name'];?></option>
											<?php } else { ?>
												<option value="<?php echo $participant_type['participant_type_id']; ?>" ><?php echo $participant_type['name'];?></option>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-2">
								<input name="participant[<?php echo $participant_row; ?>][q]" class="form-control" type="number" min="1" placeholder="Количество" value="<?php echo $participant['q']; ?>"/>
							</div>
							<?php if ($participant_row != 0) { ?>
							<div class="col-sm-4"><button onclick="$('#participant_block_<?php echo $participant_row; ?>').remove();" data-toggle="tooltip" class="delete_element" type="button"><i class="fa fa-minus-circle"></i></button></div>
							<?php } else { ?>
							<div class="col-sm-4"></div>
							<?php } ?>
						</div>
						<?php $participant_row++; ?>
					<?php } ?>

					<?php if ($error_participant) { ?>
						<div id="participant_error" class="col-sm-12 col-sm-offset-3">
							<div class="text-danger"><?php echo $error_participant; ?></div>
						</div>
					<?php } ?>

					</div>
					<div class="form-group col-sm-12" style="border-top:none;padding-top: 0">
					<div class="col-sm-offset-3">
						<small id="add_line_participant"><i class="fa fa-plus"></i> <?php echo $text_add_line; ?></i></small>
					</div>
					</div>


					<!-- Оборудование -->
					<div class="form-group">
						<label class="col-sm-3 control-label text-right" for="input-type"><?php echo $text_equipment; ?></label>
						<div class="col-sm-9">
							<div class="well well-sm" style="height: 150px; overflow: auto;">
								<?php foreach ($equipment_types as $equipment_type) { ?>
								<div class="checkbox">
									<label>
										<?php if (in_array($equipment_type['equipment_id'], $equipments)) { ?>
										<input type="checkbox" name="equipment[]" value="<?php echo $equipment_type['equipment_id']; ?>" checked />
										<?php } else { ?>
										<input type="checkbox" name="equipment[]" value="<?php echo $equipment_type['equipment_id']; ?>" />
										<?php } ?>
									<?php echo $equipment_type['name']; ?>
									</label>

								</div>
								<?php } ?>
							</div>
						</div>
					</div>

					<!-- Техника -->
					<div class="form-group" id="technics_block">
						<?php $technic_row = 0; ?>
						<?php foreach($technics as $technic) { ?>
						<div class="form-group required" id="technic_block_<?php echo $technic_row; ?>">

							<?php if ($technic_row === 0) { ?>
							<label class="col-sm-3 control-label text-right" for="input-type"><?php echo $text_technic; ?></label>
							<?php } else { ?>
							<label class="col-sm-3 control-label text-right" for="input-type"> </label>
							<?php } ?>

							<div class="col-sm-3">
								<select id="technic-list" name="technic[<?php echo $technic_row; ?>][technic_id]" class="form-control">
									<?php if ($technic_types) { ?>
										<?php foreach ($technic_types as $technic_type) { ?>
											<?php if ($technic_type['technic_type_id'] == $technic['type_id']) { ?>

												<option value="<?php echo $technic_type['technic_type_id']; ?>" selected
												><?php echo $technic_type['name'];?></option>

												<?php } else { ?>

												<option value="<?php echo $technic_type['technic_type_id']; ?>"
												><?php echo $technic_type['name'];?></option>

											<?php } ?>

										<?php } ?>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-2">
								<input name="technic[<?php echo $technic_row; ?>][quantity]"
									   class="form-control" type="number" min="1" placeholder="Количество" value="<?php echo $technic['quantity']; ?>"/>
							</div>

							<?php if ($technic_row != 0) { ?>
							<div class="col-sm-4"><button onclick="$('#technic_block_<?php echo $technic_row; ?>').remove();" data-toggle="tooltip" class="delete_element" type="button"><i class="fa fa-minus-circle"></i></button></div>
							<?php } else { ?>
							<div class="col-sm-4"></div>
							<?php } ?>


							</div>

						<?php $technic_row++; ?>
						<?php } ?>

						<?php if ($error_technic) { ?>
						<div id="technic_error" class="col-sm-12 col-sm-offset-3">
							<div class="text-danger"><?php echo $error_technic; ?></div>
						</div>
						<?php } ?>

					</div>

					<div class="form-group" style="border-top:none;padding-top: 0">
						<div class="col-sm-offset-3">
							<small id="add_line_technic"><i class="fa fa-plus"></i> <?php echo $text_add_line; ?></i></small>
						</div>
					</div>



					<!-- Пострадаvшие -->
					<div class="form-group" id="injureds_block">

						<?php if (empty($injureds)) { ?>

						<?php } ?>

						<?php $injured_row = 0; ?>
						<?php foreach ($injureds as $injured) { ?>
						<div class="form-group" id="injured_block_<?php echo $injured_row; ?>">
							<?php if ($injured_row === 0) { ?>
							<label class="col-sm-3 control-label text-right"
								   for="input-type"><?php echo $text_injured; ?></label>
							<?php } else { ?>
							<label class="col-sm-3 control-label text-right"
								   for="input-type"> </label>
							<?php } ?>

							<div class="col-sm-2">
								<input class="form-control" name="injured[<?php echo $injured_row; ?>][lastname]" placeholder="<?php echo $text_lastname;?>" value="<?php echo $injured['lastname']; ?>"/>
							</div>
							<div class="col-xs-12 visible-xs"><br/></div>
							<div class="col-sm-3">
								<input class="form-control" name="injured[<?php echo $injured_row; ?>][firstname]" placeholder="<?php echo $text_firstname;?>" value="<?php echo $injured['firstname']; ?>"/>
							</div>
							<div class="col-xs-12 visible-xs"><br/></div>

							<div class="col-sm-2 w14">
								<input data-date-format="yyyy" data-view="years" data-min-view="years" data-timepicker="false" autocomplete="off" type="text"  class="form-control datepicker-here" value="<?php echo $injured['birthday']; ?>" name="injured[<?php echo $injured_row; ?>][birthday]" placeholder="<?php echo $text_birthday;?>"/>
							</div>
							<div class="col-xs-12 visible-xs"><br/></div>

							<div class="col-sm-2 w14">
								<select name="injured[<?php echo $injured_row; ?>][type]" class="form-control">
									<?php if ($injured_types) { ?>
									<?php foreach ($injured_types as $injured_type) { ?>
										<?php if ($injured_type['injured_type_id'] == $injured['injured_type_id']) { ?>

											<option value="<?php echo $injured_type['injured_type_id']; ?>" selected
											><?php echo $injured_type['name'];?></option>

										<?php } else { ?>

											<option value="<?php echo $injured_type['injured_type_id']; ?>"
											><?php echo $injured_type['name'];?></option>

										<?php } ?>

									<?php } ?>
									<?php } ?>
								</select>
							</div>

						</div>
						<?php $injured_row++; ?>
						<?php } ?>

						<?php if ($error_injured) { ?>
						<div id="injured_error" class="col-sm-12 col-sm-offset-3">
							<div class="text-danger"><?php echo $error_injured; ?></div>
						</div>
						<?php } ?>


					</div>
					<div class="form-group" style="border-top:none;padding-top: 0">
						<div class="col-sm-offset-3 col-sm-6">
							<small id="add_line_injured"><i class="fa fa-plus"></i> <?php echo $text_add_line; ?></i>
							</small>
						</div>
						<div class="col-sm-3 text-right">
							<div class="checkbox">
								<label>
									<?php if ($none_injured) { ?>
										<input id="none_injured" type="checkbox" name="none_injured" checked/>
									<?php } else { ?>
										<input id="none_injured" type="checkbox" name="none_injured"/>
									<?php } ?>
									<?php echo $text_none_injured; ?>
								</label>
							</div>
						</div>
					</div>

					<!-- Описание ПСР -->
					<div class="form-group">
						<label class="col-sm-3 control-label text-right"
							   for="input-type"><?php echo $text_description; ?></label>
						<div class="col-sm-9">
							<textarea id="psr_description" name="description" placeholder="Выполненная работа..." class="form-control summernote"><?php echo $description; ?></textarea>
						</div>

						<?php if ($error_description) { ?>
						<div id="description_error" class="col-sm-12 col-sm-offset-3">
							<div class="text-danger"><?php echo $error_description; ?></div>
						</div>
						<?php } ?>

					</div>

					<div class="form-group" style="border-top:none;padding-top: 0">
						<div class="col-sm-12 text-center">
							<br/>
							<button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> <?php echo $text_save_button;?></button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<script type="text/javascript">


	var participant_row = <?php echo $participant_row; ?>;

	$('#add_line_participant').click(function(){
        html = '<div class="form-group required" style="border-top: none;padding-top: 0px;" id="participant_block_'+ participant_row +'"><label class="col-sm-3 control-label text-right" for="input-type"></label><div class="col-sm-3"><select name="participant['+ participant_row +'][t]" class="form-control"><?php if ($participant_types) { ?><?php foreach ($participant_types as $participant_type) { ?><option value="<?php echo $participant_type['participant_type_id']; ?>"><?php echo $participant_type['name'];?></option><?php } ?><?php } ?></select></div><div class="col-sm-2"><input name="participant[' + participant_row + '][q]" class="form-control" type="number" min="1" value="1" placeholder="Количество"/></div><div class="col-sm-4"><button onclick="$(\'#participant_block_' + participant_row  + '\').remove();participant_row--" data-toggle="tooltip" class="delete_element" type="button"><i class="fa fa-minus-circle"></i></button></div></div>';

		if ($('#participant-list option').length > participant_row) {
            $('#participants_block ').append(html);
            $('#participant_error').remove();
            participant_row++;
		}

});


    var technic_row = <?php echo $technic_row; ?>;

    $('#add_line_technic').click(function(){
        html = '<div class="form-group required" style="border-top: none;padding-top: 0px;" id="technic_block_'+ technic_row +'"><label class="col-sm-3 control-label text-right" for="input-type"></label><div class="col-sm-3"><select name="technic['+ technic_row +'][technic_id]" class="form-control"><?php if ($technic_types) { ?><?php foreach ($technic_types as $technic_type) { ?><option value="<?php echo $technic_type['technic_type_id']; ?>"><?php echo $technic_type['name'];?></option><?php } ?><?php } ?></select></div><div class="col-sm-2"><input name="technic[' + technic_row + '][quantity]" class="form-control" value="1" type="number" min="1" placeholder="Количество"/></div><div class="col-sm-4"><button onclick="$(\'#technic_block_' + technic_row  + '\').remove();technic_row--" data-toggle="tooltip" class="delete_element" type="button"><i class="fa fa-minus-circle"></i></button></div></div>';

        if ($('#technic-list option').length > technic_row) {
            $('#technics_block ').append(html);
            $('#technic_error').remove();

            technic_row++;
        }

        // Скрываем уже выбранные варианты
        $('#technic-list').each(function(indx, el) {

        });
    });

    var injured_row = <?php echo $injured_row; ?>;

    $('#add_line_injured').click(function(){
        html = '<div class="form-group" style="border-top: none;padding-top: 0px;" id="injured_block_'+ injured_row +'"><label class="col-sm-3 control-label text-right" for="input-type"></label><div class="col-sm-2"><input class="form-control" value="" name="injured['+ injured_row +'][lastname]" placeholder="<?php echo $text_lastname;?>" /></div><div class="col-xs-12 visible-xs"><br/></div><div class="col-sm-3"><input class="form-control" value="" name="injured['+ injured_row +'][firstname]" placeholder="<?php echo $text_firstname;?>"/></div><div class="col-xs-12 visible-xs"><br/></div><div class="col-sm-2 w14"><input id="birthday_dtp_' + injured_row +'" data-date-format="dd.mm.yyyy" data-timepicker="false" data-view="years" data-min-view="years" autocomplete="off" type="text"  class="form-control datepicker-here" value="" name="injured['+ injured_row +'][birthday]" placeholder="<?php echo $text_birthday;?>"/></div><div class="col-xs-12 visible-xs"><br/></div><div class="col-sm-2 w14"><select name="injured[<?php echo $injured_row; ?>][type]" class="form-control"><?php if ($injured_types) { ?><?php foreach ($injured_types as $injured_type) { ?><option value="<?php echo $injured_type['injured_type_id']; ?>"><?php echo $injured_type['name'];?></option><?php } ?><?php } ?></select></div><div class="col-sm-1 w3"><button onclick="$(\'#injured_block_' + injured_row  + '\').remove();" data-toggle="tooltip" class="delete_element" type="button"><i class="fa fa-minus-circle"></i></button></div></div>';

        $('#injureds_block').append(html);
        $('#injured_error').remove();

        // Доступ к экземпляру объекта
        $('#birthday_dtp_' + injured_row).datepicker();
        console.log($('#birthday_dtp_' + injured_row));

        injured_row++;


    });

    if ($('#none_injured').prop('checked')) {
        $('#injured_block_0 input, #injured_block_0 select').attr('disabled', 'disabled');
        $('#add_line_injured').hide();
	}


	$('#none_injured').click(function(){
		if ($(this).prop('checked')) {
			for (var i = 1; i < injured_row; i++) {
                $('#injured_block_' + i).remove();
			}
			$('#injured_block_0 input, #injured_block_0 select').attr('disabled', 'disabled')
				.val('');
            $('#add_line_injured').hide();
		} else {
            $('#injured_block_0 input, #injured_block_0 select').removeAttr('disabled');
            $('#add_line_injured').show();
		}

	});

    $(document).ready(function(){
        $('#locality_list').change(function(){
			if (($('#locality_list').find(':selected').attr('alt')) == 'R') {
				$.ajax({
					url: '?route=common/functions/getSeloByDistrict',
					type: 'get',
					data: {
						district_id: $('#locality_list').find(':selected').val(),
                        token:		 '<?php echo $token; ?>'
					},
					success: function(json) {
					    $('#sela-list').show();
					    html = '';
					    json.forEach(function(indx, el) {
                            id = indx['selo_id'];
					        name = indx['name'];
					        html = html + '<option value="' + id + '">' + name + '</option>';
						});
					    $('#sela-list select').html(html);
					}
				})
			} else {
                $('#sela-list').hide();
                $('#sela-list select').html('<option value="0"></option>');
			}
		});

        $('#locality_list').trigger('change');

        $(function () {
            $('#date_select').datetimepicker({
                defaultDate: new Date(),
                viewMode: 'months',
                format: 'MM.YYYY',
                locale: 'ru'

            });
        });

	});



    function hideSelectedElem(elem) {
		elem.each(function (indx, el) {
			alert(el);
        })
	}


</script>
<?php echo $footer; ?>