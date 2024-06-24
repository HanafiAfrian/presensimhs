<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Barcode</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h2>QR Code</h2>
        <img src="{!! $qrCode !!}" alt="QR Code">
		
        <p>
		{{$url}}
        </p>
    </div>
</body>
</html>
