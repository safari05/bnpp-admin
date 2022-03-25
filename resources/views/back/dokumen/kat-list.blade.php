@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Dokumen</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Kategori</a>
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
                        <input type="text" class="input w-full border col-span-10" placeholder="Nama Kategori" name="name" id="name">
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
                    Daftar Kategori Dokumen
                </h2>
                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <button class="button button--sm mr-1 mb-2 bg-theme-1 text-white" onclick="tambahKategori()">
                        Tambah Kategori Dokumen
                    </button>
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-kategori">
                    <thead>
                        <th>No</th>
                        <th>Kategori</th>
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
                url: '{{ route('dok.kategori.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'keterangan',name: 'keterangan'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }

    function tambahKategori(){
        $('#modal-ket .v-ket').val('');
        $('#modal-ket .btn-save').html('Simpan');
        $('#modal-ket .btn-save').off('click');
        $('#modal-ket .btn-save').on('click', function(){
            storeKategori();
        })
        cash('#modal-ket').modal('show');
    }

    function storeKategori(){
        const data = {
            '_token':'{{csrf_token()}}',
            'ket':$('#modal-ket .v-ket').val()
        };
        $.post('{{route('dok.kategori.store')}}', data, res=>{
            cash('#modal-ket').modal('hide');
            if(res.status==200){
                showSuccess(res.msg);
                refreshTable();
            }else{
                showError(res.msg);
            }
        })
    }

    function getDetail(id){
        $.getJSON('{{url('dokumen/kategori/get-kategori')}}/'+id, res=>{
            if(res.status = 200){
                $('#modal-ket .v-ket').val(res.data.ket);
                $('#modal-ket .btn-save').html('Update');
                $('#modal-ket .btn-save').off('click');
                $('#modal-ket .btn-save').on('click', function(){
                    updateKategori(id);
                })
                cash('#modal-ket').modal('show');
            }else{
                showError(res.msg);
            }
        });
    }

    function updateKategori(id){
        const data = {
            '_token':'{{csrf_token()}}',
            '_method':'put',
            'ket':$('#modal-ket .v-ket').val()
        };
        $.post('{{url('dokumen/kategori/update')}}/'+id, data, res=>{
            cash('#modal-ket').modal('hide');
            if(res.status==200){
                showSuccess(res.msg);
                refreshTable();
            }else{
                showError(res.msg);
            }
        })
    }

    function hapusKategori(id){
        Swal.fire({
            title: 'Yakin menghapus kategori?',
            text: 'Anda akan menghapus Kategori Dokumen. Dokumen yang berhubungan dengan Kategori ini akan menjadi tidak memiliki kategori. Lanjutkan?',
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
                $.post('{{url("dokumen/kategori/delete")}}/'+id, data, res=>{
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
