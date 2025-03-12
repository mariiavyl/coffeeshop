<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/db.php';
include 'includes/header.php';

$tables = ['products', 'customers', 'orders', 'order_items']; 
?>
<!--Body start-->
<body class="bg-gray-100">
<div class=" flex flex-col h-screen justify-between">
<?php include 'navbar.php'?>

<div class="w-full mt-4 px-4 mb-4">
    <h2 class="text-center text-3xl font-semibold text-danger mb-6">Admin Panel</h2>
    <ul class="flex space-x-4 justify-center mb-4">
        <?php foreach ($tables as $table): ?>
            <li class="nav-item">
                <a class="nav-link px-4 py-2 text-lg <?= isset($_GET['table']) && $_GET['table'] == $table ? 'bg-blue-600 text-white rounded-lg' : 'text-gray-700 hover:bg-gray-200 rounded-lg' ?>" href="?table=<?= $table ?>"><?= ucfirst($table) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php
    if (isset($_GET['table']) && in_array($_GET['table'], $tables)) {
        $table = $_GET['table'];
        echo "<h3 class='text-2xl font-semibold mb-3'>Table: " . ucfirst($table) . "</h3>";

        if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $stmt = $db_connection->prepare("DELETE FROM $table WHERE id = ?");
            $stmt->execute([$id]);
        
            echo '<div id="delete-notification" class="fixed bottom-4 right-4 p-4 bg-red-600 text-white shadow-lg rounded-lg">
            Record deleted
            </div>';
           echo "<script>
               setTimeout(() => {
               document.getElementById('delete-notification').remove();
               window.location.href = '?table=$table';}
               , 3000);
               </script>";
        }


        

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'] ?? 0;
            unset($_POST['id']);

            if (isset($_POST['image_url'])) {
                $_POST['image_url'] = filter_var($_POST['image_url'], FILTER_VALIDATE_URL) ? $_POST['image_url'] : '';
            }

            // Убираем столбец price_alv, если он есть
            if (isset($_POST['price_alv'])) {
                unset($_POST['price_alv']);
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
                echo '<div id="save-notification" class="fixed bottom-4 right-4 p-4 bg-green-600 text-white rounded-lg shadow-lg">
                Record saved
                </div>';
                echo "<script>
                setTimeout(() => {
                    document.getElementById('save-notification').remove();
                }, 3000);
                </script>";
            } else {
                echo '<div id="error-notification" class="fixed bottom-4 right-4 p-4 bg-green-600 text-white rounded-lg shadow-lg">
                Error saving record
                </div>';
                echo "<script>
                    setTimeout(() => {
                    getElementById('error-notification').remove();
                    }, 3000);
                </script>";
            }
        }

        $stmt = $db_connection->query("SELECT * FROM $table");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        

        echo '<div class="overflow-x-auto mb-6"><table class="min-w-full table-auto border-separate border-spacing-0 border border-gray-300"><thead>';
        echo '<tr class="bg-gray-100">';
        foreach (array_keys($rows[0] ?? []) as $column) {
            echo "<th class='px-4 py-2 border-b border-gray-200 text-left text-sm font-medium text-gray-700'>{$column}</th>";
        }
        echo '<th class="px-4 py-2 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Actions</th>';
        echo '</tr></thead><tbody>';

        foreach ($rows as $row) {
            echo '<tr class="hover:bg-gray-50">';
            echo '<form method="post"><input type="hidden" name="id" value="' . $row['id'] . '">';

            foreach ($row as $key => $value) {
                $value = htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
                $inputClass = in_array($key, ['id', 'price', 'quantity']) ? 'w-24' : 'w-full';

                if ($key == 'image_url') {
                    echo '<td class="px-4 py-2 border-b border-gray-200"><input type="url" class="form-input ' . $inputClass . '" name="' . $key . '" value="' . $value . '" placeholder="Enter image URL"></td>';
                } elseif ($key == 'category' && $table == 'products') {
                    echo '<td class="px-4 py-2 border-b border-gray-200"><select class="form-select ' . $inputClass . '" name="category">
                        <option value="coffee"' . ($value == 'coffee' ? ' selected' : '') . '>Coffee</option>
                        <option value="coffee_maker"' . ($value == 'coffee_maker' ? ' selected' : '') . '>Coffee Maker</option>
                    </select></td>';
                } elseif ($key == 'brand' && $table == 'products') {
                    echo '<td class="px-4 py-2 border-b border-gray-200"><input type="text" class="form-input ' . $inputClass . '" name="brand" value="' . $value . '" placeholder="Enter brand"></td>';
                } else {
                    echo '<td class="px-4 py-2 border-b border-gray-200"><input type="text" class="form-input ' . $inputClass . '" name="' . $key . '" value="' . $value . '"></td>';
                }
            }

            echo '<td class="px-4 py-2 border-b border-gray-200">


<button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium py-1 px-3 rounded text-sm">Save</button>
<a href="?table=' . $table . '&delete=' . $row['id'] . '" class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded text-sm">Delete</a>


            </td></form>';
            echo '</tr>';
        }

        echo '</tbody></table></div>';

        echo '<div class="overflow-x-auto"><table class="min-w-full table-auto border-separate border-spacing-0 border border-gray-300"><tbody><tr>';
        echo '<form method="post">';
        foreach (array_keys($rows[0] ?? []) as $column) {
            $inputClass = in_array($column, ['id', 'price', 'quantity']) ? 'w-24' : 'w-full';
            if ($column == 'image_url') {
                echo '<td class="px-4 py-2 border-b border-gray-200"><input type="url" class="form-input ' . $inputClass . '" name="' . $column . '" placeholder="Enter image URL"></td>';
            } elseif ($column == 'category' && $table == 'products') {
                echo '<td class="px-4 py-2 border-b border-gray-200"><select class="form-select ' . $inputClass . '" name="category">
                        <option value="coffee">Coffee</option>
                        <option value="coffee_maker">Coffee Maker</option>
                    </select></td>';
            } elseif ($column == 'brand' && $table == 'products') {
                echo '<td class="px-4 py-2 border-b border-gray-200"><input type="text" class="form-input ' . $inputClass . '" name="brand" placeholder="Enter brand"></td>';
            } else {
                echo '<td class="px-4 py-2 border-b border-gray-200"><input type="text" class="form-input ' . $inputClass . '" name="' . $column . '" placeholder="' . $column . '"></td>';
            }
        }
        echo '<td class="px-4 py-2 border-b border-gray-200"><button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium py-1 px-3 rounded text-sm">Add</button></td></form>';
        echo '</tr></tbody></table></div>';
    }
    ?>
    <script src="https://cdn.tailwindcss.com"></script>
</div>

<?php include 'includes/footer.php'; ?>
</div>