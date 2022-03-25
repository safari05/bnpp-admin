@extends('back.layout.main')
@push('css')

@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Dashboard</a>
</div>
@endsection

@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-12 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 lg:col-span-12 mt-8">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Daftar Konten
                    </h2>
                    <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                        <a href="{{route('konten.berita.index')}}">
                            <button class="button button--sm mr-1 mb-2 bg-theme-1 text-white">
                                Atur Berita
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
                            {{-- <th>Aksi</th> --}}
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function(){
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
                url: '{{ route('contentGetBerita') }}',
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'judul',name: 'judul'},
                {data: 'kategori',name: 'kategori'},
                {data: 'status',name: 'status'},
                {data: 'penulis',name: 'penulis'},
                {data: 'created_at',name: 'created_at'},
                // {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }
</script>
@endpush
