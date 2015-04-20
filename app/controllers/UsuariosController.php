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
            "nivel",
            array(
                "true" => "Habilitado",
                "false"   => "Desabilitado",
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
        $resul = Usuarios::find(array('baja_logica=1','order'=>'paterno ASC'));
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
                'telefono'=>$v->telefono,
                'celular'=>$v->celular,
                'habilitado' =>$v->habilitado
                );
        }
        echo json_encode($customers);
        
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

}
