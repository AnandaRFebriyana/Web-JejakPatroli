<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        h3 {
            margin-bottom: 20px;
        }
        .barcode-container {
            display: flex;
            justify-content: center;
        }
        .barcode {
            margin-top: 255px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Silakan pindai barcode dibawah ini 
            untuk melaporkan kondisi keamanan.
        </h2>
        <div class="barcode-container">
            @if($location && $location->id)
                <img class="barcode" src="data:image/png;base64, {!! base64_encode(QrCode::size(300)->generate($location->id)) !!}" alt="QR Code">
            @else
                <p>Barcode tidak tersedia</p>
            @endif
        </div>
    </div>
</body>
</html>
