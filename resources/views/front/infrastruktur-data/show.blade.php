@extends('front.layout.main')

@section('title', '| Detail Data '.$title)

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
@endpush

@push('styles')
    <style>
        body{
            text-align: left;
        }
        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
            padding: 7px 20px;
        }
        .btn-outline {
            color: #28a745;
            background: transparent;
            border: 1px solid #28a745;
        }
        .features-box{
            text-align: left;
        }

        .features-box .time-line-icon{
            text-align: center;
        }
        .features-box h3 {
            padding-bottom: 0;
        }
        .form-control {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem !important;
            font-size: 1rem !important;
            line-height: 1.5 !important;
            color: #495057 !important;
            background-color: #fff !important;
            background-clip: padding-box !important;
            border: 1px solid #ced4da !important;
            border-radius: .25rem !important;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            margin: 0 !important;
        }
        .custom-form label{
            margin-bottom: 5px;
        }
        .list-single-header{
            margin-top: -5px;
        }
        .overlay{
            opacity: .8;
        }
        .list-single-facts .inline-facts-wrap h3, .single-facts .inline-facts-wrap h3 {
            display: block;
            margin: 12px 0;
            font-size: 30px;
            font-weight: 800;
        }
    </style>
@endpush

@section('content')
    @if($title == 'Kecamatan')
        @include('front.infrastruktur-data.detail-kecamatan')
    @else
        @include('front.infrastruktur-data.detail-kelurahan')
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
    <script>
        var table_aset, table_mobil,
            table_ppkt, table_penduduk,
            table_kepeg, table_pondes;

        @if($title == 'Kecamatan')
            var apiURL = '{{ url('api/datatable-kecamatan') }}';
            var selectedId = '{{ $kec->id }}';
        @else
            var apiURL = '{{ url('api/datatable-kelurahan') }}';
            var selectedId = '{{ $desa->id }}';
        @endif

        $(document).ready(function(){
            initTableAset();
            initTableMobil();
            initTablePPKT();
            initTablePondes();
            initTableSipil();
            initTableKepeg();

            $('body').on('click', '.btn-foto-mobil', function(){
                window.open($(this).data('url'));
            })
        })

        async function initTableAset() {
            table_aset = await $('#list-aset').DataTable({
                language: {
                    "paginate": {
                        "previous": 'Prev',
                        "next": 'Next',
                    }
                },
                responsive: true,
                searching: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: apiURL+'/aset/'+selectedId
                },
                columns: [
                    {data: 'rownum',name: 'rownum', searchable: false},
                    {data: 'nama',name: 'nama'},
                    {data: 'jumlah_baik',name: 'jumlah_baik', searchable: false},
                    {data: 'jumlah_rusak',name: 'jumlah_rusak', searchable: false}
                ],
            });
        }

        async function initTableMobil() {
            table_mobil = await $('#list-mobil').DataTable({
                language: {
                    "paginate": {
                        'previous':'Prev',
                        'next':'Next'
                    }
                },
                searching: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: apiURL+'/mobilitas/'+selectedId
                },
                columns: [
                    {data: 'rownum',name: 'rownum', searchable: false},
                    {data: 'nama',name: 'nama'},
                    {data: 'jumlah',name: 'jumlah', searchable: false},
                    {data: 'foto',name: 'foto', searchable: false}
                ],
            });
        }

        async function initTablePPKT() {
            table = await $('#list-ppkt').DataTable({
                language: {
                    "paginate": {
                        "previous": 'Prev',
                        "next": 'Next',
                    }
                },
                searching: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: apiURL+'/ppkt/'+selectedId
                },
                columns: [
                    {data: 'rownum',name: 'rownum', searchable: false},
                    {data: 'nama',name: 'nama'},
                    {data: 'jenis',name: 'jenis'}
                ],
            });
        }

        async function initTablePondes() {
            table_pondes = await $('#list-pondes').DataTable({
                language: {
                    "paginate": {
                        "previous": 'Prev',
                        "next": 'Next',
                    }
                },
                searching: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: apiURL+'/pondes/'+selectedId
                },
                columns: [
                    {data: 'rownum',name: 'rownum', searchable: false},
                    {data: 'nama',name: 'nama'},
                    {data: 'jumlah',name: 'jumlah', searchable: false}
                ],
            });
        }

        async function initTableSipil() {
            table_penduduk = await $('#list-sipil').DataTable({
                language: {
                    "paginate": {
                        "previous": 'Prev',
                        "next": 'Next',
                    }
                },
                searching: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: apiURL+'/penduduk/'+selectedId
                },
                columns: [
                    {data: 'rownum',name: 'rownum', searchable: false},
                    {data: 'ket',name: 'ket'},
                    {data: 'jumlah',name: 'jumlah', searchable: false}
                ],
            });
        }

        async function initTableKepeg() {
            table_kepeg = await $('#list-kepeg').DataTable({
                language: {
                    "paginate": {
                        "previous": 'Prev',
                        "next": 'Next',
                    }
                },
                searching: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: apiURL+'/kepeg/'+selectedId
                },
                columns: [
                    {data: 'rownum',name: 'rownum', searchable: false},
                    {data: 'jenis_asn',name: 'jenis_asn'},
                    {data: 'staf',name: 'staf'},
                    {data: 'lemb',name: 'lemb'},
                    {data: 'jumlah',name: 'jumlah', searchable: false}
                ],
            });
        }
    </script>
@endpush
