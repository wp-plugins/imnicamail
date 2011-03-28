<?php
    
    if (!class_exists("ImnicaMailPlugin")) {
                                                                                                
        require_once(IMNICAMAIL_PLUGIN_DIR.'/thirdparty/simplehtmldom/simple_html_dom.php'); 
        require_once(IMNICAMAIL_PLUGIN_DIR.'/classes/imnicamailwidget.php');

        class ImnicaMailPlugin {

            var $AdminOptions = "ImnicaMailPluginAdminOptions";
            
            /**
             * ImnicaMailPlugin constructor function
             *
             * @return void
             * @author ImnicaMail
             */
             
            function ImnicaMailPlugin() {      
                $options = $this->getAdminOptions();
                
                if (is_null($options['powered_by'])) {
                    $this->updateAdminOptions(array('powered_by' => '1'));  
                    $options = $this->getAdminOptions();
                }
                
                add_action('widgets_init', array($this, 'loadWidget'), 1); 
                
                if (is_admin()) {    
                    /**
                    * @todo Transfer all this functions to its proper handler.
                    */
                    switch ($_GET['page']) {
                        case 'imnicamail':   
                            wp_enqueue_script('imnicamail-settings', IMNICAMAIL_PLUGIN_URL.'/scripts/settings.js', array('jquery'));
                            
                            wp_localize_script(
                                "imnicamail-settings", 
                                "imnicamail_cfg", 
                                array(
                                    'ajaxurl' => admin_url('admin-ajax.php')
                                )
                            );
                            break;
                            
                        case 'imnicamail-authentication':                                                                                                      
                            wp_enqueue_script('imnicamail-authentication', IMNICAMAIL_PLUGIN_URL.'/scripts/authentication.js', array('jquery'));     
                            wp_localize_script(
                                "imnicamail-authentication", 
                                "imnicamail_cfg", 
                                array(
                                    'imnicamail_url' => 'http://www.imnicamail.com/v4/',
                                    'ajaxurl' => admin_url('admin-ajax.php'),
                                    'username' => $options['Username'],
                                    'password' => $options['Password'],
                                )
                            );
                            break;
                            
                        case 'imnicamail-customize-form':
                            wp_enqueue_script('imnicamail-customize-form', IMNICAMAIL_PLUGIN_URL.'/scripts/customize-form.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'));
                            wp_localize_script(
                                "imnicamail-customize-form", 
                                "imnicamail_cfg", 
                                array(
                                    'imnicamail_url' => 'http://www.imnicamail.com/v4/',
                                    'ajaxurl' => admin_url('admin-ajax.php'),
                                    'username' => $options['Username'],
                                    'password' => $options['Password'],
                                )
                            );
                            break;    
                    }    
                
                    // Ajax actions handling.
                    add_action('wp_ajax_imnicamail_login', array($this, 'loginCheck'));
                    add_action('wp_ajax_imnicamail_get_subscriber_lists', array($this, 'getSubscriberLists'));
                    add_action('wp_ajax_imnicamail_get_custom_fields', array($this, 'getCustomFields'));
                    add_action('wp_ajax_imnicamail_get_subscription_form_html_code', array($this, 'getSubscriptionFormHTMLCode'));
                    add_action('wp_ajax_imnicamail_save_subscription_form', array($this, 'saveSubscriptionFormHTMLCode'));
                    add_action('wp_ajax_imnicamail_form_customnization', array($this, 'saveFormCustomization'));
                    add_action('wp_ajax_imnicamail_save_settings', array($this, 'saveSettings'));
                    add_action('wp_ajax_imnicamail_set_submit_image', array($this, 'setSubmitImage'));

                    // Add admin menus.
                    add_action('admin_menu', array($this, 'adminMenu'));
                } else {
                    add_shortcode('im-form', array($this, 'showForm'));
                    
                    if (1 == intval($options['default_styling'])) {
                        wp_enqueue_style('imnicamail', IMNICAMAIL_PLUGIN_URL.'/styles/imnicamail.css');
                    }
                }
            }
            
            function showForm($atts, $content = null, $code = "") {
                $options = $this->getAdminOptions();
                include(IMNICAMAIL_PLUGIN_DIR.'/php/form.php');
            }
            
            function setSubmitImage() {
                $file = IMNICAMAIL_PLUGIN_DIR.'/uploads/'.$_POST['file']['name'];
                $pathinfo = pathinfo($file);
                copy($file, IMNICAMAIL_PLUGIN_DIR.'/uploads/submit_button.'.$pathinfo['extension']);
                unlink($file);
            }
            
            
            /**
            * Adds the administration menus.
            */
            
            function adminMenu() {
                $page_hooks = array();
                
                add_menu_page('ImnicaMail', 'ImnicaMail', 'manage_options', 'imnicamail', array($this, 'settingsPage'));
                $page_hooks['imnicamail'] = add_submenu_page('imnicamail', __('Settings &laquo; ImnicaMail'), __('Settings'), 'manage_options', 'imnicamail', array($this, 'settingsPage'));
                $page_hooks['imnicamail-authentication'] = add_submenu_page('imnicamail', __('Authentication &laquo; ImnicaMail'), __('Authentication'), 'manage_options', 'imnicamail-authentication', array($this, 'authenticationPage'));
                $page_hooks['imnicamail-customize-form'] = add_submenu_page('imnicamail', __('Customize Form &laquo; ImnicaMail'), __('Customize Form'), 'manage_options', 'imnicamail-customize-form', array($this, 'displayFormCustomizationPage'));                
                
                add_action("load-{$page_hooks['imnicamail-customize-form']}", array($this, 'loadPageCustomizeForm'));
            }
            

            /**
            * Get the current admin options from the DB
            *
            * @return array
            */
             
            function getAdminOptions() {
                return get_option($this->AdminOptions);
            }   
            
            
            /**
            * Handle the cutomize form load action.
            */
            
            function loadPageCustomizeForm() {
                wp_enqueue_style('imnicamail-admin', IMNICAMAIL_PLUGIN_URL.'/styles/imnicamail-admin.css');
            }
            
            
            /**
            * Display the form customization page.
            */
            
            function displayFormCustomizationPage() {
                $Options = $this->getAdminOptions(); 
                include(IMNICAMAIL_PLUGIN_DIR.'/php/customize-form.php');
            }
           
           
            /**
            * Display the settings page.
            */
           
            function settingsPage() {
                $Options = $this->getAdminOptions();
                include(IMNICAMAIL_PLUGIN_DIR.'/php/settings.php');
            }
           
           
            /**
            * Display the settings page.
            */
           
            function authenticationPage() {
                $Options = $this->getAdminOptions();
                include(IMNICAMAIL_PLUGIN_DIR.'/php/authentication.php');
            }
            

            /**
            * adds an option to the wordpress options.
            *
            * @param array $OptionArray
            */
             
            function updateAdminOptions($OptionArray) {
                $Options = $this->getAdminOptions();

                foreach($OptionArray as $Key => $Value)
                {
                    $Options[$Key] = $Value;
                }

                return update_option($this->AdminOptions, $Options);
            }

            
            /**
             * registers widget to the blog by using wp admin settings.
             *
             * @return void
             * @author ImnicaMail
             */
             
            function loadWidget() {
                register_widget('ImnicaMailWidget');          
            }


            /**
             * undocumented function
             *
             * @return void
             * @author ImnicaMail
             */
            function saveSubscriptionFormHTMLCode() {
                // FormHTMLCode must be decoded first.
                // To double check on other magic quote settings.
                $formHtml = ImnicaMailFunctions::parseHtmlForm(html_entity_decode($_POST['FormHTMLCode']));
                
                // Save the form html only.
                $this->updateAdminOptions(array(
                    'FormHtml' => $formHtml
                ));
                
                die(json_encode(array(
                    'success' => true, 
                    'FormHTMLCode' => html_entity_decode($_POST['FormHTMLCode']),
                    'FormHTML' => $formHtml
                )));
            }       
            
            
            /**
            * To Document.
            */
            
            function saveFormCustomization() {       
                $Options = $this->getAdminOptions();  
                $formHtml = $Options['FormHtml'];
                $normalFields = $formHtml['normal_fields'];
                $newOrderIndexes = $_POST['new_order'];   
                
                if (is_array($normalFields) && is_array($newOrderIndexes)) {
                    $newNormalFields = array();               
                    $newEnables = $_POST['new_enables'];
                   
                    foreach ($newOrderIndexes as $k => $f) {
                        $normalFields[$f]['enabled'] = $newEnables[$k];
                        $newNormalFields[] = $normalFields[$f];     
                    }

                    $formHtml['normal_fields'] = $newNormalFields;
                     
                    $return = $this->updateAdminOptions(array(
                        'FormHtml' => $formHtml  
                    ));
                
                    die(json_encode($newNormalFields));
                }
            }
            
            
            /**
            * To Document.
            */
            
            function saveSettings() {       
                $newSettings = array(
                    'default_styling'       => $_POST['default_styling'],
                    'powered_by'            => $_POST['powered_by'],
                    'use_image_button'      => $_POST['use_image_button'],
                    'image_url'             => $_POST['image_url'],
                    'affiliate_id'          => $_POST['affiliate_id'],
                    'submit_button_text'    => $_POST['submit_button_text']
                );
                 
                $return = $this->updateAdminOptions($newSettings);
                
                if (true) {
                    die(json_encode(array(
                        'success' => true,
                        'new_settings' => $newSettings, 
                        'success_message' => 'Your settings has been successfully saved.' 
                    )));
                } else {
                    die(json_encode(array(
                        'success' => false,
                        'error_message' => 'An error has occured while saving your settings.' 
                    )));
                }
            }    

            
            /**
             * echos the result of CURL call to the given Imnica Mail server.
             */
             
            function loginCheck() {
                /* Setup POST parameters - Begin */
                $ArrayPostParameters = array();
                $ArrayPostParameters[] = "Command=User.Login";
                $ArrayPostParameters[] = "ResponseFormat=JSON";
                $ArrayPostParameters[] = "Username=".$_POST['username'];
                $ArrayPostParameters[] = "Password=".$_POST['password'];
                /* Setup POST parameters - End */

                if ($_POST['save']) {
                    $this->updateAdminOptions(array(
                        "Username" => $_POST['username'],
                        "Password" => $_POST['password'],
//                        "URL" => $_POST['imnicamail_url']
                    ));    
                }

                $response = $this->_postToRemoteURL($_POST['imnicamail_url']."/api.php?", $ArrayPostParameters);
                if (false == $response[0]) {
                    echo "false";
                } else {
                    echo $response[1];
                }
                
                exit;
            }

            
            /**
             * echos all the subscriber lists
             */
             
            function getSubscriberLists() {
                /* Setup POST parameters - Begin */
                $ArrayPostParameters = array();
                $ArrayPostParameters[] = "Command=Lists.Get";
                $ArrayPostParameters[] = "ResponseFormat=JSON";
                $ArrayPostParameters[] = "SessionID=".$_POST['SessionID'];
                $ArrayPostParameters[] = "OrderField=ListID";
                $ArrayPostParameters[] = "OrderType=ASC";
                /* Setup POST parameters - End */

                $response = $this->_postToRemoteURL($_POST['imnicamail_url']."/api.php?", $ArrayPostParameters);
                echo $response[1];
                exit;
            }

            
            /**
             * returns the custom fields of given subscriber list
             */
             
            function getCustomFields() {
                /* Setup POST parameters - Begin */
                $ArrayPostParameters = array();
                $ArrayPostParameters[] = "Command=CustomFields.Get";
                $ArrayPostParameters[] = "ResponseFormat=JSON";
                $ArrayPostParameters[] = "SessionID=".$_POST['SessionID'];
                $ArrayPostParameters[] = "OrderField=FieldName";
                $ArrayPostParameters[] = "OrderType=ASC";
                $ArrayPostParameters[] = "SubscriberListID=".$_POST['SubscriberListID'];
                /* Setup POST parameters - End */

                $response = $this->_postToRemoteURL($_POST['imnicamail_url']."/api.php?", $ArrayPostParameters);
                echo $response[1];
                exit;
            }

            
            /**
             * echos the subscription form HTML code
             */
             
            function getSubscriptionFormHTMLCode() {
                $ArrayPostParameters = array();
                $ArrayPostParameters[] = "Command=ListIntegration.GenerateSubscriptionFormHTMLCode";
                $ArrayPostParameters[] = "ResponseFormat=JSON";
                $ArrayPostParameters[] = "SessionID=".$_POST['SessionID'];
                $ArrayPostParameters[] = "SubscriberListID=".$_POST['SubscriberListID'];
                $ArrayPostParameters[] = "CustomFields=".$_POST['CustomFields'];

                $response = $this->_postToRemoteURL($_POST['imnicamail_url']."/api.php?", $ArrayPostParameters);

                die(stripslashes($response[1]));
            }
                  
                                                         
            /**
            * POSTs given array to a remote URL with CURL
            *
            * @return array(1:bool, 2:response text)
            */
             
            function _postToRemoteURL($URL, $ArrayPostParameters, $HTTPRequestType = 'POST', $HTTPAuth = false, $HTTPAuthUsername = '', $HTTPAuthPassword = '', $ConnectTimeOutSeconds = 5, $ReturnHeaders = false) {
                $PostParameters = implode('&', $ArrayPostParameters);
                $CurlHandler = curl_init();
                curl_setopt($CurlHandler, CURLOPT_URL, $URL);

                if ($HTTPRequestType == 'GET') {
                    curl_setopt($CurlHandler, CURLOPT_HTTPGET, true);
                } elseif ($HTTPRequestType == 'PUT') {
                    curl_setopt($CurlHandler, CURLOPT_PUT, true);
                } elseif ($HTTPRequestType == 'DELETE') {
                    curl_setopt($CurlHandler, CURLOPT_CUSTOMREQUEST, 'DELETE');
                } else {
                    curl_setopt($CurlHandler, CURLOPT_POST, true);
                    curl_setopt($CurlHandler, CURLOPT_POSTFIELDS, $PostParameters);
                }

                curl_setopt($CurlHandler, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($CurlHandler, CURLOPT_CONNECTTIMEOUT, $ConnectTimeOutSeconds);
                curl_setopt($CurlHandler, CURLOPT_TIMEOUT, $ConnectTimeOutSeconds);
                curl_setopt($CurlHandler, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');

                // The option doesn't work with safe mode or when open_basedir is set.
                if ((ini_get('safe_mode') != false) && (ini_get('open_basedir') != false)) {
                    curl_setopt($CurlHandler, CURLOPT_FOLLOWLOCATION, true);
                }

                if ($ReturnHeaders == true) {
                    curl_setopt($CurlHandler, CURLOPT_HEADER, true);
                } else {
                    curl_setopt($CurlHandler, CURLOPT_HEADER, false);
                }

                if ($HTTPAuth == true) {
                    curl_setopt($CurlHandler, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($CurlHandler, CURLOPT_USERPWD, $HTTPAuthUsername.':'.$HTTPAuthPassword);
                }

                $RemoteContent = curl_exec($CurlHandler);

                if (curl_error($CurlHandler) != '') {
                    return array(false, curl_error($CurlHandler));
                }

                curl_close($CurlHandler);

                return array(true, $RemoteContent);
            }     
        }
    }
?>
