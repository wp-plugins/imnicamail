<?php
    $htmlFormData = $Options['FormHtml'];
?>
<div class="wrap" id="imnicamail-customize-form">
    <div class="icon32" id="icon-options-general"></div>
    <h2>Form Customization</h2>    
    <div style="display: none;" id="update-message" class="updated below-h2">
        <strong>
            <p id="udpate-text"></p>
        </strong>
    </div>
    <div style="display: none;" id="error-message" class="error below-h2">
        <strong>
            <p id="error-text"></p>
        </strong>
    </div>
    <p>Select which list you want to generate a form from. If the selection is empty, click the refresh button.</p>
    <select id="lists"></select>
    <input class="button button-disabled" id="refresh-lists-button" type="button" value="Refresh" disabled="disabled" />
    <p>After you have selected the list, click the generate button below. Generating a new form will erase the current form data.</p>
    <input class="button button-disabled" id="generate-form-button" type="button" value="Generate Form"  disabled="disabled" /> 
    <p>This is your current form. Drag and drop fields to reorder. Uncheck the field if you do not want it to appear on your form.</p>
    <ul id="normal-fields" class="jquery-sortable">
        <?php if (is_array($htmlFormData['normal_fields']) && 0 < count($htmlFormData['normal_fields'])) : foreach ($htmlFormData['normal_fields'] as $key => $normal_field) : 
            
            require_once(IMNICAMAIL_PLUGIN_DIR.'/thirdparty/simplehtmldom/simple_html_dom.php');
            $input_html = str_get_html($normal_field['input']);
            ?>
            <li class="jquery-sortable-item">
                <input type="checkbox" name="enabled[]" <?php echo ($input_html->find('#FormValue_EmailAddress', 0)) ? 'disabled="disabled"' : ''; ?> <?php __checked_selected_helper('true', $normal_field['enabled'], true, 'checked'); ?> value="<?php echo $key; ?>" /> <?php echo $normal_field['label']; ?>
                <input type="hidden" name="order[]" value="<?php echo $key; ?>" />
            </li>
        <?php endforeach; endif; ?>
    </ul>
    <p class="submit"> 
        <input id="form-customization-submit" type="submit" class="button" value="<?php _e('Save Form Changes') ?>" />
    </p>
</div>