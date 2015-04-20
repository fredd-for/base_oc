<?php

class BasesController extends ControllerRrhh {

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
        ->addJs('/scripts/bases/index.js')
        ->addJs('/media/plugins/bootbox/bootbox.min.js')
        ;
    }

    public function listAction()
    {   $this->view->disable();
        $resul = Bases::find();
        foreach ($resul as $v) {
            $customers[] = array(
                'id'=>$v->id,
                'codigo'=>$v->codigo,
                'ubicacion'=>$v->ubicacion,
                'sector'=>$v->sector,
                'tipo'=>$v->tipo,
                'tipo1'=>$v->tipo1,
                'fecha'=>$v->fecha,
                'descripcion'=>$v->descripcion,
                'descripcion1'=> $v->descripcion1,
                'fecha_registro'=>$v->fecha_registro,
                'usuario_registro'=>$v->usuario_registro,
                );
        }
        echo json_encode($customers);
        
    }

    public function cargarcsvAction()
    {
        $archivo = $_FILES["archivo"]['name'];
        $tamano = $_FILES["archivo"]['size'];
        $tipo = $_FILES["archivo"]['type'];
        $archivo = $_FILES["archivo"]['name'];
        $prefijo = date("Y_m_d-H_i_s");

        $explode_name = explode('.',$archivo);
        $n = count($explode_name);
        $i = $n-1;
        $msm = "";
        $nro_reg = 0;
        $nro_reg_no = 0;

        if ($archivo != "" && $explode_name[$i] == 'csv') {
            $destino = "files/" . $prefijo . "_" . $archivo;
            if (copy($_FILES['archivo']['tmp_name'], $destino)) {
                $fp = fopen($destino, "r");
                $data = fgetcsv($fp,2048, ",");  //eliminamos la primera linea
                while(($data = fgetcsv($fp,2048, ","))!==false){
                 $msm =$data[0]." ".$data[1]." ".$data[2]." ".$data[3]." ".$data[4]." ".$data[5]." ".$data[6]."<br>";   
                 $resul = new Bases();
                 $resul->codigo= $data[0];
                 $resul->ubicacion = $data[1];
                 $resul->sector = $data[2];
                 $resul->tipo = $data[3];
                 $resul->tipo1 = $data[4];
                 $resul->fecha = date("Y-m-d",strtotime($data[5]));
                 $resul->descripcion = $data[6];
                 $resul->descripcion1 = $msm;
                 $resul->fecha_registro = date("Y-m-d");
                 $resul->usuario_registro = $this->_user->id;
                 $resul->save();
                 //echo $msm;
             }
             fclose($fp);
         }else{
             echo $msm = 'Error: no se subio el archivo';    
         }
     }else{
        echo $msm = 'Error: no es un archivo csv';
    }
}


}
