@extends('voyager::master')

@section('page_title', 'Viendo asistencia')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding: 0px">
                        <div class="col-md-8" style="padding: 0px">
                            <h1 class="page-title">
                                <i class="fa-solid fa-fingerprint"></i> Asistencia
                            </h1>
                        </div>
                        <div class="col-md-4 text-right" style="margin-top: 30px">
                            @if (auth()->user()->hasPermission('add_people'))
                                <a href="{{ route('attendances.synchronize') }}" class="btn btn-success btn-synchronize" id="syncButton">
                                    <i class="fa-solid fa-rotate"></i> <span id="text-synchronize">Sincronizar Reloj</span>
                                </a>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="dataTables_length" id="dataTable_length">
                                    <label>Mostrar <select id="select-paginate" class="form-control input-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> registros</label>
                                </div>
                            </div>
                            <div class="col-sm-3" style="margin-bottom: 10px">
                                <input type="text" id="input-search" placeholder="🔍 Buscar..." class="form-control">
                            </div>
                        </div>
                        <div class="row" id="div-results" style="min-height: 120px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @include('partials.modal-delete')






 
@stop

@section('css')
    <style>

    
    </style>
@stop

@section('javascript')
    <script src="{{ url('js/main.js') }}"></script>
        
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
        var countPage = 10, order = 'id', typeOrder = 'desc';
        $(document).ready(() => {
            list();
            
            $('#input-search').on('keyup', function(e){
                if(e.keyCode == 13) {
                    list();
                }
            });

            $('#select-paginate').change(function(){
                countPage = $(this).val();
               
                list();
            });
        });



        function list(page = 1){
            $('#div-results').loading({message: 'Cargando...'});

            let url = '{{ url("admin/attendances/ajax/list") }}';
            let search = $('#input-search').val() ? $('#input-search').val() : '';

            $.ajax({
                url: `${url}/${search}?paginate=${countPage}&page=${page}`,
                // url: `${url}/${search}?paginate=${countPage}&page=${page}`,
                type: 'get',
                
                success: function(result){
                    $("#div-results").html(result);
                    $('#div-results').loading('toggle');
                }
            });
        }


        $(document).ready(function() {
            $('#syncButton').click(function(e) {
                e.preventDefault(); // ¡Esto evita que el href se abra!
                const $button = $(this);
                const $icon = $button.find('i');
                const $text = $('#text-synchronize');
                const url = "{{route('attendances.synchronize')}}"; // Obtiene la URL del href

                // Cambiar texto y agregar efecto de carga
                $text.text('Sincronizando...');
                $icon.addClass('fa-spin');

                // Ejemplo: Petición AJAX para sincronizar
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $text.text('¡Sincronizado!');
                        setTimeout(() => {
                            $text.text('Sincronizar Reloj');
                            $icon.removeClass('fa-spin');
                        }, 2000);
                         list();
                    },
                    error: function() {
                        $text.text('Error. Reintentar');
                        $icon.removeClass('fa-spin');
                    }
                });
            });
        });

       
    </script>
@stop