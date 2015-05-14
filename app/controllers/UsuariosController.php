<?php

class UsuariosController extends ControllerRrhh {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {
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
        ->addJs('/scripts/usuarios/index.js')
        ->addJs('/media/plugins/bootbox/bootbox.min.js')
        ;

        $expedido = $this->tag->selectStatic(
        array(
            "expedido",
            array(
                "LP" => "La Paz",
                "OR"   => "Oruro",
                "PT" => "Potosi",
                "CO" => "Cochabamba",
                "CH" => "Chuquisaca",
                "TA" => "Tarija",
                "PA" => "Pando",
                "BE" => "Beni",
                "SC" => "Santa Cruz",
                ),
            'useEmpty' => false,
            'emptyText' => '(Selecionar)',
            'emptyValue' => '',
            'class' => 'form-control',
            'required' => 'required',
            'title' => 'Campo requerido'
            )
        );
        $this->view->setVar('expedido', $expedido);

        $nivel = $this->tag->selectStatic(
        array(
            "nivel",
            array(
                "1" => "Administrador",
                "2"   => "Consultas",
                ),
            'useEmpty' => true,
            'emptyText' => '(Selecionar)',
            'emptyValue' => '',
            'class' => 'form-control',
            'required' => 'required',
            'title' => 'Campo requerido'
            )
        );
        $this->view->setVar('nivel', $nivel);

         $estado = $this->tag->selectStatic(
        array(
            "habilitado",
            array(
                "1" => "Habilitado",
                "0"   => "Desabilitado",
                ),
            'useEmpty' => false,
            'emptyText' => '(Selecionar)',
            'emptyValue' => '',
            'class' => 'form-control',
            'required' => 'required',
            'title' => 'Campo requerido'
            )
        );
        $this->view->setVar('estado', $estado);

    }

    public function listAction()
    {   $this->view->disable();
        $estado = array('Desabilitado','Habilitado');

        $model = new Usuarios();
        $resul = $model->lista();
        // $resul = Usuarios::find(array('baja_logica=1','order'=>'paterno ASC'));
        foreach ($resul as $v) {
            $customers[] = array(
                'id'=>$v->id,
                'username'=>$v->username,
                'password'=>$v->password,
                'nombre'=>$v->nombre,
                'mosca'=>$v->mosca,
                'cargo'=>$v->cargo,
                'email'=>$v->email,
                'fecha_creacion'=> $v->fecha_creacion,
                'nivel'=>$v->nivel,
                'cedula_identidad'=>$v->cedula_identidad,
                'expedido'=>$v->expedido,
                'paterno'=>$v->paterno,
                'materno'=>$v->materno,
                'nombre_completo'=>$v->paterno.' '.$v->materno.' '.$v->nombre,
                'ci_texto'=>$v->cedula_identidad.' '.$v->expedido,
                'direccion'=>$v->direccion,
                'telefono'=>$v->telefono,
                'celular'=>$v->celular,
                'habilitado_text' =>$estado[$v->habilitado],
                'habilitado' =>$v->habilitado,
                'fecha_inicio' =>$v->fecha_inicio.' 00:00:00',
                'fecha_fin' =>$v->fecha_fin.' 00:00:00',
                'cobro_impresion' =>$v->cobro_impresion,
                'total_cobro' =>$v->total_cobro,
                );
        }
        echo json_encode($customers);
        
    }

