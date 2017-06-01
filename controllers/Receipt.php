<?php
class Receipt extends CI_Controller
{
	function __construct() 
	{ 
 		parent::__construct();
 		$this->load->library('PdfCustom');
 	}
 	
 	function index($user = 'China', $receipt_ID = 'testValue', $purchase_date = 'MM/DD/YYYY', $books_purchased = array('book1', 'book2'), $price_list = array(100, 200))
 	{
 		$pdf = new PdfCustom(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Shelf');
		$pdf->SetTitle('Receipt');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, 20, 'SHELF', 'Official Receipt', array(37,142,102), array(37,142,102));

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
		
		// set font
		$pdf->SetFont('helvetica', '', 12);

		// add a page
		$pdf->AddPage();
		
		//message
		$greeting = <<<EOD
		Dear Reader $user,
		
EOD;

		$message1 = <<<EOD
		Thank you for purchasing from Shelf.com. Your purchase will arrive in due time.
		The purchase was made on $purchase_date. The list of books bought is on the second page. 
		Please keep this file as this will serve as an official receipt for this transaction. 
		Your receipt number is $receipt_ID.<br/>
		
EOD;

		$ending = <<<EOD
		From, Shelf.
		
EOD;

		// column titles
		$header = array('Book', 'Price (PHP)');
		
		$data = $pdf->LoadData($books_purchased, $price_list);
		
		$pdf->writeHTMLCell(0, 0, '', 40, $greeting, 0, 1, 0, true, '', true);
		$pdf->writeHTMLCell(0, 0, '', 60, $message1, 0, 1, 0, true, '', true);
		$pdf->writeHTMLCell(0, 0, 165, 100, $ending, 0, 1, 0, true, '', true);
		$pdf->AddPage();
		$pdf->ColoredTable($header, $data);
		$pdf->Output('example_011.pdf', 'I');

 	}

}
?>