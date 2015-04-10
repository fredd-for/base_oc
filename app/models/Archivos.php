<?php

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Archivos extends \Phalcon\Mvc\Model {
    /* personal activo de la instatitucion */

    public static function archivosPermitidos($c) {
        $sql = "SELECT t.id,t.tipo_documento,t.codigo,' ' as nombre_archivo,'' as fecha FROM tipodocumento t 
                INNER JOIN tipodoccondicion d 
                ON t.id=d.tipodocumento_id
                where d.condicion_id='$c'
                AND t.baja_logica='1'
                ";
        $db = new Archivos();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }

    public static function listaArchivos($p) {
        $sql = "SELECT id,nombre_archivo,to_char(fecha, 'DD-mm-YYYY') as fecha, tamanio,tipo_documento,tipo_archivo
                FROM archivos WHERE persona_id='$p'
                AND baja_logica='1'
                ";
        $db = new Archivos();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }

}
