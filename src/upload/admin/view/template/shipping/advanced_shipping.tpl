<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-advanced" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
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
      <!--  -->
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-advanced" class="form-horizontal">
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="advanced_shipping_name"><?php echo $entry_name; ?></label>
        <div class="col-sm-10">
        <?php foreach ($languages as $language) { ?>
          <div class="input-group">
            <span class="input-group-addon"><?php echo $language['html_image'] ?></span>
            <input type="text" name="advanced_shipping_name[<?php echo $language['language_id'] ?>]" value="<?php echo $advanced_shipping_name[$language['language_id']]; ?>" placeholder="<?php echo $entry_name; ?>" id="advanced_shipping_name" class="form-control" />
          </div>
          <?php } ?>
        </div>
      </div>

      <div class="form-group required">
        <label class="col-sm-2 control-label" for="advanced_shipping_status"><?php echo $entry_status; ?></label>
        <div class="col-sm-10">
          <select name="advanced_shipping_status" class="form-control">
            <?php if ($advanced_shipping_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group required">
        <label class="col-sm-2 control-label" for="advanced_shipping_sort_order"><?php echo $entry_sort_order; ?></label>
        <div class="col-sm-10">
          <input type="text" name="advanced_shipping_sort_order" class="form-control" value="<?php echo $advanced_shipping_sort_order; ?>" size="1" />
        </div>
      </div>
      <fieldset class="shipping-variants tabbable tabs-left">
      <legend><?php echo $text_shippings ?></legend>
        <div id="tabs" class="vtabs">
          <?php $shipping_count = 1; ?>
          <?php foreach ($advanced_shipping_data as $value): ?>
          <a id="a_advanced_shipping_<?php echo $shipping_count ?>_tab" class="tab_btn" href="#advanced_shipping_<?php echo $shipping_count ?>_tab"><?php echo $value['name'][$current_language_id] ?> <i class="fa fa-minus-square" onclick="$('#tabs a.tab_btn:last').trigger('click');$('#a_advanced_shipping_<?php echo $shipping_count ?>_tab, #advanced_shipping_<?php echo $shipping_count ?>_tab').remove();$('#tabs a.tab_btn:last').trigger('click'); return false;"></i></a>
          <?php $shipping_count++; ?>
          <?php endforeach ?>
          <a href="#" id="add_shipping_btn"><?php echo $text_add_shipping ?>&nbsp;<i class="fa fa-plus-square"></i></a>
        </div>

        <div id="shippings">

        <?php $shipping_count = 1; ?>
          <?php foreach ($advanced_shipping_data as $value): ?>
            <div id="advanced_shipping_<?php echo $shipping_count ?>_tab" class="vtabs-content">

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="advanced_shipping_sort_order"><?php echo $entry_cost; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="advanced_shipping_data[<?php echo $shipping_count ?>][cost]" class="form-control" value="<?php echo $value['cost'] ?>" />
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="advanced_shipping_data[<?php echo $shipping_count ?>][geo_zone_id]"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="advanced_shipping_data[<?php echo $shipping_count ?>][geo_zone_id]" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $value['geo_zone_id']) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="advanced_shipping_data[<?php echo $shipping_count ?>][tax_class_id]"><?php echo $entry_tax_class; ?></label>
                <div class="col-sm-10">
                  <select name="advanced_shipping_data[<?php echo $shipping_count ?>][tax_class_id]" class="form-control">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php foreach ($tax_classes as $tax_class) { ?>
                    <?php if ($tax_class['tax_class_id'] == $value['tax_class_id']) { ?>
                    <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <!-- Lang tabs -->
              <ul id="lang_<?php echo $shipping_count ?>_tabs" class="nav nav-tabs">
                <?php foreach ($languages as $key => $language): ?>
                  <li class="<?php echo ($key == 0) ? 'active' : ''; ?>"><a data-toggle="tab" href="#mod_<?php echo $shipping_count ?>_lang_<?php echo $language['language_id'] ?>"><?php echo $language['html_image'] ?> <?php echo $language['name'] ?></a></li>
                <?php endforeach ?>
              </ul>

              <div class="tab-content">
              <?php foreach ($languages as $key => $language): ?>
                <div id="mod_<?php echo $shipping_count ?>_lang_<?php echo $language['language_id'] ?>" class="tab-pane <?php echo ($key == 0) ? 'active' : ''; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="advanced_shipping_sort_order"><?php echo $entry_shipping_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="advanced_shipping_data[<?php echo $shipping_count ?>][name][<?php echo $language['language_id'] ?>]" class="form-control" value="<?php echo $value['name'][$language['language_id']] ?>" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="advanced_shipping_sort_order"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea id="advanced_shipping_data_<?php echo $shipping_count ?>_description_lang_<?php echo $language['language_id']; ?>" name="advanced_shipping_data[<?php echo $shipping_count ?>][description][<?php echo $language['language_id'] ?>]" class="form-control"><?php echo $value['description'][$language['language_id']] ?></textarea>
                    </div>
                  </div>
                </div> <!-- tab-content -->
              <?php endforeach ?>
              </div>
              <!-- Lang tabs -->

            </div> <!-- vtabs-content -->
            <?php $shipping_count++; ?>
          <?php endforeach ?>
        </div>

        </fieldset>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
<?php $scount = 0; ?>
<?php foreach ($advanced_shipping_data as $key => $value) { ?>
<?php foreach ($languages as $language) { ?>
  $('#advanced_shipping_data_<?php echo $key ?>_description_lang_<?php echo $language['language_id']; ?>').summernote({
    height: 300
  });
<?php } ?>
<?php } ?>
//--></script>
<script>$.fn.tabs=function(){var b=this;this.each(function(){var a=$(this);$(a.attr("href")).hide();$(a).click(function(){$(b).removeClass("selected");$(b).each(function(b,a){$($(a).attr("href")).hide()});$(this).addClass("selected");$($(this).attr("href")).show();return!1})}); $(this).show(); $(this).first().click();};
</script>
<script>
var shipping_count = <?php echo $shipping_count ?>;
$(document).ready(function(){
  $('#tabs a').tabs();
  $('#add_shipping_btn').click(function(event){
    event.preventDefault();
    addShipping();
  });
});
function addShipping(){
  html = '';
html += '<div id="advanced_shipping_' + shipping_count + '_tab" class="vtabs-content">';

html += '<div class="form-group required">';
html += '<label class="col-sm-2 control-label" for="advanced_shipping_sort_order"><?php echo $entry_cost; ?></label>';
html += '<div class="col-sm-10">';
html += '<input type="text" name="advanced_shipping_data[' + shipping_count + '][cost]" class="form-control" value="1" />';
html += '</div>';
html += '</div>';

html += '<div class="form-group required">';
html += '<label class="col-sm-2 control-label" for="advanced_shipping_data[' + shipping_count + '][geo_zone_id]"><?php echo $entry_geo_zone; ?></label>';
html += '<div class="col-sm-10">';
html += '<select name="advanced_shipping_data[' + shipping_count + '][geo_zone_id]" class="form-control">';
html += '<option value="0"><?php echo $text_all_zones; ?></option>';
<?php foreach ($geo_zones as $geo_zone) { ?>
html += '<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>';
<?php } ?>
html += '</select>';
html += '</div>';
html += '</div>';

html += '<div class="form-group required">';
html += '<label class="col-sm-2 control-label" for="advanced_shipping_data[<?php echo $shipping_count ?>][tax_class_id]"><?php echo $entry_tax_class; ?></label>';
html += '<div class="col-sm-10">';
html += '<select name="advanced_shipping_data[<?php echo $shipping_count ?>][tax_class_id]" class="form-control">';
html += '<option value="0"><?php echo $text_none; ?></option>';
<?php foreach ($tax_classes as $tax_class) { ?>
html += '<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>';
<?php } ?>
html += '</select>';
html += '</div>';
html += '</div>';


html += '<ul id="lang_' + shipping_count + '_tabs" class="nav nav-tabs">';
<?php foreach ($languages as $key => $language){ ?>
html += '<li class="<?php echo ($key == 0) ? 'active' : ''; ?>"><a data-toggle="tab" href="#mod_' + shipping_count + '_lang_<?php echo $language['language_id'] ?>"><?php echo $language['html_image'] ?> <?php echo $language['name'] ?></a></li>';
<?php } ?>
html += '</ul>';

html += '<div class="tab-content">';
<?php foreach ($languages as $key => $language){ ?>
html += '<div id="mod_' + shipping_count + '_lang_<?php echo $language['language_id'] ?>" class="tab-pane <?php echo ($key == 0) ? 'active' : ''; ?>">';
html += '<div class="form-group required">';
html += '<label class="col-sm-2 control-label" for="advanced_shipping_sort_order"><?php echo $entry_shipping_name; ?></label>';
html += '<div class="col-sm-10">';
html += '<input type="text" name="advanced_shipping_data[' + shipping_count + '][name][<?php echo $language['language_id'] ?>]" class="form-control" value="<?php echo $text_shipping ?> ' + shipping_count + '" />';
html += '</div>';
html += '</div>';

html += '<div class="form-group">';
html += '<label class="col-sm-2 control-label" for="advanced_shipping_sort_order"><?php echo $entry_description; ?></label>';
html += '<div class="col-sm-10">';
html += '<textarea id="advanced_shipping_data_' + shipping_count + '_description_lang_<?php echo $language['language_id']; ?>" name="advanced_shipping_data[' + shipping_count + '][description][<?php echo $language['language_id'] ?>]" class="form-control"></textarea>';
html += '</div>';
html += '</div>';
html += '</div>';
  <?php } ?>
html += '</div>';
html += '</div>';

  $('#shippings').append(html);
  html = '<a id="a_advanced_shipping_' + shipping_count + '_tab" class="tab_btn" href="#advanced_shipping_' + shipping_count + '_tab"><?php echo $text_shipping ?> ' + shipping_count + ' <i class="fa fa-minus-square" onclick="$(\'#tabs a.tab_btn:last\').trigger(\'click\');$(\'#a_advanced_shipping_' + shipping_count + '_tab, #advanced_shipping_' + shipping_count + '_tab\').remove();$(\'#tabs a.tab_btn:last\').trigger(\'click\'); return false;"></i></a>';

  <?php foreach ($languages as $language) { ?>
    $('#advanced_shipping_data_'+shipping_count+'_description_lang_<?php echo $language['language_id']; ?>').summernote({
      height: 300
    });
  <?php } ?>

  $('#add_shipping_btn').before(html);

  $('#tabs a').tabs();

  $('#lang_' + shipping_count + '_tabs li:first').tab('show');

  shipping_count++;

  $('#tabs a.tab_btn:last').trigger('click');
}
</script>

<style>
.vtabs {
  position: absolute;
  width: 190px;
  padding: 10px 0;
  min-height: 280px;
  float: left;
  display: block;
  border-right: 1px solid #DDD
}
.vtabs a {
  display: none
}
.vtabs a,
.vtabs span {
  display: block;
  float: left;
  border-radius: 3px 0px 0px 3px;
  width: 190px;
  margin-bottom: 5px;
  clear: both;
  border-top: 1px solid #DDD;
  border-left: 1px solid #DDD;
  border-bottom: 1px solid #DDD;
  background: #F7F7F7;
  padding: 6px;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 13px;
  font-weight: 700;
  text-align: right;
  text-decoration: none;
  border-right: 1px solid #ddd;
}
.vtabs a.selected {
  background: #FFF;
  border-right: 1px solid #fff;
}
.vtabs a img,
.vtabs span img {
  position: relative;
  top: 3px;
  cursor: pointer
}
.vtabs-content {
  margin-left: 205px
}
#shippings{
  min-height: 280px;
}
</style>
<?php echo $footer; ?>