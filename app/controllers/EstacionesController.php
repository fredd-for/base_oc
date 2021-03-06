<?php 
/**
* 
*/
class EstacionesController extends ControllerBase
{
	
	public function indexAction()
	{
		$this->assets
        ->addCss('/jqwidgets/styles/jqx.base.css')
        ->addCss('/jqwidgets/styles/jqx.custom.css')
                //->addCss('/media/plugins/form-stepy/jquery.stepy.css')
        ;
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
        ->addJs('/media/plugins/bootbox/bootbox.min.js')
        ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
        ->addJs('/media/plugins/form-stepy/jquery.stepy.js')
        ->addJs('/media/demo/demo-formwizard.js')
        ->addJs('/scripts/estaciones/index.js')
        ->addJs('/assets/js/plugins.js')
        ->addJs('/assets/js/pages/formsValidation.js')
        ;

        $linea = $this->tag->select(
            array(
                'linea_id',
                Lineas::find(array('baja_logica=1','order'=>'id ASC')),
                'using' => array('id', 'linea'),
                'useEmpty' => true,
                'emptyText' => '(Selecionar)',
                'emptyValue' => '',
                'class' => 'form-control'
                )
            );
        $this->view->setVar('linea',$linea);
    }

    public function listAction()
    {
      $model = new Estaciones();
      $resul = $model->lista();
      $this->view->disable();
      foreach ($resul as $v) {
        $customers[] = array(
            'id' => $v->id,
            'linea_id' => $v->linea_id,
            'linea' => $v->linea,
            'estacion' =>$v->estacion,
            );
        }
    echo json_encode($customers);
    }


public function saveAction()
{
    if (isset($_POST['id'])) {
        if ($_POST['id']>0) {
            $resul = Estaciones::findFirstById($this->request->getPost('id'));
            $resul->linea_id= $this->request->getPost('linea_id');
            $resul->estacion = $this->request->getPost('estacion');
            if ($resul->save()) {
                $msm ='Exito: Se guardo correctamente';
            }else{
                $msm = 'Error: No se guardo el registro';
            }
        }
        else{
            $resul = new Estaciones();
            $resul->linea_id= $this->request->getPost('linea_id');
            $resul->estacion = $this->request->getPost('estacion');
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
    $resul = Estaciones::findFirstById($this->request->getPost('id'));
    $resul->baja_logica = 0;
    if ($resul->save()) {
        $msm ='Exito: Se elimino correctamente';
    }else{
        $msm = 'Error: No se guardo el registro';
    }
    $this->view->disable();
    echo $msm;
}

public function pruebaAction()
{
    $password = hash_hmac('sha256', 'lucas', '2, 4, 6, 7, 9, 15, 20, 23, 25, 30');
    echo $password;
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




public function pruebatbsAction()
{
$this->view->disable();   
// Include classes
include_once('tbs_us/tbs_class.php'); // Load the TinyButStrong template engine
include_once ('tbs_us/tbs_plugin_opentbs.php'); // Load the OpenTBS plugin

// prevent from a PHP configuration problem when using mktime() and date()
if (version_compare(PHP_VERSION,'5.1.0')>=0) {
    if (ini_get('date.timezone')=='') {
        date_default_timezone_set('America/La Paz');
    }
}

// Initialize the TBS instance
$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

// ------------------------------
// Prepare some data for the demo
// ------------------------------

// Retrieve the user name to display
$yourname = (isset($_POST['yourname'])) ? $_POST['yourname'] : '';
$yourname = trim(''.$yourname);
if ($yourname=='') $yourname = "(no name)";

// A recordset for merging tables
$data = array();
$data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
$data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
$data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );

// Other single data items
$x_num = 3152.456;
$x_pc = 0.2567;
$x_dt = mktime(13,0,0,2,15,2010);
$x_bt = true;
$x_bf = false;
$x_delete = 1;

// -----------------
// Load the template
// -----------------

$template = 'file/template/demo_ms_excel.xlsx';
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

// ----------------------
// Debug mode of the demo
// ----------------------
if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

// --------------------------------------------
// Merging and other operations on the template
// --------------------------------------------

// Merge data in the first sheet
$TBS->MergeBlock('a,b', $data);

// Merge cells (extending columns)
$TBS->MergeBlock('cell1,cell2', $data);

// Change the current sheet
$TBS->PlugIn(OPENTBS_SELECT_SHEET, 2);

// Merge data in Sheet 2
$TBS->MergeBlock('cell1,cell2', 'num', 3);
$TBS->MergeBlock('b2', $data);

// Merge pictures of the current sheet
//$x_picture = 'pic_1523d.gif';
$TBS->PlugIn(OPENTBS_MERGE_SPECIAL_ITEMS);

// Delete a sheet
$TBS->PlugIn(OPENTBS_DELETE_SHEETS, 'Delete me');


// Display a sheet (make it visible)
$TBS->PlugIn(OPENTBS_DISPLAY_SHEETS, 'Display me');

// -----------------
// Output the result
// -----------------

// Define the name of the output file
$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
$output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
if ($save_as==='') {
    // Output the result as a downloadable file (only streaming, no data saved in the server)
    $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
    // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
    exit();
} else {
    // Output the result as a file on the server.
    $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
    // The script can continue.
    exit("File [$output_file_name] has been created.");
}

}

}