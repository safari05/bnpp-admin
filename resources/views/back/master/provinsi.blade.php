@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Master</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Provinsi</a>
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
                        <input type="text" class="input w-full border col-span-5" placeholder="Nama Provinsi" name="name" id="name">
                        <select class="input input--lg col-span-5 border mr-2 w-full" name="active" id="active">
                            <option value="-1">Semua</option>
                            <option value="1">Aktif</option>
                            <option value="0">Deaktif</option>
                        </select>
                        <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white" onclick="refreshTable()">Cari</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: General Report -->
        <!-- BEGIN: Sales Report -->
        <div class="col-span-12 lg:col-span-12 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Data Provinsi
                </h2>
                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <button onclick="refreshTable()" class="ml-auto flex text-theme-1 dark:text-theme-10">
                        <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                    </button>
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-prov">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
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
@endsection

@push('js')
<script>
    var table;
    $(document).ready(function () {
        initTable();
        $('body').on('click', '.btn-deactive', function () {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda akan men-deaktivasi Provinsi. Lanjutkan?',
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

                    $.post('{{route('master.prov.change')}}', data, res => {
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
                text: 'Anda akan menaktivasi Provinsi. Lanjutkan?',
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
                    $.post('{{route('master.prov.change')}}', data, res => {
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
                url: '{{ route('master.prov.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                    d.active = ($('#active').val()!= '-1')? $('#active').val():'';
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
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
