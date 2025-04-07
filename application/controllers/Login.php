<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('User_model');
		$this->load->library(['form_validation', 'upload']);
		$this->load->library('session');
		$this->load->helper(['url']);
	}
	
	public function index()
	{
		if ($this->session->userdata('email')) {
			redirect(base_url('patient'));
		}

		$this->load->view('index');

	}

	public function login(){

		if ($this->session->userdata('email')) {
			redirect(base_url('patient'));
		}

		$validate = $this->form_validation;
		$validate->set_error_delimiters('', ''); 
		
		$validate->set_rules(
			'login_email', 'Email', 'required'
		);
		$validate->set_rules(
			'login_password', 'Password', 'required|min_length[3]|max_length[255]'
		);

		if($validate->run() == FALSE){
			$data = [
				'success' => false,
				'formnotvalid' => true,
				'data' => [
					'login_email' => form_error('login_email'),
					'login_password' => form_error('login_password'),
				],
			];
		}else{
			
			$email = $this->input->post('login_email');
			$password = $this->input->post('login_password');
			
			$check_email = $this->User_model->get_user_by_email_($email);

			if(!$check_email['email']){
				$data =[
					'success' => false,
					'message' => 'Email does not exists!'
				];
			}else{
				$login_data = $check_email['data'];
				$login_password = $login_data['password'];

				if (password_verify($password, $login_password)) {

					$this->session->set_userdata('email', $email);

					$data = [
						'success' => true,
						'redirect_url' => base_url('patient'),
					];
				}else{
					$data =[
						'success' => false,
						'message' => 'Wrong password for that email.'
					];
				}
			}

		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($data));

	}

	public function index_register(){

		if ($this->session->userdata('email')) {
			redirect(base_url('patient'));
		}

		$this->load->view('register');
	}

	public function register(){

		if ($this->session->userdata('email')) {
			redirect(base_url('patient'));
		}

		$validate = $this->form_validation;
		$validate->set_error_delimiters('', ''); 
		$validate->set_rules(
			'reg_lastname', 'Lastname', 'required|min_length[3]|max_length[60]'
		);
		$validate->set_rules(
			'reg_firstname', 'Firstname', 'required|min_length[3]|max_length[60]'
		);
		$validate->set_rules(
			'reg_email', 'Email', 'required|valid_email|is_unique[users.email]'
		);
		$validate->set_rules(
			'reg_password', 'Password', 'required|min_length[3]|max_length[255]'
		);
		$validate->set_rules(
			'reg_password_confirm', 'Confirm Password', 'required|matches[reg_password]'
		);

		if($validate->run() == FALSE){
			$data = [
				'success' => false,
				'formnotvalid' => true,
				'data' => [
					'reg_lastname' => form_error('reg_lastname'),
					'reg_firstname' => form_error('reg_firstname'),
					'reg_email' => form_error('reg_email'),
					'reg_password' => form_error('reg_password'),
					'reg_password_confirm' => form_error('reg_password_confirm'),
				],
			];
		}else{

			$user_data = [
				'lastname' => $this->input->post('reg_lastname'),
				'firstname' => $this->input->post('reg_firstname'),
				'email' => $this->input->post('reg_email'),
				'lastname' => $this->input->post('reg_password'),
				'password' => password_hash($this->input->post('reg_password'), PASSWORD_DEFAULT),
				'created_at' => date('Y-m-d H:i:s'),
			];

			if($this->User_model->insert_user($user_data)){
				$data =[
					'success' => true,
					'message' => 'Successfully Registered!'
				];
			}else{
				$data =[
					'success' => false,
					'message' => 'Failed to register User.'
				];
			}

		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($data));

	}


	public function logout(){

		$this->session->unset_userdata('username');
		$this->session->sess_destroy();

		redirect(base_url());
	}

}
