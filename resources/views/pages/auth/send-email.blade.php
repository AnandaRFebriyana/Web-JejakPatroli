<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            position: relative; /* Tambahkan posisi relatif */
        }
        .container h2 {
         
            color: #333;
           
        }
        .container p {
            color: #666;
            margin-bottom: 30px;
        }
        .input-container {
            margin-bottom: 20px;
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-container i {
            position: absolute;
            left: 10px;
            color: #ccc;
        }
        .input-container input {
            padding: 10px 40px;
            width: calc(100% - 40px);
            border: none;
            border-bottom: 2px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-bottom-color 0.3s ease;
        }
        .input-container input:focus {
            border-bottom-color: #007bff;
        }
        .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
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
    <h2>Forgot Password</h2>
    <img src="img/img.jpg">
    <p>Please enter  email address below. We will send you instructions on how to reset your password.</p>
    <form action="forgot_password.php" method="post">
        <div class="input-container">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="email" required>
        </div>
        <button type="submit" class="btn">Reset Password</button>
    </form>
</div>
    </body>
</html>
