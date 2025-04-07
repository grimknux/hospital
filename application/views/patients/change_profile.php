<!DOCTYPE html>
<html>
<head>
    <title>Change Profile Image</title>
</head>
<body>
    <h2>Change Profile Image</h2>
    <div id="validation_error" style="color:red;">
    <?php echo validation_errors(); ?>
    </div>
    <?php echo form_open('patient/change_profile/'.$patient['id']); ?>

    <label>Profile Image:</label>
    <input type="file" name="profile" accept="image/*"><br>

    <button type="submit">Submit</button>
    <a href="<?php echo base_url(); ?>">Exit</a>

    <?php echo form_close(); ?>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
<script>
    setTimeout(() => {
        $('#validation_error').html('').hide();
    }, 3000);
</script>