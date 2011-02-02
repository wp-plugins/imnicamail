jQuery(document).ready(function($){
    $('#imnicamail-authentication #submit').click(function(){
        $('#imnicamail-authentication #submit').attr('disabled', 'disabled');
        $('#imnicamail-authentication #success-message').slideUp();
        $('#imnicamail-authentication #error-message').slideUp();
        
        $.post
        (
            imnicamail_cfg.ajaxurl, 
            {            
                action : "imnicamail_login", 
                save : true,       
                username : $("#imnicamail-authentication #username").val(), 
                password : $("#imnicamail-authentication #password").val(), 
                imnicamail_url : imnicamail_cfg.imnicamail_url, 
                "cookie" : encodeURIComponent(document.cookie)
            },                                                    
            function(response){                                     
        $('#imnicamail-authentication #submit').removeAttr('disabled');
                if (response.Success) {                          
                    $('#imnicamail-authentication #success-message').slideDown();
                } else {
                    $('#imnicamail-authentication #error-message').slideDown();
                }
            }, 
            'json'
        );
    });
});