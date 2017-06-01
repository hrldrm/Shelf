<?php 
   class Search extends CI_Controller {  
      public function index() { 
         	
      }

      public function search_book($query = ''){
         $xmlPath = './data/Books.xml';
         $xmlDoc = new DOMDocument();
         $xmlDoc->load($xmlPath);
         $x = $xmlDoc->getElementsByTagName("Book");
         $q = $query;
         $response = "";
         $dir = "./assets/book_covers";

         $ImagesA = $this->images->Get_ImagesToFolder($dir);
         
         if (strlen($q)>0) {
             $resultCount = 0;
             $hint="";
             $flag = false;
             for($i = 0; $i < ($x->length); $i++) {
                 $Title = $ISBN = $ID = "";
                 $ID = $x->item($i)->getElementsByTagName("ID")[0]->nodeValue;
                 $Info = $x->item($i)->getElementsByTagName('Info')[0];
                 for($j = 0; $j < ($Info->childNodes->length); $j++){
                     if($Info->childNodes->item($j)->nodeName == "Title"){
                         $Title = $Info->childNodes->item($j)->nodeValue;
                     }
                     else if($Info->childNodes->item($j)->nodeName == "Author"){
                         $AuthorNode = $Info->childNodes->item($j);
                         for($k = 0; $k < ($AuthorNode->childNodes->length); $k++){
                             if($AuthorNode->childNodes->item($k)->nodeName == "FName"){
                                 $Author = $AuthorNode->childNodes->item($k)->nodeValue;
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
                 if(stristr($Title, $q) || stristr($Author, $q)){
                     $bookIndex = $this->images->getImageIndex(htmlspecialchars($Title) . ".jpg");
                     $link = "/Shelf/index.php/books/show/" . $ID;
                     if($hint == ""){
                         $hint = "<div class='ResultContent'><img class='BookCoverSearch' src='/Shelf/assets/book_covers/" . $ImagesA[$bookIndex] . "'>" . "<div class='Title'><a href='" . $link . "'>" . $Title . "</a></div><span class='AuthorFromSearch'>by " . $Author . "</span></div>";
                             $flag = true;
                     }else{
                         if($resultCount <= 5){
                             $hint .= "<div class='ResultContent'><img class='BookCoverSearch' src='/Shelf/assets/book_covers/" . $ImagesA[$bookIndex] . "'>" . "<div class='Title'><a href='" . $link . "'>" . $Title . "</a></div><span class='AuthorFromSearch'>by " . $Author . "</span></div>";   
                         }
                     }
                     $resultCount++;
                 }else if(stristr($ISBN, $q)){
                     $bookIndex = $this->images->getImageIndex(htmlspecialchars($Title) . ".jpg");
                     $link = "/Shelf/index.php/books/show/" . $ID;
                     if($hint == ""){
                         $hint = "<div class='ResultContent'><img class='BookCoverSearch' src='/Shelf/assets/book_covers/" . $ImagesA[$bookIndex] . "'>" . "<div class='Title'><a href='". $link . "'>" . $Title . "</a></div><br><span class='AuthorFromSearch'>by " . $Author . "<br><span class='ISBNFromSearch'>ISBN: " . $ISBN . "</span></span></div>";
                     }else{
                         if($resultCount <= 5){
                             $hint .= "<div class='ResultContent'><img class='BookCoverSearch' src='/Shelf/assets/book_covers/" . $ImagesA[$bookIndex] . "'>" . "<div><a href='". $link . "' class='Title'>" . $Title . "</a><div><br><span class='AuthorFromSearch'>by " . $Author . "<br><span class='ISBNFromSearch'>ISBN: " . $ISBN . "</span></span></div>";
                         }
                     }
                     $resultCount++;
                 }
             }

             if (!$flag) {
                 $response = "<div class='ResultContent1'><div class='Text'>No suggestions</div></div>";;
             } else {
                 $hint .= "<div class='ResultContent1'><div class='Text'><a href=''>See all results for '" . $q . "'</a></div></div>";
                 $response = $hint;
             }
             echo $response;
         }    
      } 
   } 
?>