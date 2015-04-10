<?php
/**
 * Created by PhpStorm.
 * User: JLOZA
 * Date: 14/10/2014
 * Time: 09:08 AM
 */
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Relaborales  extends \Phalcon\Mvc\Model {

    private $_db;
    public function getAll()
    {
        $sql = "SELECT * from f_relaborales()";
        $this->_db = new Relaborales();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    /**
     * Función para obtener el listado de gestiones para una determinada persona
     * @return array
     */
    public function getCol($id_persona){
        $sql = "select distinct gestion from f_listado_gestiones(".$id_persona.")";
        $this->_db = new Gestiones();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }
}