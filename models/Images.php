<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Images extends CI_Model{
		public function Get_ImagesToFolder($dir){
		        $ImagesArray = array();
		        $file_display = [ 'jpg', 'jpeg', 'png', 'gif' ];

		        if (file_exists($dir) == false) {
		            return ["Directory \'', $dir, '\' not found!"];
		        } 
		        else {
		         $dir_contents = scandir($dir);
		         foreach ($dir_contents as $file) {
		             $file_type = pathinfo($file, PATHINFO_EXTENSION);
		            if (in_array($file_type, $file_display) == true) {
		            array_push($ImagesArray, $file);
		         }
		      }
		      return $ImagesArray;
		   }
		}

		public function getImageIndex($title){
		   $directory = './assets/book_covers';
		   $ImagesA = $this->Get_ImagesToFolder($directory);
		   for($i = 0; $i < count($ImagesA); $i++){
		      $title = str_replace(array("'", "?", ":", "*", "-", ","), "", $title);   
		      if(stristr($title, $ImagesA[$i])){
		         return $i;
		      }
		   }
		}
	}
?>