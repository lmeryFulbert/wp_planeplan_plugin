<?php
namespace planeplan{
	use \planeplan\rotation ;
	use \planeplan\sauteur;
	
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

			// code d'activation du plugin ici appelé par register_activation_hook
			global $wpdb;

            $wpdb->show_errors();
			
			$charset_collate = $wpdb->get_charset_collate();

			$rotation_table_name = $wpdb->prefix . self::$_prefix_plugin. 'rotation';
			$rotation_table = rotation::createtable($rotation_table_name, $charset_collate);
			
            $sauteur_table_name = $wpdb->prefix . self::$_prefix_plugin. 'sauteur';
            $sauteur_table = sauteur::createtable($sauteur_table_name, $charset_collate);

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			$results= dbDelta($rotation_table);
            $results= dbDelta($sauteur_table);
		}
		
		/*
		Gestion du menu dans l'interface d'administration
		appelé par la fonction init()
		*/
		public function admin_planeplan_plugin_menu(){
			add_menu_page(
				__('PlanePlan Plugin setting', 'planeplan/planplan'), // Page title
				__('PlanePlan', 'planeplan/planplan '), // Menu title
				'manage_options',  // Capability
				'planeplan/planplan', // Slug
				[ &$this, 'load_planeplan_plugin_page'], // Callback page function
				'dashicons-calendar-alt'
			);
		}
			
		/*
		Affichae de la page d'administration
		*/
		public function load_planeplan_plugin_page() 
		{ 
			/*
			echo '<h1>' . __( 'planeplan Plugin', 'planeplan/planplan' ) . '</h1>';
			echo '<p>' . __( 'Welcome to planeplan Plugin', 'planeplan/planplan' ) . '</p>';
			echo '<p>' . __( 'On dit Merci Qui ? .... merci Ludo !', 'planeplan/planplan' ) . '</p>';
			*/
            echo "<h1>Planeplan Plugin</h1>";
            echo '<h2>Gestion des rotations de vols de ToursNJump</h2>';
             echo'<p id="footer-left" class="alignleft">developpé par Ludovic MERY  - version 1.0</p>';

		}

	}
}
?>