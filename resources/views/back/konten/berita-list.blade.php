@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Konten</a>
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
                        <select data-search="true" class="input input--lg border mr-2 w-full col-span-6" id="status" placeholder="Status Konten" name="status">
                            <option value="-1">Semua</option>
                            <option value="0">Draft</option>
                            <option value="1">Sudah Publis</option>
                        </select>
                        <select data-search="true" class="input input--lg border mr-2 w-full col-span-6" id="kategori">
                            <option value="0">Semua</option>
                            @foreach ($kategoris as $item)
                            <option value="{{$item->idcategory}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                        <input type="text" class="input w-full border col-span-10" placeholder="Judul Konten" name="name" id="name">
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
                    Daftar Konten
                </h2>
                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <a href="{{route('konten.berita.create')}}">
                        <button class="button button--sm mr-1 mb-2 bg-theme-1 text-white">
                            Tambah Konten
                        </button>
                    </a>
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-kategori">
                    <thead>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Penulis</th>
                        <th>Tanggal Buat</th>
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
                    <h2 class="text-2xl">Edit Kategori Dokumen</h2>
                </div>
                <div class="col-span-12">
                    <label for="">Kategori Dokumen</label>
                    <input type="text" class="input w-full border mt-2 col-span-10 v-ket" placeholder="Nama Kategori" name="ketarangan">
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
        table = await $('#list-kategori').DataTable({
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
                url: '{{ route('konten.berita.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                    d.kat = $('#kategori').val();
                    d.status = $('#status').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'judul',name: 'judul'},
                {data: 'kategori',name: 'kategori'},
                {data: 'status',name: 'status'},
                {data: 'penulis',name: 'penulis'},
                {data: 'created_at',name: 'created_at'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }

    function hapusKonten(id){
        Swal.fire({
            title: 'Yakin menghapus Konten?',
            text: 'Anda akan menghapus Konten. Konten sudah dihapus tidak dapat dikembalikan. Lanjutkan?',
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
                $.post('{{url("konten/berita/delete")}}/'+id, data, res=>{
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
