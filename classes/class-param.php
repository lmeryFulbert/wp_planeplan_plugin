<?php
namespace planeplan;
class param
{
    public static function LoadParams(){

        $plugin_dir=WP_PLUGIN_DIR."/planeplan";

        $file=$plugin_dir.'/params.json';

        $json=file_get_contents($file);

        $obj = json_decode($json);

        return $obj;
    }

    public static function showForm(){
        $vue=WP_PLUGIN_DIR."/planeplan/views/formparam.php";
        // var_dump($vue);

        $parameters=param::LoadParams();

       // var_dump($parameters);

        include($vue);
    }

    public static function processForm($data){
       // var_dump($data);

        $parameters=param::LoadParams();

        $parameters->nb_rotations=$data["nb_rotations"];
        $parameters->nb_sauteurs_by_rotation=$data["nb_sauteurs_by_rotation"];

        self::saveParams($parameters);

    }

    public static function saveParams($data){
        $plugin_dir=WP_PLUGIN_DIR."/planeplan";

        $file=$plugin_dir.'/params.json';

        $json = json_encode($data);
        $bytes = file_put_contents($file, $json);
    }



}