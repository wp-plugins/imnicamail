jQuery(document).ready(function($){
    $('.jquery-sortable').sortable({placeholder:'jquery-sortable-item-placeholder'});
    
    var SessionID;
    
    var showUpdateMessage = function (msg) {   
        $('#update-message').slideUp('slow', function(){
            $('#udpate-text').empty().append(msg);
            $(this).slideDown();
        });
    }
    
    var showErrorMessage = function (msg) {                   
        $('#error-message').slideUp('slow', function(){
            $('#error-text').empty().append(msg);
            $(this).slideDown();
        }); 
    }
    
    var hideMessages = function () {
        $('#update-message').slideUp();   
        $('#error-message').slideUp(); 
    }
    
    $.ajax({
        type: 'POST',
        url: imnicamail_cfg.ajaxurl,
        data: {            
            action : "imnicamail_login", 
            username : imnicamail_cfg.username, 
            password : imnicamail_cfg.password, 
            imnicamail_url : imnicamail_cfg.imnicamail_url, 
            "cookie" : encodeURIComponent(document.cookie)
        },
        success: function (response) {
            if ('object' == typeof response && response.Success) {
                SessionID = response.SessionID; 
                $('#imnicamail-customize-form #refresh-lists-button').removeClass('button-disabled').removeAttr('disabled');
                showUpdateMessage('Login validated, you may now procceed.');
            } else {
                showErrorMessage('Login invalid, please complete you login info at the authentication page.');
            }
        },
        dataType: 'json',
        async: false
    });
    
    $('#imnicamail-customize-form #refresh-lists-button').click(function(){
        if ('undefined' == typeof(SessionID)) {
            return;
        }
        
        $('#imnicamail-customize-form #refresh-lists-button').addClass('button-disabled').attr('disabled', 'disabled').val('Refreshing...');
        $('#imnicamail-customize-form #generate-form-button').addClass('button-disabled').attr('disabled', 'disabled');
                    
        $.post
        (
            imnicamail_cfg.ajaxurl, 
            {
                action : "imnicamail_get_subscriber_lists", 
                SessionID : SessionID, 
                imnicamail_url : imnicamail_cfg.imnicamail_url,
                "cookie" : encodeURIComponent(document.cookie)
            },    
            function (response) {
                $('#imnicamail-customize-form #refresh-lists-button').removeClass('button-disabled').removeAttr('disabled').val('Refresh');
        
                if ('object' == typeof response && response.Success) {
                    $('#imnicamail-customize-form #lists').empty();
                    $.each(response.Lists, function(index, value){
                        $('#imnicamail-customize-form #lists').append($(document.createElement('option')).val(value.ListID).append(value.Name));
                    });      
                    $('#imnicamail-customize-form #generate-form-button').removeClass('button-disabled').removeAttr('disabled');
                    
                    showUpdateMessage('Subscription lists successfully refreshed.');
                } else {            
                    showErrorMessage('An error has occured while refreshing the subscription lists.');
                }
            },
            'json'
        );
    });
    
    $('#imnicamail-customize-form #generate-form-button').click(function(){
        if ('undefined' == typeof(SessionID)) {
            return;
        }
        
        if (!confirm('This will erase the current form data.')) {
            return;
        }
        
        $('#imnicamail-customize-form #generate-form-button').addClass('button-disabled').attr('disabled', 'disabled').val('Generating Form...');
        
        $.post
        (
            imnicamail_cfg.ajaxurl, 
            {
                action : "imnicamail_get_custom_fields", 
                SubscriberListID : $('#imnicamail-customize-form #lists').val(), 
                SessionID : SessionID, 
                imnicamail_url : imnicamail_cfg.imnicamail_url, 
                "cookie" : encodeURIComponent(document.cookie)
            },
            function (response) {
                if ('object' == typeof response && response.Success) {     
                    var CustonFieldsArr = [];
                    
                    $.each(response.CustomFields, function(index, value){
                        CustonFieldsArr.push(value.CustomFieldID);       
                    });
                    
                    $.post
                    (
                        imnicamail_cfg.ajaxurl, 
                        {
                            action : "imnicamail_get_subscription_form_html_code", 
                            SubscriberListID : $('#imnicamail-customize-form #lists').val(), 
                            SessionID : SessionID, 
                            imnicamail_url : imnicamail_cfg.imnicamail_url, 
                            "cookie" : encodeURIComponent(document.cookie), 
                            CustomFields : CustonFieldsArr.join(',')
                        },
                        function (response) {
                            $('#imnicamail-customize-form #generate-form-button').removeClass('button-disabled').removeAttr('disabled').val('Generate Form');
                            
                            if ('object' == typeof response && response.Success) {
                                $.post
                                (
                                    imnicamail_cfg.ajaxurl, 
                                    {
                                        action : "imnicamail_save_subscription_form", 
                                        FormHTMLCode : response.HTMLCode.join(''), 
                                        "cookie" : encodeURIComponent(document.cookie)
                                    },
                                    function (response) {
                                        if ('object' == typeof response && response.success) {
                                            $('#normal-fields').empty();
                                            
                                            $.each(response.FormHTML.normal_fields, function(index, value){
                                                var checkbox = $(document.createElement('input'))
                                                    .attr('type', 'checkbox')
                                                    .attr('name', 'enabled[]') 
                                                    .attr('checked', 'checked');
                                                    
                                                if ('Email Address' == value.label) {
                                                    checkbox.attr('disabled', 'disabled');
                                                }
                                                                
                                                $('#normal-fields').append(                
                                                    $(document.createElement('li')).addClass('jquery-sortable-item') 
                                                        .append(checkbox)
                                                        .append(' ' + value.label)
                                                        .append(
                                                            $(document.createElement('input'))
                                                                .attr('type', 'hidden')
                                                                .attr('name', 'order[]')
                                                                .attr('value', index)
                                                        )
                                                );
                                            });     
                                            
                                            showUpdateMessage('Suscription form successfully generated.');
                                        } else {
                                            showErrorMessage('An error has occured while generating the subsciption form.');
                                        }
                                    },
                                    'json'
                                );
                            } else {                                       
                                showErrorMessage('An error has occured while generating the subsciption form.');
                            }
                        },
                        'json'
                    );
                } else {
                    showErrorMessage('An error has occured while generating the subsciption form.'); 
                }
            },
            'json'
        );
    });
    
    $('#imnicamail-customize-form #form-customization-submit').click(function(){
        $('#imnicamail-customize-form #form-customization-submit').addClass('button-disabled').attr('disabled', 'disabled').val('Saving Changes...');
        
        var newOrder = [];
        var newEnables = [];                    
        
        $('#imnicamail-customize-form input[name]').each(function(index, elem){
            if ('order[]' == $(elem).attr('name')) {
                newOrder.push($(elem).val());
            } else if ('enabled[]' == $(elem).attr('name')) {
                if ($(elem).is(':checked')) {
                    newEnables.push(true);    
                } else {
                    newEnables.push(false);    
                }
            }
        });                             
        
        $.post
        (
            imnicamail_cfg.ajaxurl, 
            {
                action:'imnicamail_form_customnization',
                new_order: newOrder,
                new_enables: newEnables
            },
            function (response) {
                $('#imnicamail-customize-form #form-customization-submit').removeClass('button-disabled').removeAttr('disabled').val('Save Changes');
                showUpdateMessage('Subscription form successfully updated.');
            },
            'json' 
        )  
    });
    
    if (0 == $('#imnicamail-customize-form #lists option').length) {
        $('#imnicamail-customize-form #refresh-lists-button').click();    
    }
});
