<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Patient_model');
		$this->load->model('Migrate_model');	
		$this->load->library(['form_validation', 'upload']);
		$this->load->library('session');
		$this->load->helper(['url']);
		//$this->load->helper('custom_validation');
	}
	
	public function index()
	{

		if (!$this->session->userdata('email')) {
			redirect(base_url());
		}
		$data['patients'] = json_decode(file_get_contents("http://hospital.test/api/v1/patients"), true);
		//$data['patients'] = $this->Patient_model->get_all_patients();
		$data['last_migrate'] = $this->Migrate_model->get_latest_migration();
		$data['navactive'] = 'view_patient';


		//$data['content'] = 'patients/index';
		$this->load->view('patients/index', $data);
		//$this->load->view('patients/home');
	}
	
	/*public function index2()
	{
		$data['patients'] = $this->Patient_model->get_all_patients();
		$data['last_migrate'] = $this->Migrate_model->get_latest_migration();


		//$data['content'] = 'patients/index';
		$this->load->view('patients/index', $data);
		//$this->load->view('patients/home');
	}*/

	public function add() {

		if (!$this->session->userdata('email')) {
			redirect(base_url());
		}


		$validate = $this->form_validation;

		$validate->set_rules(
			'firstname', 'Firstname', 'required|min_length[3]|max_length[255]'
		);
		$validate->set_rules(
			'middlename', 'Middlename', 'required|min_length[3]|max_length[255]'
		);
		$validate->set_rules(
			'lastname', 'Lastname', 'required|min_length[3]|max_length[255]'
		);
		$validate->set_rules(
			'birthdate', 'Birthdate', 'required|callback_valid_date'
		);
		$validate->set_rules(
			'sex', 'Sex', 'required|in_list[M,F]'
		);
		$validate->set_rules(
			'email', 'Email', 'required|valid_email|is_unique[patients.email]'
		);
		$validate->set_rules(
			'phone', 'Phone', 'required|min_length[10]|max_length[15]'
		);
		$validate->set_rules(
			'profile', 'Profile Image', 'callback_validate_image'
		);
		
		if($validate->run() == FALSE){
			$data['navactive'] = 'view_patient';
			$this->load->view('patients/add',$data);
		} else {

			$valid_image = $this->valid_image('profile');

			if($valid_image['success']){

				$upload_data = $valid_image['file_data'];
				$patient_data['profile_image'] = $upload_data['file_name'];

				$patient_data = [
					'firstname' => $this->input->post('firstname'),
					'middlename' => $this->input->post('middlename'),
					'lastname' => $this->input->post('lastname'),
					'birthdate' => $this->input->post('birthdate'),
					'sex' => $this->input->post('sex'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'profile_image' => $upload_data['file_name'],
					'created_at' => date('Y-m-d H:i:s'),
				];

				if($this->Patient_model->insert_patient($patient_data)){
					$this->session->set_flashdata('success', 'Patient added successfully.');
					redirect(base_url());
				}else{
					$this->session->set_flashdata('error', 'Failed to add patient.');
					redirect(base_url('patient/add'));
				}

			}else{
				$this->session->set_flashdata('error', $valid_image['message']);
				redirect(base_url('patient/add'));
			}
			
		}
	}

	public function edit_ajax($id) {

		if (!$this->session->userdata('email')) {
			redirect(base_url());
		}

		$data = [];
			$get_patient_by_id = $this->Patient_model->get_patient_by_id($id);

			if($get_patient_by_id){
				$data = [
					'success' => true,
					'name' => $get_patient_by_id['firstname'] . " " . $get_patient_by_id['middlename'] . " " . $get_patient_by_id['lastname'],
					'birthday' => date("m/d/Y", strtotime($get_patient_by_id['birthdate'])),
					'sex' => $get_patient_by_id['sex'] == "F" ? "Female" : "Male",
					'emailadd' => $get_patient_by_id['email'],
					'phonenum' => $get_patient_by_id['phone'],
					'profile' => !empty($get_patient_by_id['profile_image']) ? base_url('uploads/'.$get_patient_by_id['profile_image']) : base_url("uploads/default/avatar.jpg"),
				];
			}else{
				$data = [
					'success' => false,
					'message' => 'Patient does not exists.'
				];
			}

			return $this->output->set_content_type('application/json')->set_output(json_encode($data));
		
		
	}

	public function edit($id) {

		if (!$this->session->userdata('email')) {
			redirect(base_url());
		}

		$data['patient'] = $this->Patient_model->get_patient_by_id($id);
		$data['navactive'] = 'view_patient';
		if(!$data['patient']){
			show_404();
		}

		$this->load->view('patients/edit',$data);
	}

	public function update($id) {

		if (!$this->session->userdata('email')) {
			redirect(base_url());
		}


		$data['patient'] = $this->Patient_model->get_patient_by_id($id);

		if(!$data['patient']){
			show_404();
		}

		$validate = $this->form_validation;

		$validate->set_rules(
			'firstname', 'Firstname', 'required|min_length[3]|max_length[255]'
		);
		$validate->set_rules(
			'middlename', 'Middlename', 'required|min_length[3]|max_length[255]'
		);
		$validate->set_rules(
			'lastname', 'Lastname', 'required|min_length[3]|max_length[255]'
		);
		$validate->set_rules(
			'birthdate', 'Birthdate', 'required'
		);
		$validate->set_rules(
			'sex', 'Sex', 'required|in_list[M,F]'
		);
		$validate->set_rules(
			'email', 'Email', 'required|valid_email|callback_unique_email[' . $id . ']'
		);
		
		$validate->set_rules(
			'phone', 'Phone', 'required|min_length[10]|max_length[15]'
		);
		if(!empty($_FILES['profile']['name'])) {
			$validate->set_rules(
				'profile', 'Profile Image', 'callback_validate_image'
			);
		}

		if($validate->run() == FALSE){
			$data['navactive'] = 'view_patient';
			$this->load->view('patients/edit',$data);
		} else {

			$patient_data = [
				'firstname' => $this->input->post('firstname'),
				'middlename' => $this->input->post('middlename'),
				'lastname' => $this->input->post('lastname'),
				'birthdate' => $this->input->post('birthdate'),
				'sex' => $this->input->post('sex'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'updated_at' => date('Y-m-d H:i:s'),
			];
			
			if(!empty($_FILES['profile']['name'])) {

				$valid_image = $this->valid_image('profile');

				if($valid_image['success']){
					$upload_data = $valid_image['file_data'];

					$patient_data['profile_image'] = $upload_data['file_name'];

				}else{
					$this->session->set_flashdata('error', $valid_image['message']);
					redirect(base_url('patient/edit'));
				}

			}

			$update = $this->Patient_model->update_patient($id, $patient_data);
				
			if($update){
				$this->session->set_flashdata('success', 'Patient updated successfully.');
				redirect(base_url());
			}else{
				$this->session->set_flashdata('error', 'An Error occured.');
				$this->load->view('patients/edit', $data);
			}
		
		}
	}

	public function delete($id){

		if (!$this->session->userdata('email')) {
			redirect(base_url());
		}

		
		$data['patient'] = $this->Patient_model->get_patient_by_id($id);

		if(!$data['patient']){
			show_404();
		}


		if($this->Patient_model->delete_patient($id)){
			$this->session->set_flashdata('success', 'Patient deleted successfully.');
		}else{
			$this->session->set_flashdata('error', 'Failed to deleted patient.');
		}
		redirect(base_url());
	}


	public function migrate($version)
    {
		$this->load->library('migration');
		$last_migrate = $this->Migrate_model->get_latest_migration();

		if (empty($version)) {
            echo 'Please provide a migration version.' . ' | <a href="' . base_url() . '"> Go back to Homepage</a>';
            return;
        }

		if($version <= $last_migrate){
			echo 'Migration for this sequence was already done.' . ' | <a href="' . base_url() . '"> Go back to Homepage</a>';
            return;
		}

		$difference = abs($version - $last_migrate);
		if ($difference > 1) {
			echo 'You may have skipped some migrations. Please check latest migrations.' . ' | <a href="' . base_url() . '"> Go back to Homepage</a>';
            return;
		}

		if ($this->migration->version($version)) {
			echo 'Migrated to version: ' . $version . ' | <a href="' . base_url() . '"> Go back to Homepage</a>';
		} else {
			show_error($this->migration->error_string());
		}
        
    }



	public function valid_date($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        $d2 = DateTime::createFromFormat('Y-m-d', $date);
        
        if ($d && $d->format('Y-m-d') === $date || $d2 && $d2->format('m-d-Y') === $date) {
            return TRUE;
        } else {
            $this->form_validation->set_message('valid_date', 'The {field} field must be a valid date format.');
            return FALSE;
        }
    }

	public function unique_email($email,$id) {
        $count_patient = $this->Patient_model->get_patient_by_id_email($id,$email);

		if($count_patient > 0){
			$this->form_validation->set_message('unique_email', 'The {field} field must contain a unique value.' . $email);
			return false;
		}

		return true;
    }

	public function valid_image($field_name){

		$data = array();
		$config['upload_path']   = './uploads/'; // Save in uploads folder
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = 4096;  // 2MB max file size
		$config['max_width']     = 1920;
		$config['max_height']    = 1920;
		$config['file_name']    = time() . '_' . $_FILES[$field_name]['name'];

		$this->upload->initialize($config);

		if (!$this->upload->do_upload($field_name)) {
			//$this->session->set_flashdata('error', 'An error occured while uploading image.');
			//redirect(base_url('patient/change_profile'));
			return['success' => false, 'message' => 'An error occured while uploading image.'];
		}else{
			return['success' => true, 'file_data' => $this->upload->data()];
		}

	}

	public function validate_image()
    {
        if (empty($_FILES['profile']['name'])) {
            $this->form_validation->set_message('validate_image', 'Please select an image to upload.');
            return FALSE;
        }

        // Allowed file types
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        $max_size = 4096 * 2048; // 4MB in bytes
        $max_width = 1920;
        $max_height = 1920;

        $file_info = getimagesize($_FILES['profile']['tmp_name']);
        $file_type = $_FILES['profile']['type'];
        $file_size = $_FILES['profile']['size'];
        $image_width = $file_info[0];
        $image_height = $file_info[1];

        // Validate file type
        if (!in_array($file_type, $allowed_types)) {
            $this->form_validation->set_message('validate_image', 'Invalid file type. Allowed types: JPG, JPEG, PNG, GIF.');
            return FALSE;
        }

        // Validate file size
        if ($file_size > $max_size) {
            $this->form_validation->set_message('validate_image', 'Image size must not exceed 2MB.');
            return FALSE;
        }

        // Validate image dimensions
        if ($image_width > $max_width || $image_height > $max_height) {
            $this->form_validation->set_message('validate_image', "Image dimensions must not exceed {$max_width}x{$max_height} pixels.");
            return FALSE;
        }

        return TRUE;
    }
}
