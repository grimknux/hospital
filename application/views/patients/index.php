<?php $this->load->view('layouts/header'); ?>
<!-- Get Started Block -->
<div id="overlay">
    <div class="loader"></div>
</div>
<div class="block full">
    <!-- Get Started Title -->
    <div class="block-title">
        <h2>Patient View</h2>
    </div>
    <?php if ($this->session->flashdata('success')): ?>
        <div id="success_message">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><strong>Success</strong></h4>
                        <p><?php echo $this->session->flashdata('success'); ?></p>
                    </div>
                    <!-- END Success Alert -->
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="table-responsive">
    <a href="<?php echo base_url('patient/add'); ?>"  class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Patient</a><br><br>
        <table class="table table-striped table-bordered table-vcenter" id="pattable">
            <thead class="thead-sm">
                <tr>
                    <th class="text-center" style="width: 5%; font:">ID</th>
                    <th class="text-center" style="width: 5%;">Profile Image</th>
                    <th class="text-center" style="width: 20%;">Name</th>
                    <th class="text-center" style="width: 5%;">Birthdate</th>
                    <th class="text-center" style="width: 5%;">Sex</th>
                    <th class="text-center" style="width: 5%;">Email</th>
                    <th class="text-center" style="width: 5%;">Phone</th>
                    <th class="text-center" style="width: 15%;">Actions</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($patients as $patient): ?>
                <tr>
                    <td class="text-center"><?php echo $patient['id']; ?></td>
                    <td class="text-center"><img src="<?= !empty($patient['profile_image']) ? base_url("uploads/" . $patient['profile_image']) : base_url("uploads/default/avatar.jpg") ?>" width="25"></td>
                    <td><?php echo $patient['firstname'] . " " . $patient['middlename'] . " " . $patient['lastname']; ?></td>
                    <td><?php echo ($patient['birthdate']!= '0000-00-00') ? date('F d, Y', strtotime($patient['birthdate'])) : 'No birthdate'; ?></td>
                    <td><?php echo ($patient['sex'] == "M") ? "Male" : (($patient['sex'] == "F") ? "Female" : "Unknown"); ?></td>
                    <td><?php echo $patient['email']; ?></td>
                    <td class="text-center"><?php echo $patient['phone']; ?></td>
                    <td class="text-center">
                    <div class="btn-group">
                        <button class="btn btn-success btn-xs" onclick="getPatientData(<?= $patient['id'] ?>)"><i class="fa fa-file-o"></i> View</button>
                        <a href="<?php echo base_url('patient/edit/'.$patient['id']); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</a>
                        <a href="<?php echo base_url('patient/delete/'.$patient['id']); ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>
                </div>
                    </td>
                </tr>
                <?php endforeach; ?>   
            </tbody>
            
        </table>
    </div>
</div>

<div id="patientViewModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong>Patient Details</strong></h3>
            </div>
            <div class="modal-body">
                <img id="patientProfile" src="" width="25" alt="Profile Image">
                <p><strong>Name:</strong> <span id="patientName"></span></p>
                <p><strong>Birthdate:</strong> <span id="patientBirthday"></span></p>
                <p><strong>Sex:</strong> <span id="patientSex"></span></p>
                <p><strong>Email:</strong> <span id="patientEmail"></span></p>
                <p><strong>Phone:</strong> <span id="patientPhone"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-effect-ripple btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- END Get Started Block -->

<?php $this->load->view('layouts/footer'); ?>

<script>

    $(document).ready(function() {
        UiTables.init(); // Initialize DataTable correctly
    });
    
    function getPatientData(id){
        $("#overlay").show();
            $.ajax({
                url: baseUrl + "patient/editpatient/" + id,
                type: 'GET',
                beforeSend: function(xhr) {
                    //xhr.setRequestHeader('X-CSRF-Token', csrfToken);

                },
                success: function(response) {
                    try {
                        if(response.success){
                            $("#patientProfile").attr("src", response.profile);
                            $("#patientName").text(response.name);
                            $("#patientBirthday").text(response.birthday);
                            $("#patientSex").text(response.sex);
                            $("#patientEmail").text(response.emailadd);
                            $("#patientPhone").text(response.phonenum);
                            $("#patientViewModal").modal("show");
                        }else{
                            alert(response.message);
                        }
                    } catch (error) {
                        console.error("Error processing response:", error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred during the AJAX request:", error);
                },
                complete: function() {
                    $("#overlay").hide();
                }
            });
        }
    setTimeout(() => {
        $('#validation_error').html('').hide();
        $('#success_message').html('');
    }, 3000);
</script>