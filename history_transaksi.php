<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Ambil data transaksi dari database
    $sql = "SELECT t.id_transaksi, t.jumlah_billing, t.pc_booking, t.total_harga, t.jenis_pembayaran, t.waktu_dipesan 
            FROM transaksi t
            WHERE t.id = $user_id
            ORDER BY t.waktu_dipesan DESC";
    $result = mysqli_query($conn, $sql);
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>History Transaksi</title>
</head>
<body>
    <div class="container">
    <a href="index.php">Logout</a>/<a href="mainpage.php">Home</a>/History Transaksi
        <h2>History Transaksi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                   
                    <th>Billing</th>
                    <th>PC Booking</th>
                    <th>Total Harga</th>
                    <th>Jenis Pembayaran</th>
                    <th>Waktu & Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        
                        echo "<td>" . $row['jumlah_billing'] . "</td>";
                        echo "<td>" . $row['pc_booking'] . "</td>";
                        echo "<td>" . $row['total_harga'] . "</td>";
                        echo "<td>" . $row['jenis_pembayaran'] . "</td>";
                        echo "<td>" . $row['waktu_dipesan'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Belum ada transaksi</td></tr>";
                }
                ?>
            </tbody>
            <style>
        a{
            text-decoration: none;
        }
    </style>
</body>
</html>
