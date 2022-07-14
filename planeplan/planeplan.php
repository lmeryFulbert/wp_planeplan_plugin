                    
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
 
 /*
 remarque:
 
 WordPress ne gère pas les namespaces :-(  
 
 la loose, une journée de perdue pour comprendre le bug
 */
 
 require_once("classes/planeplan_class.php");
 require_once("classes/rotation_class.php");
 require_once("classes/sauteur_class.php");
   
//use planeplan\planeplan;
use planeplan;
 
 register_activation_hook(   __FILE__, array( 'planeplan', 'on_activation' ) );
//register_deactivation_hook( __FILE__, array( 'WCM_Setup_Demo_Class', 'on_deactivation' ) );
//register_uninstall_hook(    __FILE__, array( 'WCM_Setup_Demo_Class', 'on_uninstall' ) );

 
$plugin=new planeplan();
$plugin->init();