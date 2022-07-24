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

        public function get_columns()
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

        public function column_id($item)
        {
            $actions = array(
                'edit'      => sprintf('<a href="?page=%s&action=%s&aerodrome=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
                'delete'    => sprintf('<a href="?page=%s&action=%s&aerodrome=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
            );

            return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions));
        }

        public function get_sortable_columns()
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

        // bind data with column
        public function column_default($item, $column_name)
        {
            return $item[$column_name];
        }

        public function showview(){

            $myTable = new aerodrome();

            echo '<div class="wrap">';

            $myTable->prepare_items();

            $myTable->display();

            echo '</div>';
        }

        /*
         * CRUD Controller
         */
        function prepare_items()
        {
            /*
             * Gestion du insert
             */
            if (isset($_GET['action']) && $_GET['page'] == "planeplan_aerodrome" && $_GET['action'] == "add") {
                $this->create();
            }

            /*
             * Gestion du select
             */
            if (!isset($_GET['action']) && $_GET['page'] == "planeplan_aerodrome") {
                $this->read();
            }

            /*
             * Gestion du update
             */
            if (isset($_GET['action']) && $_GET['page'] == "planeplan_aerodrome" && $_GET['action'] == "edit") {
                $this->update();
            }

            /*
            * Gestion du delete
            */
            if (isset($_GET['action']) && $_GET['page'] == "planeplan_aerodrome" && $_GET['action'] == "delete") {
                $this->delete();
            }

            /*
             * Gestion du message
             */
            if (isset($_GET['message']) && $_GET['page'] == "planeplan_aerodrome") {
                switch ($_GET['message']){
                    case "deletesuccess":
                        echo '<div class="notice notice-success"><p>Suppression effectuée</p></div>';
                        break;
                    case "updatesuccess":
                        echo '<div class="notice notice-success"><p>Modification effectuée</p></div>';
                        break;
                    case "addsuccess":
                        echo '<div class="notice notice-success"><p>Ajout effectué</p></div>';
                        break;
                }

            }

        }

        /*
         * Gestion du CRUD
         */
        public function create(){
            $data = isset($_POST['data']) ? $_POST['data'] : false;
            if ($data) {
                $this->processForm($data);
                wp_redirect( 'admin.php?page=planeplan_aerodrome&message=addsuccess' );
            }
            else{
                $this->showForm();
            }
        }

        public function read(){
            /*
             * Gestion du bouton pour l'ajout
             */
            echo '<div class="wrap">';
            echo '<h2><a class="add-new-h2" href="?page=planeplan_aerodrome&action=add">Add</a></h2>';
            echo '</div>';

            global $wpdb;
            $table_name = $this->getTableName();

            $per_page = 10;

            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();

            $this->_column_headers = array($columns, $hidden, $sortable);

            $this->process_bulk_action();

            $req = "SELECT COUNT(id) 
                  FROM $table_name";

            $total_items = $wpdb->get_var($req);

            $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
            $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'name';
            $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

            $requete = "SELECT *
                        FROM $table_name 
                        ORDER BY $orderby $order LIMIT %d OFFSET %d";

            $this->items = $wpdb->get_results($wpdb->prepare($requete, $per_page, $paged), ARRAY_A);

            $this->set_pagination_args(array(
                'total_items' => $total_items,
                'per_page' => $per_page,
                'total_pages' => ceil($total_items / $per_page)
            ));
        }

        public function update(){

            $theid = intval($_GET['aerodrome']);

            $data = isset($_POST['data']) ? $_POST['data'] : false;

            //Traitement des données du formulaire
            if ($data) {
                $this->processForm($data,$theid);

                wp_redirect( 'admin.php?page=planeplan_aerodrome&message=updatesuccess' );
            }
            else {
                global $wpdb;
                $table_name = $this->getTableName();

                //Generation du formulaire
                $sql="SELECT * 
                        FROM $table_name 
                        WHERE id = %d";

                $lesdata = $wpdb->get_row( $wpdb->prepare($sql,$theid),ARRAY_A);

                $this->showForm($lesdata);
            }
        }

        public function delete(){
            global $wpdb;

            $table_name = $this->getTableName();

            $theid = intval($_GET['aerodrome']);

            //... do operation
            $wpdb->delete( $table_name, array( 'id' => $theid ) );

            wp_redirect( 'admin.php?page=planeplan_aerodrome&message=deletesuccess' );
        }

        public function showForm($data=null){

            $vue=WP_PLUGIN_DIR."/planeplan/views/aerodrome/form.php";

            include($vue);
        }

        public  function processForm($data, $id=null){

            global $wpdb;

            //var_dump($data);

            $table=$this->getTableName();

            /*
             * A gauche le nom des colonnes dans la table
             * A droite le nom donné au input type dans le formulaire (voir le fichier dans /views/tablename/form.php
             */
            $datatopush = array('name' => $data["name"],
                                'address' => $data["adresse"],
                                'cp' => $data["cp"],
                                'city' => $data["ville"],
                                'gpslat' => $data["lattitude"],
                                'gpslong' => $data["longitude"],
            );

           /*
            * Gestion du traitement du formulaire pour la modification
            * et pour l'insertion
            */
            if (!is_null($id)){
                $wpdb->update($table,$datatopush,array('id' => $id));
            }
            else {
                $wpdb->insert($table,$datatopush);
                $my_id = $wpdb->insert_id;
            }

        }

    }