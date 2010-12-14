<?php
    if (!class_exists('ImnicaMailFunctions')) {
        final class ImnicaMailFunctions {
            public static function parseHtmlForm($htmlForm) {
                require_once(IMNICAMAIL_PLUGIN_DIR.'/thirdparty/simplehtmldom/simple_html_dom.php'); 
                
                $html = str_get_html($htmlForm);
                $form = $html->find('form', 0);
                
                if ($form) {
                    $normal_fields = array();
                    
                    $oFormRows = $form->find('.o-form-row');
                    foreach ($oFormRows as $oFormRow) {
                        $input = $oFormRow->find('input[type=text], textarea, select, input[type=checkbox], input[type=radio]', 0);
                        if ($input) {
                            $label = $oFormRow->find('label', 0);
                            
                            $oFormRow->class = "im-form-row";
                            
                            $normal_fields[] = array(
                                'label' => $label->innertext, 
                                'input' => str_replace('<br />n', '<br />', $oFormRow->outertext) ,
                                'enabled' => 'true'
                            );    
                        }
                    }
                    
                    $hidden_fields = array();
                    $hidden_fields_htmls = $form->find('input[type=hidden]');
                    foreach ($hidden_fields_htmls as $hidden_fields_html) {
                        $hidden_fields[] = $hidden_fields_html->outertext;    
                    }
                    
                    $submit_field_html = $form->find('input[type=submit]', 0);
                    $submit_field = $submit_field_html->outertext;
                    
                    return array(
                        'method' => $form->method,
                        'action' => $form->action,
                        'normal_fields' => $normal_fields,
                        'hidden_fields' => $hidden_fields,
                        'submit_field' => $submit_field
                    );
                } else {
                    return false;
                }
            }   
        }        
    }
?>