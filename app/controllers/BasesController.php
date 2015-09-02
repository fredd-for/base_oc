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
                 $resul->ubicacion = utf8_encode($data[1]);
                 $resul->sector = utf8_encode($data[2]);
                 $resul->tipo = utf8_encode($data[3]);
                 $resul->tipo1 = utf8_encode($data[4]);
                 $resul->fecha = date("Y-m-d",strtotime($data[5]));
                 $resul->descripcion = utf8_encode($data[6]);
                 $resul->descripcion1 = utf8_encode($msm);
                 $resul->fecha_registro = date("Y-m-d");
                 $resul->usuario_registro = $this->_user->id;
                 $resul->save();
                 //echo $msm;
             }
             fclose($fp);
            $model = new Bases();
            $resul =$model->delete_base_agrupados();
            $model = new Bases();
            $resul2 = $model->insert_base_agrupados();

         }else{
             echo $msm = 'Error: no se subio el archivo';    
         }
     }else{
        echo $msm = 'Error: no es un archivo csv';
    }
    $this->response->redirect('/bases');
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




public function pdfsinhAction()
{
   require_once('tcpdf/examples/tcpdf_include.php');

   if ($this->request->isPost()) {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $ubicacion = $_POST['ubicacion'];
    $sector = $_POST['sector'];
    $tipo = $_POST['tipo'];
    //$tipo1 = $_POST['tipo1'];
    $caracteristica1 = $_POST['caracteristica1'];
    $caracteristica2 = $_POST['caracteristica2'];
    $caracteristica3 = $_POST['caracteristica3'];
    $caracteristica4 = $_POST['caracteristica4'];
    $caracteristica5 = $_POST['caracteristica5'];
    $nro_publicaciones = $_POST['nro_publicaciones'];


   
}

$where = '';
$where_or = '';
$filtrado = '';

if ($_POST['fecha_inicio']!='') {
    $fecha_inicio = date("Y-m-d",strtotime($fecha_inicio));
    $fecha_fin = date("Y-m-d",strtotime($fecha_fin));
    $where.= " AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' ";
}
if ($ubicacion!='0') {
    $where.= " AND ubicacion='$ubicacion' ";  
    $filtrado .= $ubicacion.' * '; 
}
if ($sector!='0') {
    $where.= " AND sector='$sector' ";   
    $filtrado .= $sector.' * ';
}
if ($tipo!='') {
    $where.= " AND tipo='$tipo' ";   
    $filtrado .= $tipo.' * ';
}
if ($caracteristica1!='') {
    $where.= " AND descripcion1 LIKE '%".$caracteristica1."%'";
    $filtrado .= $caracteristica1.' * ';
}
if ($caracteristica2!='') {
    $where.= " AND descripcion1 LIKE '%".$caracteristica2."%'";
    $filtrado .= $caracteristica2.' * ';
}
if ($caracteristica3!='') {
    $where.= " AND descripcion1 LIKE '%".$caracteristica3."%'";
    $filtrado .= $caracteristica3.' * ';
}
if ($caracteristica4!='') {
    $where.= " AND descripcion1 LIKE '%".$caracteristica4."%'";
    $filtrado .= $caracteristica4.' * ';
}
if ($caracteristica5!='') {
    $where.= " AND descripcion1 LIKE '%".$caracteristica5."%'";
    $filtrado .= $caracteristica5.' * ';
}
if ($nro_publicaciones!='') {
    $where.= " AND v.cantidad <= '$nro_publicaciones'";
}



$query= "SELECT v.*, b.* FROM
(SELECT codigo as cod, COUNT(codigo) as cantidad, MIN(fecha) as fecha_min,MAX(fecha) as  fecha_max 
    FROM bases 
    GROUP BY codigo) as v , bases b 
WHERE v.cod = b.codigo ".$where.$where_or."
ORDER BY v.cod DESC ";
$model = new Bases();
$resultado = $model->serverlista($query);


    
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Luis Freddy Velasco');
$pdf->SetTitle('Reporte');
$pdf->SetSubject('Reporte');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('../../../assets/img/logo.png', PDF_HEADER_LOGO_WIDTH, 'SISTEMA OSVALDO CARLO', 'Contactos - ocarlo777@gmail.com', array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);


// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.


// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

$pdf->SetFont('times', 'B', 9);
$pdf->Cell(100, 6, 'Filtrado numero de repeticiones menores a : '.$nro_publicaciones, 0, 0, 'L', 0, '', 0);
$pdf->Cell(50, 6, 'De: '. $_POST['fecha_inicio'] .' a '. $_POST['fecha_fin'] , 0, 0, 'L', 0, '', 0);
$pdf->Ln();       
$pdf->Cell(50, 6, 'Filtrado por : '.$filtrado  , 0, 1, 'L', 0, '', 0);

$pdf->SetFont('helvetica', '', 9, '', true);
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
$fill = 1;

$pdf->Cell(10, 6, 'NRO', 1, 0, 'C', $fill);
// $pdf->Cell(30, 6, 'CODIGO', 1, 0, 'C', $fill);
$pdf->Cell(30, 6, 'SECTOR', 1, 0, 'C', $fill);
$pdf->Cell(30, 6, 'FECHA', 1, 0, 'C', $fill);
$pdf->Cell(120, 6, 'DESCRIPCION', 1, 0, 'C', $fill);
$pdf->Ln();
$sum = 2;
$sw =0;
$i=1;
$titulo_codigo = '';

foreach ($resultado as $v) {



    if($titulo_codigo!=$v->codigo){
        $pdf->Cell(190,5, 'CODIGO : '.$v->codigo . ' >> Nro PUBLICACIONES: '.$v->cantidad . ' >> FECHA MIN. PUB.: '.date("d-m-Y",strtotime($v->fecha_min)) . ' >> FECHA MAX. PUB.: '.date("d-m-Y",strtotime($v->fecha_max)),1, 0 , 'L', 1 );
        $pdf->Ln();//Salto de línea para generar otra fila        
        $titulo_codigo=$v->codigo;
        $i=1;
        $sum +=1;
    }

    $maxnocells = 0;
    $cellcount = 0;
    //write text first
    $startX = $pdf->GetX();
    $startY = $pdf->GetY();
    //draw cells and record maximum cellcount
    //cell height is 6 and width is 80
    $cellcount = $pdf->MultiCell(10,6,$i,0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    // $cellcount = $pdf->MultiCell(30,6,$v->codigo,0,'L',0,0);
    // if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $cellcount = $pdf->MultiCell(30,6,$v->sector,0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $cellcount = $pdf->MultiCell(30,6,date("d-m-Y",strtotime($v->fecha)),0,'C',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $cellcount = $pdf->MultiCell(120,6,$v->descripcion,0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $pdf->SetXY($startX,$startY);
    
    //now do borders and fill
    //cell height is 6 times the max number of cells
    $pdf->MultiCell(10,$maxnocells * 5,'','LB','L',0,0);
    // $pdf->MultiCell(30,$maxnocells * 5,'','LB','L',$sw,0);
    $pdf->MultiCell(30,$maxnocells * 5,'','LB','L',0,0);
    $pdf->MultiCell(30,$maxnocells * 5,'','LB','L',0,0);
    $pdf->MultiCell(120,$maxnocells * 5,'','LRB','L',0,0);
    $pdf->Ln();
    $sw=!$sw;
    $sum +=$maxnocells;
    if ($sum > 42) {
        $pdf->AddPage();
        $sum=0;
    }
    $i++;
}


// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('reporte_sin_historial.pdf', 'I');
$this->view->disable();


$resul = new Impresiones();
$resul->usuario_id= $this->_user->id;
$resul->costo_impresion = $this->_user->cobro_impresion;
$resul->fecha_reg = date("Y-m-d H:i:s");
$resul->estado = 1;
$resul->baja_logica = 1;
if($resul->save()){
    $msm = 'Exito, se guardo correctamente';
}

}



public function pdfconhAction()
{
     require_once('tcpdf/examples/tcpdf_include.php');

     if ($this->request->isPost()) {
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $ubicacion = $_POST['ubicacion'];
            $sector = $_POST['sector'];
            $tipo = $_POST['tipo'];
            //$tipo1 = $_POST['tipo1'];
            $caracteristica1 = $_POST['caracteristica1'];
            $caracteristica2 = $_POST['caracteristica2'];
            $caracteristica3 = $_POST['caracteristica3'];
            $caracteristica4 = $_POST['caracteristica4'];
            $caracteristica5 = $_POST['caracteristica5'];
            $nro_publicaciones = $_POST['nro_publicaciones'];


        }



$filtrado = '';
$where = '';
    if ($fecha_inicio!='') {
        $fecha_inicio = date("Y-m-d",strtotime($fecha_inicio));
        $fecha_fin = date("Y-m-d",strtotime($fecha_fin));
        $where.= " AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' ";
    }
    if ($ubicacion!='0') {
        $where.= " AND ubicacion='$ubicacion' "; 
        $filtrado .= $ubicacion.' * ';  
    }
    if ($sector!='0') {
        $where.= " AND sector='$sector' ";   
        $filtrado .= $sector.' * ';
    }
    if ($tipo!='') {
        $where.= " AND tipo='$tipo' ";   
    }
    if ($caracteristica1!='') {
        $where.= " AND descripcion1 LIKE '%".$caracteristica1."%'";
        $filtrado .= $caracteristica1.' * ';
    }
    if ($caracteristica2!='') {
        $where.= " AND descripcion1 LIKE '%".$caracteristica2."%'";
        $filtrado .= $caracteristica2.' * ';
    }
    if ($caracteristica3!='') {
        $where.= " AND descripcion1 LIKE '%".$caracteristica3."%'";
        $filtrado .= $caracteristica3.' * ';
    }
    if ($caracteristica4!='') {
        $where.= " AND descripcion1 LIKE '%".$caracteristica4."%'";
        $filtrado .= $caracteristica4.' * ';
    }
    if ($caracteristica5!='') {
        $where.= " AND descripcion1 LIKE '%".$caracteristica5."%'";
        $filtrado .= $caracteristica5.' * ';
    }
    if ($nro_publicaciones!='') {
        $where.= "AND (SELECT COUNT(codigo) FROM bases WHERE codigo = b.codigo)<=".$nro_publicaciones;
    }


    $sql = "SELECT ba.* 
            FROM bases ba,(SELECT b.codigo as cod FROM bases b WHERE  1=1 ".$where." GROUP BY b.codigo) as v
            WHERE v.cod = ba.codigo 
            ORDER BY ba.codigo";
    $model = new Bases();
    $resultado = $model->serverlista($sql);



$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Luis Freddy Velasco');
        $pdf->SetTitle('Reporte');
        $pdf->SetSubject('Reporte');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
        $pdf->SetHeaderData('../../../assets/img/logo.png', PDF_HEADER_LOGO_WIDTH, 'SISTEMA OSVALDO CARLO', 'Contactos - ocarlo777@gmail.com', array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------

// set default font subsetting mode
        $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
        

// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();
$pdf->SetFont('times', 'B', 9);
$pdf->Cell(100, 6, 'Filtrado numero de repeticiones menores a : '.$nro_publicaciones, 0, 0, 'L', 0, '', 0);
$pdf->Cell(50, 6, 'De: '. $_POST['fecha_inicio'] .' a '. $_POST['fecha_fin'] , 0, 0, 'L', 0, '', 0);
$pdf->Ln();       
$pdf->Cell(50, 6, 'Filtrado por : '.$filtrado  , 0, 1, 'L', 0, '', 0);

$pdf->SetFont('helvetica', '', 9, '', true);

$pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $fill = 1;

$pdf->Cell(10, 6, 'NRO', 1, 0, 'C', $fill);
// $pdf->Cell(30, 6, 'CODIGO', 1, 0, 'C', $fill);
$pdf->Cell(30, 6, 'SECTOR', 1, 0, 'C', $fill);
$pdf->Cell(30, 6, 'FECHA', 1, 0, 'C', $fill);
$pdf->Cell(120, 6, 'DESCRIPCION', 1, 0, 'C', $fill);
$pdf->Ln();
$sum = 2;
$sw =0;
$i=1;
 $titulo_codigo = '';

foreach ($resultado as $v) {

     

    if($titulo_codigo!=$v->codigo){
        $pdf->Cell(190,5, 'CODIGO : '.$v->codigo,1, 0 , 'L', $sw );
        $pdf->Ln();//Salto de línea para generar otra fila        
        $titulo_codigo=$v->codigo;
        $i=1;
        $sum +=1;
    }

    $maxnocells = 0;
    $cellcount = 0;
    //write text first
    $startX = $pdf->GetX();
    $startY = $pdf->GetY();
    //draw cells and record maximum cellcount
    //cell height is 6 and width is 80
    $cellcount = $pdf->MultiCell(10,6,$i,0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    // $cellcount = $pdf->MultiCell(30,6,$v->codigo,0,'L',0,0);
    // if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $cellcount = $pdf->MultiCell(30,6,$v->sector,0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $cellcount = $pdf->MultiCell(30,6,date("d-m-Y",strtotime($v->fecha)),0,'C',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $cellcount = $pdf->MultiCell(120,6,$v->descripcion,0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $pdf->SetXY($startX,$startY);
    
    //now do borders and fill
    //cell height is 6 times the max number of cells
    $pdf->MultiCell(10,$maxnocells * 5,'','LB','L',$sw,0);
    // $pdf->MultiCell(30,$maxnocells * 5,'','LB','L',$sw,0);
    $pdf->MultiCell(30,$maxnocells * 5,'','LB','L',$sw,0);
    $pdf->MultiCell(30,$maxnocells * 5,'','LB','L',$sw,0);
    $pdf->MultiCell(120,$maxnocells * 5,'','LRB','L',$sw,0);
    $pdf->Ln();
    $sw=!$sw;
    $sum +=$maxnocells;
    if ($sum > 42) {
        $pdf->AddPage();
        $sum=0;
    }
    $i++;
}


// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('reporte_con_historial.pdf', 'I');
$this->view->disable();

$resul = new Impresiones();
$resul->usuario_id= $this->_user->id;
$resul->costo_impresion = $this->_user->cobro_impresion;
$resul->fecha_reg = date("Y-m-d H:i:s");
$resul->estado = 1;
$resul->baja_logica = 1;
if($resul->save()){
    $msm = 'Exito, se guardo correctamente';
}

}


public function pruebapdfAction()
{
// Include the main TCPDF library (search for installation path).
require_once('tcpdf/examples/tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 9, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
$pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $fill = 0;

$pdf->Cell(10, 6, 'Nro', 1, 0, 'L', $fill);
$pdf->Cell(30, 6, 'Ubicación', 1, 0, 'L', $fill);
$pdf->Cell(30, 6, 'Sector', 1, 0, 'R', $fill);
$pdf->Cell(30, 6, 'Fecha', 1, 0, 'R', $fill);
$pdf->Cell(90, 6, 'Descripción', 1, 0, 'R', $fill);
$pdf->Ln();
$sum = 0;
$sw =0;
for ($i=1; $i <100 ; $i++) { 

    
    $maxnocells = 0;
    $cellcount = 0;
    //write text first
    $startX = $pdf->GetX();
    $startY = $pdf->GetY();
    //draw cells and record maximum cellcount
    //cell height is 6 and width is 80
    $cellcount = $pdf->MultiCell(10,6,$i,0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $cellcount = $pdf->MultiCell(30,6,'Cochabamba',0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $cellcount = $pdf->MultiCell(30,6,'Sector',0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $cellcount = $pdf->MultiCell(30,6,'Sector',0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $cellcount = $pdf->MultiCell(90,6,' fjalañsdklfjalskd ',0,'L',0,0);
    if ($cellcount > $maxnocells ) {$maxnocells = $cellcount;}
    $pdf->SetXY($startX,$startY);
    
    //now do borders and fill
    //cell height is 6 times the max number of cells
    $pdf->MultiCell(10,$maxnocells * 5,'','LB','L',$sw,0);
    $pdf->MultiCell(30,$maxnocells * 5,'','LB','L',$sw,0);
    $pdf->MultiCell(30,$maxnocells * 5,'','LB','L',$sw,0);
    $pdf->MultiCell(30,$maxnocells * 5,'','LB','L',$sw,0);
    $pdf->MultiCell(90,$maxnocells * 5,'','LRB','L',$sw,0);
    $pdf->Ln();
    $sw=!$sw;
    $sum +=$maxnocells;
    if ($sum > 42) {
        $pdf->AddPage();
        $sum=0;
    }
    
}

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

$this->view->disable();
}


}
