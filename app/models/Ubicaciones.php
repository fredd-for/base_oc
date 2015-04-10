<?php
/**
 * Created by PhpStorm.
 * User: JLOZA
 * Date: 24/10/2014
 * Time: 10:17 AM
 */

class Ubicaciones  extends \Phalcon\Mvc\Model {
    public $id;
    public $ubicacion;
    public $observacion;
    public $estado;
    public $baja_logica;
    public $agrupador;
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
            'ubicacion' => 'ubicacion',
            'observacion' => 'observacion',
            'estado' => 'estado',
            'baja_logica' => 'baja_logica',
            'agrupador'=>'agrupador'
        );
    }
} 