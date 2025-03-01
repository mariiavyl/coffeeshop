<?php

class View {
    public static function show_all($users) {
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<div class="container mt-4">';
        echo '<a href="index.php?action=add" class="btn btn-primary mb-3">Add new</a>';
        echo '<table class="table table-bordered table-striped">';
        echo '<thead class="table-dark">';
        echo '<tr><th>User ID</th><th>First Name</th><th>Last Name</th><th>Edit</th><th>Delete</th></tr>';
        echo '</thead><tbody>';

        foreach ($users as $user) {
            echo "<tr>
                <td>{$user['user_id']}</td>
                <td>{$user['first_name']}</td>
                <td>{$user['last_name']}</td>
                <td><a href='index.php?action=edit&id={$user['user_id']}' class='btn btn-warning btn-sm'>Edit</a></td>
                <td><a href='index.php?action=delete&id={$user['user_id']}' class='btn btn-danger btn-sm'>Delete</a></td>
            </tr>";
        }

        echo '</tbody></table>';
        echo '</div>';
    }

    public static function new_page() {
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<div class="container mt-4">';
        echo '<h2>Add New User</h2>
            <form method="POST" action="index.php" class="mt-3">'
            . '<input type="hidden" name="action" value="add">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>';
        echo '</div>';
    }

    public static function edit_page($user) {
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<div class="container mt-4">';
        echo '<h2>Edit User</h2>
            <form method="POST" action="index.php" class="mt-3">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="' . htmlspecialchars($user['user_id']) . '">
            <div class="mb-3">
                <label class="form-label">First Name</label> 
                <input type="text" name="first_name" class="form-control" value="' . htmlspecialchars($user['first_name']) . '" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="' . htmlspecialchars($user['last_name']) . '" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>';
        echo '</div>';
    }
}

?>
