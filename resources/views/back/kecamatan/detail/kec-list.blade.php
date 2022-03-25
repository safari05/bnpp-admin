@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Kecamatan</a>
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
                        <select class="input input--lg col-span-6 border mr-2 w-full" name="provid" id="provid">
                            {{-- <option value="0">Semua Provinsi</option> --}}
                            @foreach ($provinces as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <select class="input input--lg col-span-6 border mr-2 w-full" name="kotaid" id="kotaid">
                            <option value="0">Semua Kota</option>
                        </select>
                        {{-- <select class="input input--lg col-span-4 border mr-2 w-full" name="active" id="active">
                            <option value="-1">Semua</option>
                            <option value="1">Aktif</option>
                            <option value="0">Deaktif</option>
                        </select> --}}
                        {{-- <div class="col-span-6 mt-2"><h3 class="text-medium font-medium truncate mr-5">Tipe Kecamatan</h3></div> --}}
                        <div class="col-span-12 mt-2"><h3 class="text-medium font-medium truncate mr-5">Lokpri Kecamatan</h3></div>
                        {{-- <div class="flex flex-col sm:flex-row col-span-6">
                            @foreach ($tipe as $item)
                            <div class="flex items-center text-gray-700 mr-2">
                                <input type="checkbox" class="input border mr-2 s-check-tipe" value="{{$item->typeid}}" data-tipe="{{$item->typeid}}">
                                <label class="cursor-pointer select-none">{{$item->nickname}}</label>
                            </div>
                            @endforeach
                        </div> --}}
                        <div class="flex flex-col sm:flex-row col-span-12">
                            @foreach ($lokpri as $item)
                            <div class="flex items-center text-gray-700 mr-2">
                                <input type="checkbox" class="input border mr-2 s-check-lokpri" value="{{$item->lokpriid}}" data-tipe="{{$item->lokpriid}}">
                                <label class="cursor-pointer select-none">{{$item->nickname}}</label>
                            </div>
                            @endforeach
                        </div>
                        <input type="text" class="input w-full border mt-2 col-span-10" placeholder="Nama Kecamatan" name="name" id="name">
                        <button class="button w-24 mr-1 mb-2 bg-theme-1 mt-2 col-span-2 text-white w-full" onclick="refreshTable()">Cari</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: General Report -->
        <!-- BEGIN: Sales Report -->
        <div class="col-span-12 lg:col-span-12 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Data Kecamatan
                </h2>
                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <button onclick="refreshTable()" class="ml-auto flex text-theme-1 dark:text-theme-10">
                        <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                    </button>
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-kota">
                    <thead>
                        <th>No</th>
                        <th>Provinsi</th>
                        <th>Kota</th>
                        <th>Kecamatan</th>
                        {{-- <th>Tipe</th> --}}
                        <th>Lokasi Prioritas</th>
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

        initKota(11);
        $('#provid').on('change', function(){
            initKota($(this).val());
        })

        $('body').on('click', '.btn-detail', function (){
            window.location.replace('{{url('kecamatan/detail')}}/'+$(this).data('id'));
        })
    })

    function initKota(prov = 0){
        $.getJSON('{{route('opt.kota')}}?provid='+prov,
            res=>{
                $('#kotaid').html('');
                $('#kotaid').append('<option value="0">Semua Kota</option>');
                if(res){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#kotaid').append(opt);
                    });
                }
            },
        )
    }

    async function initTable() {
        table = await $('#list-kota').DataTable({
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
                url: '{{ route('kec.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                    d.provid = $('#provid').val();
                    d.kotaid = $('#kotaid').val();

                    // let tipe = '';
                    // let tipecheck = document.querySelectorAll('.s-check-tipe');
                    // tipecheck.forEach(element => {
                    //     if($(element).prop('checked')){
                    //         if(isEmpty(tipe)) tipe = $(element).val();
                    //         else tipe += ','+$(element).val();
                    //     }
                    // });
                    // d.tipe = tipe;

                    let lokpri = '';
                    let lokpricheck = document.querySelectorAll('.s-check-lokpri');
                    lokpricheck.forEach(element => {
                        if($(element).prop('checked')){
                            if(isEmpty(lokpri)) lokpri = $(element).val();
                            else lokpri += ','+$(element).val();
                        }
                    });
                    d.lokpri = lokpri;

                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'provinsi',name: 'provinsi'},
                {data: 'kota',name: 'kota'},
                {data: 'name',name: 'name'},
                // {data: 'tipe',name: 'tipe'},
                {data: 'lokpri',name: 'lokpri'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }

</script>
@endpush
