<?php
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';


    if (empty($email) || empty($password) || empty($password_confirm)) {
        echo "<p class='text-danger'>All fields are required!</p>";
    } elseif ($password !== $password_confirm) {

        echo "<p class='text-danger'>Passwords do not match!</p>";
    } else {

        $stmt = $db_connection->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "<p class='text-danger'>Email already taken!</p>";
        } else {

            $stmt = $db_connection->prepare("INSERT INTO customers (email, password) VALUES (?, ?)");
            if ($stmt->execute([$email, $password])) {
                echo "<p class='text-success'>Registration successful! You can now log in.</p>";
            } else {
                echo "<p class='text-danger'>Error registering user!</p>";
            }
        }
    }
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Register</h2>
    <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirm" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