    public function saveAction()
    {
        if (isset($_POST['id'])) {
            if ($_POST['id']>0) {
                $resul = Usuarios::findFirstById($this->request->getPost('id'));
                $resul->fecha_inicio = date("Y-m-d",strtotime($this->request->getPost('fecha_inicio')));
                $resul->fecha_fin = date("Y-m-d",strtotime($this->request->getPost('fecha_fin')));
                $resul->cobro_impresion= $this->request->getPost('cobro_impresion');
                $resul->nombre = $this->request->getPost('nombre');
                $resul->cargo = $this->request->getPost('cargo');
                $resul->email = $this->request->getPost('email');
                $resul->habilitado = $this->request->getPost('habilitado');
                $resul->nivel = $this->request->getPost('nivel');
                $resul->cedula_identidad = $this->request->getPost('cedula_identidad');
                $resul->expedido = $this->request->getPost('expedido');
                $resul->direccion = $this->request->getPost('direccion');
                $resul->paterno = $this->request->getPost('paterno');
                $resul->materno = $this->request->getPost('materno');
                $resul->telefono = $this->request->getPost('telefono');
                $resul->celular = $this->request->getPost('celular');
                if ($resul->save()) {
                    $msm ='Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }
            else{
                $resul = new Usuarios();
                $resul->username= $this->request->getPost('username');
                $resul->fecha_inicio = date("Y-m-d",strtotime($this->request->getPost('fecha_inicio')));
                $resul->fecha_fin = date("Y-m-d",strtotime($this->request->getPost('fecha_fin')));
                $resul->cobro_impresion= $this->request->getPost('cobro_impresion');
                $resul->password = hash_hmac('sha256', $this->request->getPost('password'), '2, 4, 6, 7, 9, 15, 20, 23, 25, 30');
                $resul->nombre = $this->request->getPost('nombre');
                $resul->mosca = '';
                $resul->cargo = '';
                $resul->email = $this->request->getPost('email');
                $resul->logins = 0;
                $resul->fecha_creacion = date("Y-m-d H:i:s");
                $resul->habilitado = $this->request->getPost('habilitado');
                $resul->nivel = $this->request->getPost('nivel');
                $resul->genero = 1;
                $resul->prioridad = '';
                $resul->entidad_id = 1;
                $resul->super = 1;
                $resul->cedula_identidad = $this->request->getPost('cedula_identidad');
                $resul->expedido = $this->request->getPost('expedido');
                $resul->theme = '';
                $resul->direccion = $this->request->getPost('direccion');
                $resul->paterno = $this->request->getPost('paterno');
                $resul->materno = $this->request->getPost('materno');
                $resul->last_login = '';
                $resul->telefono = $this->request->getPost('telefono');
                $resul->celular = $this->request->getPost('celular');
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
        $resul = Usuarios::findFirstById($this->request->getPost('id'));
        $resul->baja_logica = 0;
        if ($resul->save()) {
                    $msm ='Exito: Se elimino correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
        $this->view->disable();
        echo $msm;
    }


    public function profileAction() {
        $id=$this->_user->id;
        $mUsuario=new usuarios();
        $user=$mUsuario->profileUsuario($id);        
        $this->view->setVar('user', $user[0]);        

    }

    public function logoutAction() {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
        $this->response->redirect('/login');
    }

    public function listimpresionesAction()
    {
        $html='<div class="table-responsive">';
        $suma = 0;
        if ($_POST['id']>0) {
            $resul=Impresiones::find(array('baja_logica=1 and estado = 1 and usuario_id='.$_POST['id'],'order'=>'fecha_reg ASC'));
            if (count($resul)>0) {
                $html.='<table class="table table-vcenter table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha Impresión</th>
                                        <th>Cobro x Impresion</th>
                                    </tr>
                                </thead>
                                <tbody>';
                foreach ($resul as $v) {
                    $fecha_reg = date("d-m-Y H:i:s",strtotime($v->fecha_reg));
                    // $cobro_impresion = $v->cobro_impresion;
                    $suma+=$v->costo_impresion;
                    $html.='<tr>
                                <td>'.$fecha_reg.'</td>
                                <td class="text-right">'.$v->costo_impresion.' Bs.</td>
                            </tr>';
                }   
                $html.='<tr>
                                <td><strong>TOTAL</strong></td>
                                <td class="text-right">'.$suma.' Bs.</td>
                            </tr></tbody></table>'; 
            }else{
                $html.='<p>No se tiene impresiones</p>';
            }
               
        }
        $html.='</div>';
        $this->view->disable();
        echo $html;
    }

    public function resetimpresionesAction(){
        $model  = new Usuarios();
        $resul = $model->resetimpresiones($this->request->getPost('id'));
        if ($resul) {
                    $msm ='Exito: Se reseteo correctamente';
                }else{
                    $msm = 'Error: No se reseteo el registro';
                }
        $this->view->disable();
        echo $msm;
    }


}
