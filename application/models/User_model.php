<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{

    private $table = 'users';

    public function __construct(){

        parent::__construct();
        $this->load->database();
    }

    public function insert_user($data){
        return $this->db->insert($this->table, $data); 
    }

    public function get_all_users(){
        return $this->db->get($this->table)->result_array();     
    }

    public function get_user_by_id($id){
        return $this->db->get_where($this->table, ['id' => $id])->row_array();     
    }

    public function get_user_by_email_password($email,$password){
        $query = $this->db
                    ->where('email', $email)  // Example: Add another WHERE condition
                    ->get($this->table);
        return [
            'num_rows' => $query->num_rows(),
            'data' => $query->row_array(),
        ];
        
    }

    public function get_user_by_email_($email) {
        $query = $this->db->where('email', $email)->get($this->table);
    
        if ($query->num_rows() > 0) {
            return [
                'email' => true,
                'data' => $query->row_array(),
            ];
        }
    
        // If no user is found, return a consistent response
        return [
            'email' => false,
            'data' => null,
        ];
    }

    public function update_user($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delet_user($id){
        return $this->db->delete($this->table, ['id' => $id]);     
    }

}