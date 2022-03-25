@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('dok.manage.index')}}">Dokumen</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('dok.pengajuan.index')}}">Pengajuan</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Riwayat</a>
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
                        <th>Waktu Pengajuan</th>
                        <th>Status</th>
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
                url: '{{ route('dok.pengajuan.history.list') }}',
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
                {data: 'waktu',name: 'waktu'},
                {data: 'status',name: 'status'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }
</script>
@endpush
