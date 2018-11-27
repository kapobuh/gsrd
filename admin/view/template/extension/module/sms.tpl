<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-html" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-html" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-login"><?php echo $entry_login; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sms_login" value="<?php echo $sms_login; ?>" placeholder="<?php echo $entry_login; ?>" id="input-login" class="form-control" />

            </div>
          </div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sms_password" value="<?php echo $sms_password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />

            </div>
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-service"><?php echo $entry_service; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sms_service" value="<?php echo $sms_service; ?>" placeholder="<?php echo $entry_service; ?>" id="input-service" class="form-control" />
            </div>
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-spaceforce"><?php echo $entry_spaceforce; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sms_spaceforce" value="<?php echo $sms_spaceforce; ?>" placeholder="<?php echo $entry_spaceforce; ?>" id="input-spaceforce" class="form-control" />
            </div>
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-space"><?php echo $entry_space; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sms_space" value="<?php echo $sms_space; ?>" placeholder="<?php echo $entry_space; ?>" id="input-space" class="form-control" />

            </div>
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_ordersms; ?></label>
            <div class="col-sm-10">
              <select name="sms_ordersms" id="input-status" class="form-control">
                <?php if ($sms_ordersms) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="sms_status" id="input-status" class="form-control">
                <?php if ($sms_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>  
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>