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
}
