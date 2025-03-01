<?php 
require_once("signupConfig.php");
$data = new signupConfig();
$all = $data->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Records List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    table td,
    table th {
        text-align: center;
        vertical-align: middle;
    }
</style>

<body>
    <div class="container mt-5 text-center">
        <h2 class="text-center">List of all records</h2>
        <button class="btn btn-primary m-3 mb-4" data-bs-toggle="modal" data-bs-target="#addModal">Add New</button>
        <table class="table table-striped">
            <thead class="bg-dark text-white">
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
            foreach($all as $key => $val) {
            ?>
            
                <tr>
                    <td><?= $val['firstName'];?></td>
                    <td><?= $val['lastName'];?></td>
                    <td><?= $val['address'];?></td>
                    <td>
                    <a href="delete.php?id=<?= $val['id'] . '&req=delete'; ?>" class="btn btn-danger">DELETE</a>

                   <button type="button" class="btn btn-warning edit-btn" 
                   data-id="<?= $val['id'];?>"
                   data-firstName="<?= $val['firstName'];?>"
                   data-lastName="<?= $val['lastName'];?>"
                   data-address="<?= $val['address'];?>">
                   EDIT
            </button>

                    </td>
                </tr>
                <?php
            }
                ?>
            </tbody>
        </table>
    </div>

        <!-- Modal -->
<?php include "modal.php"?>

    <!-- Modal for Editing -->
<?php include "edit.php"?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>