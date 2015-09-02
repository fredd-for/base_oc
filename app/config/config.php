<?php

 return new \Phalcon\Config(array(
    'database' => array(
       'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'user_base_oc',
        'password'    => 'pass_base_oc',
        'dbname'      => 'base_oc',
        
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'baseUri'        => '   ',
        // Cargar librería fpdf
        'fpdf'        => __DIR__ . '/../../app/libs/fpdf/',
        'tcpdf'       => __DIR__ . '/../../app/libs/tcpdf/',
        'phpexcel'    => __DIR__ . '/../../app/libs/phpexcel178/',
        'baseUri'     => '',
    )
));