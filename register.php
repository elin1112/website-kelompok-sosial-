<?php
include('./header.php');
include('./config.php'); // File koneksi ke database

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password

    // Periksa apakah username sudah ada
    $checkUser = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        $error = "Username sudah digunakan!";
    } else {
        // Simpan user ke database
        $stmt = $conn->prepare("INSERT INTO users (username, password, name, alamat) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $name, $alamat);

        if ($stmt->execute()) {
            header("Location: login.php?success=1"); // Redirect ke login setelah berhasil
            exit();
        } else {
            $error = "Gagal mendaftarkan akun!";
        }
        $stmt->close();
    }
    $checkUser->close();
}
?>

<div class="container d-flex justify-content-center align-items-center vh-100" style="margin-top: 150px; margin-bottom : 20px">
    <div class="card shadow p-4" style="width: 400px;">
        <h4 class="text-center mb-4">Register</h4>

        <?php if (isset($error)) {
            echo '<div class="alert alert-danger text-center">' . $error . '</div>';
        } ?>

        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" name="register" class="btn btn-success w-100">Register</button>
        </form>

        <p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</div>

<?php include('./footer.php'); ?>