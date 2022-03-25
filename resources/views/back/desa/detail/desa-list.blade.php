@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Desa</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Daftar</a>
</div>
@endsection
@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-12 grid grid-cols-12 gap-6">
        <!-- BEGIN: General Report -->
        <div class="col-span-12 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Pencarian
                </h2>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="col-span-12 intro-y">
                    <div class="grid grid-cols-12 gap-2">
                        <select class="input input--lg col-span-4 border mr-2 w-full" name="provid" id="provid">
                            {{-- <option value="0">Semua Provinsi</option> --}}
                            @foreach ($provinces as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <select class="input input--lg col-span-4 border mr-2 w-full" name="kotaid" id="kotaid">
                            {{-- <option value="0">Semua Kota</option> --}}
                        </select>
                        <select class="input input--lg col-span-4 border mr-2 w-full" name="kecid" id="kecid">
                            <option value="0">Semua Kecamatan</option>
                        </select>
                        <input type="text" class="input w-full border col-span-10" placeholder="Nama Desa" name="name" id="name">
                        <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" onclick="refreshTable()">Cari</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: General Report -->
        <!-- BEGIN: Sales Report -->
        <div class="col-span-12 lg:col-span-12 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Data Desa
                </h2>
                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <button onclick="refreshTable()" class="ml-auto flex text-theme-1 dark:text-theme-10">
                        <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                    </button>
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-desa">
                    <thead>
                        <th>No</th>
                        <th>Kota</th>
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END: Sales Report -->
    </div>
</div>
@endsection

@push('js')
<script>
    var table;
    $(document).ready(function () {
        initTable();

        initKota();
        $('#provid').on('change', function(){
            initKota($(this).val());
        })

        initKec();
        $('#kotaid').on('change', function(){
            initKec($(this).val());
        })

        $('body').on('click', '.btn-desa-detail', function (){
            window.location.replace('{{url('desa/detail')}}/'+$(this).data('id'));
        })
    })

    async function initTable() {
        table = await $('#list-desa').DataTable({
            language: {
                "paginate": {
                    'previous':'Prev',
                    'next':'Next'
                }
            },
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('desa.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                    d.provid = $('#provid').val();
                    d.kotaid = $('#kotaid').val();
                    d.kecid = $('#kecid').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'kota',name: 'kota'},
                {data: 'kec',name: 'kec'},
                {data: 'name',name: 'name'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }

    function initKota(prov = 0){
        $.getJSON('{{route('opt.kota')}}?provid='+prov,
            res=>{
                $('#kotaid').html('');
                // $('#kotaid').append('<option value="0">Semua Kota</option>');
                if(res){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#kotaid').append(opt);
                    });
                    initKec($('#kotaid').val());
                }
                initKec(res[0].id||0);
            },
        )
    }

    function initKec(kota = 0){
        $.getJSON('{{route('opt.kec')}}?kotaid='+kota,
            res=>{
                $('#kecid').html('');
                $('#kecid').append('<option value="0">Semua Kecamatan</option>');
                if(res){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#kecid').append(opt);
                    });
                }
            },
        )
    }

</script>
@endpush
