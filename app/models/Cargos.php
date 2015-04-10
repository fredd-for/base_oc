<?php
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Cargos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $organigrama_id;

    /**
     *
     * @var integer
     */
    public $ejecutora_id;

    /**
     *
     * @var string
     */
    public $codigo;

    /**
     *
     * @var string
     */
    public $cargo;

    /**
     *
     * @var integer
     */
    public $codigo_nivel;

    /**
     *
     * @var integer
     */
    public $cargo_estado_id;

    /**
     *
     * @var integer
     */
    public $baja_logica;

    /**
     *
     * @var integer
     */
    public $user_reg_id;

    /**
     *
     * @var string
     */
    public $fecha_reg;

    /**
     *
     * @var integer
     */
    public $user_mod_id;

    /**
     *
     * @var string
     */
    public $fecha_mod;

    /**
     *
     * @var integer
     */
    public $estado;

    /**
     *
     * @var integer
     */
    public $fin_partida_id;

    /**
     *
     * @var integer
     */
    public $depende_id;

    /**
     *
     * @var string
     */
    public $formacion_requerida;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("");
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'organigrama_id' => 'organigrama_id',
            'ejecutora_id' => 'ejecutora_id',
            'codigo' => 'codigo',
            'cargo' => 'cargo',
            'codigo_nivel' => 'codigo_nivel',
            'cargo_estado_id' => 'cargo_estado_id',
            'baja_logica' => 'baja_logica',
            'user_reg_id' => 'user_reg_id',
            'fecha_reg' => 'fecha_reg',
            'user_mod_id' => 'user_mod_id',
            'fecha_mod' => 'fecha_mod',
            'estado' => 'estado',
            'fin_partida_id' => 'fin_partida_id',
            'depende_id' => 'depende_id',
            'formacion_requerida' => 'formacion_requerida'
        );
    }

    private $_db;

    public function lista($organigrama_id = '', $estado2 = '', $condicion = '')
    {
        $where = '';
        if ($organigrama_id > 0) {
            $where .= ' AND c.organigrama_id=' . $organigrama_id;
        }
        if ($condicion > 0) {
            $where .= ' AND f.condicion_id=' . $condicion;
        }
        if ($estado2 > 0) {
            if ($estado2 == 1) {
                $where .= ' AND r.estado is NOT NULL';
            } else {
                $where .= ' AND r.estado is NULL';
            }
        }

// $sql="SELECT ROW_NUMBER() OVER(order by c.organigrama_id asc, c.codigo_nivel ASC) AS nro,c.id,c.organigrama_id,c.fin_partida_id,o.unidad_administrativa,c.codigo_nivel,
// c.depende_id,c.codigo,c.cargo,n.categoria,n.clase,n.nivel,n.denominacion,n.sueldo,co.condicion,
// CASE WHEN r.estado>0  THEN 'ADJUDICADO' ELSE 'ACEFALO'  END as estado1,CONCAT(p.p_nombre,' ',p.s_nombre,' ',p.p_apellido,' ',p.s_apellido) as nombre, CONCAT(p.ci,' ',p.expd) as ci
// FROM cargos c 
// INNER JOIN organigramas o ON c.organigrama_id=o.id
// INNER JOIN nivelsalariales n ON c.codigo_nivel = n.nivel AND n.activo=1 
// INNER JOIN finpartidas f ON c.fin_partida_id = f.id
// INNER JOIN condiciones co ON f.condicion_id = co.id
// LEFT JOIN relaborales r ON r.cargo_id=c.id AND r.estado>0 AND r.baja_logica=1
// LEFT JOIN personas p ON r.persona_id=p.id
// WHERE c.baja_logica=1 ". $where ." order by c.organigrama_id asc, c.codigo_nivel ASC";
        $sql="SELECT c.id,c.organigrama_id,c.fin_partida_id,o.unidad_administrativa,c.codigo_nivel,
c.depende_id,c.codigo,c.cargo,n.categoria,n.clase,n.nivel,n.denominacion,n.sueldo,co.condicion,
CASE WHEN r.estado>0  THEN 'ADJUDICADO' ELSE 'ACEFALO'  END as estado1,CONCAT(p.p_nombre,' ',p.s_nombre,' ',p.p_apellido,' ',p.s_apellido) as nombre, CONCAT(p.ci,' ',p.expd) as ci,
f.partida,
cp.gestion,cp.programa,cp.proyecto,cp.actividad,
org.codigo as organismo_codigo,org.organismo,
fu.codigo as fuente_codigo,fu.fuente
FROM cargos c 
INNER JOIN organigramas o ON c.organigrama_id=o.id
INNER JOIN nivelsalariales n ON c.codigo_nivel = n.nivel AND n.activo=1 
INNER JOIN finpartidas f ON c.fin_partida_id = f.id
INNER JOIN condiciones co ON f.condicion_id = co.id
LEFT JOIN relaborales r ON r.cargo_id=c.id AND r.estado>0 AND r.baja_logica=1
LEFT JOIN personas p ON r.persona_id=p.id
LEFT JOIN financiamientos fi ON fi.id=f.financiamiento_id
LEFT JOIN categoriasprog cp ON cp.id = fi.categoriaprog_id
LEFT JOIN organismos org ON org.id = fi.organismo_id
LEFT JOIN fuentes fu ON fu.id = fi.fuente_id
WHERE c.baja_logica=1 ". $where ." order by c.organigrama_id asc, c.codigo_nivel ASC ";

        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }


    public function listapac($estado = '', $organigrama_id = '',$fecha_ini='',$fecha_fin='')
    {
        $where = '';
        if ($estado == 1) {
            $where.= " AND se.estado is NULL ";
        }
        if ($organigrama_id>0) {
            $where.= " AND c.organigrama_id =".$organigrama_id;   
        }
        if ($fecha_ini!='' && $fecha_fin!='') {
            $where.= " AND p.fecha_ini BETWEEN '$fecha_ini' AND '$fecha_fin'";   
        }

        $sql = "SELECT  ROW_NUMBER() OVER(ORDER BY p.fecha_ini asc) AS nro,p.*, c.cargo,c.codigo,n.sueldo,o.unidad_administrativa, se.estado as estado1
FROM pacs p
INNER JOIN cargos c ON p.cargo_id=c.id
INNER JOIN organigramas o ON c.organigrama_id=o.id
INNER JOIN nivelsalariales n ON c.codigo_nivel=n.nivel AND n.activo=1
LEFT JOIN seguimientos s ON s.pac_id=p.id AND s.baja_logica=1
LEFT JOIN seguimientosestados se ON s.seguimiento_estado_id=se.id
WHERE p.baja_logica=1 " . $where . " order by p.fecha_ini asc";
        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    public function getEstadoSeguimiento($cargo_id)
    {
        $sql = "SELECT p.*,s.seguimiento_estado_id ,CASE WHEN s.seguimiento_estado_id is NULL  THEN '0' ELSE s.seguimiento_estado_id  END as estado1
        FROM pacs p 
        LEFT JOIN seguimientos s ON p.id=s.pac_id AND s.baja_logica=1
        WHERE p.baja_logica = 1 AND p.cargo_id = '$cargo_id'";
        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    public function getCI($cargo_id = '')
    {
        $sql = "select p.ci,p.p_nombre,p.p_apellido,p.s_apellido from relaborales r,personas p 
        where r.cargo_id='$cargo_id' and r.estado > 0 and r.baja_logica=1 and r.persona_id = p.id";
        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    public function getPersonalOrganigrama($organigrama_id = '')
    {
        $sql = "SELECT r.id,CONCAT(p.p_apellido,' ',p.s_apellido,' ',p.p_nombre,' ',p.s_nombre) as nombre,c.cargo
        FROM relaborales r, personas p, cargos c 
        WHERE r.estado = 1 AND r.baja_logica=1 AND r.organigrama_id = '$organigrama_id' AND r.persona_id=p.id AND r.cargo_id=c.id
        ORDER BY p.p_apellido ASC";
        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    public function listPersonal($organigrama_id = '', $depende_id = 0)
    {
        $where = "";
        if ($organigrama_id > 0) {
            $where = " AND c.organigrama_id='$organigrama_id'";
        }

        $sql = "SELECT c.*, r.estado as estado1
                FROM cargos c
                LEFT JOIN relaborales r ON c.id = r.cargo_id AND r.baja_logica = 1
                WHERE c.baja_logica = 1 AND c.depende_id = '$depende_id' " . $where;
        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    /**
     * Función para listar los nombres de cargos registrados en la tabla de cargos.
     * @author JLM
     * @return Resultset
     */
    public function listNombresCargos()
    {
        $sql = "SELECT DISTINCT cargo FROM cargos ORDER BY cargo";
        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    /**
     * Función para desplegar el registro del cargo del inmediato superior de un cargo identificado mediante el parámetro enviado.
     * @author JLM
     * @return Resultset
     */
    public function getCargoSuperior($id_cargo)
    {
        $sql = "SELECT * FROM f_cargo_inmediato_superior(" . $id_cargo . ")";
        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    /**
     * Función para desplegar el registro del cargo del inmediato superior de acuerdo al identificador del registro de relación laboral enviado como parámetro.
     * @author JLM
     * @return Resultset
     */
    public function getCargoSuperiorPorRelaboral($id_relaboral)
    {
        $sql = "SELECT * FROM f_cargo_inmediato_superior_relaboral(" . $id_relaboral . ")";
        $this->_db = new Cargos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }
}
