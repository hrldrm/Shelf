<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Users_traverse extends CI_Model{
		public function addUser($data){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$currID = uniqid();
			$User = $xmlDoc->createElement("User");
			$Info = $xmlDoc->createElement("Info");
			$UserID = $xmlDoc->createElement("UserID", $currID);
			$FirstName = $xmlDoc->createElement("FirstName", $data['FName']);
			$LastName = $xmlDoc->createElement("LastName", $data['LName']);
			$Email = $xmlDoc->createElement("Email", $data['Email']);
			$VerifiedEmail = $xmlDoc->createElement("VerifiedEmail", "false");
			$Password = $xmlDoc->createElement("EncryptedPass", $data['Password']);
			$Hash = $xmlDoc->createElement("Hash", $data['Hash']);
			$Shelves = $xmlDoc->createElement("Shelves");
			$Cart = $xmlDoc->createElement("Cart");
			$Rated = $xmlDoc->createElement("RatedBooks");
			$Info->appendChild($UserID);
			$Info->appendChild($FirstName);
			$Info->appendChild($LastName);
			$Info->appendChild($Email);
			$Info->appendChild($VerifiedEmail);
			$Info->appendChild($Hash);
			$Info->appendChild($Password);
			$Info->appendChild($Shelves);
			$Info->appendChild($Cart);
			$Info->appendChild($Rated);
			$User->appendChild($Info);
			$xmlDoc->preserveWhiteSpace = false;
			$xmlDoc->formatOutput = true;
			$xmlDoc->getElementsByTagName("Users")[0]->appendChild($User);
			$xmlDoc->save($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			return true;
		}
		public function checkDuplicateEmail($Email){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			for($i = 0; $i < ($x->length); $i++) {
				$Info = $x->item($i)->getElementsByTagName('Info')[0];
				for($j = 0; $j < ($Info->childNodes->length); $j++){
					if($Info->childNodes->item($j)->nodeName == "Email"){
						if ($Email == $Info->childNodes->item($j)->nodeValue) return true;
					}
				}
			}
			return false;
		}
		public function addUserReview($BookID, $UserID, $Vote){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($UserID);
			$Info = $x->item($NodeNumber)->getElementsByTagName('Info')[0];
			for($i = 0; $i < ($Info->childNodes->length); $i++){
				if($Info->childNodes->item($i)->nodeName == "RatedBooks"){
					$RatedBooks = $Info->childNodes->item($i);
					$Rating = $xmlDoc->createElement("Rating");
					$BookIDNode = $xmlDoc->createElement("BookID", $BookID);
					$VoteNode = $xmlDoc->createElement("Vote", $Vote);
					$Rating->appendChild($BookIDNode);
					$Rating->appendChild($VoteNode);
					$RatedBooks->appendChild($Rating);
					$xmlDoc->save($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
					return true;
				}
			}	
		}
		public function getUserInfoFromEmail($Email){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getUserNodeNumber($Email);
			$UserNode = $x->item($NodeNumber);
			$Info = $UserNode->getElementsByTagName('Info')[0];
			$UserID = $FName = "";
			for($j = 0; $j < ($Info->childNodes->length); $j++){
				if($Info->childNodes->item($j)->nodeName == "FirstName"){
					$FName = $Info->childNodes->item($j)->nodeValue;
				}else if($Info->childNodes->item($j)->nodeName == "UserID"){
					$UserID = $Info->childNodes->item($j)->nodeValue;
				}else if($Info->childNodes->item($j)->nodeName == "Hash"){
					$Hash = $Info->childNodes->item($j)->nodeValue;
				}
			}
			$data = array('NodeNumber' => $NodeNumber, 'UserID' => $UserID, 'FName' => $FName, 'Hash' => $Hash);
			return $data;
		}
		public function getEmail($NodeNumber){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$UserNode = $x->item($NodeNumber);
			$Info = $UserNode->getElementsByTagName('Info')[0];
			$Email = "";
			for($j = 0; $j < ($Info->childNodes->length); $j++){
				if($Info->childNodes->item($j)->nodeName == "Email"){
					$Email = $Info->childNodes->item($j)->nodeValue;
					break;
				}
			}
			return $Email;
		}
		public function verifyEmail($email){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$Email = "";
			for($i = 0; $i < ($x->length); $i++) {
				$Info = $x->item($i)->getElementsByTagName('Info')[0];
				for($j = 0; $j < ($Info->childNodes->length); $j++){
					if($Info->childNodes->item($j)->nodeName == "Email"){
						$Email = $Info->childNodes->item($j)->nodeValue;
						if($email == $Email) return true;
						break;
					}
				}
			}
			return false;
		}
		
		public function getUserHash($UserID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($UserID);
			$Info = $x->item($NodeNumber)->getElementsByTagName('Info')[0];
			for($j = 0; $j < ($Info->childNodes->length); $j++){
				if($Info->childNodes->item($j)->nodeName == "Hash"){	
					 return $Info->childNodes->item($j)->nodeValue;	
				}
			}
		}
		
		public function changeVerifyStatus($UserID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($UserID);
			$Info = $x->item($NodeNumber)->getElementsByTagName('Info')[0];
			for($j = 0; $j < ($Info->childNodes->length); $j++){
				if($Info->childNodes->item($j)->nodeName == "VerifiedEmail"){	
					 //return $Info->childNodes->item($j)->nodeValue;
					 $Info->childNodes->item($j)->nodeValue = 'true';
					 $xmlDoc->save($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');	
				}
			}
		}
		public function getUserName($UserID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($UserID);
			$UserName = "";
			$Info = $x->item($NodeNumber)->getElementsByTagName('Info')[0];
			for($j = 0; $j < ($Info->childNodes->length); $j++){
				if($Info->childNodes->item($j)->nodeName == "FirstName"){	
					 return $Info->childNodes->item($j)->nodeValue;	
				}
			}
		}		
		public function getNodeNumberUsingID($UserID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$UserNodeNumber = -1;
			for($i = 0; $i < ($x->length); $i++) {
				$Info = $x->item($i)->getElementsByTagName('Info')[0];
				for($j = 0; $j < ($Info->childNodes->length); $j++){
					if($Info->childNodes->item($j)->nodeName == "UserID"){	
						if($UserID == $Info->childNodes->item($j)->nodeValue){
							$UserNodeNumber = $i;
							break;	
						}
					}
				}
				if($UserNodeNumber != -1) break; //UserNumber has been found. Break loop.
			}
			return $UserNodeNumber;
		}
		public function getUserNodeNumber($email){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$UserID = "";
			$UserNodeNumber = $UserIDNodeNumber = -1;
			for($i = 0; $i < ($x->length); $i++) {
				$Info = $x->item($i)->getElementsByTagName('Info')[0];
				for($j = 0; $j < ($Info->childNodes->length); $j++){
					if($Info->childNodes->item($j)->nodeName == "Email"){	
						if($email == $Info->childNodes->item($j)->nodeValue){
							$UserNodeNumber = $i;
							break;	
						}
					}
				}
				if($UserNodeNumber != -1) break; //UserNumber has been found. Break loop.
			}
			return $UserNodeNumber;
		}
		public function getBookID($NodeNumber, $BookID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$RatedBooks = $x->item($NodeNumber)->getElementsByTagName('RatedBooks')[0];
			for($i = 0; $i < ($RatedBooks->childNodes->length); $i++) {
				if($RatedBooks->childNodes->item($i)->nodeName == "Rating"){
					$Rating = $RatedBooks->childNodes->item($i);
					for($j = 0; $j < ($Rating->childNodes->length); $j++){
						if($Rating->childNodes->item($j)->nodeName == "BookID"){
							if($Rating->childNodes->item($j)->nodeValue == $BookID) return true;
						}
					}
				}
			}
			return false;	
		}
		public function getShelfNames($NodeNumber){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$Shelves = $x->item($NodeNumber)->getElementsByTagName('Shelves')[0];
			$ShelfNamesArr = array();
			if($Shelves->childNodes->length == 0) return $ShelfNamesArr;
			else{
				for($i = 0; $i < ($Shelves->childNodes->length); $i++) {
					if($Shelves->childNodes->item($i)->nodeName == "Shelf"){
						$Shelf = $Shelves->childNodes->item($i);
						for($j = 0; $j < ($Shelf->childNodes->length); $j++){
							if($Shelf->childNodes->item($j)->nodeName == "ShelfName"){
								array_push($ShelfNamesArr, $Shelf->childNodes->item($j)->nodeValue);
							}
						}
					}
				}
				return $ShelfNamesArr;
			} 	
		}
		public function getAllShelves($UserID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($UserID);
			$Shelves = $x->item($NodeNumber)->getElementsByTagName('Shelves')[0];
			$ShelfArr = array();
			if($Shelves->childNodes->length == 0) return $ShelfArr;
			else{
				for($i = 0; $i < ($Shelves->childNodes->length); $i++) {
					if($Shelves->childNodes->item($i)->nodeName == "Shelf"){
						$Shelf = $Shelves->childNodes->item($i);
						$CurrShelfName = "";
						$BookIDs = array();
						for($j = 0; $j < ($Shelf->childNodes->length); $j++){
							if($Shelf->childNodes->item($j)->nodeName == "ShelfName"){
								$CurrShelfName = $Shelf->childNodes->item($j)->nodeValue;
							}else if($Shelf->childNodes->item($j)->nodeName == "BookID"){
								array_push($BookIDs, $Shelf->childNodes->item($j)->nodeValue);
							}
						}
						$ShelfArr[$CurrShelfName] = $BookIDs;
					}
				}
				return $ShelfArr;
			} 	
		}
		public function addBookAndShelf($BookID, $UserID, $ShelfName){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($UserID);
			$Shelves = $x->item($NodeNumber)->getElementsByTagName('Shelves')[0];
			$Shelf = $xmlDoc->createElement("Shelf");
			$ShelfNameNode = $xmlDoc->createElement("ShelfName", $ShelfName);
			$BookIDNode = $xmlDoc->createElement("BookID", $BookID);
			$Shelf->appendChild($ShelfNameNode);
			$Shelf->appendChild($BookIDNode);
			$Shelves->appendChild($Shelf);
			$xmlDoc->save($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
		}
		public function addBookToShelf($BookID, $UserID, $ShelfNumber){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($UserID);
			$Shelves = $x->item($NodeNumber)->getElementsByTagName('Shelves')[0];
			$BookIDNode = $xmlDoc->createElement("BookID", $BookID);
			$Shelves->childNodes->item($ShelfNumber)->appendChild($BookIDNode);
			$xmlDoc->save($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
		}
		public function getCartContent($UserID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($UserID);
			$Cart = $x->item($NodeNumber)->getElementsByTagName('Cart')[0];
			$CartArr = array();
			if($Cart->childNodes->length == 0) return $CartArr;
			else{
				for($i = 0; $i < ($Cart->childNodes->length); $i++) {
					if($Cart->childNodes->item($i)->nodeName == "BookID"){
						array_push($CartArr, $Cart->childNodes->item($i)->nodeValue);
					}
				}
				return $CartArr;
			} 	
		}
		public function addBookToCart($BookID, $UserID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($UserID);
			$Cart = $x->item($NodeNumber)->getElementsByTagName('Cart')[0];
			$BookIDNode = $xmlDoc->createElement("BookID", $BookID);
			$Cart->appendChild($BookIDNode);
			$xmlDoc->save($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');	
		}

		public function deleteItemFromCart($BookID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($this->session->userdata('UserID'));
			$Cart = $x->item($NodeNumber)->getElementsByTagName('Cart')[0];
			for($i = 0; $i < $Cart->childNodes->length; $i){
				if($Cart->childNodes->item($i)->nodeName = "BookID"){
					if($BookID == $Cart->childNodes->item($i)->nodeValue){
						$Cart->removeChild($Cart->childNodes->item($i));
					}
				}
			}
			$xmlDoc->save($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
		}

		public function clearCart($UserID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$NodeNumber = $this->getNodeNumberUsingID($UserID);
			$Cart = $x->item($NodeNumber)->getElementsByTagName('Cart')[0];
			while($Cart->childNodes->length > 0){
				$Cart->removeChild($Cart->firstChild);
			}
			$xmlDoc->save($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
		}
		
		public function decode_password($password){
			$this->load->library('encrypt');
			return $this->encrypt->decode($password);
		}
		public function verifyPassword($UserNumber, $password){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Users.xml');
			$x = $xmlDoc->getElementsByTagName("User");
			$Info = $x->item($UserNumber)->getElementsByTagName('Info')[0];
			for($i = 0; $i < ($Info->childNodes->length); $i++) {
				if($Info->childNodes->item($i)->nodeName == "EncryptedPass"){
					if($password == $this->decode_password($Info->childNodes->item($i)->nodeValue)){
					//if(password_verify($password, $Info->childNodes->item($i)->nodeValue)){
						return true;
					}else{
						return false;
					}
				}
			}
			return false;	
		}
	}
?>
