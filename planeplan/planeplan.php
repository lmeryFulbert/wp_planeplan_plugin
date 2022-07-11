                    
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
 
 class PlanePlan 
{
    public function __construct()
    {
        // Your code here
		add_action( 'admin_menu', [ $this, 'admin_planeplan_plugin_menu'] );
    }
	
	public function admin_planeplan_plugin_menu(){
		add_menu_page(
			__('PlanePlan Plugin', 'planeplan'), // Page title
			__('PlanePlan Plugin', 'planeplan '), // Menu title
			'manage_options',  // Capability
			'planeplan', // Slug
			[ &$this, 'load_planeplan_plugin_page'] // Callback page function
		);
	}
	
	public function load_planeplan_plugin_page() 
	{ 
        echo '<h1>' . __( 'planeplan Plugin', 'planeplan' ) . '</h1>'; 
        echo '<p>' . __( 'Welcome to planeplan Plugin', 'planeplan' ) . '</p>'; 
		echo '<p>' . __( 'On dit Merci Qui ? .... merci Ludo !', 'planeplan' ) . '</p>'; 
	}

}


new PlanePlan();

                