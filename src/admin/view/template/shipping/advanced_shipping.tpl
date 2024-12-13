<?php echo $header; ?>
<style>
  textarea{
    width:100%;
    min-height: 150px;
  }
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_name; ?></td>
            <td>
            <?php foreach ($languages as $key => $language): ?>
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> &nbsp;<input type="text" name="advanced_shipping_name[<?php echo $language['language_id'] ?>]" value="<?php echo $advanced_shipping_name[$language['language_id']]; ?>" /><br>
            <?php endforeach ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="advanced_shipping_status">
                <?php if ($advanced_shipping_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="advanced_shipping_sort_order" value="<?php echo $advanced_shipping_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
        <h2><?php echo $text_shippings ?></h2>
        <div id="tabs" class="vtabs">
          <?php $shipping_count = 0; ?>
          <?php foreach ($advanced_shipping_data as $key => $value): ?>
            <a class="tab_btn" id="a_advanced_shipping_<?php echo $shipping_count ?>_tab" href="#advanced_shipping_<?php echo $shipping_count ?>_tab"><?php echo $value['name'][$current_language_id] ?> <img src="view/image/delete.png" onclick="$('#tabs a.tab_btn:last').trigger('click');$('#a_advanced_shipping_<?php echo $shipping_count ?>_tab, #advanced_shipping_<?php echo $shipping_count ?>_tab').remove(); return false;"></a>
          <?php $shipping_count++; ?>
          <?php endforeach ?>
          <a href="#" id="add_shipping_btn"><?php echo $text_add_shipping ?> <img src="view/image/add.png"></a>
        </div>
        <?php $shipping_count = 0; ?>
        <div id="shippings">
          <?php foreach ($advanced_shipping_data as $key => $value): ?>
            <div id="advanced_shipping_<?php echo $shipping_count ?>_tab" class="vtabs-content">
              <div id="tabs<?php echo $shipping_count ?>" class="htabs">
                <a class="tab_btn" id="link_tab_<?php echo $shipping_count ?>_common" href="#tab_<?php echo $shipping_count ?>_common"><?php echo $tab_common ?></a>
                <a class="tab_btn" id="link_tab_<?php echo $shipping_count ?>_price" href="#tab_<?php echo $shipping_count ?>_price"><?php echo $tab_price ?></a>
                <a class="tab_btn" id="link_tab_<?php echo $shipping_count ?>_weight" href="#tab_<?php echo $shipping_count ?>_weight"><?php echo $tab_weight ?></a>
                <a class="tab_btn" id="link_tab_<?php echo $shipping_count ?>_customer" href="#tab_<?php echo $shipping_count ?>_customer"><?php echo $tab_customer ?> </a>
              </div>

              <div id="tab_<?php echo $shipping_count ?>_common" class="htabs-content">
                <table class="form">
                  <tr>
                    <td><?php echo $entry_cost ?> </td>
                    <td>
                      <input type="text" name="advanced_shipping_data[<?php echo $shipping_count ?>][cost]" value="<?php echo $value['cost'] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_geo_zone; ?></td>
                    <td><select name="advanced_shipping_data[<?php echo $shipping_count ?>][geo_zone_id]">
                        <option value="0"><?php echo $text_all_zones; ?></option>
                        <?php foreach ($geo_zones as $geo_zone) { ?>
                        <?php if ($geo_zone['geo_zone_id'] == $value['geo_zone_id']) { ?>
                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_tax_class; ?></td>
                    <td><select name="advanced_shipping_data[<?php echo $shipping_count ?>][tax_class_id]">
                          <option value="0"><?php echo $text_none; ?></option>
                          <?php foreach ($tax_classes as $tax_class) { ?>
                          <?php if ($tax_class['tax_class_id'] == $value['tax_class_id']) { ?>
                          <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                  </tr>
                </table>
                <div id="lang_<?php echo $shipping_count ?>_tabs" class="htabs lang_tabs">
                  <?php foreach ($languages as $language): ?>
                    <a href="#mod_<?php echo $shipping_count ?>_lang_<?php echo $language['language_id'] ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name'] ?></a>
                  <?php endforeach ?>
                </div>
                <?php foreach ($languages as $language): ?>
                  <div id="mod_<?php echo $shipping_count ?>_lang_<?php echo $language['language_id'] ?>" class="htabs-content">
                    <table class="form">
                      <tr>
                        <td><?php echo $entry_shipping_name ?> </td>
                        <td><input type="text" name="advanced_shipping_data[<?php echo $shipping_count ?>][name][<?php echo $language['language_id'] ?>]" value="<?php echo $value['name'][$language['language_id']] ?>"></td>
                      </tr>
                      <tr>
                        <td><?php echo $entry_description ?> </td>
                        <td>
                          <textarea id="advanced_shipping_data_<?php echo $shipping_count ?>_description_lang_<?php echo $language['language_id']; ?>" name="advanced_shipping_data[<?php echo $shipping_count ?>][description][<?php echo $language['language_id'] ?>]"><?php echo $value['description'][$language['language_id']] ?></textarea>
                        </td>
                      </tr>
                    </table>
                  </div>
                <?php endforeach ?>
              </div>

              <div id="tab_<?php echo $shipping_count ?>_price" class="htabs-content">
                <table class="form">
                  <tr>
                    <td><?php echo $entry_price_range ?> <span class="help"><?php echo $entry_price_range_help ?></span></td>
                    <td>
                      <input type="text" name="advanced_shipping_data[<?php echo $shipping_count ?>][price_range][0]" class="form-control separated-input co-sm-6" value="<?php echo $value['price_range'][0] ?>" />
                      <input type="text" name="advanced_shipping_data[<?php echo $shipping_count ?>][price_range][1]" class="form-control separated-input co-sm-6" value="<?php echo $value['price_range'][1] ?>" />
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_currency; ?></td>
                    <td><select name="advanced_shipping_data[<?php echo $shipping_count ?>][currency]" class="form-control">
                          <?php foreach ($currencies as $currency) { ?>
                          <?php if ($currency['code'] == $value['currency']) { ?>
                          <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                  </tr>
                </table>
              </div>

              <div id="tab_<?php echo $shipping_count ?>_weight" class="htabs-content">
                <table class="form">
                  <tr>
                    <td><?php echo $entry_weight_range ?> <span class="help"><?php echo $entry_weight_range_help ?></span></td>
                    <td>
                      <input type="text" name="advanced_shipping_data[<?php echo $shipping_count ?>][weight_range][0]" class="form-control separated-input co-sm-6" value="<?php echo $value['weight_range'][0] ?>" />
                      <input type="text" name="advanced_shipping_data[<?php echo $shipping_count ?>][weight_range][1]" class="form-control separated-input co-sm-6" value="<?php echo $value['weight_range'][1] ?>" />
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_weight_class; ?></td>
                    <td><select name="advanced_shipping_data[<?php echo $shipping_count ?>][weight_class_id]" class="form-control">
                          <?php foreach ($weight_classes as $weight_class) { ?>
                          <?php if ($weight_class['weight_class_id'] == $value['weight_class_id']) { ?>
                          <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                  </tr>
                </table>
              </div>

              <div id="tab_<?php echo $shipping_count ?>_customer" class="htabs-content">
              <table class="form">
                <tr class="customer_groups module<?php echo $shipping_count ?> common<?php echo $shipping_count ?>">
                  <td><?php echo $entry_customer_group ?> <span class="help"><?php echo $entry_customer_group_help ?></span></td>
                  <td>
                    <div class="scrollbox">
                    <?php $class = 'odd'; ?>
                    <?php foreach ($customer_groups as $customer_group_shipping_count => $customer_group_data) { ?>
                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                    <div class="<?php echo $class; ?>">
                      <?php if (in_array($customer_group_data['customer_group_id'], $value['customer_groups'])) { ?>
                      <input type="checkbox" name="advanced_shipping_data[<?php echo $shipping_count ?>][customer_groups][<?php echo $customer_group_data['customer_group_id']; ?>]" id="advanced_shipping_data[<?php echo $shipping_count ?>][customer_groups][<?php echo $customer_group_data['customer_group_id']; ?>]" value="<?php echo $customer_group_data['customer_group_id']; ?>" checked="checked" />
                      <label for="advanced_shipping_data[<?php echo $shipping_count ?>][customer_groups][<?php echo $customer_group_data['customer_group_id']; ?>]"><?php echo $customer_group_data['name']; ?></label>
                      <?php } else { ?>
                      <input type="checkbox" name="advanced_shipping_data[<?php echo $shipping_count ?>][customer_groups][<?php echo $customer_group_data['customer_group_id']; ?>]" id="advanced_shipping_data[<?php echo $shipping_count ?>][customer_groups][<?php echo $customer_group_data['customer_group_id']; ?>]" value="<?php echo $customer_group_data['customer_group_id']; ?>" />
                      <label for="advanced_shipping_data[<?php echo $shipping_count ?>][customer_groups][<?php echo $customer_group_data['customer_group_id']; ?>]"><?php echo $customer_group_data['name']; ?></label>
                      <?php } ?>
                    </div>
                    <?php } ?>
                  </div>
                  <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                  </td>
                </tr>
              </table>
              </div>

            </div>
            <?php $shipping_count++; ?>
          <?php endforeach ?>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($advanced_shipping_data as $key => $value) { ?>
<?php foreach ($languages as $language) { ?>
// CKEDITOR.replace('advanced_shipping_data_<?php echo $shipping_count ?>_description_lang_<?php echo $language['language_id']; ?>', {
//   filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
//   filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
//   filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
//   filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
//   filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
//   filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
// });
<?php } ?>
<?php } ?>
//--></script>
<script>
var shipping_count = <?php echo $shipping_count ?>;
$(document).ready(function(){
<?php $scount = 0; ?>
<?php foreach ($advanced_shipping_data as $key => $value) { ?>
<?php foreach ($languages as $language) { ?>
  $('#lang_<?php echo $scount ?>_tabs a').tabs();
<?php } ?>
  $('#tabs<?php echo $scount ?> a').tabs();
<?php $scount++; ?>
<?php } ?>

  $('#tabs a').tabs();
  $('#add_shipping_btn').click(function(event){
    event.preventDefault();
    addShipping();
  });
});
function addShipping(){
html = '';
html += '<div id="advanced_shipping_' + shipping_count + '_tab" class="vtabs-content">';
html += '  <div id="tabs' + shipping_count + '" class="htabs">';
html += '    <a class="tab_btn" id="link_tab_' + shipping_count + '_common" href="#tab_' + shipping_count + '_common"><?php echo $tab_common ?></a>';
html += '    <a class="tab_btn" id="link_tab_' + shipping_count + '_price" href="#tab_' + shipping_count + '_price"><?php echo $tab_price ?></a>';
html += '    <a class="tab_btn" id="link_tab_' + shipping_count + '_weight" href="#tab_' + shipping_count + '_weight"><?php echo $tab_weight ?></a>';
html += '    <a class="tab_btn" id="link_tab_' + shipping_count + '_customer" href="#tab_' + shipping_count + '_customer"><?php echo $tab_customer ?> </a>';
html += '  </div>';

html += '  <div id="tab_' + shipping_count + '_common" class="htabs-content">';
html += '    <table class="form">';
html += '      <tr>';
html += '        <td><?php echo $entry_cost ?> </td>';
html += '        <td>';
html += '          <input type="text" name="advanced_shipping_data[' + shipping_count + '][cost]" value="1">';
html += '        </td>';
html += '      </tr>';
html += '      <tr>';
html += '        <td><?php echo $entry_geo_zone; ?></td>';
html += '        <td><select name="advanced_shipping_data[' + shipping_count + '][geo_zone_id]">';
html += '            <option value="0"><?php echo $text_all_zones; ?></option>';
<?php foreach ($geo_zones as $geo_zone) { ?>
html += '<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>';
<?php } ?>
html += '</select></td>';
html += '      </tr>';
html += '      <tr>';
html += '        <td><?php echo $entry_tax_class; ?></td>';
html += '        <td><select name="advanced_shipping_data[' + shipping_count + '][tax_class_id]">';
html += '              <option value="0"><?php echo $text_none; ?></option>';
<?php foreach ($tax_classes as $tax_class) { ?>
html += '              <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>';
<?php } ?>
html += '            </select></td>';
html += '      </tr>';
html += '    </table>';
html += '    <div id="lang_' + shipping_count + '_tabs" class="htabs lang_tabs">';
<?php foreach ($languages as $language): ?>
html += '        <a href="#mod_' + shipping_count + '_lang_<?php echo $language['language_id'] ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name'] ?></a>';
<?php endforeach ?>
html += '    </div>';
<?php foreach ($languages as $language): ?>
html += '      <div id="mod_' + shipping_count + '_lang_<?php echo $language['language_id'] ?>" class="htabs-content">';
html += '        <table class="form">';
html += '          <tr>';
html += '            <td><?php echo $entry_shipping_name ?> </td>';
html += '            <td><input type="text" name="advanced_shipping_data[' + shipping_count + '][name][<?php echo $language['language_id'] ?>]" value="<?php echo $text_shipping ?> ' + shipping_count + '"></td>';
html += '          </tr>';
html += '          <tr>';
html += '            <td><?php echo $entry_description ?> </td>';
html += '            <td>';
html += '              <textarea id="advanced_shipping_data_' + shipping_count + '_description_lang_<?php echo $language['language_id']; ?>" name="advanced_shipping_data[' + shipping_count + '][description][<?php echo $language['language_id'] ?>]"></textarea>';
html += '            </td>';
html += '          </tr>';
html += '        </table>';
html += '      </div>';
<?php endforeach ?>
html += '  </div>';

html += '  <div id="tab_' + shipping_count + '_price" class="htabs-content">';
html += '    <table class="form">';
html += '      <tr>';
html += '        <td><?php echo $entry_price_range ?> <span class="help"><?php echo $entry_price_range_help ?></span></td>';
html += '        <td>';
html += '          <input type="text" name="advanced_shipping_data[' + shipping_count + '][price_range][0]" class="form-control separated-input co-sm-6" value="0" />';
html += '          <input type="text" name="advanced_shipping_data[' + shipping_count + '][price_range][1]" class="form-control separated-input co-sm-6" value="0" />';
html += '        </td>';
html += '      </tr>';
html += '      <tr>';
html += '        <td><?php echo $entry_currency; ?></td>';
html += '        <td><select name="advanced_shipping_data[' + shipping_count + '][currency]" class="form-control">';
<?php foreach ($currencies as $currency) { ?>
html += '              <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>';
<?php } ?>
html += '            </select></td>';
html += '      </tr>';
html += '    </table>';
html += '  </div>';
html += '';
html += '  <div id="tab_' + shipping_count + '_weight" class="htabs-content">';
html += '    <table class="form">';
html += '      <tr>';
html += '        <td><?php echo $entry_weight_range ?> <span class="help"><?php echo $entry_weight_range_help ?></span></td>';
html += '        <td>';
html += '          <input type="text" name="advanced_shipping_data[' + shipping_count + '][weight_range][0]" class="form-control separated-input co-sm-6" value="0" />';
html += '          <input type="text" name="advanced_shipping_data[' + shipping_count + '][weight_range][1]" class="form-control separated-input co-sm-6" value="0" />';
html += '        </td>';
html += '      </tr>';
html += '      <tr>';
html += '        <td><?php echo $entry_weight_class; ?></td>';
html += '        <td><select name="advanced_shipping_data[' + shipping_count + '][weight_class_id]" class="form-control">';
<?php foreach ($weight_classes as $weight_class) { ?>
html += '              <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>';
<?php } ?>
html += '            </select></td>';
html += '      </tr>';
html += '    </table>';
html += '  </div>';
html += '';
html += '  <div id="tab_' + shipping_count + '_customer" class="htabs-content">';
html += '  <table class="form">';
html += '    <tr class="customer_groups module' + shipping_count + ' common' + shipping_count + '">';
html += '      <td><?php echo $entry_customer_group ?> <span class="help"><?php echo $entry_customer_group_help ?></span></td>';
html += '      <td>';
html += '        <div class="scrollbox">';
html += '        <?php $class = 'odd'; ?>';
<?php foreach ($customer_groups as $customer_group_shipping_count => $customer_group_data) { ?>
html += '        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>';
html += '        <div class="<?php echo $class; ?>">';
html += '          <input type="checkbox" name="advanced_shipping_data[' + shipping_count + '][customer_groups][<?php echo $customer_group_data['customer_group_id']; ?>]" id="advanced_shipping_data[' + shipping_count + '][customer_groups][<?php echo $customer_group_data['customer_group_id']; ?>]" value="<?php echo $customer_group_data['customer_group_id']; ?>" />';
html += '          <label for="advanced_shipping_data[' + shipping_count + '][customer_groups][<?php echo $customer_group_data['customer_group_id']; ?>]"><?php echo $customer_group_data['name']; ?></label>';
html += '        </div>';
<?php } ?>
html += '      </div>';
html += '      <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>';
html += '      </td>';
html += '    </tr>';
html += '  </table>';
html += '  </div>';

html += '</div>';

$('#shippings').append(html);

html = '<a class="tab_btn" id="a_advanced_shipping_' + shipping_count + '_tab" href="#advanced_shipping_' + shipping_count + '_tab"><?php echo $text_shipping ?> ' + shipping_count + '&nbsp;<img src="view/image/delete.png" onclick="$(\'#tabs a.tab_btn:last\').trigger(\'click\');$(\'#a_advanced_shipping_' + shipping_count + '_tab, #advanced_shipping_' + shipping_count + '_tab\').remove(); return false;"></a> ';
<?php foreach ($languages as $language) { ?>
  // CKEDITOR.replace('advanced_shipping_data_'+shipping_count+'_description_lang_<?php echo $language['language_id']; ?>', {
  //   filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  //   filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  //   filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  //   filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  //   filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  //   filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
  // });
<?php } ?>

$('#add_shipping_btn').before(html);

$('#tabs a').tabs();
$('#tabs a.tab_btn:last').trigger('click');

$('#tabs' + shipping_count + ' a').tabs();

$('#lang_' + shipping_count + '_tabs a').tabs();

shipping_count++;
}
</script>
<?php echo $footer; ?>