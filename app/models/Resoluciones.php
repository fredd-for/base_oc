<?php

class Resoluciones extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $tipo_resolucion;

    /**
     *
     * @var integer
     */
    public $numero_res;

    /**
     *
     * @var integer
     */
    public $institucion_sector_id;

    /**
     *
     * @var integer
     */
    public $institucion_rectora_id;

    /**
     *
     * @var string
     */
    public $instituciones_otras;

    /**
     *
     * @var integer
     */
    public $gestion_res;

    /**
     *
     * @var string
     */
    public $fecha_emi;

    /**
     *
     * @var string
     */
    public $fecha_apr;

    /**
     *
     * @var string
     */
    public $fecha_fin;

    /**
     *
     * @var integer
     */
    public $estado;

    /**
     *
     * @var integer
     */
    public $baja_logica;

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
            'tipo_resolucion' => 'tipo_resolucion', 
            'numero_res' => 'numero_res', 
            'institucion_sector_id' => 'institucion_sector_id', 
            'institucion_rectora_id' => 'institucion_rectora_id', 
            'instituciones_otras' => 'instituciones_otras', 
            'gestion_res' => 'gestion_res', 
            'fecha_emi' => 'fecha_emi', 
            'fecha_apr' => 'fecha_apr', 
            'fecha_fin' => 'fecha_fin', 
            'estado' => 'estado', 
            'baja_logica' => 'baja_logica'
        );
    }

}
