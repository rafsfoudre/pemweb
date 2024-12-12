<?php
include('connection.php'); // Include database connection

// Cek apakah sesi sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Mulai sesi hanya jika belum dimulai
}

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: signin.php');
    exit();
}

// Ambil data pengguna dari database
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM user WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<div class='alert alert-danger'>User  not found.</div>";
    exit();
}

// Proses update data jika formulir disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Proses upload gambar
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar adalah gambar yang sebenarnya
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check === false) {
        echo "File yang di-upload bukan gambar.";
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($_FILES["foto"]["size"] > 500000) { // 500 KB
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Cek format file
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Jika semua cek lulus, upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Update data pengguna di database
            $stmt = $conn->prepare("UPDATE user SET nama=?, username=?, password=?, foto=? WHERE username=?");
            $stmt->bind_param("sssss", $nama, $username, $password, $target_file, $username);
            // Simpan jalur relatif
            $target_file = 'uploads/' . basename($_FILES["foto"]["name"]);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Profil berhasil diperbarui!</div>";
                $_SESSION['nama'] = $nama; // Update nama di session
                $_SESSION['foto'] = $target_file; // Update foto di session
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "Maaf, terjadi kesalahan saat meng-upload file.";
        }
    }
}
?>

<div>
    <h3>Sunting Profil Pengguna</h3>
    <form action="admin.php?hal=editProfile" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['nama']; ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="foto">Foto Profil:</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto profil.</small>
        </div>
        <button type="submit" class="btn btn-primary">Update Profil</button>
    </form>
</div>