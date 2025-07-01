<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="text-align: center">Nombre</th>    
                    <th style="text-align: center">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>
                            <small>
                                {{$item->user_id}}
                            </small> <br>
                            {{$item->name}}

                        </td>
                        <td style="text-align: center">
                            {{date('Y-m-d H:i:s', strtotime($item->timestamp))}} 
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td style="text-align: center" valign="top" colspan="3" class="dataTables_empty">No hay datos disponibles en la tabla</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-4" style="overflow-x:auto">
        @if(count($data)>0)
            <p class="text-muted">Mostrando del {{$data->firstItem()}} al {{$data->lastItem()}} de {{$data->total()}} registros.</p>
        @endif
    </div>
    <div class="col-md-8" style="overflow-x:auto">
        <nav class="text-right">
            {{ $data->links() }}
        </nav>
    </div>
</div>

<script>
   
   var page = "{{ request('page') }}";
    $(document).ready(function(){
        $('.page-link').click(function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            if(link){
                page = link.split('=')[1];
                list(page);
            }
        });

        $('.btn-payments-period').click(function(){
            let id = $(this).data('id');
            $('#form-payments-period input[name="id"]').val(id);
        });
    });
</script>