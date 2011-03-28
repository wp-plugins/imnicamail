jQuery(document).ready(function($){    
    var ui = {
        submit: $('#imnicamail-settings #submit'),
        error_message: $('#imnicamail-settings #error-message'),
        success_message: $('#imnicamail-settings #success-message'),
        default_styling: $("#imnicamail-settings #default_styling"),
        powered_by: $("#imnicamail-settings #powered_by"),
        use_image_button: $("#imnicamail-settings #use_image_button"),
        affiliate_id: $("#imnicamail-settings #affiliate_id"),
        image_url:$("#imnicamail-settings #image_url"),
        submit_button_text: $("#imnicamail-settings #submit_button_text"),
        success_message_content: $('#imnicamail-settings #success-message-content'),
        error_message_content: $('#imnicamail-settings #error-message-content') 
    };
     
    ui.submit.click(function(){  
        ui.submit.attr('disabled', 'disabled');
        ui.error_message.slideUp();  
        ui.success_message.slideUp();
        
        $.post
        (
            imnicamail_cfg.ajaxurl, 
            {            
                action : "imnicamail_save_settings", 
                default_styling : ui.default_styling.is(':checked') ? '1' : '0', 
                powered_by : ui.powered_by.is(':checked') ? '1' : '0', 
                use_image_button : ui.use_image_button.is(':checked') ? '1' : '0', 
                affiliate_id : ui.affiliate_id.val(),
                image_url : ui.image_url.val(),
                submit_button_text : ui.submit_button_text.val(),         
            }, 
            function(response){  
                ui.submit.removeAttr('disabled');
                
                if ('object' == typeof response && response.success) {                          
                    ui.success_message_content.empty().append(response.success_message);
                    ui.success_message.slideDown();
                } else {                                                                            
                    ui.error_message_content.empty().append(response.error_message);
                    ui.error_message.slideDown();
                }
            }, 
            'json'
        );
    });      
});