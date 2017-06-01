<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Email extends CI_Controller
	{
	
		function __construct(){
			parent::__construct();
			$this->load->library('PhpMail');
		}
		
		function send_verification($NodeNumber, $UserID, $FName, $Hash){
			//$NodeNumber, $UserID, $FName
			$emailToSendTo = $this->users->getEmail($NodeNumber);
			//configuration for PHPMailer
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = 2;
			$mail->Host = 'smtp.gmail.com';
			$mail->Username = 'shelfnoreply@gmail.com'; //web e-mail
			$mail->Password = 'jerethechinese9869';
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPDebug = 0;
			$mail->Port = 465;
			$mail->IsHTML(true);
			$mail->From = 'shelfnoreply@gmail.com';
			$mail->FromName = 'Shelf';
			$mail->addAddress($emailToSendTo, $FName); //insert email address here
			$mail->Subject = 'E-mail verification';
			$message = "<html><head><style>body{background-color: red;}</style></head><body>";
			$message .= "<p>Hi " . $FName . "!</p><br/><br/>";
			$message .= "<p>Welcome to Shelf! We would just like you to verify your e-mail address that comes with your account.</p><br/><br/>";
			$message .= "<p>Follow the link below to start enjoying Shelf!</p></body></html>";
			//Insert link here
			$message .= '<a href="'.base_url().'index.php/Login/verify/'.$UserID.'/'.$Hash.'">Link</a>';
			$mail->Body = $message;
			if($mail->Send()) {
				echo 'Email sent!';
            	//echo "Error: " . $mail->ErrorInfo;
        	} else {
            	//$data["message"] = "Message sent correctly!";
        	}
        	//Set session variables
        	$this->session->set_userdata('isUserLoggedIn', TRUE);
        	$this->session->set_userdata('UserID', $UserID);
        	$this->session->set_userdata('FName', $FName);
        	$this->session->set_userdata('Email', $emailToSendTo);
			$this->session->set_tempdata('SentEmail', "True", 300);
			redirect('login/sent_ver_email', "refresh");		
		}

		function index($emailToSendTo = 'shelfnoreply@gmail.com', $UserName = 'InsertUserNameHere', $message = 'This is a body from index'){
			//$this->load->library('PhpMail');
			
			//configuration for PHPMailer
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = 2;
			$mail->Host = 'smtp.gmail.com';
			$mail->Username = 'shelfnoreply@gmail.com'; //web e-mail
			$mail->Password = 'jerethechinese9869';
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPDebug = 0;
			$mail->Port = 465;
			
			$mail->From = 'shelfnoreply@gmail.com';
			$mail->FromName = 'Shelf';
			$mail->addAddress($emailToSendTo, $UserName); //insert email address here
			$mail->Subject = 'This is a Subject';
			$mail->Body = $message;
			//$mail->AddStringAttachment($this->createReceipt(), 'receipt.pdf');
			if(!$mail->Send()) {
            	//echo "Error: " . $mail->ErrorInfo;
            	echo 'Sent!';
        	} else {
            	//$data["message"] = "Message sent correctly!";
        	}
		}
		
		function createReceipt($user = 'China', $receipt_ID = 'testValue', $purchase_date = 'MM/DD/YYYY', $books_purchased = array('book1', 'book2'), $price_list = array(100, 200))
		{
		$this->load->library('PdfCustom');
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
		$file = $pdf->Output('receipt.pdf', 'S');
		
		return $file;
		}
		
	}
?>			