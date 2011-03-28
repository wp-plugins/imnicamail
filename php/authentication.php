<div class="wrap" id="imnicamail-authentication">
    <div class="icon32" id="icon-options-general"></div><h2>Authentication</h2>
    <div style="display: none;" id="success-message" class="updated below-h2">
        <strong>
            <p>
                Your login to Imnica Mail has been successfully authenticated.<br />
                Click <a href="<?php echo admin_url('admin.php?page=imnicamail-customize-form'); ?>">here</a> to customize your form.
            </p>
        </strong>
    </div>
    <div style="display: none;" id="error-message" class="error below-h2">
        <strong>
            <p>Your login details is invalid. Please try again.</p>
        </strong>
    </div>
    <div id="adduser">
        <table class="form-table">
            <tr valign="top" class="form-field form-required">
                <th scope="row">
                    <label for="username"><b>ImnicaMail Username</b></label>     
                </th>
                <td>
                    <input class="regular-text" id="username" type="text" name="username" value="<?php echo $Options['Username']; ?>" />
                    <div class="description">(e.g. username@imnica.com)</div>
                </td>
            </tr>
            <tr valign="top" class="form-field form-required">
                <th scope="row">
                    <label for="password"><b>ImnicaMail Password</b></label>       
                </th>
                <td>                                                                                                      
                    <input class="regular-text" id="password" type="password" name="password" value="<?php echo $Options['Password']; ?>" />
                </td>
            </tr>  
        </table>
        <p>
            <i><b>Note:</b> Login will be automatically save when it is authenticated.</i>
        </p>
        <p class="submit">
            <input id="submit" type="submit" class="button" value="<?php _e('Authenticate Login') ?>" />
        </p>
    </div>
</div>