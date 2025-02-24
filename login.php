<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db_connection->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password == $user['password']) { 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        header('Location: profile.php');
        exit;
    } else {
        $error = "Invalid login or password!";
    }
}
?>

<div class="container mt-4">
    <h2 class="text-center">Login</h2>
    <form method="post" autocomplete="off">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Login</button>
    </form>
    <?php if (isset($error)) { echo "<div class='text-danger mt-3'>$error</div>"; } ?>
    <br>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</div>

<?php include 'includes/footer.php'; ?>
