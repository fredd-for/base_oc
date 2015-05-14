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
                'fecha'=>$v->fecha.' 00:00:00',
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
                $data = fgetcsv($fp,2048, ";");  //eliminamos la primera linea
                while(($data = fgetcsv($fp,2048, ";"))!==false){
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

    public function listafiltroAction($fecha_inicio,$fecha_fin,$ubicacion,$sector,$tipo,$caracteristica1,$caracteristica2,$caracteristica3,$caracteristica4,$caracteristica5,$nro_publicaciones)
    {
         //echo "caracteristica1=>".$caracteristica1;
        $where = '';
        $where_or = '';
        if ($fecha_inicio!='') {
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
        if ($tipo!='0') {
            $where.= " AND tipo='$tipo' ";   
        }
        if ($caracteristica1!='0') {
            $where.= " AND descripcion1 LIKE '%".$caracteristica1."%'";
        }
        if ($caracteristica2!='0') {
            $where.= " AND descripcion1 LIKE '%".$caracteristica2."%'";
        }
        if ($caracteristica3!='0') {
            $where.= " AND descripcion1 LIKE '%".$caracteristica3."%'";
        }
        if ($caracteristica4!='0') {
            $where.= " AND descripcion1 LIKE '%".$caracteristica4."%'";
        }
        if ($caracteristica5!='0') {
            $where.= " AND descripcion1 LIKE '%".$caracteristica5."%'";
        }
        if ($nro_publicaciones!='') {
            $where.= " AND v.cantidad <= '$nro_publicaciones'";
        }


        // if ($caracteristica1!='0') {
        //     $where_or.= " OR descripcion LIKE '%".$caracteristica1."%'";
        // }
        // if ($caracteristica2!='0') {
        //     $where_or.= " OR descripcion LIKE '%$caracteristica2%'";
        // }
        // if ($caracteristica3!='0') {
        //     $where_or.= " OR descripcion LIKE '%$caracteristica3%'";
        // }
        // if ($caracteristica4!='0') {
        //     $where_or.= " OR descripcion LIKE '%$caracteristica4%'";
        // }
        // if ($caracteristica5!='0') {
        //     $where_or.= " OR descripcion LIKE '%$caracteristica5%'";
        // }
        // //echo "where or =>".$where_or;
        // if(strlen($where_or)>0){
        //     $where_or = substr($where_or, 4);
        //     $where_or = " AND ( ".$where_or." )";
        // }
        

         $sql= "SELECT v.*, b.* FROM
(SELECT codigo as cod, COUNT(codigo) as cantidad, MIN(fecha) as fecha_min,MAX(fecha) as  fecha_max
FROM bases 
GROUP BY codigo) as v , bases b 
WHERE v.cod = b.codigo ".$where.$where_or."
ORDER BY v.cantidad DESC";
        //echo "where =>".$sql;
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
         // $customers[] = array();
       $this->view->disable();
        foreach ($resul as $v) {
            // echo 'cantidad =>'.$v->cantidad;
            $customers[] = array(
                'id'=>$v->id,
                'cantidad'=>$v->cantidad,
                'fecha_min'=>$v->fecha_min.' 00:00:00',
                'fecha_max'=>$v->fecha_max.' 00:00:00',
                'codigo'=>$v->codigo,
                'ubicacion'=>$v->ubicacion,
                'sector'=>$v->sector,
                'fecha'=>$v->fecha.' 00:00:00',
                'tipo'=>$v->tipo,
                'tipo1'=>$v->tipo1,
                'descripcion'=>$v->descripcion,
                'descripcion1'=> $v->descripcion1,
                'fecha_registro'=>$v->fecha_registro,
                'usuario_registro'=>$v->usuario_registro,
                );
        }
        $data[] = array('TotalRows' => $total_rows,'Rows' => $customers);
        echo json_encode($data);
        

    }


     public function deleteAction(){
        $model = new Bases();

        $fecha_inicio = date("Y-m-d",strtotime($_POST['fecha_inicio']));
        $fecha_fin = date("Y-m-d",strtotime($_POST['fecha_fin']));
        $resul =$model->deletereg($fecha_inicio,$fecha_fin);
        // if ($resul->save()) {
        //             $msm ='Exito: Se elimino correctamente';
        //         }else{
        //             $msm = 'Error: No se guardo el registro';
        //         }
        $msm ='Exito: Se elimino correctamente';
        $this->view->disable();
        echo $msm;
    }


public function exportarAction($fecha_inicio,$fecha_fin,$ubicacion,$sector,$tipo,$caracteristica1,$caracteristica2,$caracteristica3,$caracteristica4,$caracteristica5,$nro_publicaciones)
{

    $where = '';
    if ($fecha_inicio!='') {
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
    if ($tipo!='0') {
        $where.= " AND tipo='$tipo' ";   
    }
    if ($caracteristica1!='0') {
        $where.= " AND descripcion1 LIKE '%".$caracteristica1."%'";
    }
    if ($caracteristica2!='0') {
        $where.= " AND descripcion1 LIKE '%".$caracteristica2."%'";
    }
    if ($caracteristica3!='0') {
        $where.= " AND descripcion1 LIKE '%".$caracteristica3."%'";
    }
    if ($caracteristica4!='0') {
        $where.= " AND descripcion1 LIKE '%".$caracteristica4."%'";
    }
    if ($caracteristica5!='0') {
        $where.= " AND descripcion1 LIKE '%".$caracteristica5."%'";
    }
    $having='';
    if ($nro_publicaciones!='') {
        $where.= "AND (SELECT COUNT(codigo) FROM bases WHERE codigo = b.codigo)<=".$nro_publicaciones;
    }


    $sql = "SELECT ba.* 
            FROM bases ba,(SELECT b.codigo as cod FROM bases b WHERE  1=1 ".$where." GROUP BY b.codigo) as v
            WHERE v.cod = ba.codigo 
            ORDER BY ba.codigo";
    $model = new Bases();
    $resul = $model->serverlista($sql);

$pdf = new fpdf('P','mm','Letter');
     //$pdf = new pdfoasis('L','mm','Letter');
$pdf->pageWidth=80;
$pdf->AddPage();
$pdf->debug=0;
$pdf->title = utf8_decode('Reporte de Plan Anual de Contratacion de Personal');
$pdf->header = utf8_decode('Empresa Estatal de Transporte por Cable "Mi Teleférico"');
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(50, 28);
$pdf->Cell(0,0,"REPORTE");
$pdf->SetXY(10, 35);
$pdf->SetFont('Arial','B',9);
 $pdf->SetFillColor(52, 151, 219);//Fondo verde de celda
 $pdf->SetTextColor(240, 255, 240); //Letra color blanco
 $pdf->Cell(9,7, 'Nro',1, 0 , 'L', true );
 $pdf->Cell(30,7, 'Ubicacion',1, 0 , 'L', true );
 $pdf->Cell(30,7, 'Sector',1, 0 , 'L', true );
 $pdf->Cell(30,7, 'Tipo',1, 0 , 'L', true );
 // $pdf->Cell(30,7, 'Tipo 1',1, 0 , 'L', true );
 $pdf->Cell(20,7, 'Fecha',1, 0 , 'L', true );
 $pdf->Cell(80,7, 'Descripcion',1, 0 , 'L', true );
 $pdf->SetXY(10,42);
 $pdf->SetFont('Arial','',7);
$pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
$pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
$c=1;
$titulo_codigo = '';
foreach ($resul as $v) {
    if($titulo_codigo!=$v->codigo){
        $pdf->Cell(199,7, 'CODIGO : '.$v->codigo,1, 0 , 'L', $bandera );
        $pdf->Ln();//Salto de línea para generar otra fila        
        $titulo_codigo=$v->codigo;
    }

    $bandera = false; //Para alternar el relleno
    if ($c % 2==0) {
        $bandera = true; //Para alternar el relleno        
    }
    $pdf->Cell(9,7, $c,1, 0 , 'L', $bandera );
    $pdf->Cell(30,7, utf8_decode($v->ubicacion),1, 0 , 'L', $bandera );
    $pdf->Cell(30,7, utf8_decode($v->sector),1, 0 , 'L', $bandera );
    $pdf->Cell(30,7, utf8_decode($v->tipo),1, 0 , 'L', $bandera );
    // $pdf->Cell(30,7, $v->tipo1,1, 0 , 'L', $bandera ); 
    $pdf->Cell(20,7, date("d-m-Y", strtotime($v->fecha)),1, 0 , 'L', $bandera );
    $pdf->Cell(80,7, utf8_decode($v->descripcion),1, 0 , 'L', $bandera );
    $pdf->Ln();//Salto de línea para generar otra fila    
    $c++;
}
$pdf->Output();

$resul = new Impresiones();
$resul->usuario_id= $this->_user->id;
$resul->costo_impresion = $this->_user->cobro_impresion;
$resul->fecha_reg = date("Y-m-d H:i:s");
$resul->estado = 1;
$resul->baja_logica = 1;
if($resul->save()){
    $msm = 'Exito, se guardo correctamente';
}

$this->view->disable();
}


}
