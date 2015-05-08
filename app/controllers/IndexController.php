<?php

class IndexController extends ControllerRrhh {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {
        // $datos = array();
        // if ($this->request->isPost()) {
        //     $datos['fecha_inicio'] = $_POST['fecha_inicio'];
        //     $datos['fecha_fin'] = $_POST['fecha_fin'];
        //     $datos['ubicacion'] = $_POST['ubicacion'];
        //     $datos['sector'] = $_POST['sector'];
        //     $datos['tipo'] = $_POST['tipo'];
        //     $datos['caracteristica1'] = $_POST['caracteristica1'];
        //     $datos['caracteristica2'] = $_POST['caracteristica2'];
        //     $datos['caracteristica3'] = $_POST['caracteristica3'];
        //     $datos['caracteristica4'] = $_POST['caracteristica4'];
        //     $datos['caracteristica5'] = $_POST['caracteristica5'];

        // }
        $this->assets
                ->addCss('/jqwidgets/styles/jqx.base.css')
                ->addCss('/jqwidgets/styles/jqx.custom.css');
        $this->assets
                ->addJs('/jqwidgets/jqxcore.js')
                ->addJs('/jqwidgets/jqxmenu.js')
                ->addJs('/jqwidgets/jqxdropdownlist.js')
                ->addJs('/jqwidgets/jqxlistbox.js')
                ->addJs('/jqwidgets/jqxcheckbox.js')
                ->addJs('/jqwidgets/jqxscrollbar.js')
                ->addJs('/jqwidgets/jqxgrid.js')
                ->addJs('/jqwidgets/jqxdata.js')
                ->addJs('/jqwidgets/jqxgrid.sort.js')
                ->addJs('/jqwidgets/jqxgrid.pager.js')
                ->addJs('/jqwidgets/jqxgrid.filter.js')
                ->addJs('/jqwidgets/jqxgrid.selection.js')
                ->addJs('/jqwidgets/jqxgrid.grouping.js')
                ->addJs('/jqwidgets/jqxgrid.columnsreorder.js')
                ->addJs('/jqwidgets/jqxgrid.columnsresize.js')
                ->addJs('/jqwidgets/jqxdatetimeinput.js')
                ->addJs('/jqwidgets/jqxcalendar.js')
                ->addJs('/jqwidgets/jqxbuttons.js')
                ->addJs('/jqwidgets/jqxdata.export.js')
                ->addJs('/jqwidgets/jqxgrid.export.js')
                ->addJs('/jqwidgets/globalization/globalize.js')
                ->addJs('/jqwidgets/jqxgrid.aggregates.js')
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
        // $this->view->setVar('datos', $datos);

    }



}
