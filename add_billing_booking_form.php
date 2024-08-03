<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Top Up Billing & Booking PC</title>
    <script>
        function calculateTotalPrice() {
            const billing = document.getElementById('billing').value;
            const totalPrice = billing * 5000;
            document.getElementById('total_price').value = totalPrice;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <a href="index.php">Logout</a>/<a href="mainpage.php">Home</a>/Topup
        <h2>Top Up Billing & Booking PC</h2>
        <form action="add_billing_booking.php" method="POST">
            <div class="mb-3">
                <label for="billing" class="form-label">Billing</label>
                <input type="number" class="form-control" id="billing" name="billing" oninput="calculateTotalPrice()">
            </div>
            <div class="mb-3">
                <label for="booking" class="form-label">Booking PC</label>
                <input type="number" class="form-control" id="booking" name="booking">
            </div>
            <div class="mb-3">
                <label for="total_price" class="form-label">Total Harga</label>
                <input type="number" class="form-control" id="total_price" name="total_price" readonly>
            </div>
            <div class="mb-3">
                <label for="payment_type" class="form-label">Jenis Pembayaran</label>
                <select class="form-select" id="payment_type" name="payment_type" required>
                    <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                    <option value="DANA">DANA</option>
                    <option value="OVO">OVO</option>
                    <option value="GOPAY">GOPAY</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <style>
        a{
            text-decoration: none;
        }
    </style>
</body>
</html>
