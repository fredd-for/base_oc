<?php 
/**
* 
*/
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Bases extends \Phalcon\Mvc\Model
{
	 private $_db;
	public function serverlista($sql)
    {
        $this->_db = new Bases();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    public function ubicacion()
    {
    	$sql='SELECT ubicacion FROM bases GROUP BY ubicacion';
    	$this->_db = new Bases();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    public function sector()
    {
    	$sql='SELECT sector FROM bases GROUP BY sector';
    	$this->_db = new Bases();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    public function fecha_max_min()
    {
    	$sql='SELECT MIN(fecha) as fecha_min,MAX(fecha) as fecha_max FROM bases ';
    	$this->_db = new Bases();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    public function deletereg($fecha_inicio,$fecha_fin)
    {
        $sql="DELETE FROM bases WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
        $this->_db = new Bases();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }
}
