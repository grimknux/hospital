<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('Patient_model');
    }
    /**
     * @OA\Get(
     *     path="/api/v1/patients",
     *     summary="This will return all patients",
     *     tags={"Patient"},
     *     security={{"basicAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved patients",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Patient")
     *         )
     *     ), 
     *     @OA\Response(
     *         response=400,
     *         description="Failed to load patients",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */


     public function all() {

        $patient = $this->Patient_model->get_all_patients();


        if($patient){
            $response = $patient;
            $status_code = 200;
        }else{
            $response = [
                'message' => 'Error retrieving patients'
            ];
            $status_code = 400;
        }
        
        return $this->output
        ->set_status_header($status_code)
        ->set_content_type('application/json')
        ->set_output(json_encode($response));

    }

    /**
     * @OA\Post(
     *     tags={"Patient"}, 
     *     path="/api/v1/patient", 
     *     security={{"BasicAuth": {}}},
     *     summary="Create a new patient", 
     *     @OA\RequestBody( 
     *         required=true, 
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ), 
     *     @OA\Response( 
     *         response=200, 
     *         description="Successfully created patient", 
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ), 
     *     @OA\Response(
     *         response=400, 
     *         description="Invalid request. Patient creation failed",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ), 
     *     @OA\Response(
     *         response=500, 
     *         description="Error creating patient",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ) 
     * )
     */


    public function create(){
        
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if ($data) {
            $data['created_at'] = date('Y-m-d H:i:s');
        
            if($this->Patient_model->insert_patient($data)){
                $response = [
                    'message' => 'Successfully created patient'
                ];
                $status_code = 201;
            }else{
                $response = [
                    'message' => 'Error creating patient'
                ];
                $status_code = 500;
            }
        } else {
            $response = [
                'message' => 'Invalid request. Patient creation failed'
            ];
            $status_code = 400;
        }

        return $this->output
        ->set_status_header($status_code)
        ->set_content_type('application/json')
        ->set_output(json_encode($response));

    }

    /**
     * @OA\Post(
     *   tags={"Patient"}, 
     *   path="/api/v1/patient/update/{id}", 
     *   security={{"BasicAuth": {}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient ID",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *   summary="Update a patient", 
     *   @OA\RequestBody( 
     *     required=true, 
     *     @OA\JsonContent(ref="#/components/schemas/Patient")
     *   ), 
     *   @OA\Response( 
     *     response=200, 
     *     description="Patient updated successfully", 
     *     @OA\JsonContent(
     *          type="object",
     *           @OA\Property(property="message", type="string")
     *      )
     *   ), 
     *   @OA\Response(
     *     response=400, 
     *     description="Invalid request. Error retrieving patient",
     *     @OA\JsonContent(
     *          type="object",
     *           @OA\Property(property="message", type="string")
     *      )
     *   ), 
     *   @OA\Response(
     *     response=500, 
     *     description="Error updating patient",
     *     @OA\JsonContent(
     *          type="object",
     *           @OA\Property(property="message", type="string")
     *      )
     *   )
     * )
     */


    public function update($id)
    {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if ($data) {

            $patient = $this->Patient_model->get_patient_by_id($id);

            if($patient){
                $data['created_at'] = date('Y-m-d H:i:s');

                if ($this->Patient_model->update_patient($id, $data)) {
                    $response = [
                        'message' => 'Patient Updated Successfully'
                    ];
                    $status_code = 200; // OK
                } else {
                    $response = [
                        'message' => 'Error updating patient'
                    ];
                    $status_code = 500; // Internal Server Error
                }
            }else{
                $response = [
                    'message' => 'Patient not found'
                ];
                $status_code = 404; // Internal Server Error
            }

        } else {
            $response = [
                'message' => 'Error occurred retrieving patient'
            ];
            $status_code = 400; // Bad Request
        }

        return $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    /**
     * @OA\DELETE(
     *     tags={"Patient"}, 
     *     path="/api/v1/patient/delete/{id}", 
     *     security={{"BasicAuth": {}}},
     *     summary="Delete a patient",  
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Patient ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Patient Constraints",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */


    public function delete($id){
        
        $patient = $this->Patient_model->get_patient_by_id($id);

		if($patient){
			if($this->Patient_model->delete_patient($id)){
                $response = [
                    'message' => 'Patient deleted successfully'
                ];
                $status_code = 200; // Internal Server Error
            }else{
                $response = [
                    'message' => 'Failed to delete patient'
                ];
                $status_code = 409; // Internal Server Error
            }
		}else{
            $response = [
                'message' => 'Patient does not exists'
            ];
            $status_code = 404; // Internal Server Error
        }

        return $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json')
            ->set_output(json_encode($response));

    }



    /**
     * @OA\Get( 
     *     tags={"Patient"},
     *     path="/api/v1/patient/{id}", 
     *     summary="This will return patient based on patient ID",
     *     security={{"BasicAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Patient ID",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved patient",
     *         @OA\JsonContent(ref="#/components/schemas/Patient") 
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid Patient Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    
    public function read($id){

        if(!empty($id)){

            $patient = $this->Patient_model->get_patient_by_id($id);

            if(!empty($patient)){
                $response = $patient;
                $status_code = 200;
            }else{
                $response = [
                    'message' => 'Patient does not exists'
                ];
                $status_code = 404;
            }

        }else{
            $response = [
                'message' => 'Patient ID empty'
            ];
            $status_code = 400;
        }

        return $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }



     /**
     * @OA\Schema(
     *     title="Patient model",
     *     description="Patient model",
     *     schema="Patient",
     *     @OA\Property(property="firstname", type="string", description="Patient Firstname"), 
     *     @OA\Property(property="middlename", type="string", description="Patient Middlename"), 
     *     @OA\Property(property="lastname", type="string", description="Patient Lastname"), 
     *     @OA\Property(property="birthdate", type="string", format="date", description="Patient Birthdate"), 
     *     @OA\Property(property="sex", type="string", description="Patient Sex"), 
     *     @OA\Property(property="email", type="string", description="Patient Email"), 
     *     @OA\Property(property="phone", type="string", description="Patient Phone"), 
     *     @OA\Property(property="profile_image", type="string", description="Profile Image"), 
     *     required={"id", "firstname", "middlename", "lastname", "birthdate", "sex", "email", "phone"} 
     * )
     */
}