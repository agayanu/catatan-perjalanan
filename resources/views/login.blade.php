<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catatan Perjalanan</title>
    <link rel="shortcut icon" href="{{asset('logo/favicon.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('coreui/css/coreui.min.css')}}">
    <link rel="stylesheet" href="{{asset('@coreui/icons/css/all.min.css')}}">
</head>
<body>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    @include('layouts.flash-message')
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-7 p-4 mb-0">
                            <div class="card-body">
                                <h1>Catatan Perjalanan</h1>
                                <p class="text-medium-emphasis">Masuk atau Buat akun anda</p>
                                <form action="" method="post">
                                @csrf
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                            <i class="icon cil-user"></i>
                                        </span>
                                        <input class="form-control @error('nik') is-invalid @enderror" type="text" name="nik" placeholder="NIK">
                                        @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">
                                            <i class="icon cil-user"></i>
                                        </span>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Nama Lengkap">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit" name="action" value="login">Masuk</button>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-secondary" type="submit" name="action" value="register">Pengguna Baru</button>
                                        </div>
                                        @error('action')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('coreui/js/coreui.bundle.min.js')}}"></script>
</body>
</html>