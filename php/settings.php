<div class="wrap" id="imnicamail-settings">
    <div class="icon32" id="icon-options-general"></div>
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
                        <b>Default Styling</b>
                    </label>
                </th>
                <td>
                    <label>
                        <input id="default_styling" type="checkbox" name="default_styling" <?php __checked_selected_helper('1', $Options['default_styling'], true, 'checked'); ?> />
                        Check to enable.
                    </label>
                    <div class="description">
                        Use default styling predefined by the plugin.
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="powered_by">
                        <b>ImnicaMail Text</b>
                    </label>
                </th>
                <td>
                    <label>
                        <input id="powered_by" type="checkbox" name="powered_by" <?php __checked_selected_helper('1', $Options['powered_by'], true, 'checked'); ?> />
                        Check to enable.
                    </label>
                    <div class="description">
                        Include a phrase below the form. This is where your affiliate id will be included.
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="use_image_button">
                        <b>Use Image Button</b>
                    </label>
                </th>
                <td>
                    <label> 
                        <input id="use_image_button" type="checkbox" name="use_image_button" <?php __checked_selected_helper('1', $Options['use_image_button'], true, 'checked'); ?> />
                        Check to enable.
                    </label>
                    <div class="description">
                        Use an image instead of a regular button.
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="image_url">
                        <b>Image URL</b>     
                    </label>
                </th>
                <td>
                    <input class="regular-text" id="image_url" type="text" name="image_url" value="<?php echo $Options['image_url']; ?>" />
                    <div class="description">
                        Specify the url of the image to be used as the button. You'll need to check the "Use Image Button" to use this.
                    </div>
                </td>
            </tr>    
            <tr valign="top">
                <th scope="row">
                    <label for="submit_button_text">
                        <b>Submit Button Text</b>
                    </label>
                </th>
                <td>
                    <input class="regular-text" id="submit_button_text" type="text" name="submit_button_text" value="<?php echo $Options['submit_button_text']; ?>" />
                    <div class="description">
                        Specify a text for the submit button. Leave empty for default.
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="affiliate_id">
                        <b>Affilaite ID</b>
                    </label>
                </th>
                <td>
                    <input class="regular-text" maxlength="10" id="affiliate_id" type="text" name="affiliate_id" value="<?php echo $Options['affiliate_id']; ?>" />
                </td>
            </tr>      
        </table>
        
        <p class="submit">
            <input id="submit" type="submit" class="button" value="<?php _e('Save Settings') ?>" />
        </p>
    </div>
</div>              