<?php
/**
 * Plugin Name: PlanePlan 
 * Plugin URI: https://github.com/lmeryFulbert/wp_planeplan_plugin.git
 * Description: Manage Plane Plan for skydiving
 * Version: 1.0.0  
 * Author Name: MERY Ludovic (ludovic.mery@lyceefulbert.fr)  
 * Author: MERY Ludovic (Undefined)  
 * Domain Path: /fr  
 * Text Domain: linky 
 * Author URI: https://www.sio.lyceefulbert.fr
 */
namespace planeplan;


    require_once("classes/class-planeplan.php");
    require_once("classes/class-rotation.php");
    require_once("classes/class-sauteur.php");
    require_once("classes/class-param.php");

   // use \planeplan\planeplan;

    register_activation_hook(__FILE__, array('\planeplan\planeplan', 'on_activation'));

//register_deactivation_hook( __FILE__, array( 'WCM_Setup_Demo_Class', 'on_deactivation' ) );
//register_uninstall_hook(    __FILE__, array( 'WCM_Setup_Demo_Class', 'on_uninstall' ) );


    function save_output_buffer_to_file()
    {
        file_put_contents(
            ABSPATH . 'wp-content/plugins/activation_output_buffer.html', ob_get_contents()
        );
    }

    add_action('activated_plugin', 'planeplan\save_output_buffer_to_file');

    $plugin = new planeplan();
    $plugin->init();