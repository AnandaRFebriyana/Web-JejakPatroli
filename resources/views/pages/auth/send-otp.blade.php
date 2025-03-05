<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            padding: 40px;
            text-align: center;
            margin: auto; /* Pusatkan horizontal */
        }
        .container h2 {
            color: #333;
        }
        .container p {
            color: #666;
            margin-bottom: 30px;
        }
        .otp-input {
            display: flex;
            justify-content: space-between;
            width: 100%; /* Atur lebar 100% agar semua input berjejer */
        }
        .otp-input input {
            width: 45px; /* Atur lebar 10px */
            height: 45px; /* Atur tinggi 10px */
            padding: 0; /* Hapus padding */
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
            font-size: 20px; /* Sesuaikan ukuran teks */
            margin-right: 2px;
            box-sizing: border-box;
        }
        .otp-input input:last-child {
            margin-right: 0;
        }
        .otp-input input:focus {
            outline: none;
            border-color: #007bff;
        }
        .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 12px 24px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #0056b3;
        }

         img {
            width: 190px; /* Atur lebar gambar */
            height: auto; /* Biarkan tinggi otomatis sesuai rasio */
            border-radius: 50%; /* Ubah ke lingkaran */
            display: block; /* Jadikan tampilan blok untuk margin otomatis */
            margin: auto; /* Pusatkan horizontal */
            margin-bottom: 20px; /* Beri margin bawah */
        }

    </style>
</head>

<body>
<div class="container">
    <h2>OTP Verification</h2>
    <img src="img/img.jpg">
    <p>Please enter the OTP sent to your email address below.</p>
    <form action="verify_otp.php" method="post">
        <div class="otp-input">
            <input type="text" name="otp1" maxlength="1" oninput="moveToNext(this, 'otp2')" required>
            <input type="text" name="otp2" maxlength="1" oninput="moveToNext(this, 'otp3')" required>
            <input type="text" name="otp3" maxlength="1" oninput="moveToNext(this, 'otp4')" required>
            <input type="text" name="otp4" maxlength="1" oninput="moveToNext(this, 'otp5')" required>
            <input type="text" name="otp5" maxlength="1" oninput="moveToNext(this, 'otp6')" required>
            <input type="text" name="otp6" maxlength="1" required>
        </div>
        <button type="submit" class="btn">Verify OTP</button>
    </form>
</div>

<script>
    function moveToNext(input, nextInputName) {
        if (input.value.length >= input.maxLength) {
            var nextInput = document.getElementsByName(nextInputName)[0];
            if (nextInput) {
                nextInput.focus();
            }
        }
    }
</script>

</body>
</html>
