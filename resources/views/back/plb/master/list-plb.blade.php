@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Pos Lintas Batas</a>
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
                        <select class="input input--lg col-span-3 border mr-2 w-full" name="provid" id="provid">
                            {{-- <option value="0">Semua Provinsi</option> --}}
                            @foreach ($provinces as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <select class="input input--lg col-span-3 border mr-2 w-full" name="kotaid" id="kotaid">
                            <option value="0">Semua Kota</option>
                        </select>
                        <select class="input input--lg col-span-3 border mr-2 w-full" name="kecid" id="kecid">
                            <option value="0">Semua Kecamatan</option>
                        </select>
                        <select class="input input--lg col-span-3 border mr-2 w-full" name="desaid" id="desaid">
                            <option value="0">Semua Desa</option>
                        </select>
                        {{-- <div class="col-span-6 mt-2"><h3 class="text-medium font-medium truncate mr-5">Tipe Kecamatan</h3></div>
                        <div class="col-span-6 mt-2"><h3 class="text-medium font-medium truncate mr-5">Lokpri Kecamatan</h3></div>
                        <div class="flex flex-col sm:flex-row col-span-6">
                            @foreach ($tipe as $item)
                            <div class="flex items-center text-gray-700 mr-2">
                                <input type="checkbox" class="input border mr-2 s-check-tipe" value="{{$item->typeid}}" data-tipe="{{$item->typeid}}">
                                <label class="cursor-pointer select-none">{{$item->nickname}}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex flex-col sm:flex-row col-span-6">
                            @foreach ($lokpri as $item)
                            <div class="flex items-center text-gray-700 mr-2">
                                <input type="checkbox" class="input border mr-2 s-check-lokpri" value="{{$item->lokpriid}}" data-tipe="{{$item->lokpriid}}">
                                <label class="cursor-pointer select-none">{{$item->nickname}}</label>
                            </div>
                            @endforeach
                        </div> --}}
                        <input type="text" class="input w-full border mt-2 col-span-7" placeholder="Nama PLB" name="name" id="name">
                        <select class="input input--lg col-span-3 border mr-2 w-full" name="tipeplb" id="tipeplb">
                            <option value="0">Semua Tipe PLB</option>
                            <option value="1">Non PLBN</option>
                            <option value="2">PLBN</option>
                        </select>
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
                    <a href="{{route('plb.master.create')}}">
                        <button class="button button--sm block bg-theme-1 text-white">
                            Tambah PLB
                        </button>
                    </a>
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-kota">
                    <thead>
                        <th>No</th>
                        <th>Lokasi</th>
                        <th>Nama PLB</th>
                        <th>Jenis</th>
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

        $('#kotaid').on('change', function(){
            initKec($(this).val());
        })

        $('#kecid').on('change', function(){
            initDesa($(this).val());
            initPlb($(this).val(), $('#desaid').val());
        })
    })

    function initKota(prov = 0){
        $.getJSON('{{route('opt.kota')}}?provid='+prov,
            res=>{
                $('#kotaid').empty();
                // $('#kotaid').append('<option value="0">Semua Kota</option>');
                console.log(res && prov > 0);
                if(res && prov > 0){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#kotaid').append(opt);
                    });
                }
                initKec(res[0].id||0);
            },
        )
    }

    function initKec(kota = 0){
        $.getJSON('{{route('opt.kec')}}?kotaid='+kota,
            res=>{
                $('#kecid').html('');
                // $('#kecid').append('<option value="0">Semua Kecamatan</option>');
                if(res && kota > 0){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#kecid').append(opt);
                    });
                }

                initDesa(res[0].id||0)
            },
        )
    }

    function initDesa(kec = 0){
        $.getJSON('{{route('opt.desa')}}?kecid='+kec,
            res=>{
                $('#desaid').html('');
                $('#desaid').append('<option value="0">Semua Desa</option>');
                if(res && kec > 0){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#desaid').append(opt);
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
                url: '{{ route('plb.master.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                    d.desa = $('#desaid').val();
                    d.kec = $('#kecid').val();
                    d.jenis = $('#tipeplb').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'lokasi',name: 'lokasi'},
                {data: 'nama_plb',name: 'nama_plb'},
                {data: 'jenis',name: 'jenis'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }

    function hapusPLB(id){
        Swal.fire({
            title: 'Yakin menghapus Pos Lintas Batas?',
            text: 'Data Pos yang Anda hapus tidak dapat dikembalikan. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                const data = {
                    '_token':'{{csrf_token()}}',
                    '_method':'delete',
                };
                $.post('{{url("plb/master/delete")}}/'+id, data, res=>{
                    if(res.status==200){
                        showSuccess(res.msg);
                        refreshTable();
                    }else{
                        showError(res.msg);
                    }
                })
            }
        })
    }

</script>
@endpush
