<?php $this->load->view('login_layouts/header'); ?>
<div id="overlay">
    <div class="loader"></div>
</div>
<div id="login-container">
    <!-- Register Header -->
    <h1 class="h2 text-light text-center animation-slideDown">
        <i class="fa fa-plus"></i> <strong>Create Account</strong>
    </h1>
    <!-- END Register Header -->

    <!-- Register Form -->
    <div class="block animation-fadeInQuickInv">
        <!-- Register Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <a href="<?= base_url() ?>" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Back to login"><i class="fa fa-user"></i></a>
            </div>
            <h2>Register</h2>
        </div>
        <!-- END Register Title -->

        <!-- Register Form -->
        <form id="user_register" method="post" class="form-horizontal">
            <div class="form-group reg_firstname">
                <div class="col-xs-12">
                    <input type="text" id="reg_firstname" name="reg_firstname" class="form-control" placeholder="Firstname">
                    <div class="reg_firstnameMessage valid-feedback"></div>
                </div>
            </div>
            <div class="form-group reg_lastname">
                <div class="col-xs-12">
                    <input type="text" id="reg_lastname" name="reg_lastname" class="form-control " placeholder="Lastname">
                    <div class="reg_lastnameMessage valid-feedback"></div>
                </div>
            </div>
            <div class="form-group reg_email">
                <div class="col-xs-12">
                    <input type="text" id="reg_email" name="reg_email" class="form-control " placeholder="Email">
                    <div class="reg_emailMessage valid-feedback"></div>
                </div>
            </div>
            <div class="form-group reg_password">
                <div class="col-xs-12">
                    <input type="password" id="reg_password" name="reg_password" class="form-control reg_password" placeholder="Password">
                    <div class="reg_passwordMessage valid-feedback"></div>
                </div>
            </div>
            <div class="form-group reg_password_confirm">
                <div class="col-xs-12">
                    <input type="password" id="reg_password_confirm" name="reg_password_confirm" class="form-control reg_password_confirm" placeholder="Confirm Password">
                    <div class="reg_password_confirmMessage valid-feedback"></div>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-xs-12 text-right">
                    <button type="submit" class="btn btn-effect-ripple btn-success"><i class="fa fa-plus"></i> Create Account</button>
                </div>
            </div>
        </form>
        <!-- END Register Form -->
    </div>
    <!-- END Register Block -->

<?php $this->load->view('login_layouts/footer'); ?>


<script>
     $(document).ready(function() {
        
        $('#user_register').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);


            $.ajax({
                url: baseUrl + "user/register",
                type: 'POST',
                dataType: 'JSON',
                data: formData,
                processData: false,  // Prevent jQuery from processing FormData
                contentType: false,
                beforeSend: function(xhr) {
                    //xhr.setRequestHeader('X-CSRF-Token', csrfToken);

                },
                success: function(response) {
                    try {
                        if(response.success){
                            alert(response.message);
                            $('#user_register')[0].reset();
                            $('.has-error').removeClass('has-error');
                            $('.has-success').removeClass('has-success');
                            $('.invalid-feedback').empty();
                        }else{
                            if(response.formnotvalid){
                                handleValidationErrors(response.data);
                            }else{
                                alert(response.message);
                            }
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
            
        });

    });


    function handleValidationErrors(response) {
        // Reset validation messages
        $('.has-error').removeClass('has-error');
        $('.has-success').removeClass('has-success');
        $('.invalid-feedback').empty();
        
        // Iterate over the response object and display validation errors
        var hasErrors = false; // Flag to track if any errors are found

        console.log(response);
        for (var field in response) {
            if (response.hasOwnProperty(field)) {
                var error = response[field];

                if (error) {
                    var element = $('.' + field);
                    var messageElement = $('.' + field + 'Message');

                    element.addClass('has-error');
                    messageElement.addClass('text-danger').html(error);

                    hasErrors = true;
                } else {
                    var validElement = $('.' + field);
                    var validMessageElement = $('.' + field + 'Message');

                    validElement.removeClass('has-error');
                    validMessageElement.removeClass('invalid-feedback').empty();
                }
            }
        }
    }


</script>