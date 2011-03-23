jQuery(document).ready(function($){
    var ui = {
        submit: $('#imnicamail-authentication #submit'),      
        success_message: $('#imnicamail-authentication #success-message'),
        error_message: $('#imnicamail-authentication #error-message'),
        username: $("#imnicamail-authentication #username"),
        password: $("#imnicamail-authentication #password")
    };
    
    ui.submit.click(function(){
        ui.submit.attr('disabled', 'disabled');
        ui.success_message.slideUp();
        ui.error_message.slideUp();
        
        $.post
        (
            imnicamail_cfg.ajaxurl, 
            {            
                action : "imnicamail_login", 
                save : true,       
                username : ui.username.val(), 
                password : ui.password.val(), 
                imnicamail_url : imnicamail_cfg.imnicamail_url, 
                "cookie" : encodeURIComponent(document.cookie)
            },                                                    
            function (response) {                                     
                ui.submit.removeAttr('disabled');
                
                if ('object' == typeof response && response.Success) {                          
                    ui.success_message.slideDown();
                } else {
                    ui.error_message.slideDown();
                }
            }, 
            'json'
        );
    });
});