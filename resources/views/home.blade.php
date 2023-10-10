@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Panel de Inicio') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!--{{ __('Entro en el sistema') }}-->
                    <div class="container center">
                        <img width="120px" src="../images/eleinca_logo.jpg" class="mb-4" style="display: block;
  margin-left: auto;
  margin-right: auto;">
                    </div>
                    <div class="alert alert-primary text-center" role="alert">
                        Bienvenido a ELESISCON
                    </div>
                    <div class="text-center">
                        En la parte superior visualizará los módulos del sistema y podrá ingresar a ellos dependiendo del rol de usuario que se le haya sido asignado.
                    </div>
                </div>
            </div>
            <div class="text-center mt-3 text-muted">
                        Eleinca - 2021
                    </div>
        </div>
    </div>
</div>
@endsection
