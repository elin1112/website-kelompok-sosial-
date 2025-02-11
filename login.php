<?php
session_start();
include('./header.php');
include('./config.php'); // File koneksi ke database

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query untuk mengambil data user
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password yang di-hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: index.php"); // Redirect ke dashboard setelah login
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
    $stmt->close();
}
?>

<div class="container d-flex justify-content-center align-items-center vh-100" style="margin-top: 150px; margin-bottom: 40px;">
    <div class="card shadow p-4" style="width: 350px;">
        <h4 class="text-center mb-4">Login</h4>
        <?php if (isset($error)) {
            echo '<div class="alert alert-danger text-center">' . $error . '</div>';
        } ?>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="<?= $baseUrl; ?>register.php">Daftar di sini</a></p>
    </div>
</div>

<?php include('./footer.php'); ?>