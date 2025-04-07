<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model
{

    private $table = 'patients';

    public function __construct(){

        parent::__construct();
        $this->load->database();
    }

    public function get_patient_list(){
        $query = $this->db->query("
                    SELECT
                        id,
                        firstname,
                        middlename,
                        lastname,
                        birthdate,
                        sex,
                        phone,
                        email
                    FROM patients
                ");

        return $query->result_array();
    }

    public function get_patient_list_all(){
        $this->db->select("
                    id,
                    firstname,
                    middlename,
                    lastname,
                    birthdate,
                    sex,
                    phone,
                    email
                ");
        $this->db->from($this->table);
        return $this->db->get()->result_array();

    }

    public function insert_patient($data){
        return $this->db->insert($this->table, $data); 
    }

    public function get_all_patients(){
        return $this->db->get($this->table)->result_array();     
    }

    public function get_patient_by_id($id){
        return $this->db->get_where($this->table, ['id' => $id])->row_array();     
    }

    public function update_patient($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete_patient($id){
        return $this->db->delete($this->table, ['id' => $id]);     
    }

    public function get_patient_by_id_email($id,$email){
        $query = $this->db
                    ->where('id !=', $id)  // Exclude this ID
                    ->where('email', $email)  // Example: Add another WHERE condition
                    ->get($this->table);

        return $query->num_rows();
    }

}