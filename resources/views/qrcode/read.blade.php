<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post" action="{{route('qrinfo')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>QR Code</label>
            <input type="file" name="cart_qrcode" id="cart_qrcode" required class="form-control">

        </div>
        <button type="submit" class="btn btn-primary btn-block">Read QR</button>

    </form>
</body>
</html>