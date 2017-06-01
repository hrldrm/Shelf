<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Book_traverse extends CI_Model{
		public function getBookTitle($ID){
			$Info = array();
			$Info = $this->getBookInfoByID($ID);
			return $Info['Title'];
		}

		public function getBookInfoByID($ID){
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Books.xml');
			$x = $xmlDoc->getElementsByTagName("Book");
			$Title = $ISBN = $Author = $Synopsis = $Price = "";
			for($i = 0; $i < ($x->length); $i++) {
				$currID = $x->item($i)->getElementsByTagName("ID")[0]->nodeValue;
				if($currID === $ID){
					$Info = $x->item($i)->getElementsByTagName('Info')[0];
					for($j = 0; $j < ($Info->childNodes->length); $j++){
						if($Info->childNodes->item($j)->nodeName == "Title"){
							$Title = $Info->childNodes->item($j)->nodeValue;
						}
						if($Info->childNodes->item($j)->nodeName == "Synopsis"){
							$Synopsis = $Info->childNodes->item($j)->nodeValue;
						}
						else if($Info->childNodes->item($j)->nodeName == "Author"){
							$AuthorNode = $Info->childNodes->item($j);
							for($k = 0; $k < ($AuthorNode->childNodes->length); $k++){
								if($AuthorNode->childNodes->item($k)->nodeName == "FName"){
									$Author = $AuthorNode->childNodes->item($k)->nodeValue;
								}elseif($AuthorNode->childNodes->item($k)->nodeName == "MInit"){
									$MInit = $AuthorNode->childNodes->item($k)->nodeValue;
									if($MInit != ""){
										$Author .= " " . $MInit . ". ";
									}
								}elseif ($AuthorNode->childNodes->item($k)->nodeName == "LName"){
									$Author .= " " . $AuthorNode->childNodes->item($k)->nodeValue;
								}
							} 
						}
						else if($Info->childNodes->item($j)->nodeName == "PublicationDetails"){
							$PubDet = $Info->childNodes->item($j);
							for($k = 0; $k < ($PubDet->childNodes->length); $k++){
								if($PubDet->childNodes->item($k)->nodeName == "ISBN"){
									$ISBNNode = $PubDet->childNodes->item($k);
									for($l = 0; $l < $ISBNNode->childNodes->length; $l++){
										if($ISBNNode->childNodes->item($l)->nodeType == 1){
											$ISBN .= $ISBNNode->childNodes->item($l)->nodeValue;
										}
									}
								}
							}
						}
					}
					$Price = $x->item($i)->getElementsByTagName("Price")[0]->nodeValue;
					break;
				}

			}
			$data = array('ID' => $ID, 'Title' => $Title, 'Author' => $Author, "ISBN" => $ISBN, 'Synopsis' => $Synopsis, 'Price' => $Price);
			return $data;
		}

		public function getReviews($ID){
				$xmlDoc = new DOMDocument();
				$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Books.xml');
				$x = $xmlDoc->getElementsByTagName("Book");
				$Reviews = array();
				for($i = 0; $i < ($x->length); $i++) {
					$currID = $x->item($i)->getElementsByTagName("ID")[0]->nodeValue;
					if($currID === $ID){

						for($j = 0; $j < $x->item($i)->getElementsByTagName("Review")->length; $j++){
							$CurrReviewNode = $x->item($i)->getElementsByTagName("Review")[$j];
							$CurrReview = array();
							for($k = 0; $k < $CurrReviewNode->childNodes->length; $k++){ 
								if($CurrReviewNode->childNodes->item($k)->nodeName == "Vote"){
									$CurrReview["Vote"] = $CurrReviewNode->childNodes->item($k)->nodeValue;
								}
								if($CurrReviewNode->childNodes->item($k)->nodeName == "Date"){
									$CurrReview["Date"] = $CurrReviewNode->childNodes->item($k)->nodeValue;
								}
								if($CurrReviewNode->childNodes->item($k)->nodeName == "Reviewer"){
									$CurrReview["Reviewer"] = $CurrReviewNode->childNodes->item($k)->nodeValue;
								}
								if($CurrReviewNode->childNodes->item($k)->nodeName == "ReviewContent"){
									$CurrReview["ReviewContent"] = $CurrReviewNode->childNodes->item($k)->nodeValue;
								}
							}
							$Reviews[$j] = $CurrReview;
						}
						break;
					}
				}
				return $Reviews;
			}

			public function addReviewNode($data){
				$xmlDoc = new DOMDocument();
				$xmlDoc->load($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Books.xml');
				$x = $xmlDoc->getElementsByTagName("Book");
				for($i = 0; $i < ($x->length); $i++) {
					$currID = $x->item($i)->getElementsByTagName("ID")[0]->nodeValue;
					if($currID === $data['ID']){
						$currBookNode = $x->item($i);
						$Review = $xmlDoc->createElement("Review");
						$Vote = $xmlDoc->createElement("Vote", $data['vote']);
						$Review->appendChild($Vote);
						$Date = $xmlDoc->createElement("Date", date("Y-M-d"));
						$Review->appendChild($Date);
						$Reviewer = $xmlDoc->createElement("Reviewer", $data['name']);
						$Review->appendChild($Reviewer);
						$ReviewContent = $xmlDoc->createElement("ReviewContent", $data['review']);
						$Review->appendChild($ReviewContent);			
						$xmlDoc->getElementsByTagName("Book")[$i]->appendChild($Review);
						$xmlDoc->save($_SERVER['DOCUMENT_ROOT'] . '/Shelf/data/Books.xml');
						break;
					}
				}
				return true;
			}
	}
?>