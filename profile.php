<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (empty($email) || empty($name) || empty($lastname) || empty($address) || empty($phone)) {
        echo "<p class='text-danger'>All fields are required!</p>";
    } elseif ($password !== $password_confirm) {
        echo "<p class='text-danger'>Passwords do not match!</p>";
    } else {
        try {
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db_connection->prepare("UPDATE customers SET email = ?, name = ?, lastname = ?, address = ?, phone = ?, password = ? WHERE id = ?");
                $stmt->execute([$email, $name, $lastname, $address, $phone, $hashed_password, $_SESSION['user_id']]);
            } else {
                $stmt = $db_connection->prepare("UPDATE customers SET email = ?, name = ?, lastname = ?, address = ?, phone = ? WHERE id = ?");
                $stmt->execute([$email, $name, $lastname, $address, $phone, $_SESSION['user_id']]);
            }

            echo "<p class='text-success'>Profile updated successfully!</p>";
        } catch (PDOException $e) {
            echo "<p class='text-danger'>Error updating profile: " . $e->getMessage() . "</p>";
        }
    }
}

$stmt = $db_connection->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Your Profile</h2>
    <p>Check my orders <a href="my_orders.php">here</a></p>
    <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" >
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($user['name']?? '') ?>" >
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form-control" value="<?= htmlspecialchars($user['lastname']?? '') ?>" >
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="<?= htmlspecialchars($user['address']?? '') ?>" >
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($user['phone']?? '') ?>" >
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" >
        </div>
        <div class="mb-3">
            <label for="password_confirm" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control" >
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
    <br>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<?php include 'includes/footer.php'; ?>
