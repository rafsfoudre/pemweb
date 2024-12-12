<?php
include('connection.php'); // Include database connection

// Check if NIM is provided
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Fetch current data
    $stmt = $conn->prepare("SELECT * FROM mhs WHERE nim=?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>No record found.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>NIM not provided.</div>";
    exit();
}

// Update data if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaMhs = $_POST['namaMhs'];
    $angkatan = $_POST['angkatan'];
    $kodeProdi = $_POST['kodeProdi'];

    // Update the student data in the database
    $stmt = $conn->prepare("UPDATE mhs SET namaMhs=?, angkatan=?, kodeProdi=? WHERE nim=?");
    $stmt->bind_param("ssss", $namaMhs, $angkatan, $kodeProdi, $nim);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Data mahasiswa berhasil diperbarui!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close(); // Close the statement
}

// Form to edit student data
?>
<div>
    <h3>Edit Mahasiswa</h3>
    <form action="admin.php?hal=editMhs&nim=<?php echo $nim; ?>" method="POST">
        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $row['nim']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="namaMhs">Nama Mahasiswa:</label>
            <input type="text" class="form-control" id="namaMhs" name="namaMhs" value="<?php echo $row['namaMhs']; ?>" required>
        </div>
        <div class="form-group">
            <label for="angkatan">Angkatan:</label>
            <input type="text" class="form-control" id="angkatan" name="angkatan" value="<?php echo $row['angkatan']; ?>" required>
        </div>
        <div class="form-group">
            <label for="kodeProdi">Kode Prodi:</label>
            <input type="text" class="form-control" id="kodeProdi" name="kodeProdi" value="<?php echo $row['kodeProdi']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>