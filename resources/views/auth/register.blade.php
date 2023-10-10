<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="row m-0 justify-content-center align-items-center vh-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xs-8 col-sm-5 col-md-6 col-lg-5 align-self-center text-center">
                    <h1>Registro</h1>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="col form-group">
                            <div class="row mx-auto my-3 w-100">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mx-auto my-3 w-100">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo Electrónico">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mx-auto my-3 w-100">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mx-auto my-3 w-100">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Repetir contraseña">
                            </div>
                            <div class="row mx-auto my-3 w-100">
                                <button type="submit" class="btn btn-primary col-md-12">{{ __('Registrar') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<!--<div class="row">
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                          <div class="col-md-1">.col-md-1</div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">.col-md-8</div>
                          <div class="col-md-4">.col-md-4</div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">.col-md-4</div>
                          <div class="col-md-4">.col-md-4</div>
                          <div class="col-md-4">.col-md-4</div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">.col-md-6</div>
                          <div class="col-md-6">.col-md-6</div>
                        </div>-->
