<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Login extends CI_Controller{

		public function index(){
			if($this->session->userdata('isUserLoggedIn')) redirect('home');
			else $this->load->view('login_screen.php');
		}

		public function login_fail(){
			$this->load->view("login_fail.php");	
		}	

		public function signup_fail(){
			$this->load->view("signup_fail.php");	
		}	

		public function sent_ver_email($Email){
			$this->load->view("sent_ver_email.php", $Email);
		}

		public function login_user(){
			if($this->verifyEmail($this->input->post("Email"))){ //Email exists in the database
				$Email = strip_tags($this->input->post("Email"));
				$NodeNumber = $this->users->getUserNodeNumber($Email);
				if($this->verifyPassword($NodeNumber, $this->input->post("Password"))){
					$data = array(
						'Email' => strip_tags($this->input->post("Email"))
						//'Password' => password_hash($this->input->post("Password"), $hash)
					);
					$UserInfo = $this->users->getUserInfoFromEmail($data['Email']);
					$this->session->set_userdata('FName', $UserInfo['FName']);
					$this->session->set_userdata('isUserLoggedIn', TRUE);
					$this->session->set_userdata('UserID', $UserInfo['UserID']);
					$this->session->set_userdata('Email', $data['Email']);
                   	redirect("home", "refresh");
				}else{
					$this->login_fail();
				}
			}else{
				$this->login_fail();
			}
		}

		public function logout(){
			$this->session->unset_userdata('FName');
			$this->session->unset_userdata('isUserLoggedIn');
			$this->session->unset_userdata('UserID');
			$this->session->unset_userdata('Email');
			$this->session->sess_destroy();
			redirect('', "refresh");
		}
		
		public function encrypt_password($password){
			$this->load->library('encrypt');
			return $this->encrypt->encode($password);
		}

		public function register_user(){
			//https://www.codexworld.com/codeigniter-user-registration-login-system/
			if($this->users->checkDuplicateEmail($this->input->post("Email"))){
				$this->signup_fail();
			}
			else{
				$data = array(
					'Email' => strip_tags($this->input->post("Email")),
					'FName' => strip_tags($this->input->post("FName")),
					'LName' => strip_tags($this->input->post("LName")),
					//'Password' => password_hash($this->input->post("Password"), PASSWORD_DEFAULT)
					'Password' => $this->encrypt_password($this->input->post("Password")),
					'Hash' => md5(rand(0, 1000))
				);
				$result = $this->users->addUser($data);
				$params = array();
				$params = $this->users->getUserInfoFromEmail($data['Email']);
				$path = 'email/send_verification/' . $params['NodeNumber'] . '/' . $params['UserID'] . '/' .$params['FName'] . '/' .$params['Hash'];
				redirect($path, "refresh");
			}
		}
		
		public function verify($userID, $hash){
			if($this->users->getUserHash($userID) == $hash){
				$this->users->changeVerifyStatus($userID);
				redirect('home');
			}
		}

		public function verifyEmail($email){
			if($this->users->verifyEmail($email)) return true;
			else return false;
		}

		public function verifyPassword($UserNumber, $password){
			return $this->users->verifyPassword($UserNumber, $password);
		}
	}
?>