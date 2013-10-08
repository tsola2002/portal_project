<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename, $stream) 
{ 
  require_once("dompdf/dompdf_config.inc.php");
    spl_autoload_register('DOMPDF_autoload');
    $dompdf = new DOMPDF();
    $dompdf->set_paper("a4", "portrait"); 
    $dompdf->load_html($html);
    $dompdf->render();
    $pdf = $dompdf->output();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    }else {
        ini_set('error_reporting', E_ALL);
        if(!write_file("./files/temp/".$filename.".pdf", $pdf)) {
            echo "files/temp/".$filename.".pdf". ' -> PDF could not be saved! Check your server settings!';
           die();
            }
    }
} 

