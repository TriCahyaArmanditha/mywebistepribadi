<?php
session_start();
if ($_SESSION['role'] != 'user') {
    header('Location: loginform.php');
    exit();
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'user_login');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari semua tabel
$sql_orders = "SELECT * FROM orders";
$result_orders = $conn->query($sql_orders);

// Ambil data messages
$sql_messages = "SELECT * FROM messages ORDER BY id DESC LIMIT 10"; // Ambil 10 pesan terbaru
$result_messages = $conn->query($sql_messages);

// Menutup koneksi
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="CSS/dashboarduser.css">

    <style>
        body {
        font-family: Arial, sans-serif;
        background: url(backgrounduserdashboard.jpg);
        background-position: center;
        background-size: cover;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        }

    </style>
</head>
<body style="background-color: #f0f8ff;">
    <header style="background-color:rgb(13, 64, 116); color: white; padding: 10px;">
        <h1>Welcome to User Dashboard</h1>
        <nav>
            <a href="logout.php" style="color: white; font-size: 18px;">Logout</a>
        </nav>
    </header>

    <div class="container" style="padding: 20px;">
        <h2 style="color: #1e90ff;">Your Orders</h2>
        <?php if ($result_orders->num_rows > 0): ?>
            <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background-color:rgba(9, 16, 21, 0.49); color: white;">
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>product</th>
                        <th>Total</th>
                        <th>Selected Service</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_orders->fetch_assoc()): ?>
                        <tr style="background-color:rgba(224, 247, 250, 0.65);">
                            <td ><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['hp']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['product']; ?></td>
                            <td><?php echo $row['total']; ?></td>
                            <td><?php echo $row['selected_service']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No data available.</p>
        <?php endif; ?>

        <!-- Tabel Messages -->
        <h2 style="color: #1e90ff; margin-top: 40px;">Recent Messages</h2>
        <?php if ($result_messages->num_rows > 0): ?>
            <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background-color:rgb(13, 64, 116); color: white;">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_messages->fetch_assoc()): ?>
                        <tr style="background-color: rgba(224, 247, 250, 0.65)">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['subject']; ?></td>
                            <td><?php echo $row['message']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No messages available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
