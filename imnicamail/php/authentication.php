<div class="wrap" id="imnicamail-authentication">
    <h2>Settings</h2>
    <div style="display: none;" id="success-message" class="updated below-h2">
        <strong>
            <p>
                Your login to Imnica Mail has been successfully validated.<br />
                Click <a href="<?php echo admin_url('admin.php?page=imnicamail-customize-form'); ?>">here</a> to customize your form.
            </p>
        </strong>
    </div>
    <div style="display: none;" id="error-message" class="error below-h2">
        <strong>
            <p>
                Your login details is invalid. Please try again.
            </p>
        </strong>
    </div>
    <div id="adduser">
        <table class="form-table">
            <tr valign="top" class="form-field form-required">
                <th scope="row">
                    <label for="username"><b>Imnica Mail Username</b></label>
                    <span class="description">(Required)</span>
                </th>
                <td>
                    <input id="username" type="text" name="username" value="<?php echo $Options['Username']; ?>" />
                </td>
            </tr>
            <tr valign="top" class="form-field form-required">
                <th scope="row">
                    <label for="password"><b>Imnica Mail Password</b></label>
                    <span class="description">(Required)</span>
                </th>
                <td>                                                                                                      
                    <input id="password" type="password" name="password" value="<?php echo $Options['Password']; ?>" />
                </td>
            </tr>  
        </table>
        <p class="submit">
            <input id="submit" type="submit" class="button-primary" value="<?php _e('Validate') ?>" />
        </p>
    </div>
</div>