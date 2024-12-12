<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    session_start();
    include('connection.php'); // Include database connection

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
    ?>

    <div class="container-fluid">
        <?php include('header.php'); // Menyertakan header.php ?>
        <div class="row">
            <div class="col-md-3 bg-light sidebar">
                <div class="profile-pic text-center mt-4">
                    <img src="<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto Profil" style="width:100px; height:auto; border-radius:50%;">
                    <h4><?php echo htmlspecialchars($_SESSION['nama']); ?></h4>
                </div>
                <nav class="nav flex-column mt-4">
                    <a class="nav-link active" href="admin.php?hal=dashboard">Dashboard</a>
                    <a class="nav-link" href="admin.php?hal=viewMhs">Data Mahasiswa</a>
                    <a class="nav-link" href="admin.php?hal=addMhs">Tambah Mahasiswa</a>
                    <a class="nav-link" href="admin.php?hal=editProfile">Sunting Profil Pengguna</a>
                </nav>
            </div>
            <div class="col-md-9">
                <main class="content">
                    <h2 class="text-center mt-4">Welcome to the Admin Dashboard</h2>
                    <div class="content mt-4">
                        <p>Here you can manage users, view statistics, and configure settings.</p>
                    </div>
                    <div id="contentArea" class="mt-4">
                        <?php
                        if (isset($_GET['hal'])) {
                            $hal = $_GET['hal'];
                            $allowed_pages = ['dashboard', 'viewMhs', 'addMhs', 'editMhs', 'editProfile'];
                            if (in_array($hal, $allowed_pages)) {
                                include "$hal.php";
                            } else {
                                echo "<div class='alert alert-danger'>Halaman tidak ditemukan.</div>";
                            }
                        } else {
                            include "dashboard.php"; // Halaman default
                        }
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <?php include('footer.php'); // Menyertakan footer.php ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>