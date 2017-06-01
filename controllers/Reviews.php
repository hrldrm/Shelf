<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Reviews extends CI_Controller{
		public function retrieve($ID){
			$Reviews = array();
			$Reviews = $this->books->getReviews($ID);
			$ReviewsHTML = "";
			if(sizeof($Reviews) > 0){
				for($i = 0; $i < sizeof($Reviews); $i++){
					$CurrReviewer = $this->users->getUserName($Reviews[$i]['Reviewer']); //Retrieve reviewer name
					if($CurrReviewer == $this->session->userdata("FName")) $ReviewsHTML .= "<div class='Review'><a href='javascript:void(0);'>" . "You" . "</a><h1> gave it a </h1>";
					else $ReviewsHTML .= "<div class='Review'><a href='javascript:void(0);'>" . $CurrReviewer . "</a><h1> gave it a </h1>";
					if($Reviews[$i]["Vote"] == '1'){
						$ReviewsHTML .= "<img class='voteimg' src='/Shelf/assets/images/like.png'>";
					}
					else if($Reviews[$i]["Vote"] == '-1') $ReviewsHTML .= "<img class='voteimg' src='/Shelf/assets/images/dislike.png'>";  
					$ReviewsHTML .= "<p>" . $Reviews[$i]["Date"] . "</p>";
					$ReviewsHTML .= "<p>" . $Reviews[$i]["ReviewContent"] . "</p></div>";
				}
				echo $ReviewsHTML;
			}else{
				echo "No reviews yet, add yours!";
			}
		}

		public function if_reviewed($UserID, $BookID){
			$NodeNumber = $this->users->getNodeNumberUsingID($UserID);
			if($this->users->getBookID($NodeNumber, $BookID)){
				echo "true";
			}else{
				echo "false";
			}
		}
	}
?>