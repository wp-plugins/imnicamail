<div class="wrap" id="imnicamail-settings">
    <h2>Settings</h2>
    
    <div style="display: none;" id="success-message" class="updated below-h2">
        <strong><p id="success-message-content"></p></strong>
    </div>
    <div style="display: none;" id="error-message" class="error below-h2">
        <strong><p id="error-message-content"></p></strong>
    </div>
    
    <div>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="default_styling">
                        <b>Enable Default Styling</b>
                    </label>
                </th>
                <td>
                    <input id="default_styling" type="checkbox" name="default_styling" <?php __checked_selected_helper('1', $Options['default_styling'], true, 'checked'); ?> />
                    Check to enable default styling.
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="submit_button_text">
                        <b>Submit Button Text</b>
                    </label>
                </th>
                <td>
                    <input id="submit_button_text" type="text" name="submit_button_text" value="<?php echo $Options['submit_button_text']; ?>" /><br />
                    Specify a text for the submit button. Leave empty for default.
                </td>
            </tr>
        </table>
        
        <p class="submit">
            <input id="submit" type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />
        </p>
    </div>
</div>              