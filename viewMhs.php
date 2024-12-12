<div>
    <h3>Data Mahasiswa</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Angkatan</th>
                <th>Kode Prodi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('connection.php'); // Include database connection

            // Fetch student data from the database
            $sql = "SELECT * FROM mhs"; // Assuming mhs table contains student data
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nim']}</td>
                            <td>{$row['namaMhs']}</td>
                            <td>{$row['angkatan']}</td>
                            <td>{$row['kodeProdi']}</td>
                            <td>
                                <a href='admin.php?hal=editMhs&nim={$row['nim']}' class='btn btn-warning'>Edit</a>
                                <a href='deleteMhs.php?id={$row['nim']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No data found</td></tr>";
            }

            $conn->close(); // Close the database connection
            ?>
        </tbody>
    </table>
</div>