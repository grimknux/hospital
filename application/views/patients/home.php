<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<html>
    <head>
        <title>Test Hospital</title>
    </head>
    <body>
        <div>
            <table border="1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($patient as $pat): ?>
                    <tr>
                        <td><?= $pat['name'] ?></td>
                        <td><?= $pat['email'] ?></td>
                        <td><?= $pat['phone'] ?></td>
                        <td></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>