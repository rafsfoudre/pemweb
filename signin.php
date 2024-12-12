<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to CSS file -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
</head>
<body>
    <div class="container">
        <h2 class="text-center">Sign In</h2>
        <form action="signin.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <?php
    session_start(); // Start the session

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include('connection.php'); // Include database connection

        // Get form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare and bind
        $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Ambil data pengguna
            $user = $result->fetch_assoc();
            $_SESSION['username'] = $user['username']; // Simpan username di sesi
            $_SESSION['nama'] = $user['nama']; // Simpan nama di sesi
            header("Location: admin.php"); // Redirect ke admin page
            exit();
        }

        $stmt->close(); // Close the statement
        $conn->close(); // Close the database connection
    }
    ?>
</body>
</html>
</create_file>
