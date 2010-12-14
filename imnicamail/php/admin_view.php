<div class="wrap">
	<div id="icon-imnicamail" class="icon32"><br></div>
	<h2 id="add-new-user">ImnicaMail Plugin Settings</h2>

	<div id="ajax-response"></div>

	<p>Please enter your Imnica Mail login information.</p>
    
    <?php
        /**
        * CURL Warning
        */
        
        if (!in_array('curl', get_loaded_extensions())) {
            ?>
                <div style="display: block;" id="error" class="error below-h2">
                    <strong>
                        <p id="error">PHP CURL Extension is not enabled.</p>
                    </strong>
                </div>
            <?php
        } 
    ?>

	<div class="error" id="error" style="display:none;"><strong><p id="error"></p></strong></div>
	<div class="updated" id="success" style="display:none;"><strong><p id="success"></p></strong></div>


	<form action="#login-check" method="post" name="adduser" id="adduser" class="add:users: validate">
		<input id="_wpnonce" name="_wpnonce" value="5d825100c0" type="hidden">
		<input name="_wp_http_referer" value="/wp-admin/user-new.php" type="hidden">
		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row"><label for="username">Imnica Mail Username <span class="description">(required)</span></label>
					<input name="action" id="action" value="adduser" type="hidden"></th>
					<td><input name="username" id="username" value="<?php if(isset($Options['Username'])) echo $Options['Username'];?>" aria-required="true" type="text"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="password">Imnica Mail Password <span class="description">(required)</span></label></th>
					<!-- <td><input name="password" id="password" autocomplete="off" type="password"></td>  -->
					<td><input name="password" id="password" type="password" value="<?php if(isset($Options['Password'])) echo $Options['Password'];?>"></td>
				</tr>
				<tr class="form-field form-required">
<!--					<p><th scope="row"><label for="imnicamail_url">Imnica Mail URL <span class="description">(required)</span></label></th> -->
					<td><input type="hidden" name="imnicamail_url" id="imnicamail_url" value="http://www.imnicamail.com/v4/"></td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input name="login-check" id="login-check" class="button-primary" value="Submit" type="submit">
		</p>
	</form>

	<div id="content-after-login">
		<form action="#do-nothing" style="display:none;" id="subscriber-list-form">
			<table class="form-table">
				<tbody>
					<tr valign="top" class="form-field form-required">
						<th scope="row"><label for="subscriber-lists">Choose Subscriber List</label></th>
						<td>
							<select name="subscriber-lists" id="subscriber-lists"></select>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
        <!--
        <ul class="jquery-sortable">
            <li class="jquery-sortable-item">
                <input type="checkbox"> Custom Field 1
            </li>
            <li class="jquery-sortable-item">
                <input type="checkbox"> Custom Field 2
            </li>
            <li class="jquery-sortable-item">
                <input type="checkbox"> Custom Field 3
            </li>
        </div>
        -->

		<form action="#do-nothing" style="display:none;" id="custom-field-form">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
				        	<label for="checklist-content">
                                Choose Custom fields<br />
                                <span class="description">The elements on the right side are sortable.<br />Uncheck box to exclude custom field.</span>
                            </label>                                                      
				        </th>
						<td id="checklist-content" class="jquery-sortable" name="checklist-content" style="margin-left:150px;"> 
							<!-- Here comes the checklist content with AJAX -->
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input name="get-html-code" id="get-html-code" class="button-primary" value="Generate Form" type="button">
			</p>

		</form>


	</div>
    
    <div id="preview" style="background: #ccc; border: 1px;">
    </div>

	<div id="form-gotten-added" class="updated" style="display:none;"><p><strong>Subscription form have been gotten from Imnica Mail and added to your settings. Be sure that you have added Imnica Mail widget from "Appearance -> Widgets" menu.</strong></p>
	</div>
    
	<!-- 
        To Remove
        <textarea id="dummy" style="width:300px; height:100px; display:none;"></textarea> 
    -->   
</div> 