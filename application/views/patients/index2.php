<!DOCTYPE html>
<html>
<head>
    <title>View Patient</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap4.css">

    <style>
        .text-center{
            text-align: center;
        }
    </style>
</head>
<body>


    <h2>Patients List</h2>
    <?php if ($this->session->flashdata('success')): ?>
        <p id="message" style="color: green;"><?php echo $this->session->flashdata('success'); ?></p>
    <?php endif; ?>
    <a href="<?php echo base_url('patient/add'); ?>" class="btn btn-primary btn-sm">Add New Patient</a>
    <table border="1" id="pattable">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">ID</th>
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
                    <a href="<?php echo base_url('patient/edit/'.$patient['id']); ?>">Edit</a> |
                    <a href="<?php echo base_url('patient/delete/'.$patient['id']); ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>   
        </tbody>
        
    </table>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap4.js"></script>
<script>
   $(document).ready(function() {
        new DataTable('#pattable'); // Initialize DataTable correctly
    });
    setTimeout(() => {
        $('#validation_error').html('').hide();
    }, 3000);
</script>