@extends('back.layout.main')
@push('css')
<style>
    td.details-control {
        background: url('{{asset('assets/vendor/yajra')}}/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('{{asset('assets/vendor/yajra')}}/details_close.png') no-repeat center center;
    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">Monev</a>
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
                        <select data-search="true" class="input input--lg border mr-2 w-full col-span-3" id="tahun" name="tahun">
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                        </select>
                        <input type="text" class="input w-full border col-span-7" placeholder="Nama Kecamatan" name="name" id="name">
                        <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" onclick="refreshTable()">Cari</button>
                    </div>
                </div>
            </div>
        <!-- END: General Report -->
        <!-- BEGIN: Sales Report -->
        <div class="col-span-12 lg:col-span-12 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Daftar Monev
                </h2>
                {{-- <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <a href="{{route('konten.berita.create')}}">
                        <button class="button button--sm mr-1 mb-2 bg-theme-1 text-white">
                            Tambah Konten
                        </button>
                    </a>
                </div> --}}
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-monev">
                    <thead>
                        <th></th>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatam</th>
                        <th>Provinsi</th>
                        <th>Kota</th>
                        <th>Kecamatan</th>
                        <th>Rata CIQ</th>
                        <th>Rata PAP</th>
                        <th>Waktu Buat</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>
<script id="details-template" type="text/x-handlebars-template">
    @verbatim
    <table class="table">
        <tr>
            <td>Alamat</td>
            <td>{{alamat_kantor}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{email}}</td>
        </tr>
        <tr>
            <td>Telepon</td>
            <td>{{no_hp}}</td>
        </tr>
        <tr>
            <td>Lokpri Batas Darat</td>
            <td>{{lokpri_batas_darat}}</td>
        </tr>
        <tr>
            <td>Lokpri Batas Laut</td>
            <td>{{lokpri_batas_laut}}</td>
        </tr>
        <tr>
            <td>Lokpri PKSN Darat</td>
            <td>{{lokpri_pksn_darat}}</td>
        </tr>
        <tr>
            <td>Lokpri PKSN Laut</td>
            <td>{{lokpri_pksn_laut}}</td>
        </tr>
        <tr>
            <td>Lokpri PPKT</td>
            <td>{{lokpri_ppkt}}</td>
        </tr>
    </table>
    @endverbatim
</script>
<script>
    var table;
    $(document).ready(function () {
        feather.replace();
        initTable();
    })

    async function initTable() {
        var template = Handlebars.compile($("#details-template").html());

        table = await $('#list-monev').DataTable({
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
                url: '{{ route('monev.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                    d.tahun = $('#tahun').val();
                }
            }, 
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "searchable":     false,
                    "data":           null,
                    "defaultContent": ''
                },
                {data: 'rownum',name: 'rownum'},
                {data: 'nama',name: 'nama'},
                {data: 'jabatan',name: 'jabatan'},
                {data: 'provinsi',name: 'provinsi'},
                {data: 'kabupaten',name: 'kabupaten'},
                {data: 'kecamatan',name: 'kecamatan'},
                {data: 'rata_rata_ciq',name: 'rata_rata_ciq'},
                {data: 'rata_rata_pap',name: 'rata_rata_pap'},
                {data: 'created_at',name: 'created_at'},
                {data: 'aksi',name: 'aksi'},
            ],
        });

        // Add event listener for opening and closing details
        $('#list-monev tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( template(row.data()) ).show();
                tr.addClass('shown');
            }
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }
</script>
@endpush
