<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('pdf_create'))
{
	function pdf_create($html, $filename='', $stream=TRUE) 
	{
	    require_once("dompdf/dompdf_config.inc.php");
    
	    $dompdf = new DOMPDF();
		$dompdf->set_paper('A4','landscape');
	    $dompdf->load_html($html);
	    $dompdf->render();
	    if ($stream) {
	        $dompdf->stream($filename.".pdf");
	    } else {
	        return $dompdf->output();
	    }
	}
}

?>