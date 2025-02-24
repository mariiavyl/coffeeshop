<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/db.php';
include 'includes/header.php';

$tables = ['products', 'customers', 'orders', 'order_items']; 
?>

<div class="container mt-4">
    <h2 class="text-center text-danger">Admin Panel</h2>
    <ul class="nav nav-tabs">
        <?php foreach ($tables as $table): ?>
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['table']) && $_GET['table'] == $table ? 'active' : '' ?>" href="?table=<?= $table ?>"><?= ucfirst($table) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php
    if (isset($_GET['table']) && in_array($_GET['table'], $tables)) {
        $table = $_GET['table'];
        echo "<h3 class='mt-3'>Table: " . ucfirst($table) . "</h3>";

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $stmt = $db_connection->prepare("DELETE FROM $table WHERE id = ?");
            $stmt->execute([$id]);
            echo "<p class='text-danger'>Record deleted!</p>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'] ?? 0;
            unset($_POST['id']);

            if (isset($_POST['image_url'])) {
                $_POST['image_url'] = filter_var($_POST['image_url'], FILTER_VALIDATE_URL) ? $_POST['image_url'] : '';
            }

            if ($table == 'products') {
                if (isset($_POST['category'])) {
                    $_POST['category'] = in_array($_POST['category'], ['coffee', 'coffee_maker']) ? $_POST['category'] : 'coffee';
                }
                if (!isset($_POST['brand'])) {
                    $_POST['brand'] = '';
                }
            }

            $columns = array_keys($_POST);
            $values = array_values($_POST);

            if ($id) {
                $update = implode(", ", array_map(fn($col) => "$col = ?", $columns));
                $sql = "UPDATE $table SET $update WHERE id = ?";
                $values[] = $id;
            } else {
                $placeholders = implode(", ", array_fill(0, count($columns), "?"));
                $sql = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES ($placeholders)";
            }

            $stmt = $db_connection->prepare($sql);
            if ($stmt->execute($values)) {
                echo "<p class='text-success'>Record saved!</p>";
            } else {
                echo "<p class='text-danger'>Error saving record.</p>";
            }
        }

        $stmt = $db_connection->query("SELECT * FROM $table");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<table class="table table-bordered mt-3"><tr>';
        foreach (array_keys($rows[0] ?? []) as $column) {
            echo "<th>{$column}</th>";
        }
        echo '<th>Actions</th></tr>';

        foreach ($rows as $row) {
            echo '<tr>';
            echo '<form method="post"><input type="hidden" name="id" value="' . $row['id'] . '">';

            foreach ($row as $key => $value) {
                $value = htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
                if ($key == 'image_url') {
                    echo '<td><input type="url" class="form-control" name="' . $key . '" value="' . $value . '" placeholder="Enter image URL"></td>';
                } elseif ($key == 'category' && $table == 'products') {
                    echo '<td>
                        <select class="form-control" name="category">
                            <option value="coffee"' . ($value == 'coffee' ? ' selected' : '') . '>Coffee</option>
                            <option value="coffee_maker"' . ($value == 'coffee_maker' ? ' selected' : '') . '>Coffee Maker</option>
                        </select>
                    </td>';
                } elseif ($key == 'brand' && $table == 'products') {
                    echo '<td><input type="text" class="form-control" name="brand" value="' . $value . '" placeholder="Enter brand"></td>';
                } else {
                    echo '<td><input type="text" class="form-control" name="' . $key . '" value="' . $value . '"></td>';
                }
            }

            echo '<td>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
                <a href="?table=' . $table . '&delete=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a>
            </td></form>';
            echo '</tr>';
        }

        echo '<tr><form method="post">';
        foreach (array_keys($rows[0] ?? []) as $column) {
            if ($column == 'image_url') {
                echo '<td><input type="url" class="form-control" name="' . $column . '" placeholder="Enter image URL"></td>';
            } elseif ($column == 'category' && $table == 'products') {
                echo '<td>
                    <select class="form-control" name="category">
                        <option value="coffee">Coffee</option>
                        <option value="coffee_maker">Coffee Maker</option>
                    </select>
                </td>';
            } elseif ($column == 'brand' && $table == 'products') {
                echo '<td><input type="text" class="form-control" name="brand" placeholder="Enter brand"></td>';
            } else {
                echo '<td><input type="text" class="form-control" name="' . $column . '" placeholder="' . $column . '"></td>';
            }
        }
        echo '<td><button type="submit" class="btn btn-primary btn-sm">Add</button></td></form></tr>';
        echo '</table>';
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>
