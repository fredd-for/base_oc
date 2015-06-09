<?php

class IndexController extends ControllerRrhh {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {
        $datos = array();
        $resultado = array();
        $nro_avisos = array();
        if ($this->request->isPost()) {
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $ubicacion = $_POST['ubicacion'];
            $sector = $_POST['sector'];
            $tipo = $_POST['tipo'];
            $tipo1 = $_POST['tipo1'];
            $caracteristica1 = $_POST['caracteristica1'];
            $caracteristica2 = $_POST['caracteristica2'];
            $caracteristica3 = $_POST['caracteristica3'];
            $caracteristica4 = $_POST['caracteristica4'];
            $caracteristica5 = $_POST['caracteristica5'];
            $nro_publicaciones = $_POST['nro_publicaciones'];


            $datos['fecha_inicio'] = $_POST['fecha_inicio'];
            $datos['fecha_fin'] = $_POST['fecha_fin'];
            $datos['ubicacion'] = $_POST['ubicacion'];
            $datos['sector'] = $_POST['sector'];
            $datos['tipo'] = $_POST['tipo'];
            $datos['tipo1'] = $_POST['tipo1'];
            $datos['caracteristica1'] = $_POST['caracteristica1'];
            $datos['caracteristica2'] = $_POST['caracteristica2'];
            $datos['caracteristica3'] = $_POST['caracteristica3'];
            $datos['caracteristica4'] = $_POST['caracteristica4'];
            $datos['caracteristica5'] = $_POST['caracteristica5'];
            $datos['nro_publicaciones'] = $_POST['nro_publicaciones'];




            $where = '';
            $where_or = '';
            if ($_POST['fecha_inicio']!='') {
                $fecha_inicio = date("Y-m-d",strtotime($fecha_inicio));
                $fecha_fin = date("Y-m-d",strtotime($fecha_fin));
                $where.= " AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' ";
            }
            if ($ubicacion!='0') {
                $where.= " AND ubicacion='$ubicacion' ";   
            }
            if ($sector!='0') {
                $where.= " AND sector='$sector' ";   
            }
            if ($tipo!='') {
                $where.= " AND tipo='$tipo' ";   
            }
            if ($caracteristica1!='') {
                $where.= " AND descripcion1 LIKE '%".$caracteristica1."%'";
            }
            if ($caracteristica2!='') {
                $where.= " AND descripcion1 LIKE '%".$caracteristica2."%'";
            }
            if ($caracteristica3!='') {
                $where.= " AND descripcion1 LIKE '%".$caracteristica3."%'";
            }
            if ($caracteristica4!='') {
                $where.= " AND descripcion1 LIKE '%".$caracteristica4."%'";
            }
            if ($caracteristica5!='') {
                $where.= " AND descripcion1 LIKE '%".$caracteristica5."%'";
            }
            if ($nro_publicaciones!='') {
                $where.= " AND v.cantidad <= '$nro_publicaciones'";
            }


           $query= "SELECT v.*, b.* FROM
 (SELECT codigo as cod, COUNT(codigo) as cantidad, MIN(fecha) as fecha_min,MAX(fecha) as  fecha_max 
FROM bases 
GROUP BY codigo) as v , bases b 
WHERE v.cod = b.codigo ".$where.$where_or."
 ORDER BY v.cantidad DESC LIMIT 5";
 
$this->view->setVar('sql', $query);

$model = new Bases();
$resultado = $model->serverlista($query);


$query = "SELECT count(b.codigo) as cantidad FROM
 (SELECT codigo as cod, COUNT(codigo) as cantidad 
FROM bases 
GROUP BY codigo) as v , bases b 
WHERE v.cod = b.codigo ".$where.$where_or."
 ORDER BY v.cantidad DESC";
 $model = new Bases();
$nro_avisos = $model->serverlista($query);

}


// $this->assets
// ->addCss('/jqwidgets/styles/jqx.base.css')
// ->addCss('/jqwidgets/styles/jqx.custom.css');
$this->assets
// ->addJs('/jqwidgets/jqxcore.js')
// ->addJs('/jqwidgets/jqxmenu.js')
// ->addJs('/jqwidgets/jqxdropdownlist.js')
// ->addJs('/jqwidgets/jqxlistbox.js')
// ->addJs('/jqwidgets/jqxcheckbox.js')
// ->addJs('/jqwidgets/jqxscrollbar.js')
// ->addJs('/jqwidgets/jqxgrid.js')
// ->addJs('/jqwidgets/jqxdata.js')
// ->addJs('/jqwidgets/jqxgrid.sort.js')
// ->addJs('/jqwidgets/jqxgrid.pager.js')
// ->addJs('/jqwidgets/jqxgrid.filter.js')
// ->addJs('/jqwidgets/jqxgrid.selection.js')
// ->addJs('/jqwidgets/jqxgrid.grouping.js')
// ->addJs('/jqwidgets/jqxgrid.columnsreorder.js')
// ->addJs('/jqwidgets/jqxgrid.columnsresize.js')
// ->addJs('/jqwidgets/jqxdatetimeinput.js')
// ->addJs('/jqwidgets/jqxcalendar.js')
// ->addJs('/jqwidgets/jqxbuttons.js')
// ->addJs('/jqwidgets/jqxdata.export.js')
// ->addJs('/jqwidgets/jqxgrid.export.js')
// ->addJs('/jqwidgets/globalization/globalize.js')
// ->addJs('/jqwidgets/jqxgrid.aggregates.js')
->addJs('/scripts/index.js')
->addJs('/media/plugins/bootbox/bootbox.min.js')
;
$model = new Bases();
$ubicacion = $model->ubicacion();
$sector = $model->sector();
$fecha_max_min = $model->fecha_max_min();

$this->view->setVar('fecha_max_min', $fecha_max_min);
$this->view->setVar('ubicacion', $ubicacion);
$this->view->setVar('sector', $sector);
$this->view->setVar('usuario', $this->_user);
$this->view->setVar('datos', $datos);
$this->view->setVar('resultado', $resultado);
$this->view->setVar('nro_avisos', $nro_avisos[0]);

}



}
