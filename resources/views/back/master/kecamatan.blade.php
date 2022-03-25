@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Master</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Kecamatan</a>
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
                            <option value="0">Semua Kota</option>
                        </select>
                        <select class="input input--lg col-span-4 border mr-2 w-full" name="active" id="active">
                            <option value="-1">Semua</option>
                            <option value="1">Aktif</option>
                            <option value="0">Deaktif</option>
                        </select>
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
                        <input type="text" class="input w-full border mt-2 col-span-10" placeholder="Nama Kota" name="name" id="name">
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
                        <th>Status Saat Ini</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END: Sales Report -->
    </div>
</div>

{{-- START: Modal Tipe --}}
{{-- <div class="modal" id="modal-tipe">
    <div class="modal__content p-10 text-center">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <h3>Tipe Kecamatan</h3>
            </div>
            <div class="col-span-12 text-center">
                @foreach ($tipe as $item)
                <div class="flex items-center text-gray-700 mr-2">
                    <input type="checkbox" class="input border mr-2 check-tipe" value="{{$item->typeid}}" data-tipe="{{$item->typeid}}">
                    <label class="cursor-pointer select-none">{{$item->nickname}}</label>
                </div>
                @endforeach
            </div>
            <div class="col-span-6">
                <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" id="btn-simpan-tipe">Simpan</button>
            </div>
            <div class="col-span-6">
                <button class="button w-24 mr-1 mb-2 bg-theme-2 col-span-2 text-gray-700 w-full" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div> --}}
{{-- END: Modal Tipe --}}

{{-- START: Modal Lokpri --}}
<div class="modal" id="modal-lokpri">
    <div class="modal__content p-10 text-center">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <h3>Lokpri Kecamatan</h3>
            </div>
            <div class="col-span-12 text-center">
                @foreach ($lokpri as $item)
                <div class="flex items-center text-gray-700 mr-2">
                    <input type="checkbox" class="input border mr-2 check-lokpri" value="{{$item->lokpriid}}" data-lokpri="{{$item->lokpriid}}">
                    <label class="cursor-pointer select-none">{{$item->nickname}}</label>
                </div>
                @endforeach
            </div>
            <div class="col-span-6">
                <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" id="btn-simpan-lokpri">Simpan</button>
            </div>
            <div class="col-span-6">
                <button class="button w-24 mr-1 mb-2 bg-theme-2 col-span-2 text-gray-700 w-full" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
{{-- END: Modal lokpri --}}
@endsection

