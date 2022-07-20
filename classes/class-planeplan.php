<?php
namespace planeplan{

    use planeplan\param;
    use \planeplan\rotation ;
	use \planeplan\sauteur;
    use \planeplan\aerodrome;
	
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
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			// code d'activation du plugin ici appelé par register_activation_hook
			global $wpdb;

            $wpdb->show_errors();
			
			$charset_collate = $wpdb->get_charset_collate();

			$rotation_table_name = $wpdb->prefix . self::$_prefix_plugin. 'rotation';
			$rotation_table = rotation::createtable($rotation_table_name, $charset_collate);
            dbDelta($rotation_table);

            $sauteur_table_name = $wpdb->prefix . self::$_prefix_plugin. 'sauteur';
            $sauteur_table = sauteur::createtable($sauteur_table_name, $charset_collate);
            dbDelta($sauteur_table);

            $aerodrome_table_name = $wpdb->prefix . self::$_prefix_plugin. 'aerodrome';
            $aerodrome_table = sauteur::createtable($aerodrome_table_name, $charset_collate);
            dbDelta($aerodrome_table);

		}
		
		/*
		Gestion du menu dans l'interface d'administration
		appelé par la fonction init()
		*/
		public function admin_planeplan_plugin_menu(){
		    /*
		     * Menu principal
		     */
			add_menu_page(
				__('PlanePlan Plugin setting', 'planeplan/planplan'), // Page title
				__('PlanePlan', 'planeplan/planplan '), // Menu title
				'manage_options',  // Capability
				'planplan_settings_page', // Slug
				[ &$this, 'load_planeplan_accueil'], // Callback page function
				'dashicons-calendar-alt'
			);

            /*
             * Sous Menu principal
            */
            add_submenu_page(
                'planplan_settings_page', // slug du Menu Parent
                __( 'PlanePlan Gestion des Rotations', 'planeplan/planplan' ), // Titre de la page identique au menu parent
                __( 'Rotations', 'planeplan/planplan' ),          // Menu title, Text Domain(pour la traduction)
                'manage_options',                                        // Capabilities (Capacités)
                'planplan_rotation',                               // Slug du sous menu
                [ &$this, 'load_planeplan_rotation']                 // Callback fonction (this pour dire que c'est dans cette classe
            );


            /*
             * Sous Menu Aerodrome
             */
            add_submenu_page(
                'planplan_settings_page', // slug du Menu Parent
                __( 'PlanePage Aerodrome Setting', 'planeplan/planplan' ),  // Titre de la page identique au menu parent
                __( 'Aerodromes', 'planeplan/planplan' ),                   // Menu title, Text Domain(pour la traduction)
                'manage_options',                                           // Capabilities (Capacités)
                'PlanePlane__menu_aerodrome',                               // Slug du sous menu
                [ &$this, 'gestion_aerodrome']
            // Priority/position
            );

            add_submenu_page(
                'planplan_settings_page', // slug du Menu Parent
                __( 'PlanePage General Setting', 'planeplan/planplan' ),  // Titre de la page identique au menu parent
                __( 'Parametres', 'planeplan/planplan' ),                   // Menu title, Text Domain(pour la traduction)
                'manage_options',                                           // Capabilities (Capacités)
                'PlanePlane__menu_parametres',                               // Slug sous menu
                [ &$this, 'parametres']
            // Priority/position
            );

		}

        /*
        Affichae de la page d'accueil du plugin
        */
        public function load_planeplan_accueil()
        {
            /*
            echo '<h1>' . __( 'planeplan Plugin', 'planeplan/planplan' ) . '</h1>';
            echo '<p>' . __( 'Welcome to planeplan Plugin', 'planeplan/planplan' ) . '</p>';
            echo '<p>' . __( 'On dit Merci Qui ? .... merci Ludo !', 'planeplan/planplan' ) . '</p>';
            */
            echo "<h1>Planeplan Plugin</h1>";
            echo '<h2>Welcome Mathieu Deshamps</h2>';

            self::credits();
        }
			
		/*
		Affichae de la page de gestion des rotations
		*/
		public function load_planeplan_rotation()
		{ 
			/*
			echo '<h1>' . __( 'planeplan Plugin', 'planeplan/planplan' ) . '</h1>';
			echo '<p>' . __( 'Welcome to planeplan Plugin', 'planeplan/planplan' ) . '</p>';
			echo '<p>' . __( 'On dit Merci Qui ? .... merci Ludo !', 'planeplan/planplan' ) . '</p>';
			*/
            echo "<h1>Planeplan Plugin</h1>";
            echo '<h2>Gestion des rotations de vols de ToursNJump</h2>';

            self::credits();
		}

        /*
        Affichae de la page de gestion des aerodromes
        */
        public function gestion_aerodrome()
        {
            /*
            echo '<h1>' . __( 'planeplan Plugin', 'planeplan/planplan' ) . '</h1>';
            echo '<p>' . __( 'Welcome to planeplan Plugin', 'planeplan/planplan' ) . '</p>';
            echo '<p>' . __( 'On dit Merci Qui ? .... merci Ludo !', 'planeplan/planplan' ) . '</p>';
            */
            echo "<h1>Planeplan Plugin</h1>";
            echo '<h2>Gestion des Aerodromes</h2>';


            self::credits();
        }

        /*
        Gestion des parametres
        */
        public function parametres()
        {

            echo "<h1>Planeplan Plugin Settings</h1>";

           // var_dump(param::LoadParams());

              $data = isset($_POST['data']) ? $_POST['data'] : false;

              if ($data) {
                  param::processForm($data);

                  param::showForm();

                  echo '<div class="notice notice-success"><p>Nouveaux paramètres bien pris en compte</p></div>';

              }
              else {
                  param::showForm();
              }
            self::credits();
        }

        public static function credits(){
            echo'<p id="footer-left" class="alignleft">developpé par Ludovic MERY  - version 1.0</p>';
        }
	}
}
?>