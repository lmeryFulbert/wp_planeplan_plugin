<?php
namespace planeplan;
/*
 *  Voir documentation https://onlinewebtutorblog.com/wordpress-table
 */

    class aerodrome extends \WP_List_Table
    {
        private static function getTableName(){
            global $wpdb;
            $aerodrome_table_name = $wpdb->prefix . planeplan::$_prefix_plugin. 'aerodrome';

            return $aerodrome_table_name;
        }

        public static function createtable($tablename, $charset)
        {
            $sql = "CREATE TABLE $tablename (
                    id         int auto_increment not null,
                    name         varchar(50)  not null,
                    address      varchar(100)  null,
                    cp          varchar(5) null,
                    city        varchar(50) null,
                    gpslat        DECIMAL(11,4) null,
                    gpslong        DECIMAL(11,4) null,
                    primary key(id)
                ) $charset;";
            return $sql;
        }

        /*
         * devenue inutile avec l'heritage de WP_List_Table
         *

        public static function LoadAll(){
            global $wpdb;

            $aerodrome_table_name = $wpdb->prefix . planeplan::$_prefix_plugin. 'aerodrome';

            $req="SELECT * FROM $aerodrome_table_name";

           // var_dump($req);

            $rows=$wpdb->get_results($req);

            return $rows;
        }
        */


        public static function listing(){

            /* var_dump($vue);

            $data=aerodrome::LoadAll();

            $vue=WP_PLUGIN_DIR."/planeplan/views/aerodrome/listing.php";
              */

            $myTable = new aerodrome();

            echo '<div class="wrap">';


             $myTable->prepare_items();


            if (isset($_GET['action']) && $_GET['page'] == "planeplan_aerodrome" && $_GET['action'] == "edit") {
                $slug="planeplan_aerodrome_update";
                $url=admin_url()."admin.php?page=$slug";
               // $myTable->display();
            }
            else{
                $slug="planeplan_aerodrome_add";
                $url=admin_url()."admin.php?page=$slug";

                echo '<h2><a class="add-new-h2" href="'.$url.'">Add</a></h2>';
                $myTable->search_box('search', 'search_id');       //zone de recherche
                // Display table
                $myTable->display();
            }

            echo '</div>';
        }

        function get_columns()
        {
            $columns = array(
             //   'cb' => '<input type="checkbox" />',
                'id'        =>__('id'),
                'name'      => __('Nom'),
                'address'  => __('addresse'),
                'cp'     => __('code postal'),
                'city'     => __('ville'),
                'gpslat'   => __('lattitude'),
                'gpslong'       => __('longitude'),
            );
            return $columns;
        }

        function column_id($item)
        {
            $actions = array(
                'edit'      => sprintf('<a href="?page=%s&action=%s&aerodrome=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
                'delete'    => sprintf('<a href="?page=%s&action=%s&aerodrome=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
            );

            return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions));
        }

        function get_sortable_columns()
        {
            $sortable_columns = array(
                'id'      => array('id', true),
                'name'      => array('name', true),
                'address'  => array('lastname', true),
                'cp'     => array('email', true),
                'city'     => array('phone', true),
                'gpslat'       => array('web', false),
                'gpslong' => array('two_email', false),
            );
            return $sortable_columns;
        }

        /*
         * Gestion du CRUD
         */
        function prepare_items()
        {
            global $wpdb;
            $table_name = $wpdb->prefix . planeplan::$_prefix_plugin. 'aerodrome';

            // delete
            if (isset($_GET['action']) && $_GET['page'] == "planeplan_aerodrome" && $_GET['action'] == "delete") {
                $theid = intval($_GET['aerodrome']);

                //... do operation
                $wpdb->delete( $table_name, array( 'id' => $theid ) );
            }

                $per_page = 10;

                $columns = $this->get_columns();
                $hidden = array();
                $sortable = $this->get_sortable_columns();

                $this->_column_headers = array($columns, $hidden, $sortable);

                $this->process_bulk_action();

                $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");


                $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
                $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'name';
                $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

                $requete = "SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d";


                $this->items = $wpdb->get_results($wpdb->prepare($requete, $per_page, $paged), ARRAY_A);


                $this->set_pagination_args(array(
                    'total_items' => $total_items,
                    'per_page' => $per_page,
                    'total_pages' => ceil($total_items / $per_page)
                ));

            // Edit controller
            if (isset($_GET['action']) && $_GET['page'] == "planeplan_aerodrome" && $_GET['action'] == "edit") {

                $theid = intval($_GET['aerodrome']);

                $data = isset($_POST['data']) ? $_POST['data'] : false;

                if ($data) {
                    aerodrome::processForm($data,$theid);

                    echo '<div class="notice notice-success"><p>Modification enregistrées</p></div>';

                    $url = esc_url( $_SERVER['REQUEST_URI']);

                    echo '<div class="wrap">';
                    echo '<h2><a class="add-new-h2" href="'.$url.'">Retour</a></h2>';
                    echo '</div>';

                   // exit();
                }
                else {

                    $sql="SELECT * FROM $table_name WHERE id = %d";

                    $lesdata = $wpdb->get_row( $wpdb->prepare($sql,$theid),ARRAY_A);
                    // var_dump($lesdata);

                    self::showForm($lesdata);
                }

                self::credits();

            }


        }

        // bind data with column
        function column_default($item, $column_name)
        {
            switch ($column_name) {
                case 'id':
                case 'user_login':
                case 'user_email':
                    return $item[$column_name];
                case 'display_name':
                    return ucwords($item[$column_name]);
                default:
                   // return print_r($item, true); //Show the whole array for troubleshooting purposes
                     return $item[$column_name];
            }
        }


        function column_cb($item)
        {
            return sprintf(
                '<input type="checkbox" name="user[]" value="%s" />',
                $item['id']
            );
        }

        public static function showForm($data=null){

            $vue=WP_PLUGIN_DIR."/planeplan/views/aerodrome/form.php";
            // var_dump($vue);

            include($vue);
        }

        public static function processForm($data, $id=null){

            global $wpdb;

            //var_dump($data);

            $table=aerodrome::getTableName();

            $datainabse = array('name' => $data["name"],
                                'address' => $data["adresse"],
                                'cp' => $data["cp"],
                                'city' => $data["ville"],
                                'gpslat' => $data["lattitude"],
                                'gpslong' => $data["longitude"],
            );

          //  var_dump($datainabse);

            //$format = array('%s','%d');
            if (!is_null($id)){
                $wpdb->update($table,$datainabse,array('id' => $id));
            }
            else {

                $wpdb->insert($table,$datainabse);
                $my_id = $wpdb->insert_id;
            }

        }

    }