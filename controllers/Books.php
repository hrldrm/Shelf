<?php 
class Books extends CI_Controller {  
	public function index() { 
		echo("403 Forbidden");	
	}

	public function show($ID){
		if($ID >= 1 && $ID <= 104){
			$dir = '/Shelf/assets/book_covers';
			$ImagesA = $this->images->Get_ImagesToFolder($dir);
			$data = $this->books->getBookInfoByID($ID);
			$fileName = str_replace(array("'", "?", ":", "*", "-", ","), "", htmlspecialchars($data['Title'])) . ".jpg";
			$data['bookLink'] = $dir . "/" . $fileName;
			$this->load->view('loadBook.php', $data);   
		}else{
			$this->load->view('error404.php');   
		}
		
	} 
} 
?>