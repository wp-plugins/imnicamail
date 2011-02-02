jQuery(document).ready(function($){     
    $('#imnicamail-settings #submit').click(function(){  
        $('#imnicamail-settings #submit').attr('disabled', 'disabled');
        $('#imnicamail-settings #error-message').slideUp();  
        $('#imnicamail-settings #success-message').slideUp();
        
        $.post
        (
            imnicamail_cfg.ajaxurl, 
            {            
                action : "imnicamail_save_settings", 
                default_styling : $("#imnicamail-settings #default_styling").is(':checked') ? '1' : '0', 
                powered_by : $("#imnicamail-settings #powered_by").is(':checked') ? '1' : '0', 
                use_image_button : $("#imnicamail-settings #use_image_button").is(':checked') ? '1' : '0', 
                affiliate_id : $("#imnicamail-settings #affiliate_id").val(),
                image_url : $("#imnicamail-settings #image_url").val(),
                submit_button_text : $("#imnicamail-settings #submit_button_text").val(),         
            }, 
            function(response){  
                $('#imnicamail-settings #submit').removeAttr('disabled');
                if (response.success) {                          
                    $('#imnicamail-settings #success-message-content').empty().append(response.success_message);
                    $('#imnicamail-settings #success-message').slideDown();
                } else {                                                                            
                    $('#imnicamail-settings #error-message-content').empty().append(response.error_message);
                    $('#imnicamail-settings #error-message').slideDown();
                }
            }, 
            'json'
        );
    });      
});