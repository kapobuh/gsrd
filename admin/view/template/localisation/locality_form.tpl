<?php echo $header; ?>

<?php if (!$district_id) { ?>
<style>
  .districts_for_r {
    display: none;
  }
</style>
<?php } ?>

<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div  id="center_main_block" class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-order-status" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div id="center_main_block" class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-order-status" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_type; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>

                <select id="locality_type" name="locality[<?php echo $language['language_id']; ?>][type]" class="form-control">
                  <option value="G"><?php echo $text_gorod;?></option>
                  <option value="R"><?php echo $text_district;?></option>
                  <option value="S"><?php echo $text_vilage;?></option>
                </select>

              <?php if (isset($error_name[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              <?php } ?>
              <?php } ?>
            </div>
          </div>


          <div class="form-group required districts_for_r">
            <label class="col-sm-2 control-label">Район</label>
            <div class="col-sm-10">

              <select id="district_list" name="district_id" class="form-control">
                <option value="0">Выберите район</option>
                <?php if ($district_list) { ?>
                <?php foreach ($district_list as $district) { ?>
                  <?php if ($district['locality_id'] == $district_id['vilage_id']) { ?>
                    <option selected value="<?php echo $district['locality_id']; ?>"><?php echo $district['name']; ?></option>
                <?php } else { ?>
                    <option value="<?php echo $district['locality_id']; ?>"><?php echo $district['name']; ?></option>
                <?php } ?>
                <?php } ?>
                <?php } ?>
              </select>

              <?php if (isset($error_district)) { ?>
              <div class="text-danger"><?php echo $error_district; ?></div>
              <?php } ?>
              </div>
          </div>


          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
              <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="locality[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($locality[$language['language_id']]) ? $locality[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
              </div>
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              <?php } ?>
              <?php } ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){


      $('#locality_type').change(function(){
          if ($(this).val() === 'S') {
              $('.districts_for_r').show();
          } else {
              $('#district_list option[value="0"]').prop('selected', true);
              $('.districts_for_r').hide();

          }
      });

     // $('#locality_type option[value="<?php echo $locality[3]['type']; ?>"]').attr('selected','true');
  });
</script>
<?php echo $footer; ?>