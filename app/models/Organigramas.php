<?php
/*
*   Sarha - Sistema de Gestión para Recursos Humanos
*   Empresa Estatal de Transporte por Cable "Mi Teleférico"
*   Versión:  1.0.0
*   Usuario Creador: Ing. Freddy Velasco
*   Fecha Creación:  13-10-2014
*/
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Organigramas extends \Phalcon\Mvc\Model
{

    private $_db;
    public function lista() {
        $sql = "SELECT o.id,o.padre_id,org.unidad_administrativa as padre,d.direccion_administrativa,o.unidad_administrativa,o.nivel_estructural_id,o.da_id,n.nivel_estructural,o.sigla 
        FROM organigramas o, das d, nivelestructurales n, organigramas org
        WHERE o.da_id=d.id AND o.nivel_estructural_id=n.id AND o.baja_logica=1 AND o.padre_id=org.id ORDER BY o.padre_id ASC";
        $this->_db = new Seguimientos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    /**
     * Función para la obtención del listado de áreas administrativas de acuerdo al parámetro enviado.
     * @param $idPadre Identificador del organigrama del cual se desea conocer las áreas dependientes.
     * @return Resultset Listado de organigramas con nivel estructural de area.
     */
    public function getAreas($idPadre=0)
    {
        $sql = "SELECT * from f_areas(".$idPadre.")";
        $this->_db = new Organigramas();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

}
