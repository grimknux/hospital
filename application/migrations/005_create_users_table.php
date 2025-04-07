<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users_table extends CI_Migration
{

    public function up() {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],

            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
            ],

            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
            ],
            
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'unique' => TRUE,
            ],
            
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],

        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
        
    }

}

