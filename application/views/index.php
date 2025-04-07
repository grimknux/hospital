<?php $this->load->view('login_layouts/header'); ?>

<!-- Login Container -->
<div id="login-container">
    <!-- Login Header -->
    <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
        <i class="fa fa-cube"></i> <strong>Welcome to Hospital EMR</strong>
    </h1>
    <!-- END Login Header -->

    <!-- Login Block -->
    <div class="block animation-fadeInQuickInv">
        <!-- Login Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <a href="<?= base_url('register') ?>" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Create new account"><i class="fa fa-plus"></i></a>
            </div>
            <h2>Please Login</h2>
        </div>
        <!-- END Login Title -->

        <!-- Login Form -->
        <form id="user_login" action="index.html" method="post" class="form-horizontal">
            <div class="form-group login_email">
                <div class="col-xs-12">
                    <input type="text" id="login_email" name="login_email" class="form-control" placeholder="Your email..">
                    <div class="login_emailMessage valid-feedback"></div>
                </div>
            </div>
            <div class="form-group login_password">
                <div class="col-xs-12">
                    <input type="password" id="login_password" name="login_password" class="form-control" placeholder="Your password..">
                    <div class="login_passwordMessage valid-feedback"></div>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-xs-12 text-right">
                    <button type="submit" class="btn btn-effect-ripple btn-sm btn-primary"><i class="fa fa-check"></i> Login</button>
                </div>
            </div>
        </form>
        <!-- END Login Form -->
    </div>
    <!-- END Login Block -->

    <!-- Footer -->
    <footer class="text-muted text-center animation-pullUp">
        <small><span id="year-copy"></span> &copy; <a href="http://goo.gl/RcsdAh" target="_blank">AppUI 2.7</a></small>
    </footer>
    <!-- END Footer -->
</div>
<!-- END Login Container -->


<?php $this->load->view('login_layouts/footer'); ?>

<script>

$(document).ready(function() {
        
        $('#user_login').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: baseUrl + "user/login",
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
                            window.location.href = response.redirect_url;
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