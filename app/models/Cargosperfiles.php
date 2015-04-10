<?php

class Cargosperfiles extends \Phalcon\Mvc\Model
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
    public $nivelsalarial_id;

    /**
     *
     * @var string
     */
    public $formacion_academica0;

    /**
     *
     * @var string
     */
    public $exp_general_lic0;

    /**
     *
     * @var string
     */
    public $exp_general_tec0;

    /**
     *
     * @var string
     */
    public $exp_profesional_lic0;

    /**
     *
     * @var string
     */
    public $exp_profesional_tec0;

    /**
     *
     * @var string
     */
    public $exp_relacionado_lic0;

    /**
     *
     * @var string
     */
    public $exp_relacionado_tec0;

    /**
     *
     * @var string
     */
    public $formacion_academica;

    /**
     *
     * @var string
     */
    public $exp_general_lic;

    /**
     *
     * @var string
     */
    public $exp_general_tec;

    /**
     *
     * @var string
     */
    public $exp_profesional_lic;

    /**
     *
     * @var string
     */
    public $exp_profesional_tec;

    /**
     *
     * @var string
     */
    public $exp_relacionado_lic;

    /**
     *
     * @var string
     */
    public $exp_relacionado_tec;

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
            'nivelsalarial_id' => 'nivelsalarial_id', 
            'formacion_academica0' => 'formacion_academica0', 
            'exp_general_lic0' => 'exp_general_lic0', 
            'exp_general_tec0' => 'exp_general_tec0', 
            'exp_profesional_lic0' => 'exp_profesional_lic0', 
            'exp_profesional_tec0' => 'exp_profesional_tec0', 
            'exp_relacionado_lic0' => 'exp_relacionado_lic0', 
            'exp_relacionado_tec0' => 'exp_relacionado_tec0', 
            'formacion_academica' => 'formacion_academica', 
            'exp_general_lic' => 'exp_general_lic', 
            'exp_general_tec' => 'exp_general_tec', 
            'exp_profesional_lic' => 'exp_profesional_lic', 
            'exp_profesional_tec' => 'exp_profesional_tec', 
            'exp_relacionado_lic' => 'exp_relacionado_lic', 
            'exp_relacionado_tec' => 'exp_relacionado_tec', 
            'estado' => 'estado', 
            'baja_logica' => 'baja_logica'
        );
    }

}
