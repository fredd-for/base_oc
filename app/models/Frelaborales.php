<?php
/*
*   Oasis - Sistema de Gestión para Recursos Humanos
*   Empresa Estatal de Transporte por Cable "Mi Teleférico"
*   Versión:  1.0.0
*   Usuario Creador: Lic. Javier Loza
*   Fecha Creación:  20-10-2014
*/


use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Frelaborales extends \Phalcon\Mvc\Model {
    public $id_relaboral;
    public $id_persona;
    public $p_nombre;
    public $s_nombre;
    public $t_nombre;
    public $p_apellido;
    public $s_apellido;
    public $c_apellido;
    public $ci;
    public $expd;
    public $num_complemento;
    public $fecha_nac;
    public $edad;
    public $lugar_nac;
    public $genero;
    public $e_civil;
    public $item;
    public $carrera_amd;
    public $num_contrato;
    public $contrato_numerador_estado;
    public $id_solelabcontrato;
    public $solelabcontrato_regional_sigla;
    public $solelabcontrato_numero;
    public $solelabcontrato_gestion;
    public $solelabcontrato_codigo;
    public $solelabcontrato_user_reg_id;
    public $solelabcontrato_fecha_sol;
    public $fecha_ini;
    public $fecha_incor;
    public $fecha_fin;
    public $fecha_baja;
    public $fecha_ren;
    public $fecha_acepta_ren;
    public $fecha_agra_serv;
    public $motivo_baja;
    public $motivosbajas_abreviacion;
    public $descripcion_baja;
    public $descripcion_anu;
    public $id_cargo;
    public $cargo_codigo;
    public $cargo;
    public $id_nivelessalarial;
    public $nivelsalarial;
    public $nivelsalarial_resolucion_id;
    public $numero_escala;
    public $gestion_escala;
    public $sueldo;
    public $id_proceso;
    public $proceso_codigo;
    public $id_convocatoria;
    public $convocatoria_codigo;
    public $convocatoria_tipo;
    public $id_fin_partida;
    public $fin_partida;
    public $id_condicion;
    public $condicion;
    public $categoria_relaboral;
    public $id_da;
    public $direccion_administrativa;
    public $organigrama_regional_id;
    public $organigrama_regional;
    public $id_regional;
    public $regional;
    public $regional_codigo;
    public $id_departamento;
    public $departamento;
    public $id_provincia;
    public $provincia;
    public $id_localidad;
    public $localidad;
    public $residencia;
    public $unidad_ejecutora;
    public $cod_ue;
    public $id_gerencia_administrativa;
    public $gerencia_administrativa;
    public $id_departamento_administrativo;
    public $departamento_administrativo;
    public $id_organigrama;
    public $unidad_administrativa;
    public $organigrama_sigla;
    public $organigrama_codigo;
    public $id_area;
    public $area;
    public $id_ubicacion;
    public $ubicacion;
    public $unidades_superiores;
    public $unidades_dependientes;
    public $partida;
    public $fuente_codigo;
    public $fuente;
    public $organismo_codigo;
    public $organismo;
    public $relaborales_observacion;
    public $relaborales_estado;
    public $relaborales_estado_descripcion;
    public $relaborales_estado_abreviacion;
    public $tiene_contrato_vigente;
    public $id_eventual;
    public $id_consultor;
    public $user_reg_id;
    public $fecha_reg;
    public $user_mod_id;
    public $fecha_mod;
    public $persona_user_reg_id;
    public $persona_fecha_reg;
    public $persona_user_mod_id;
    public $persona_fecha_mod;

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
            'id_relaboral'=>'id_relaboral',
            'id_persona'=>'id_persona',
            'p_nombre'=>'p_nombre',
            's_nombre'=>'s_nombre',
            't_nombre'=>'t_nombre',
            'p_apellido'=>'p_apellido',
            's_apellido'=>'s_apellido',
            'c_apellido'=>'c_apellido',
            'ci'=>'ci',
            'expd'=>'expd',
            'num_complemento'=>'num_complemento',
            'fecha_nac'=>'fecha_nac',
            'edad'=>'edad',
            'lugar_nac'=>'lugar_nac',
            'genero'=>'genero',
            'e_civil'=>'e_civil',
            'item'=>'item',
            'carrera_amd'=>'carrera_amd',
            'num_contrato'=>'num_contrato',
            'contrato_numerador_estado'=>'contrato_numerador_estado',
            'id_solelabcontrato'=>'id_solelabcontrato',
            'solelabcontrato_regional_sigla'=>'solelabcontrato_regional_sigla',
            'solelabcontrato_numero'=>'solelabcontrato_numero',
            'solelabcontrato_gestion'=>'solelabcontrato_gestion',
            'solelabcontrato_codigo'=>'solelabcontrato_codigo',
            'solelabcontrato_user_reg_id'=>'solelabcontrato_user_reg_id',
            'solelabcontrato_fecha_sol'=>'solelabcontrato_fecha_sol',
            'fecha_ini'=>'fecha_ini',
            'fecha_incor'=>'fecha_incor',
            'fecha_fin'=>'fecha_fin',
            'fecha_baja'=>'fecha_baja',
            'fecha_ren'=>'fecha_ren',
            'fecha_acepta_ren'=>'fecha_acepta_ren',
            'fecha_agra_serv'=>'fecha_agra_serv',
            'motivo_baja'=>'motivo_baja',
            'motivosbajas_abreviacion'=>'motivosbajas_abreviacion',
            'descripcion_baja'=>'descripcion_baja',
            'descripcion_anu'=>'descripcion_anu',
            'id_cargo'=>'id_cargo',
            'cargo_codigo'=>'cargo_codigo',
            'cargo'=>'cargo',
            'id_nivelessalarial'=>'id_nivelessalarial',
            'nivelsalarial'=>'nivelsalarial',
            'nivelsalarial_resolucion_id'=>'nivelsalarial_resolucion_id',
            'numero_escala'=>'numero_escala',
            'gestion_escala'=>'gestion_escala',
            'sueldo'=>'sueldo',
            'id_proceso'=>'id_proceso',
            'proceso_codigo'=>'proceso_codigo',
            'id_convocatoria'=>'id_convocatoria',
            'convocatoria_codigo'=>'convocatoria_codigo',
            'convocatoria_tipo'=>'convocatoria_tipo',
            'id_fin_partida'=>'id_fin_partida',
            'fin_partida'=>'fin_partida',
            'id_condicion'=>'id_condicion',
            'condicion'=>'condicion',
            'categoria_relaboral'=>'categoria_relaboral',
            'id_da'=>'id_da',
            'direccion_administrativa'=>'direccion_administrativa',
            'organigrama_regional_id'=>'organigrama_regional_id',
            'organigrama_regional'=>'organigrama_regional',
            'id_regional'=>'id_regional',
            'regional'=>'regional',
            'regional_codigo'=>'regional_codigo',
            'id_departamento'=>'id_departamento',
            'departamento'=>'departamento',
            'id_provincia'=>'id_provincia',
            'provincia'=>'provincia',
            'id_localidad'=>'id_localidad',
            'localidad'=>'localidad',
            'residencia'=>'residencia',
            'unidad_ejecutora'=>'unidad_ejecutora',
            'cod_ue'=>'cod_ue',
            'id_gerencia_administrativa'=>'id_gerencia_administrativa',
            'gerencia_administrativa'=>'gerencia_administrativa',
            'id_departamento_administrativo'=>'id_departamento_administrativo',
            'departamento_administrativo'=>'departamento_administrativo',
            'id_organigrama'=>'id_organigrama',
            'unidad_administrativa'=>'unidad_administrativa',
            'organigrama_sigla'=>'organigrama_sigla',
            'organigrama_codigo'=>'organigrama_codigo',
            'id_area'=>'id_area',
            'area'=>'area',
            'id_ubicacion'=>'id_ubicacion',
            'ubicacion'=>'ubicacion',
            'unidades_superiores'=>'unidades_superiores',
            'unidades_dependientes'=>'unidades_dependientes',
            'partida'=>'partida',
            'fuente_codigo'=>'fuente_codigo',
            'fuente'=>'fuente',
            'organismo_codigo'=>'organismo_codigo',
            'organismo'=>'organismo',
            'observacion'=>'observacion',
            'estado'=>'estado',
            'estado_descripcion'=>'estado_descripcion',
            'estado_abreviacion'=>'estado_abreviacion',
            'tiene_contrato_vigente'=>'tiene_contrato_vigente',
            'id_eventual'=>'id_eventual',
            'id_consultor'=>'id_consultor',
            'user_reg_id'=>'user_reg_id',
            'fecha_reg'=>'fecha_reg',
            'user_mod_id'=>'user_mod_id',
            'fecha_mod'=>'fecha_mod',
            'persona_user_reg_id'=>'persona_user_reg_id',
            'persona_fecha_reg'=>'persona_fecha_reg',
            'persona_user_mod_id'=>'persona_user_mod_id',
            'persona_fecha_mod'=>'persona_fecha_mod',
        );
    }
    private $_db;
    /**
     * Función para la obtención de la totalidad de los registros de relaciones laborales.
     * @return Resultset
     */
    public function getAll()
    {
        $sql = "SELECT * from f_relaborales()";
        $this->_db = new Frelaborales();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }
    /**
     * Función para la obtención de la totalidad de los registros de relaciones laborales para un persona en particular.
     * @return Resultset
     */
    public function getAllByPerson($idPersona,$gestion=0)
    {
        $sql = "SELECT * from f_relaborales() WHERE id_persona=".$idPersona;
        if($gestion>0)$sql.=" AND EXTRACT(YEAR FROM fecha_ini)::int = ".$gestion;
        $sql.=" ORDER BY fecha_ini DESC";
        $this->_db = new Frelaborales();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

    /**
     * Función para la obtención de la totalidad de los registros de relaciones laborales,
     * adicionando el registro de personas que nunca tuvieron una relación laboral con la empresa.
     * @return Resultset
     */
    public function getAllWithPersons()
    {
        $sql = "SELECT * from f_relaborales_y_personas_nuevas()";
        $this->_db = new Frelaborales();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
    }

} 