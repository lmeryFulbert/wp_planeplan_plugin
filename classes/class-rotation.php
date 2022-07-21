<?php
namespace planeplan;
    class rotation
    {
        private $day;
        private $id;
        private $hour;

        public static function createtable($tablename, $charset)
        {
            /*
             * Bug avec if not exist
             * https://developer.wordpress.org/reference/functions/dbdelta/
             */

            $sql = "CREATE TABLE $tablename (
				day         date not null,
				id_rotation int  not null,
				heure_deb   time not null,
				primary key(day,id_rotation)
			) $charset;";
            //echo $sql;
            return $sql;
        }

        public function getday()
        {
            return $this->day;
        }

        public function getid()
        {
            return $this->id;
        }

        public function getjour()
        {
            return $this->hour;
        }
    }
?>