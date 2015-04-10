<?php

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Cargos extends \Phalcon\Mvc\Model {

    private $_db;

    public function lista() {
        $sql = "SELECT c.id,c.organigrama_id,o.unidad_administrativa,c.nivelsalarial_id,e.unidad_ejecutora,c.codigo,c.cargo,n.denominacion,n.sueldo,ca.estado,CASE WHEN c.estado=0  THEN 'ACEFALO'  WHEN c.estado=1  THEN 'ADJUDICADO'  ELSE 'OTRO'  END as estado1,c.fin_partida_id, f.denominacion as fuentefinanciamiento,c.cargo_estado_id
FROM cargos c 
INNER JOIN organigramas o ON c.organigrama_id=o.id
INNER JOIN ejecutoras e ON c.ejecutora_id=e.id
INNER JOIN nivelsalariales n ON c.nivelsalarial_id = n.id 
INNER JOIN cargosestados ca ON c.cargo_estado_id=ca.id
INNER JOIN finpartidas f ON c.fin_partida_id=f.id
WHERE c.baja_logica=1 order by c.id ";
        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    public function listapac() {
        $sql = "SELECT  ROW_NUMBER() OVER(ORDER BY p.fecha_ini asc) AS nro,p.*, c.cargo,c.codigo,n.sueldo,o.unidad_administrativa 
        FROM pacs p
INNER JOIN cargos c ON p.cargo_id=c.id
INNER JOIN organigramas o ON c.organigrama_id=o.id
INNER JOIN nivelsalariales n ON c.nivelsalarial_id=n.id
WHERE p.baja_logica=1 order by p.fecha_ini asc";
        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    public  function getCI($cargo_id = '') {
        $sql = "select p.ci,CONCAT(p.p_nombre,' ',p.p_apellido,' ',p.s_apellido) as nombre from relaborales r,personas p where r.cargo_id='$cargo_id' and r.estado = 1 and r.baja_logica=1 and r.persona_id = p.id";
        $this->_db = new cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

}
