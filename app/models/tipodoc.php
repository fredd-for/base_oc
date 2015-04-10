<?php

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Tipodoc extends \Phalcon\Mvc\Model {

    public static function historico($estacion = 0) {
        if ($estacion == 0) {
            $sql = "SELECT CONCAT(UNIX_TIMESTAMP(DATE_FORMAT(fecha,'%Y-%m-%d H:i:s')),'000') as fecha,SUM(contadorEntradas) "
                    . "as cantidad FROM molineteHistorico GROUP BY fecha";
        } else {
            $sql = "SELECT CONCAT(UNIX_TIMESTAMP(DATE_FORMAT(fecha,'%Y-%m-%d H:i:s')),'000') as fecha,SUM(contadorEntradas) "
                    . "as cantidad FROM molineteHistorico WHERE agencia='$estacion' GROUP BY fecha";
        }
        $molinete = new movimiento();
        return new Resultset(null, $molinete, $molinete->getReadConnection()->query($sql));
    }


}
