<div>
    <h3>Tambah Mahasiswa</h3>
    <form action="addMhs.php" method="POST">
        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" class="form-control" id="nim" name="nim" required>
        </div>
        <div class="form-group">
            <label for="namaMhs">Nama Mahasiswa:</label>
            <input type="text" class="form-control" id="namaMhs" name="namaMhs" required>
        </div>
        <div class="form-group">
            <label for="angkatan">Angkatan:</label>
            <input type="text" class="form-control" id="angkatan" name="angkatan" required>
        </div>
        <div class="form-group">
            <label for="kodeProdi">Kode Prodi:</label>
            <input type="text" class="form-control" id="kodeProdi" name="kodeProdi" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include('connection.php'); // Include database connection

        // Get form data
        $nim = $_POST['nim'];
        $namaMhs = $_POST['namaMhs'];
        $angkatan = $_POST['angkatan'];
        $kodeProdi = $_POST['kodeProdi'];

        // Insert data into the mhs table
        $sql = "INSERT INTO mhs (nim, namaMhs, angkatan, kodeProdi) VALUES ('$nim', '$namaMhs', '$angkatan', '$kodeProdi')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Mahasiswa berhasil ditambahkan!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }

        $conn->close(); // Close the database connection
    }
    ?>
</div>