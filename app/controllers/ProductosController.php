<?php 
/**
* 
*/
class ProductosController extends ControllerBase
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

        $linea = $this->tag->select(
                array(
                    'linea_id',
                    Lineas::find(array('baja_logica=1', 'order' => 'id ASC')),
                    'using' => array('id', "linea"),
                    'useEmpty' => true,
                    'emptyText' => '(Selecionar)',
                    'emptyValue' => '',
                    'class' => 'form-control',
                    'required' => 'required',
                    'title' => 'Campo requerido'
                )
        );

        $this->view->setVar('linea', $linea);

        $grupo = $this->tag->select(
                array(
                    'grupo_id',
                    Grupos::find(array('baja_logica=1', 'order' => 'id ASC')),
                    'using' => array('id', "grupo"),
                    'useEmpty' => true,
                    'emptyText' => '(Selecionar)',
                    'emptyValue' => '',
                    'class' => 'form-control',
                    'required' => 'required',
                    'title' => 'Campo requerido'
                )
        );
        $this->view->setVar('grupo', $grupo);

        $tiempo = $this->tag->selectStatic(
        array(
            "tiempo",
            array(
                "Hora" => "Hora",
                "Dia"   => "Dia",
                "Semanal" => "Semanal",
                "Mensual" => "Mensual",
                "Anual" => "Anual",
                ),
            'useEmpty' => true,
            'emptyText' => '(Selecionar)',
            'emptyValue' => '',
            'class' => 'form-control',
            'required' => 'required',
            'title' => 'Campo requerido'
            )
        );
        $this->view->setVar('tiempo', $tiempo);

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

    public function foto($carpeta, $archivo) {
        $file = "/file/productos/images.png";
        if (file_exists($carpeta . $archivo)) {
            $file = "/".$carpeta . $archivo;
        } 
        return $file;
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



    public function select_estacionesAction()
    {
        $resul = Estaciones::find(array('baja_logica = 1 and linea_id='.$_POST['linea_id'] , 'order' => 'id ASC' ));
        $this->view->disable();
        $options = '<option value="">(Seleccionar)</option>';
        foreach ($resul as $v) {
            $options.='<option value="'.$v->id.'" >'.$v->estacion.'</option>';
        }
        echo $options; 
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

    public function galeriaAction($producto_id)
    {
        if ($this->request->hasFiles() == true) {
                foreach ($this->request->getUploadedFiles() as $file) {
                //Move the file into the application
                $carpeta = "file/productos/";
                    $path = $carpeta.date("Ymd_his").$file->getName();
                    if($file->moveTo($path)) {
                        $resul3 = new Archivos();
                        $resul3->producto_id = $producto_id;
                        $resul3->tipo_archivo = $file->getType();
                        $resul3->nombre_archivo = date("Ymd_his").$file->getName();
                        $resul3->carpeta = $carpeta;
                        $resul3->tamanio = $file->getSize();
                        $resul3->usuario_reg = $this->_user->id;
                        $resul3->fecha_reg = date("Y-m-d h:i:s");
                        $resul3->estado = 1;
                        $resul3->baja_logica = 1;
                        
                        if ($resul3->save()) {
                            $this->flashSession->success("Exito: Registro guardado correctamente...");    
                        }else{
                            $this->flashSession->error("Error: no se a guardado el registro...");    
                        }
                    } else {
                        die("Acurrio algun error.");    
                    } 
                }
            }

            

        // $model = new Productos();
        // $resul = $model->getProducto($producto_id);
        // $producto_id = 0;
        // foreach ($resul as $v) {
        //     $producto_id = $v->id;
        // }
        $this->view->setVar('producto_id', $producto_id);


    }

}