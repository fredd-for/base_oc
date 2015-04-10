<?php

/**
 * 
 */
class ResolucionesController extends ControllerRrhh {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {
        $this->assets
                ->addCss('/jqwidgets/styles/jqx.base.css')
                ->addCss('/jqwidgets/styles/jqx.custom.css')
                ->addCss('/media/plugins/pines-notify/jquery.pnotify.default.css');
        $this->assets
                ->addJs('/js/jqwidgets/simulator.js')
                ->addJs('/js/jqwidgets/jqxcore.js')
                ->addJs('/js/jqwidgets/jqxdata.js')
                ->addJs('/js/jqwidgets/jqxbuttons.js')
                ->addJs('/js/jqwidgets/jqxscrollbar.js')
                ->addJs('/js/jqwidgets/jqxdatatable.js')
                ->addJs('/js/jqwidgets/jqxlistbox.js')
                ->addJs('/js/jqwidgets/jqxdropdownlist.js')
                ->addJs('/js/jqwidgets/jqxpanel.js')
                ->addJs('/js/jqwidgets/jqxradiobutton.js')
                ->addJs('/js/jqwidgets/jqxinput.js')                                
                ->addJs('/js/jqwidgets/jqxmenu.js')
                ->addJs('/js/jqwidgets/jqxgrid.js')
                ->addJs('/js/jqwidgets/jqxgrid.filter.js')
                ->addJs('/js/jqwidgets/jqxgrid.sort.js')
                ->addJs('/js/jqwidgets/jqxtabs.js')
                ->addJs('/js/jqwidgets/jqxgrid.selection.js')
                ->addJs('/js/jqwidgets/jqxcalendar.js')
                ->addJs('/js/jqwidgets/jqxdatetimeinput.js')
                ->addJs('/js/jqwidgets/jqxcheckbox.js')
                ->addJs('/js/jqwidgets/jqxgrid.grouping.js')
                ->addJs('/js/jqwidgets/jqxgrid.pager.js')
                ->addJs('/js/jqwidgets/jqxnumberinput.js')
                ->addJs('/js/jqwidgets/jqxwindow.js')
                ->addJs('/js/jqwidgets/globalization/globalize.js')
                ->addJs('/js/jqwidgets/jqxcombobox.js')
                ->addJs('/js/jqwidgets/jqxexpander.js')
                ->addJs('/js/jqwidgets/globalization/globalize.js')
                ->addJs('/js/jqwidgets/jqxvalidator.js')
                ->addJs('/js/jqwidgets/jqxmaskedinput.js')
                ->addJs('/js/jqwidgets/jqxchart.js')
                ->addJs('/js/jqwidgets/jqxgrid.columnsresize.js')
                ->addJs('/js/jqwidgets/jqxsplitter.js')
                ->addJs('/js/jqwidgets/jqxtree.js')
                ->addJs('/js/jqwidgets/jqxdata.export.js')
                ->addJs('/js/jqwidgets/jqxgrid.export.js')
                ->addJs('/js/jqwidgets/jqxgrid.edit.js')
                ->addJs('/media/plugins/bootbox/bootbox.min.js')
                ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
                ->addJs('/scripts/resoluciones/index.js')
                ;
    }

    public function listAction() {
        $resul = Resoluciones::find(array('baja_logica=:activo1:', 'bind' => array('activo1' => '1'), 'order' => 'id ASC'));
        $this->view->disable();
        foreach ($resul as $v) {
            $customers[] = array(
                'id' => $v->id,
                'tipo_resolucion' => $v->tipo_resolucion,
                'numero_res' => $v->numero_res,
                'fecha_emi' => $v->fecha_emi,
                'fecha_apr' => $v->fecha_apr,
            );
        }
        echo json_encode($customers);
    }

    public function saveAction() {
        if (isset($_POST['id'])) {

            $fecha_emi = date("Y-m-d", strtotime($_POST['fecha_emi']));
            $fecha_apr = date("Y-m-d", strtotime($_POST['fecha_apr']));

            if ($_POST['id'] > 0) {
                $resul = Resoluciones::findFirstById($_POST['id']);
                $resul->tipo_resolucion = $_POST['tipo_resolucion'];
                $resul->numero_res = $_POST['numero_res'];
                $resul->fecha_emi = $fecha_emi;
                $resul->fecha_apr = $fecha_apr;
                if ($resul->save()) {
                    $msm = array('msm' => 'Exito: Se guardo correctamente');
                } else {
                    $msm = array('msm' => 'Error: No se guardo el registro');
                }
            } else {
                $resul = new Resoluciones();
                $resul->tipo_resolucion = $_POST['tipo_resolucion'];
                $resul->numero_res = $_POST['numero_res'];
                $resul->institucion_sector_id = 1;
                $resul->institucion_rectora_id = 2;
                //$resul->instituciones_otras = "otra";
                $resul->gestion_res = date("Y");
                $resul->fecha_emi = $fecha_emi;
                $resul->fecha_apr = $fecha_apr;
                //$resul->fecha_fin = $fecha_emi;
                $resul->estado = 1;
                $resul->baja_logica = 1;
                if ($resul->save()) {
                    $msm = array('msm' => 'Exito: Se guardo correctamente');
                } else {
                    $msm = array('msm' => 'Error: No se guardo el registro');
                }
            }
        }
        $this->view->disable();
        echo json_encode($msm);
    }

    public function deleteAction() {
        $resul = Resoluciones::findFirstById($_POST['id']);
        $resul->baja_logica = 0;
        $resul->save();
        $this->view->disable();
        echo json_encode();
    }

}

?>