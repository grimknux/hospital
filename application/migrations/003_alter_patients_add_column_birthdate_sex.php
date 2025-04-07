<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_patients_add_column_birthdate_sex extends CI_Migration
{

    public function up(){
    
        $fields = array(
            'birthdate' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'sex' => array(
                'type' => 'CHAR',
                'constraint' => 1,
                'null' => FALSE
            ),
        );
    
        $this->dbforge->add_column('patients', $fields);
    }

    public function down(){

        $this->dbforge->drop_column('patients', 'birthdate');
        $this->dbforge->drop_column('patients', 'sex');
    }

    

}

