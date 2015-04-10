<?php 
/**
* 
*/
class PlanpagosController extends ControllerBase
{
	
	public function indexAction()
	{
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
                ->addJs('/scripts/productos/index.js')
                ->addJs('/media/plugins/bootbox/bootbox.min.js')
        ;

 	}

	public function listAction()
	{
		$model = new Productos();
        $resul = $model->lista();
        $this->view->disable();
        foreach ($resul as $v) {
            $customers[] = array(
                'id' => $v->id,
                'linea_id' => $v->linea_id,
                'linea' => $v->linea,
                'estacion' => $v->estacion,
                'grupo' => $v->grupo,
                'grupo_id' => $v->grupo_id,
                'linea_id' => $v->linea_id,
                'estacion_id' => $v->estacion_id,
                'producto' => $v->producto,
                'codigo' => $v->codigo,
                'descripcion' => $v->descripcion,
                'precio_unitario' => $v->precio_unitario,
                'cantidad' => $v->cantidad,
                'tiempo' => $v->tiempo,
                'foto' => $this->foto($v->carpeta,$v->nombre_archivo)
            );
        }
        echo json_encode($customers);
	}


    public function saveAction()
    {
        if (isset($_POST['id'])) {
            if ($_POST['id']>0) {
                $resul = Productos::findFirstById($this->request->getPost('id'));
                $resul->grupo_id= $this->request->getPost('grupo_id');
                $resul->estacion_id = $this->request->getPost('estacion_id');
                $resul->producto = $this->request->getPost('producto');
                $resul->codigo = $this->request->getPost('codigo');
                $resul->descripcion = $this->request->getPost('descripcion');
                $resul->precio_unitario = $this->request->getPost('precio_unitario');
                $resul->cantidad = $this->request->getPost('cantidad');
                $resul->tiempo = $this->request->getPost('tiempo');
                // $resul->usuario_reg = $this->_user->id;
                // $resul->fecha_reg = date("Y-m-d");
                // $resul->baja_logica = 1;
                if ($resul->save()) {
                    $msm ='Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }
            else{
                $resul = new Productos();
                $resul->grupo_id= $this->request->getPost('grupo_id');
                $resul->estacion_id = $this->request->getPost('estacion_id');
                $resul->producto = $this->request->getPost('producto');
                $resul->codigo = $this->request->getPost('codigo');
                $resul->descripcion = $this->request->getPost('descripcion');
                $resul->precio_unitario = $this->request->getPost('precio_unitario');
                $resul->cantidad = $this->request->getPost('cantidad');
                $resul->tiempo = $this->request->getPost('tiempo');
                $resul->usuario_reg = $this->_user->id;
                $resul->fecha_reg = date("Y-m-d H:i:s");
                $resul->dimension_x = 1;
                $resul->dimension_y = 1;
                $resul->baja_logica = 1;
                if ($resul->save()) {
                    $msm ='Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }   
        }
    $this->view->disable();
    echo $msm;
    }



    public function deleteAction(){
        $resul = Productos::findFirstById($this->request->getPost('id'));
        $resul->baja_logica = 0;
        if ($resul->save()) {
                    $msm ='Exito: Se elimino correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
        $this->view->disable();
        echo $msm;
    }

    

}