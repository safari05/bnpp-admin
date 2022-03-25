@extends('back.layout.main')
@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Master</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Kepegawaian</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Kelembagaan</a>
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
                        <input type="text" class="input w-full border col-span-10" placeholder="Nama Kelembagaan" name="name" id="name" tabindex="1">
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
                    Data Kelembagaan
                </h2>
                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <button class="button w-24 mr-1 mb-2 bg-theme-1 text-white w-full" onclick="tambahAset()">Tambah</button>
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-prov">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END: Sales Report -->
    </div>
</div>

{{-- START: Modal Aset --}}
<div class="modal" id="modal-aset">
    <div class="modal__content p-10 text-center">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12">
                <h3>Tambah Jenis Kelembagaan</h3>
            </div>
            <div class="col-span-12 text-center">
                <input type="text" class="input w-full border" placeholder="Nama Kelembagaan" name="input-nama" id="input-nama">
            </div>
            <div class="col-span-6">
                <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" id="btn-simpan-aset">Simpan</button>
            </div>
            <div class="col-span-6">
                <button class="button w-24 mr-1 mb-2 bg-theme-2 col-span-2 text-gray-700 w-full" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
{{-- END: Modal Aset --}}
@endsection

@push('js')
<script>
    var table;
    $(document).ready(function () {
        initTable();
    })

    function initTable() {
        table = $('#list-prov').DataTable({
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
                url: '{{ route('master.kep.lembaga.list') }}',
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

    function tambahAset(){
        $('#input-nama').val('');
        $('#btn-simpan-aset').off('click');
        $('#btn-simpan-aset').on('click', function(){
            cash('#modal-aset').modal('hide');

            let data = {
                '_token':'{{csrf_token()}}',
                'keterangan':$('#input-nama').val(),
            };
            console.log(data);
            $.post('{{route('master.kep.lembaga.store')}}', data, res=>{
                if (res.status == 200) {
                    refreshTable();
                    showSuccess(res.msg);
                } else {
                    showError(res.msg);
                }
            });
        });
        cash('#modal-aset').modal('show');
    }

    function hapusAset(id){
        Swal.fire({
            title: 'Hapus Jenis Kelembagaan',
            text: 'Jenis Kelembagaan yang dihapus tidak dapat dikembalikan. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                const data = {
                    '_token':'{{csrf_token()}}',
                    '_method':'delete',
                    'id':id
                };

                $.post('{{url('kepdata/lembaga/delete')}}/'+id, data, res=>{
                    if (res.status == 200) {
                        refreshTable();
                        showSuccess(res.msg);
                    } else {
                        showError(res.msg);
                    }
                });
            }
        })
    }

</script>
@endpush
