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
    {   
        $sql= "SELECT * FROM bases Order BY fecha asc ";

        $pagenum = $_GET['pagenum'];
        $pagesize = $_GET['pagesize'];
        $start = $pagenum * $pagesize;
        $query = "SELECT * FROM (".$sql.") as v ";

        if (isset($_GET['filterscount']))
        {
            $filterscount = $_GET['filterscount'];
            if ($filterscount > 0)
            {
                $where = " WHERE (";
                $tmpdatafield = "";
                $tmpfilteroperator = "";

                for ($i=0; $i < $filterscount; $i++)
                {
                // get the filter's value.
                    $filtervalue = $_GET["filtervalue" . $i];
                // get the filter's condition.
                    $filtercondition = $_GET["filtercondition" . $i];
                // get the filter's column.
                    $filterdatafield = $_GET["filterdatafield" . $i];
                // get the filter's operator.
                    $filteroperator = $_GET["filteroperator" . $i];

                    if ($tmpdatafield == ""){
                        $tmpdatafield = $filterdatafield;
                    }else if($tmpdatafield <> $filterdatafield){ 
                        $where .= ")AND(";
                    }else if ($tmpdatafield == $filterdatafield){
                        if ($tmpfilteroperator == 0){ 
                            $where .= " AND ";
                        }else { 
                            $where .= " OR ";
                        }                   
                    }
                    switch($filtercondition){
                        case "CONTAINS":$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
                        break;
                        case "DOES_NOT_CONTAIN":$where .= " " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
                        break;
                        case "EQUAL": $where .= " " . $filterdatafield . " = '" . $filtervalue ."'";
                        break; 
                        case "NOT_EQUAL":$where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";
                        break;
                        case "GREATER_THAN": $where .= " " . $filterdatafield . " > '" . $filtervalue ."'";
                        break; 
                        case "LESS_THAN": $where .= " " . $filterdatafield . " < '" . $filtervalue ."'";
                        break;
                        case "GREATER_THAN_OR_EQUAL":$where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";
                        break;
                        case "LESS_THAN_OR_EQUAL": $where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";
                        break;
                        case "STARTS_WITH": $where .= " " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
                        break;
                        case "ENDS_WITH": $where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
                        break;
                    }
                    if ($i == $filterscount - 1){
                        $where .= ")";
                        }
                    $tmpfilteroperator = $filteroperator;
                    $tmpdatafield = $filterdatafield;
                    }

                    $query = $query . $where;
                }
            }

        /*
        ordenamos
         */ 
        if (isset($_GET['sortdatafield']))
        {
            $sortfield = $_GET['sortdatafield'];
            $sortorder = $_GET['sortorder'];
            if ($sortfield != NULL)
            {
                $query = $query." ORDER BY" . " " . $sortfield . " ".$sortorder;
            }
            
        }
        
        $model = new Bases();
        $resul = $model->serverlista($query);
        $total_rows = count($resul);

        $query=$query." LIMIT $start, $pagesize ";
        $model = new Bases();
        $resul = $model->serverlista($query);

       $this->view->disable();
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
        $data[] = array('TotalRows' => $total_rows,'Rows' => $customers);
        echo json_encode($data);
        
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
