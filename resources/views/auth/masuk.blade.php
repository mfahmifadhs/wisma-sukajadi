<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/icon-kemenkes.png') }}" type="image/x-icon">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('dist_admin/css/login.min.css') }}">
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('dist_admin/css/login.css') }}">

    <title>WISMA SUKAJADI BANDUNG</title>
  </head>
  <body>

    <div class="d-lg-flex half">
      <div class="bg order-1 order-md-2" style="background-image: url('/images/admin/login-form.jpg');"></div>
      <div class="contents order-2 order-md-1">

        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7">
              <center>
                <p><img src="{{ asset('images/main/logo-kemenkes.png') }}" style="width:50%;" alt="KEMENKES Logo" class="img-login animation__shake img-responsive"></p>
                <h4>Wisma Sukajadi Bandung</h4>
                <h5><strong>Kementerian Kesehatan Republik Indonesia</strong></h5>
                <p class="mb-4">Jl. Sukajadi No.155, Kota Bandung.</p>
              </center>
              <div class="form-group first">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                  <p style="color:white;margin: auto;">{{ $message }}</p>
                </div>
                @endif
                @if ($message = Session::get('failed'))
                <div class="alert alert-danger">
                  <p style="color:white;margin: auto;">{{ $message }}</p>
                </div>
                @endif
              </div>
              <form action="{{ route('masuk') }}" method="POST">
                @csrf
                <div class="form-group first">
                  <label for="username">Username</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" name="username" class="form-control" placeholder="Masukan Username" required>
                  </div>
                </div>
                <div class="form-group last mb-3">
                  <label for="password">Password</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" id="myInput" placeholder="Masukan Password" minlength="6" required>
                  </div>

                </div>

                <div class="d-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-0"><span class="caption">Lihat Password</span>
                    <input type="checkbox" onclick="myFunction()">
                    <div class="control__indicator"></div>
                  </label>
                </div>

                <button type="submit" class="btn btn-block btn-success font-weight-bold">MASUK</button>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>



    <script src="{{ asset('dist-admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist-admin/js/login.min.js') }}"></script>
    <script src="{{ asset('dist-admin/js/login.js') }}"></script>
    <script type="text/javascript">
      function myFunction() {
        var x = document.getElementById("myInput");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
    </script>
  </body>
  </html>
