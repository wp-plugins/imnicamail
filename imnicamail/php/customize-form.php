<?php
    $htmlFormData = $Options['FormHtml'];
?>
<div class="wrap" id="imnicamail-customize-form">
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
     <table class="form-table">
        <tr valign="top">
            <th scope="row">
                <label><b>Lists</b></label><br />
                <span class="description">Select a list and generate form.</span>
            </th>
            <td>
                <select id="lists">
                </select>
                <input class="button-primary button-primary-disabled" id="refresh-lists-button" type="button" value="Refresh" disabled="disabled" />
                <input class="button-primary button-primary-disabled" id="generate-form-button" type="button" value="Generate Form"  disabled="disabled" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label><b>Fields</b></label><br />
                <span class="description">Reorder fields by drag and drop.</span>
            </th>
            <td>
                <ul id="normal-fields" class="jquery-sortable">
                    <?php foreach ($htmlFormData['normal_fields'] as $key => $normal_field) : 
                        
                        require_once(IMNICAMAIL_PLUGIN_DIR.'/thirdparty/simplehtmldom/simple_html_dom.php');
                        $input_html = str_get_html($normal_field['input']);
                        ?>
                        <li class="jquery-sortable-item">
                            <input type="checkbox" name="enabled[]" <?php echo ($input_html->find('#FormValue_EmailAddress', 0)) ? 'disabled="disabled"' : ''; ?> <?php __checked_selected_helper('true', $normal_field['enabled'], true, 'checked'); ?> value="<?php echo $key; ?>" /> <?php echo $normal_field['label']; ?>
                            <input type="hidden" name="order[]" value="<?php echo $key; ?>" />
                        </li>
                    <?php endforeach; ?>
                </ul>
            </td>
        </tr>
     </table>
    <p class="submit"> 
        <input id="form-customization-submit" type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
    </p>
</div>
