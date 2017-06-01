<?php 
   class Error404 extends CI_Controller {  
      public function index() { 
      	$this->load->helper('url'); 
      	$this->load->view('error404.php');
      } 
   } 
?>