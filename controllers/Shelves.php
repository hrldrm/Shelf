<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Shelves extends CI_Controller{
		public function index(){
			$this->load->view("myshelf.php");
		}

		public function get_shelves($UserID, $BookID){
			$NodeNumber = $this->users->getNodeNumberUsingID($UserID);
			$ShelfNames = array();
			$ShelfNames = $this->users->getShelfNames($NodeNumber);
			if(sizeof($ShelfNames) == 0){
				$HTML = "<h2>You have no shelves yet. Create one below! This book will automatically be added to this Shelf.</h2>
					  <form method='POST' action='/Shelf/index.php/shelves/addBookAndShelf/" . $BookID . "'>
					  <input type='text' name='ShelfName' placeholder='Shelf Name' required> 
					  <input type='submit' name='Add to new Shelf'>
					  </form>"; 
				echo $HTML;
			}
			else{
				$Response = "<h2>Select from your existing Shelves below:</h2>";
				$count = 0;
				foreach ($ShelfNames as $Name) { 
					$Response .= "<div class='ShelfName' onclick=\"addBookToShelf(";
					$Response .= "'" . $UserID . "','" . $BookID . "','" . $count . "'";
					$Response .= ")\">";
					$Response .= "<p>&bull; " . $Name . "</p></div>";
					$count++;
				}
				$Response .= "<div><h2>Or create a new Shelf! This book will automatically be added to this Shelf.</h2>
					  <form method='POST' action='/Shelf/index.php/shelves/addBookAndShelf/" . $BookID . "'>
					  <input type='text' name='ShelfName' placeholder='Shelf Name' required> 
					  <input type='submit' name='Add to new Shelf'>
					  </form></div>";
				echo $Response;
			}	
		}

		public function retrieveShelves(){
			$Shelves = array();
			$Shelves = $this->users->getAllShelves($this->session->userdata('UserID'));
			$Response = "";
			if(sizeof($Shelves) == 0){
				$Response = "<h1>You have no shelves yet! Try adding some books.</h1>";
			}else{
				$dir = "./assets/book_covers";
				$ImagesA = $this->images->Get_ImagesToFolder($dir);
				foreach ($Shelves as $Name => $BookIDs) {
					$Response .= "<h1>" . $Name . "</h1><br/>";
					if(sizeof($BookIDs) == 0){
						$Response .= "<h2>This shelf does not contain any books!</h2>";
					}else{
						for ($i = 0; $i < sizeof($BookIDs); $i++){
							$Info = array();
							$Info = $this->books->getBookInfoByID($BookIDs[$i]);
							$bookIndex = $this->images->getImageIndex(htmlspecialchars($Info['Title']) . ".jpg");
							 $link = "/Shelf/index.php/books/show/" . $BookIDs[$i];
							$Response .= "<a href='" . $link . "'><div class='BookCover'><p id='Title'>" . $Info['Title'] . "<br/><p id='Author'>by: " . $Info['Author'] . "</p>" . "<span id='deleteShelfBook'>&times;</span><img src='/Shelf/assets/book_covers/" . $ImagesA[$bookIndex] . "'></div></a>";
						}	
					}
				}
			}
			echo $Response;
		}
		
		public function addBookAndShelf($BookID){
			$ShelfName = $this->input->post("ShelfName");
			$this->users->addBookAndShelf($BookID, $this->session->userdata("UserID"), $ShelfName);
			$path = "books/show/" . $BookID;
			redirect($path, "refresh");
		}

		public function addBookToShelf($BookID, $ShelfNumber){
			$this->users->addBookToShelf($BookID, $this->session->userdata("UserID"), $ShelfNumber);
			$path = "books/show/" . $BookID;
			redirect($path, "refresh");	
		}
	}
?>