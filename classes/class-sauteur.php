<?php
namespace planeplan {
    class sauteur
    {
        private $_id;
        private $_nom;
        private $_prenom;
        private $_taille;
        private $_poid;

        public static function createtable($tablename, $charset)
        {
            $sql = "CREATE TABLE $tablename (
				id         int not null,
				nom         varchar(50)  not null,
				prenom      varchar(50)  null,
				taille      int null,
				poid        int null,
				primary key(id)
			) $charset;";
            return $sql;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->_id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->_id = $id;
        }

        /**
         * @return mixed
         */
        public function getNom()
        {
            return $this->_nom;
        }

        /**
         * @param mixed $nom
         */
        public function setNom($nom)
        {
            $this->_nom = $nom;
        }

        /**
         * @return mixed
         */
        public function getPrenom()
        {
            return $this->_prenom;
        }

        /**
         * @param mixed $prenom
         */
        public function setPrenom($prenom)
        {
            $this->_prenom = $prenom;
        }

        /**
         * @return mixed
         */
        public function getTaille()
        {
            return $this->_taille;
        }

        /**
         * @param mixed $taille
         */
        public function setTaille($taille)
        {
            $this->_taille = $taille;
        }

        /**
         * @return mixed
         */
        public function getPoid()
        {
            return $this->_poid;
        }

        /**
         * @param mixed $poid
         */
        public function setPoid($poid)
        {
            $this->_poid = $poid;
        }

        public function getImc()
        {
            return $this->_poid / $this->_taille;
        }
    }
}
?>