
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
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
