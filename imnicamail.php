<?php

    /**
    * Plugin Name: ImnicaMail
    * Plugin URI: http://www.imnicamail.com/
    * Description: This plugin adds a subsciption form to your blog, so that your viewers can subscribe easily to your mail list.
    * Version: 0.2.4
    * Author: ImnicaMail
    * Author URI: http://www.imnicamail.com
    */

    $imnicalmailFolder = basename(dirname(__FILE__));
    define("IMNICAMAIL_PLUGIN_DIR", WP_PLUGIN_DIR."/{$imnicalmailFolder}");
    define("IMNICAMAIL_PLUGIN_URL", WP_PLUGIN_URL."/{$imnicalmailFolder}");

    /**
    * @todo Resolve filename casing issue.
    */
    
    require_once(IMNICAMAIL_PLUGIN_DIR.'/functions.php');
    require_once(IMNICAMAIL_PLUGIN_DIR.'/classes/imnicamailplugin.php');   
    
    $ImnicaMailPlugin = new ImnicaMailPlugin();   
    
?>