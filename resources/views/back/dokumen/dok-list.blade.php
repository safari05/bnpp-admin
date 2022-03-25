@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('dok.manage.index')}}">Dokumen</a>
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
                        <select data-search="true" class="input input--lg border mr-2 w-full col-span-6" id="akses" placeholder="Kategori Dokumen" name="akses">
                            <option value="-1">Semua</option>
                            <option value="1">Publik</option>
                            <option value="0">Rahasia / Private</option>
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
                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <a href="{{route('dok.manage.create')}}">
                        <button class="button button--sm mr-1 mb-2 bg-theme-1 text-white">
                            Tambah Dokumen
                        </button>
                    </a>
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-manage">
                    <thead>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Hak Akses</th>
                        {{-- <th>Status Validasi</th> --}}
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
                    <input type="text" class="input w-full border mt-2 col-span-10 v-nama" placeholder="Nama Kategori" readonly>
                </div>
                <div class="col-span-12">
                    <label for="">Tahun</label>
                    <input type="number" class="input w-full border mt-2 col-span-10 v-tahun" placeholder="Tahun Dokumen" readonly>
                </div>
                <div class="col-span-12">
                    <label for="">Jenis Akses</label>
                    <select type="number" class="input w-full border mt-2 col-span-10 v-publik" placeholder="Status Publik">
                        <option value="1">Publik</option>
                        <option value="0">Private</option>
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
                url: '{{ route('dok.manage.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                    d.kat = $('#kategori').val();
                    d.akses = $('#akses').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'nama',name: 'nama'},
                {data: 'kategori',name: 'kategori'},
                {data: 'tahun',name: 'tahun'},
                {data: 'akses',name: 'akses'},
                // {data: 'validasi',name: 'validasi'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }

    function ubahPublic(id){
        $.getJSON('{{url('dokumen/manage/get-detail')}}/'+id, res=>{
            if(res.status = 200){
                $('#modal-ket .v-nama').val(res.data.nama);
                $('#modal-ket .v-tahun').val(res.data.tahun);
                $('#modal-ket .v-publik').val(res.data.ispublic);
                $('#modal-ket .btn-save').html('Update');
                $('#modal-ket .btn-save').off('click');
                $('#modal-ket .btn-save').on('click', function(){
                    updateAkses(id);
                })
                cash('#modal-ket').modal('show');
            }else{
                showError(res.msg);
            }
        });
    }

    function updateAkses(id){
        const data = {
            '_token':'{{csrf_token()}}',
            '_method':'put',
            'public':$('#modal-ket .v-publik').val(),
        };
        $.post('{{url('dokumen/manage/change-akses')}}/'+id, data, res=>{
            cash('#modal-ket').modal('hide');
            if(res.status==200){
                showSuccess(res.msg);
                refreshTable();
            }else{
                showError(res.msg);
            }
        })
    }

    function hapusDokumen(id){
        Swal.fire({
            title: 'Yakin menghapus Dokumen?',
            text: 'Anda akan menghapus Dokumen. Dokumen yang telah dihapus tidak dapat di kembalikan. Lanjutkan?',
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
                $.post('{{url("dokumen/manage/delete")}}/'+id, data, res=>{
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

    function mintaAkses(id){
        Swal.fire({
            title: 'Anda akan membuat Pengajuan Dokumen?',
            text: 'Anda harus menunggu respon dari Pemilik Dokumen untuk dapat mengakses dokumen yang Anda minta. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            if (result.isConfirmed) {
                let data = {
                    '_token':'{{csrf_token()}}',
                    'id':id
                };

                $.post('{{route('dok.pengajuan.request')}}', data, res=>{
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
