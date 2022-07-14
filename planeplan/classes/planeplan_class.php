<?php
//namespace planeplan{
	//use planeplan\rotation ;
	use rotation;
	
	class planeplan 
	{
		public static $_prefix_plugin="pp_";
		
		
		public function __construct()
		{
			//rien pour l'instant
			//on definira les variables du plugin
			
		}
		
		public function init()
		{
			//Ajout du menu dans le menu d'administration
			add_action( 'admin_menu', [ $this, 'admin_planeplan_plugin_menu'] );
		}
		
		/*
		Gestion de l'installation du plugin
		
		Attention la methode doit être static
		*/

		static function on_activation() {
			
			// code d'activation ici 
			global $wpdb;
			
			$charset_collate = $wpdb->get_charset_collate();

			$rotation_table_name = $wpdb->prefix . self::$_prefix_plugin. 'rotation';
			//$rotation_table_name = $this->_prefix_plugin . 'rotation';

			$rotation_table = rotation::createtable($rotation_table_name, $charset_collate);

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			dbDelta($rotation_table);
		}
		
		/*
		Gestion du menu dans l'interface d'administration
		appelé par la fonction init()
		*/
		public function admin_planeplan_plugin_menu(){
			add_menu_page(
				__('PlanePlan Plugin setting', 'planeplan'), // Page title
				__('PlanePlan', 'planeplan '), // Menu title
				'manage_options',  // Capability
				'planeplan', // Slug
				[ &$this, 'load_planeplan_plugin_page'], // Callback page function
				'dashicons-calendar-alt'
			);
		}
			
		/*
		Affichae de la page d'administration
		*/
		public function load_planeplan_plugin_page() 
		{ 
			echo '<h1>' . __( 'planeplan Plugin', 'planeplan' ) . '</h1>'; 
			echo '<p>' . __( 'Welcome to planeplan Plugin', 'planeplan' ) . '</p>'; 
			echo '<p>' . __( 'On dit Merci Qui ? .... merci Ludo !', 'planeplan' ) . '</p>'; 
		}

	}
//}
?>