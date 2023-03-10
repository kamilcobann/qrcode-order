

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
  <body>
    <div class="card" style="width: 18rem;">
  <img src="/generated/qrcode{!!$user->name.ucfirst($user->surname)!!}.png" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Cart Details</h5>
    </div>
    <ul class="list-group list-group-flush">
      @foreach ($data['cart'] as $c)
      <li class="list-group-item">
        <div class="float-start">Product ID :{!! $c->product_id !!}</div>
        <div class="float-end">Amount :{!! $c->amount !!}</div>
      </li>
      @endforeach
    </ul>
    <div class="card-body">
      <a href="#" class="card-link">Card link</a>
      <a href="#" class="card-link">Another link</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

  </body>
</html>

