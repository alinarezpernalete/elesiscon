@extends('layouts.app')

@section('title', 'Artículos')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Panel de Opciones') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col">
                            <div class="row mx-auto w-100 justify-content-center">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-articulos">Listar artículos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#agregar-articulo">Agregar artículo</a>
                                    </li> 
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active show" id="listar-articulos">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/articles/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeArticle">Código</option>
                                                <option value="nameType">Tipo</option>
                                                <option value="nameArticle">Descripción</option>
                                                <option value="modelArticle">Modelo</option>
                                                <option value="referenceArticle">Referencia</option>
                                                <option value="weightArticle">Peso</option>
                                                <option value="locationArticle">Ubicación</option>
                                                <option value="nameLine">Línea</option>
                                                <option value="nameSubline">Sublínea</option>
                                                <option value="nameGroup">Grupo</option>
                                                <option value="nameOrigin">Procedencia</option>
                                                <option value="nameProvider">Proveedor</option>
                                                <option value="articles.created_at">Fecha</option>
                                            </select>
                                            
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/articles/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" hidden="hidden">ID</th>
                                                    <th scope="col">Código</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Descrip.</th>
                                                    <th scope="col">Modelo</th>
                                                    <th scope="col">Ref.</th>
                                                    <th scope="col">Peso</th>
                                                    <th scope="col">Ubicación</th>
                                                    <th scope="col">Línea</th>
                                                    <th scope="col">Sublínea</th>
                                                    <th scope="col">Grupo</th>
                                                    <th scope="col">Procedencia</th>
                                                    <th scope="col">Proveedor</th>
                                                    <th scope="col">Registro</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($articles as $article)
                                                    <tr>
                                                        <th scope="row" hidden="hidden">{{ $article->id }}</th>
                                                        <th scope="row">{{ $article->codeArticle }}</th>
                                                        <td>{{ $article->nameType }}</td>
                                                        <td>{{ $article->nameArticle }}</td>
                                                        <td>{{ $article->modelArticle }}</td>
                                                        <td>{{ $article->referenceArticle }}</td>
                                                        <td>{{ $article->weightArticle }}</td>
                                                        <td>{{ $article->locationArticle }}</td>
                                                        <td>{{ $article->nameLine }}</td>
                                                        <td>{{ $article->nameSubline }}</td>
                                                        <td>{{ $article->nameGroup }}</td>
                                                        <td>{{ $article->nameOrigin }}</td>
                                                        <td>{{ $article->nameProvider }}</td>
                                                        <td>{{ date("d", strtotime($article->created_at)) }}-{{ date("m", strtotime($article->created_at)) }}-{{ date("Y", strtotime($article->created_at)) }} {{ date("H", strtotime($article->created_at)) }}:{{ date("i", strtotime($article->created_at)) }}:{{ date("s", strtotime($article->created_at)) }}</td>
                                                        <td>
                                                            <div class="col">
                                                                <div class="row mx-auto my-2 w-100 justify-content-center">
                                                                    <button type="button" class="btn btn-success col-md-12 mx-auto btn-block btnAdditionalArticle" data-toggle="modal" data-target="#modal-additional-article">Ver</button>
                                                                    <button type="button" class="btn btn-outline-danger col-md-12 mx-auto btn-block desactiveArticle" data-toggle="modal">Inactivar</button>
                                                                </div>
                                                            </div>
                                                            @include('modals.articles.modal-additional-article')
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-8 mt-3">
                                    {{ $articles->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------------------------------------------------------------------>
                    <div class="tab-pane fade" id="agregar-articulo">
                        <div class="form-group">
                            <form action="/articles/store" method="POST">
                                @method('POST')
                                @csrf
                                <div class="form-group mt-3">
                                    <div class="row">
                                        <div class="col"> 
                                            <input type="text" name="codeArticle" class="form-control col-md-12 my-1" id="" placeholder="Código">
                                        </div>
                                        <div class="col">
                                            <select class="browser-default custom-select col-md-12 my-1" name="typeArticle">
                                                <option selected="" disabled="">Tipo</option>
                                                @foreach ( $types as $type )
                                                <option value="{{ $type->id }}">{{ $type->codeType }} - {{ $type->nameType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="date" name="created_at" id="created_at" class="form-control col-md-12 my-1" disabled="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <input type="text" name="nameArticle" class="form-control col-md-12 my-1" placeholder="Descripción">
                                        </div>
                                    </div>
                                            
                                    <hr class="my-4">
                                    <!-- -->
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" name="modelArticle" class="form-control col-md-12 my-1" id="" placeholder="Modelo">
                                        </div>
                                        <div class="col">
                                            <input type="text" name="referenceArticle" class="form-control col-md-12 my-1" id="" placeholder="Referencia">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <select class="browser-default custom-select col-md-12 my-1" name="lineArticle">
                                                <option selected="" disabled="">Línea</option>
                                                @foreach ( $lines as $line )
                                                <option value="{{ $line->id }}">{{ $line->codeLine }} - {{ $line->nameLine }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="text" name="weightArticle" class="form-control col-md-12 my-1" id="" placeholder="Peso">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <select class="browser-default custom-select col-md-12 my-1" name="sublineArticle">
                                                <option selected="" disabled="">Sub-línea</option>
                                                @foreach ( $sublines as $subline )
                                                <option value="{{ $subline->id }}">{{ $subline->codeSubline }} - {{ $subline->nameSubline }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <select class="browser-default custom-select col-md-12 my-1" name="groupArticle">
                                                <option selected="" disabled="">Grupo</option>
                                                @foreach ( $groups as $group )
                                                <option value="{{ $group->id }}">{{ $group->codeGroup }} - {{ $group->nameGroup }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col">
                                        </div>
                                    </div>
                    
                                    <hr class="my-4">
                                    <!-- -->
                                    <div class="row">
                                        <div class="col">
                                            <select class="browser-default custom-select col-md-12 my-1" name="providerArticle">
                                                <option selected="" disabled="">Proveedor</option>
                                                @foreach ( $providers as $provider )
                                                <option value="{{ $provider->id }}">{{ $provider->codeProvider }} - {{ $provider->nameProvider }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="text" name="locationArticle" class="form-control col-md-12 my-1" id="" placeholder="Ubicación">
                                        </div>
                                    </div>
                                                
                                    <div class="row">
                                        <div class="col">
                                            <select class="browser-default custom-select col-md-12 my-1" name="originArticle">
                                                <option selected="" disabled="">Procedencia</option>
                                                @foreach ( $origins as $origin )
                                                <option value="{{ $origin->id }}">{{ $origin->codeOrigin }} - {{ $origin->nameOrigin }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col">
                                            <select class="browser-default custom-select col-md-12 my-1">
                                                <option selected="" disabled="">IVA</option>
                                                <option value="1">Gravable</option>
                                                <option value="2">Exenta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary col">Guardar</button>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-warning col" id="cleanEmployee">Limpiar campos</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!------------------------------------------------------------------------------------>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        console.log("JQuery is working");
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

                $('#search').keypress(function(e){
            $('#search').attr("maxlength", "50"); $('#search').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,-_/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        
        fecha();
        function fecha(){
            var fecha = new Date();
            var diaActual =  parseInt(fecha.getDate());
            var mesActual = parseInt(fecha.getMonth()+1);
            var añoActual = parseInt(fecha.getFullYear());
            if(diaActual < 10){
                diaActual = "0"+diaActual;
            }
            if(mesActual < 10){
                mesActual = "0"+mesActual;
            }
            var fechaActual = añoActual+"-"+mesActual+"-"+diaActual;
            $("#created_at").val(fechaActual);

        }

        $(document).on('click', '.btnAdditionalArticle', function(){
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var idArticle = $(info).find("th:eq(0)").text();
            $.ajax({
                url : "{{ route('articles.additionalQuery') }}",
                type : 'GET',
                data : { idArticle },
                success : function(response){
                    $("#currentPrice").val(response.prices[0].currentPrice);
                    var substract = response.prices[0].updated_at.substring(0,10);
                    $("#updated_at").val(substract);
                    // -------------------------------------------------------------- //
                    $("#currentStock").val(response.stocks[0].currentStock);
                    $("#committedStock").val(response.stocks[0].committedStock);
                    $("#dispatchStock").val(response.stocks[0].dispatchStock);
                    $("#arriveStock").val(response.stocks[0].arriveStock);
                }
            })
        })

        $(document).on('click', '#clean', function(){
            $("#search").val('');
            $("#filterSearch").val('0');
        })

        $(".desactiveArticle").click(function(e){
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var id = $(info).find("th:eq(0)").text();
            var print = confirm("¿Desea inactivar el artículo?");
            if (print == true) { 
                $.ajax({ url : "{{ route('articles.desactiveArticle') }}", type : 'POST', data : { id },
                    success : function(response){
                        console.log(response);
                        if (response == 1) {
                            alert("Información actualizada");
                            window.location.replace("http://127.0.0.1:8000/articles/index");
                        }
                    }
                })
            }
        });
    });
</script>
@endsection('scripts')

