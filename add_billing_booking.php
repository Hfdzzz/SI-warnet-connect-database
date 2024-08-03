<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Ambil nilai billing, booking, total price, dan payment type dari form, atau set menjadi 0 jika tidak diisi
    $billing = isset($_POST['billing']) ? intval($_POST['billing']) : 0;
    $booking = isset($_POST['booking']) ? intval($_POST['booking']) : 0;
    $total_price = isset($_POST['total_price']) ? intval($_POST['total_price']) : 0;
    $payment_type = isset($_POST['payment_type']) ? mysqli_real_escape_string($conn, $_POST['payment_type']) : '';

    // Cek apakah pengguna sudah memiliki data di about_warnet
    $sql = "SELECT id_billing, billing, booking FROM about_warnet WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Jika data ada, update billing dan booking
        $row = mysqli_fetch_assoc($result);
        $new_billing = $billing > 0 ? $row['billing'] + $billing : $row['billing'];
        $new_booking = $booking > 0 ? $booking : $row['booking'];
        $id_billing = $row['id_billing'];
        $sql_update = "UPDATE about_warnet SET billing = $new_billing, booking = $new_booking WHERE id_billing = $id_billing";
        if (mysqli_query($conn, $sql_update)) {
            // Masukkan data ke tabel transaksi
            $sql_insert_transaksi = "INSERT INTO transaksi (id, id_billing, jumlah_billing, pc_booking, total_harga, jenis_pembayaran) VALUES ($user_id, $id_billing, $billing, $booking, $total_price, '$payment_type')";
            if (mysqli_query($conn, $sql_insert_transaksi)) {
                header("Location: mainpage.php?success=Berhasil Membeli Billing / Booking");
            } else {
                header("Location: mainpage.php?error=Failed to record transaction");
            }
        } else {
            header("Location: mainpage.php?error=Proses Membeli Billing / Booking Gagal");
        }
    } else {
        // Jika data tidak ada, insert baru
        $sql_insert = "INSERT INTO about_warnet (billing, booking, id) VALUES ($billing, $booking, $user_id)";
        if (mysqli_query($conn, $sql_insert)) {
            // Masukkan data ke tabel transaksi
            $id_billing = mysqli_insert_id($conn);
            $sql_insert_transaksi = "INSERT INTO transaksi (id, id_billing, jumlah_billing, pc_booking, total_harga, jenis_pembayaran) VALUES ($user_id, $id_billing, $billing, $booking, $total_price, '$payment_type')";
            if (mysqli_query($conn, $sql_insert_transaksi)) {
                header("Location: mainpage.php?success=Billing and Booking added successfully");
            } else {
                header("Location: mainpage.php?error=Failed to record transaction");
            }
        } else {
            header("Location: mainpage.php?error=Failed to add Billing and Booking");
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
