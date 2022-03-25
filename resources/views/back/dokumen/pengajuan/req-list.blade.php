@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('dok.manage.index')}}">Dokumen</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('dok.pengajuan.index')}}">Pengajuan</a>
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
                        <select data-search="true" class="input input--lg border mr-2 w-full col-span-6" id="respon" placeholder="Respon" name="respon">
                            <option value="0">Semua</option>
                            <option value="1">Menunggu</option>
                            <option value="2">Disetujui</option>
                            <option value="3">Ditolak</option>
                        </select>
                        <select data-search="true" class="input input--lg border mr-2 w-full col-span-6" id="kategori">
                            <option value="0">Semua</option>
                            @foreach ($kategoris as $item)
                            <option value="{{$item->idkategori}}">{{$item->keterangan}}</option>
                            @endforeach
                        </select>
                        <input type="text" class="input w-full border col-span-10" placeholder="Nama Dokumen" name="name" id="name">
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
                    Daftar Dokumen
                </h2>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-manage">
                    <thead>
                        <th>No</th>
                        <th>Nama Dokumen</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>User Pengaju</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END: Sales Report -->
    </div>


    {{-- START: Modal Edit Ket --}}
    <div class="modal" id="modal-ket">
        <div class="modal__content p-10">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 p-5 text-center">
                    <h2 class="text-2xl">Edit Akses Publik Dokumen</h2>
                </div>
                <div class="col-span-12">
                    <label for="">Nama Dokumen</label>
                    <input type="text" class="input w-full border mt-2 col-span-10 v-nama" placeholder="Nama Dokumen" readonly>
                </div>
                <div class="col-span-12">
                    <label for="">Pengaju</label>
                    <input type="text" class="input w-full border mt-2 col-span-10 v-user" placeholder="User Pengaju" readonly>
                </div>
                <div class="col-span-12">
                    <label for="">Respon Pengajuan</label>
                    <select class="input w-full border mt-2 col-span-10 v-respon" placeholder="Respon">
                        <option value="2">Terima</option>
                        <option value="3">Tolak</option>
                    </select>
                </div>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full btn-save">Simpan</button>
                </div>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-2 col-span-2 text-gray-700 w-full" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Modal Edit Balai --}}
</div>
@endsection

@push('js')
<script>
    var table;
    $(document).ready(function () {
        initTable();
    })

    async function initTable() {
        table = await $('#list-manage').DataTable({
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
                url: '{{ route('dok.pengajuan.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                    d.kat = $('#kategori').val();
                    d.respon = $('#respon').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'namadok',name: 'namadok'},
                {data: 'katdok',name: 'katdok'},
                {data: 'status',name: 'status'},
                {data: 'pengaju',name: 'pengaju'},
                // {data: 'validasi',name: 'validasi'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }

    function respon(id, respon = 0){
        if(respon > 0){
            storeRespon(id, respon);
        }else{
            $.getJSON('{{url('dokumen/pengajuan/detail')}}/'+id, res=>{
                if(res.status == 200){
                    $('#modal-ket .v-nama').val(res.data.dokumen);
                    $('#modal-ket .v-user').val(res.data.user);
                    $('#modal-ket .v-respon').val(res.data.status);
                    $('#modal-ket .btn-save').off('click');
                    $('#modal-ket .btn-save').on('click', function(){
                        cash('#modal-ket').modal('hide');
                        storeRespon(id, $('#modal-ket .v-respon').val());
                    });
                    cash('#modal-ket').modal('show');
                }else{
                    showError(res.msg);
                }
            })
        }
    }

    function storeRespon(id, respon){
        let msg = respon==2? 'menerima':(respon==3?'menolak':'merespon');
        let lgmsg = respon==2? 'User Pengaju akan dapat mengakses dokumen yang Anda setujui. ':(respon==3?'User Pengaju tidak dapat mengakses dokumen yang Anda tolak.':'Anda akan merespon Pengajuan Dokumen tersebut.');
        Swal.fire({
            title: 'Anda akan '+msg+' Pengajuan Dokumen?',
            text: lgmsg+' Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            if (result.isConfirmed) {
                let data = {
                    '_token':'{{csrf_token()}}',
                    'idseries':id,
                    'status':respon
                };

                $.post('{{route('dok.pengajuan.respon')}}', data, res=>{
                    if(res.status == 200){
                        showSuccess(res.msg);
                        refreshTable();
                    }else{
                        showError(res.msg);
                    }
                })
            }
        });
    }
</script>
@endpush
