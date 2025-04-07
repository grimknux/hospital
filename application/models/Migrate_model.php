<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate_model extends CI_Model
{

    private $table = 'migrations';

    public function __construct(){

        parent::__construct();
        $this->load->database();
    }


    public function get_latest_migration(){
        $query = $this->db->get('migrations')->row();
        return $query->version;
    }
}