<?php
namespace planeplan;
class aerodrome
{
    private $_id;
    private $_name;
    private $_address;
    private $_cp;
    private $_ville;
    private $_gpslat;

    public static function createtable($tablename, $charset)
    {
        $sql = "CREATE TABLE $tablename (
				id         int not null,
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

    /**
     * @return mixed
     */
    public function getGpslat()
    {
        return $this->_gpslat;
    }

    /**
     * @param mixed $gpslat
     */
    public function setGpslat($gpslat)
    {
        $this->gpslat = $gpslat;
    }

    /**
     * @return mixed
     */
    public function getGpslong()
    {
        return $this->gpslong;
    }

    /**
     * @param mixed $gpslong
     */
    public function setGpslong($gpslong)
    {
        $this->gpslong = $gpslong;
    }



    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->_address = $address;
    }
    private $gpslong;



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
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->_adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->_adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getCp()
    {
        return $this->_cp;
    }

    /**
     * @param mixed $cp
     */
    public function setCp($cp)
    {
        $this->_cp = $cp;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->_ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->_ville = $ville;
    }

    /**
     * @return mixed
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * @param mixed $gps
     */
    public function setGps($gps)
    {
        $this->gps = $gps;
    }


}