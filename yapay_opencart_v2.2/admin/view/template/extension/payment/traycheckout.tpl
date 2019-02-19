<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
	<div class="container-fluid">
	  <div class="pull-right">
		<button type="submit" form="formTc" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
		<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a> </div>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> Configuração - <?php echo $heading_title; ?></h3>
      </div>
      <div class="content">
	    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="formTc">
	  	  <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_token"><span data-toggle="tooltip" title="<?php echo $help_token; ?>"><?php echo $entry_token; ?></span></label>
            <div class="col-sm-8">
              <input type="text" name="traycheckout_token" value="<?php echo $traycheckout_token; ?>" placeholder="<?php echo $entry_token; ?>" id="traycheckout_token" class="form-control" />
            </div>
          </div>
          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_suffix"><span data-toggle="tooltip" title="<?php echo $help_suffix; ?>"><?php echo $entry_suffix; ?></span></label>
            <div class="col-sm-8">
              <input type="text" name="traycheckout_suffix" value="<?php echo $traycheckout_suffix; ?>" placeholder="<?php echo $entry_suffix; ?>" id="traycheckout_suffix" class="form-control" />
            </div>
          </div>
          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-8">
              <select name="traycheckout_status" id="traycheckout_status" class="form-control">
                <?php if ($traycheckout_status) { ?>
	            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	            <option value="0"><?php echo $text_disabled; ?></option>
	            <?php } else { ?>
	            <option value="1"><?php echo $text_enabled; ?></option>
	            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	            <?php } ?>
              </select>
            </div>
          </div>
          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_sandbox"><span data-toggle="tooltip" title="<?php echo $help_sandbox; ?>"><?php echo $entry_sandbox; ?></span></label>
            <div class="col-sm-8">
              <select name="traycheckout_sandbox" id="traycheckout_sandbox" class="form-control">
                <?php if ($traycheckout_sandbox) { ?>
	            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	            <option value="0"><?php echo $text_disabled; ?></option>
	            <?php } else { ?>
	            <option value="1"><?php echo $text_enabled; ?></option>
	            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	            <?php } ?>
              </select>
            </div>
          </div>

          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_update_status_alert"><span data-toggle="tooltip" title="<?php echo $help_update_status_alert; ?>"><?php echo $entry_update_status_alert; ?></span></label>
            <div class="col-sm-8">
              <select name="traycheckout_update_status_alert" id="traycheckout_update_status_alert" class="form-control">
                <?php if ($traycheckout_update_status_alert) { ?>
	            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	            <option value="0"><?php echo $text_disabled; ?></option>
	            <?php } else { ?>
	            <option value="1"><?php echo $text_enabled; ?></option>
	            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	            <?php } ?>
              </select>
            </div>
          </div>

          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_order_pending"><span data-toggle="tooltip" title="<?php echo $help_order_pending; ?>"><?php echo $entry_order_pending; ?></span></label>
            <div class="col-sm-8">
              <select name="traycheckout_order_pending" id="traycheckout_order_pending" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
	            <?php if ($order_status['order_status_id'] == $traycheckout_order_pending) { ?>
	            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
	            <?php } else { ?>
	            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
	            <?php } ?>
	            <?php } ?>
              </select>
            </div>
          </div>

          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_order_processing"><span data-toggle="tooltip" title="<?php echo $help_order_processing; ?>"><?php echo $entry_order_processing; ?></span></label>
            <div class="col-sm-8">
              <select name="traycheckout_order_processing" id="traycheckout_order_processing" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
	            <?php if ($order_status['order_status_id'] == $traycheckout_order_processing) { ?>
	            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
	            <?php } else { ?>
	            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
	            <?php } ?>
	            <?php } ?>
              </select>
            </div>
          </div>

          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_order_processed"><span data-toggle="tooltip" title="<?php echo $help_order_processed; ?>"><?php echo $entry_order_processed; ?></span></label>
            <div class="col-sm-8">
              <select name="traycheckout_order_processed" id="traycheckout_order_processed" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
	            <?php if ($order_status['order_status_id'] == $traycheckout_order_processed) { ?>
	            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
	            <?php } else { ?>
	            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
	            <?php } ?>
	            <?php } ?>
              </select>
            </div>
          </div>

          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_order_cancel"><span data-toggle="tooltip" title="<?php echo $help_order_cancel; ?>"><?php echo $entry_order_cancel; ?></span></label>
            <div class="col-sm-8">
              <select name="traycheckout_order_cancel" id="traycheckout_order_cancel" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
	            <?php if ($order_status['order_status_id'] == $traycheckout_order_cancel) { ?>
	            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
	            <?php } else { ?>
	            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
	            <?php } ?>
	            <?php } ?>
              </select>
            </div>
          </div>

          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_order_failed"><span data-toggle="tooltip" title="<?php echo $help_order_failed; ?>"><?php echo $entry_order_failed; ?></span></label>
            <div class="col-sm-8">
              <select name="traycheckout_order_failed" id="traycheckout_order_failed" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
	            <?php if ($order_status['order_status_id'] == $traycheckout_order_failed) { ?>
	            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
	            <?php } else { ?>
	            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
	            <?php } ?>
	            <?php } ?>
              </select>
            </div>
          </div>

          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_geo_zone_id"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-8">
              <select name="traycheckout_geo_zone_id" id="traycheckout_geo_zone_id" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
	            <?php foreach ($geo_zones as $geo_zone) { ?>
	            <?php if ($geo_zone['geo_zone_id'] == $traycheckout_geo_zone_id) { ?>
	            <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
	            <?php } else { ?>
	            <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
	           <?php } ?>
	            <?php } ?>
              </select>
            </div>
          </div>

          <hr>&nbsp;</hr>
          <div class="form-group">
            <label class="col-sm-4 control-label" for="traycheckout_sort_order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-8">
              <input type="text" name="traycheckout_sort_order" value="<?php echo $traycheckout_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="traycheckout_sort_order" class="form-control" />
            </div>
          </div>

          <hr>&nbsp;</hr>

      </form>
    </div>
  </div>
  </div>
</div>
<?php echo $footer; ?> 