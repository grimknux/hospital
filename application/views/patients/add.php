
<?php $this->load->view('layouts/header'); ?>
<div class="row">
    <div class="col-sm-8">
        <div class="block full">
        <!-- Get Started Title -->
            <div class="block-title">
                <h2>Add Patient</h2>
            </div>
            
            <?php echo form_open_multipart('patient/add'); ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="firstname">Firstname</label>
                        <input type="text" name="firstname" class="form-control input-sm" value="<?php echo set_value('firstname'); ?>">
                        <span class="text-danger validation_error"><?= form_error('firstname'); ?></span>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="middlename">Middlename</label>
                        <input type="text" name="middlename" class="form-control input-sm" value="<?php echo set_value('middlename'); ?>">
                        <span class="text-danger validation_error"><?= form_error('middlename'); ?></span>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="lastname">Lastname</label>
                        <input type="text" name="lastname" class="form-control input-sm" value="<?php echo set_value('lastname'); ?>">
                        <span class="text-danger validation_error"><?= form_error('lastname'); ?></span>
                    </div>
                </div>
            </div>
           
            
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="birthdate">Birthdate</label>
                        <input type="date" name="birthdate" class="form-control input-sm" value="<?php echo set_value('birthdate'); ?>">
                        <span class="text-danger validation_error"><?= form_error('birthdate'); ?></span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label" for="sex">Sex</label>
                        <select id="sex" name="sex" class="select-chosen" data-placeholder="Choose a Sex.." style="width: 250px;">
                            <option value="" <?= set_select('sex', ''); ?>>Select Sex</option>
                            <option value="M" <?= set_select('sex', 'M'); ?>>Male</option>
                            <option value="F" <?= set_select('sex', 'F'); ?>>Female</option>
                        </select><br>
                        <span class="text-danger validation_error"><?= form_error('sex'); ?></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="email">Email</label>
                        <input type="text" name="email" class="form-control input-sm" value="<?php echo set_value('email'); ?>">
                        <span class="text-danger validation_error"><?= form_error('email'); ?></span>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control input-sm" value="<?php echo set_value('phone'); ?>">
                        <span class="text-danger validation_error"><?= form_error('phone'); ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="profile">Profile Image</label>
                        <input type="file" name="profile" class="form-control input-sm">
                        <span class="text-danger validation_error"><?= form_error('profile'); ?></span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            <a href="<?php echo base_url(); ?>" class="btn btn-warning btn-sm">Exit</a>
           
            

            <?php echo form_close(); ?>
        </div>
    </div>
</div>



<?php $this->load->view('layouts/footer'); ?>
<script>
</script>