@push('js')
<script>
    var table;
    $(document).ready(function () {
        initTable();
        $('body').on('click', '.btn-deactive', function () {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda akan mendeaktivasi Kecamatan. Lanjutkan?',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Tutup',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    const id = $(this).data('id');
                    const data = {
                        '_token': '{{csrf_token()}}',
                        'id': id,
                        'active': 0,
                    };

                    $.post('{{route('master.kec.change')}}', data, res => {
                        if (res.status == 200) {
                            refreshTable();
                            showSuccess(res.msg);
                        } else {
                            showError(res.msg);
                        }
                    })
                }
            })
        })

        $('body').on('click', '.btn-active', function () {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda akan mengaktivasi Kecamatan. Lanjutkan?',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Tutup',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    const id = $(this).data('id');
                    const data = {
                        '_token': '{{csrf_token()}}',
                        'id': id,
                        'active': 1,
                    };
                    $.post('{{route('master.kec.change')}}', data, res => {
                            if (res.status == 200) {
                                refreshTable();
                                showSuccess(res.msg);
                            } else {
                                showError(res.msg);
                            }
                        })
                }
            })
        })

        initKota();
        $('#provid').on('change', function(){
            initKota($(this).val());
        })
    })

    // function ubahTipe(id){
    //     $.getJSON('{{url('master/kecamatan/detail')}}/'+id,
    //         res=>{
    //             if(res.tipe){
    //                 let tipecheck = document.querySelectorAll('.check-tipe');
    //                 tipecheck.forEach(element => {
    //                     if(res.tipe.includes(""+$(element).data('tipe')))
    //                         $(element).prop('checked', true);
    //                     else $(element).prop('checked', false);
    //                 });
    //             }
    //         },
    //     )

    //     cash('#modal-tipe').modal('show');

    //     $('#btn-simpan-tipe').on('click', function () {
    //         cash('#modal-tipe').modal('hide');
    //         Swal.fire({
    //             title: 'Konfirmasi',
    //             text: 'Anda akan mengubah Tipe Kecamatan. Lanjutkan?',
    //             showCancelButton: true,
    //             confirmButtonText: 'Lanjutkan',
    //             cancelButtonText: 'Tutup',
    //         }).then((result) => {
    //             /* Read more about isConfirmed, isDenied below */
    //             if (result.isConfirmed) {
    //                 let tipe = '';
    //                 let tipecheck = document.querySelectorAll('.check-tipe');
    //                 tipecheck.forEach(element => {
    //                     if($(element).prop('checked')){
    //                         if(isEmpty(tipe)) tipe = $(element).val();
    //                         else tipe += ','+$(element).val();
    //                     }
    //                 });

    //                 let mdata = {
    //                     '_token':'{{csrf_token()}}',
    //                     'id':id,
    //                     'tipe':tipe
    //                 };

    //                 $.ajax({
    //                     method:'post',
    //                     dataType:'json',
    //                     data:mdata,
    //                     url:'{{route('master.kec.tipe.change')}}',
    //                     success:res=>{
    //                         if(res.status == 200){
    //                             showSuccess(res.msg);
    //                         }else{
    //                             showError(res.msg);
    //                         }

    //                         tipecheck.forEach(element => {
    //                             $(element).prop('checked', false);
    //                         });
    //                     }
    //                 });
    //             }
    //         })
    //     })
    // }

    function ubahLokpri(id){
        $.getJSON('{{url('master/kecamatan/detail')}}/'+id,
            res=>{
                if(res.lokpri){
                    let lokpricheck = document.querySelectorAll('.check-lokpri');
                    lokpricheck.forEach(element => {
                        if(res.lokpri.includes(""+$(element).data('lokpri')))
                            $(element).prop('checked', true);
                        else $(element).prop('checked', false);
                    });
                }
            },
        )

        cash('#modal-lokpri').modal('show');

        $('#btn-simpan-lokpri').on('click', function () {
            cash('#modal-lokpri').modal('hide');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda akan mengubah lokpri Kecamatan. Lanjutkan?',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Tutup',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    let lokpri = '';
                    let lokpricheck = document.querySelectorAll('.check-lokpri');
                    lokpricheck.forEach(element => {
                        if($(element).prop('checked')){
                            if(isEmpty(lokpri)) lokpri = $(element).val();
                            else lokpri += ','+$(element).val();
                        }
                    });

                    let mdata = {
                        '_token':'{{csrf_token()}}',
                        'id':id,
                        'lokpri':lokpri
                    };
                    console.log(mdata);
                    $.ajax({
                        method:'post',
                        dataType:'json',
                        data:mdata,
                        url:'{{route('master.kec.lokpri.change')}}',
                        success:res=>{
                            if(res.status == 200){
                                showSuccess(res.msg);
                            }else{
                                showError(res.msg);
                            }

                            lokpricheck.forEach(element => {
                                $(element).prop('checked', false);
                            });
                        }
                    });
                }
            })
        })
    }

    function initKota(prov = 0){
        $.getJSON('{{route('master.kec.kota')}}?provid='+prov,
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
                url: '{{ route('master.kec.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                    d.provid = $('#provid').val();
                    d.kotaid = $('#kotaid').val();
                    d.active = ($('#active').val()!= '-1')? $('#active').val():'';

                    let tipe = '';
                    let tipecheck = document.querySelectorAll('.s-check-tipe');
                    tipecheck.forEach(element => {
                        if($(element).prop('checked')){
                            if(isEmpty(tipe)) tipe = $(element).val();
                            else tipe += ','+$(element).val();
                        }
                    });
                    d.tipe = tipe;

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
                {data: 'status',name: 'status'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }

</script>
@endpush
