<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Cart extends CI_Controller{
		public function index(){
			$this->load->view("mycart.php");
		}

		public function addBookToCart($BookID){
			$this->users->addBookToCart($BookID, $this->session->userdata('UserID'));
		}

		public function checkout(){
			$this->session->set_userdata("CartQuantities", $_POST);
			$this->load->view('checkout.php');
		}

		public function place_order(){
			$this->session->unset_userdata("CartQuantities", $_POST);
			$this->session->unset_userdata("Titles", $Titles);
			$this->session->unset_userdata("Prices", $Prices);
			$this->session->unset_userdata("Quantities", $Quantities);
			$this->users->clearCart($this->session->userdata('UserID'));
			$this->load->view("order_placed.php");
		}

		public function getCheckoutData(){
			$Cart = $this->users->getCartContent($this->session->userdata('UserID'));
			$COTable = "<table><tr><th></th><th>Title</th><th>Price</th><th>Quantity</th></tr>";
			$Subtotal = 0;
			$Titles = array();
			$Prices = array();
			$Quantities = array();
			for ($i = 0; $i < sizeof($Cart); $i++){
				$Info = array();
				$Info = $this->books->getBookInfoByID($Cart[$i]);
				$bookIndex = $this->images->getImageIndex(htmlspecialchars($Info['Title']) . ".jpg");
				$dir = "./assets/book_covers";
				$ImagesA = $this->images->Get_ImagesToFolder($dir);
				array_push($Titles, $Info['Title']);
				array_push($Prices, $Info['Price']);
				$link = "/Shelf/index.php/books/show/" . $Cart[$i];
				$COTable .= "
						 		<tr>
						 			<td>
						 				<img id='CartBookCover' style='width: 120px;height: 175px' src='/Shelf/assets/book_covers/" . $ImagesA[$bookIndex] . "'/>
						 			</td>
						 			<td>
						 				<p id='Title'>" . $Info['Title']; 
				$COTable .= "              </p>	
						 			</td>
						 			<td>
						 				<p class='Price'>&#8369;" . $Info['Price'] . "</p>";
				$COTable .= "		 	</td>
									<td>
										<p class='Quantity'>" . $this->session->userdata['CartQuantities']["b" . $Info['ID']] . "
									</td>
						 		</tr>";
				$Subtotal += $Info['Price'] * $this->session->userdata['CartQuantities']["b" . $Info['ID']]; 
				array_push($Quantities, $this->session->userdata['CartQuantities']["b" . $Info['ID']]);
			}
			//Unset this later
			$this->session->set_userdata("Titles", $Titles);
			$this->session->set_userdata("Prices", $Prices);
			$this->session->set_userdata("Quantities", $Quantities);
			$COTable .= "</table><p id='total'>&#8369;" . $Subtotal . "</p></div>";
			echo $COTable;
		}

		public function deleteItemFromCart($BookID){
			$this->users->deleteItemFromCart($BookID);
			$Response = $this->retrieveCart();
			echo $Response;
		}

		public function retrieveCart(){
			$Cart = array();
			$Cart = $this->users->getCartContent($this->session->userdata('UserID'));
			$Response = "";
			if(sizeof($Cart) == 0){
				$Response = "<h1>Your shopping cart is empty!</h1>";
			}else{
				$Response = "<h1>Your shopping cart</h1>";
				$dir = "./assets/book_covers";
				$ImagesA = $this->images->Get_ImagesToFolder($dir);
				$Prices = array();
				$OriginalTotal = 0;
				$Form = "<form method='POST' action='/Shelf/index.php/cart/checkout'><table><tr><th></th><th>Title</th><th>Price (&#8369;)</th><th>Quantity</th></tr>";
				for ($i = 0; $i < sizeof($Cart); $i++){
					$Info = array();
					$Info = $this->books->getBookInfoByID($Cart[$i]);
					$bookIndex = $this->images->getImageIndex(htmlspecialchars($Info['Title']) . ".jpg");
					array_push($Prices, $Info['Price']);
					$OriginalTotal += $Info['Price'];
					$link = "/Shelf/index.php/books/show/" . $Cart[$i];
					$Form .= "<tr>
							 			<td>
							 				<img id='CartBookCover' style='width: 120px;height: 175px' src='/Shelf/assets/book_covers/" . $ImagesA[$bookIndex] . "'/>
							 			</td>
							 			<td>
							 				<p id='Title'>" . $Info['Title']; 
					$Form .= "              </p>	
							 			</td>
							 			<td>
							 				<p class='Price'>" . $Info['Price'] . "</p>";
					$Form .= "		 	</td>
										<td>
											<input type='number' name='b" . $Info['ID'] . "' value='1' min='1' max='10' onchange='updateTotal()'>
										</td>
										<td class='deleteItem'>
											<p class='deleteFromCart' onclick='removeItemFromCart(" . $Info['ID'] . ")'>&times;</p>
										</td>
							 		</tr>";
				}
				$Form .= "</table></p><input type='submit' value='Proceed to Checkout'></form><div><p id='total'>&#8369;" . $OriginalTotal . "</div>";
				$Response .= $Form;
			}
			echo $Response;
		}
	}
?>