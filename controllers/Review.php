<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Review extends CI_Controller{
		public function insert(){
			$ID = $this->input->post('ID');
			$data = array(
				'ID' => $this->input->post('ID'),
				'vote' => $this->input->post('vote'),
				'name' => $this->session->userdata('UserID'),
				'review' => $this->input->post('review')
			);
			$this->users->addUserReview($data['ID'], $data['name'], $data['vote']);
			if($this->books->addReviewNode($data)) redirect("/books/show/" . $ID, 'refresh'); //Adding of review successful
		}
	}
?>