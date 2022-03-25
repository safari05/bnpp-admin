@extends('front.layout.main')

@section('title', '| Data Infrastruktur Perbatasan')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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

        .checkbox label:hover{
            cursor: pointer;
        }
        .checkbox label{
            display: flex;
            align-items: center;
            font-size: 16px;
        }
        .checkbox input{
            margin-right: 7px;
        }
        .custom-form input[type='checkbox'] {
             margin-bottom: 0;
        }
        .table{
            width: 100% !important;
        }
    </style>
@endpush

@section('content')
    <!--section -->
    <!--section -->
    <section class="parallax-section text-center" data-scrollax-parent="true">
        <div class="bg par-elem"  data-bg="{{asset('assets/front')}}/images/bg/infrastruktur.jpg" data-scrollax="properties: { translateY: '30%' }"></div>
        <div class="overlay"></div>
        <div class="container">
            <div class="section-title center-align">
                <h2><span>Data & Grafik Infrastruktur Perbatasan</span></h2>
                <div class="breadcrumbs fl-wrap"><a href="{{ route('home') }}">Beranda</a><span>Data & Grafik Infrastruktur Perbatasan</span></div>
                <span class="section-separator"></span>
            </div>
        </div>
        <div class="header-sec-link">
            <div class="container"><a href="#sec1" class="custom-scroll-link">Baca Selengkapnya</a></div>
        </div>
    </section>
    <!-- section end -->

    <!--section -->
    <section  id="sec1">
        <div class="container">
            <div class="section-title">
                <h2>Data & Grafik</h2>
                <div class="section-subtitle">Infrastruktur Perbatasan</div>
                <span class="section-separator"></span>
                <p>Pilih data infrastruktur perbatasan yang akan ditampilkan</p>
            </div>

            <!-- features-box-container -->
            <div class="features-box-container fl-wrap row">
                <!--features-box -->
                <div class="features-box col-md-6">
                    <div class="time-line-icon">
                        <i class="fa fa-institution"></i>
                    </div>
                    <h3>Kecamatan</h3>
                    <p>Tampilkan data infrastuktur perbatasan kawasan Kecamatan</p>
                    <a href="#list-kecamatan" class="btn btn-success btnList">Terpilih</a>
                </div>
                <!-- features-box end  -->
                <!--features-box -->
                <div class="features-box col-md-6">
                    <div class="time-line-icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <h3>Desa</h3>
                    <p>Tampilkan data infrastuktur perbatasan kawasan Desa</p>
                    <a href="#list-kelurahan" class="btn btn-success btn-outline btnList">Lihat Data</a>
                </div>
                <!-- features-box end  -->
            </div>
            <!-- features-box-container end  -->
        </div>
    </section>
    <!-- section end -->

    <!-- section -->
    @include('front.infrastruktur-data.list-kecamatan')

    <!-- section -->
    @include('front.infrastruktur-data.list-kelurahan')
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        var tableKec;
        var tableDesa;
        $(document).ready(function () {
            /** Default Page Component **/
            $('.form-select2').select2();

            $('.btnList').on('click', function(e){
                e.preventDefault();
                var target = $(this).attr('href');

                $('.btnList').addClass('btn-outline');
                $('.btnList').text('Lihat Data');
                $(this).removeClass('btn-outline');
                $(this).text('Terpilih');

                $('.infra-list').addClass('hidden');
                $(target).removeClass('hidden');

                setTimeout(function(){
                    $('body, html').animate({
                        'scrollTop' : ($(target).offset().top-100)+'px'
                    }, 500);
                }, 100);
            });
            /** End Default Page Component **/

            /** Table Kecamatan Data Component **/
            initTableKecamatan();

            initKota(11);
            $('#provid').on('change', function(){
                initKota($(this).val());
            })

            $('#list-content-kecamatan').on('click', '.btn-detail', function (){
                window.location.replace('{{url('infrastruktur-data/kecamatan')}}/'+$(this).data('id'));
            })
            /** End Table Kecamatan Data Component **/

            /** Table Desa Data Component **/
            initTableDesa();

            initKota(0, '_kel');
            $('#provid_kel').on('change', function(){
                initKota($(this).val(), '_kel');
            })

            initKec(0, '_kel');
            $('#kotaid_kel').on('change', function(){
                initKec($(this).val(), '_kel');
            })

            $('#list-content-kelurahan').on('click', '.btn-detail', function (){
                window.location.replace('{{url('infrastruktur-data/kelurahan')}}/'+$(this).data('id'));
            })
            /** End Table Desa Data Component **/
        })

        function initKota(prov = 0, tipe = ''){
            $.getJSON('{{route('opt.kota')}}?provid='+prov,
                res=>{
                    $('#kotaid'+tipe).html('');
                    $('#kotaid'+tipe).append('<option value="0">Semua Kota</option>');
                    if(res){
                        res.forEach(element => {
                            let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                            $('#kotaid'+tipe).append(opt);
                        });
                    }
                },
            )
        }

        function initKec(kota = 0, tipe = ''){
            $.getJSON('{{route('opt.kec')}}?kotaid='+kota,
                res=>{
                    $('#kecid'+tipe).html('');
                    $('#kecid'+tipe).append('<option value="0">Semua Kecamatan</option>');
                    if(res){
                        res.forEach(element => {
                            let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                            $('#kecid'+tipe).append(opt);
                        });
                    }
                },
            )
        }

        /** Table Kecamatan Component **/
        async function initTableKecamatan() {
            tableKec = await $('#list-content-kecamatan').DataTable({
                language: {
                    "paginate": {
                        'previous':'Prev',
                        'next':'Next'
                    }
                },
                responsive: true,
                searching: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url('api/datatable-kecamatan') }}',
                    data : function(d){
                        d.q = $('#name').val();
                        d.provid = $('#provid').val();
                        d.kotaid = $('#kotaid').val();

                        let tipe = '';
                        let tipecheck = document.querySelectorAll('.s-check-tipe');
                        tipecheck.forEach(element => {
                            if($(element).prop('checked')){
                                if(tipe == '') tipe = $(element).val();
                                else tipe += ','+$(element).val();
                            }
                        });
                        d.tipe = tipe;

                        let lokpri = '';
                        let lokpricheck = document.querySelectorAll('.s-check-lokpri');
                        lokpricheck.forEach(element => {
                            if($(element).prop('checked')){
                                if(lokpri == '') lokpri = $(element).val();
                                else lokpri += ','+$(element).val();
                            }
                        });
                        d.lokpri = lokpri;

                    }
                },
                columnDefs: [
                    { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: 5 },
                ],
                columns: [
                    {data: 'rownum',name: 'rownum'},
                    {data: 'kota',name: 'kota'},
                    {data: 'name',name: 'name'},
                    {data: 'tipe',name: 'tipe'},
                    {data: 'lokpri',name: 'lokpri'},
                    {data: 'aksi',name: 'aksi'},
                ],
            });
        }

        function refreshTableKec() {
            tableKec.ajax.reload();
        }
        /** End Table Kecamatan Component **/

        /** End Table Desa Component **/
        async function initTableDesa() {
            tableDesa = await $('#list-content-kelurahan').DataTable({
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
                    url: '{{ url('api/datatable-kelurahan') }}',
                    data : function(d){
                        d.q = $('#name_kel').val();
                        d.provid = $('#provid_kel').val();
                        d.kotaid = $('#kotaid_kel').val();
                        d.kecid = $('#kecid_kel').val();
                    }
                },
                columns: [
                    {data: 'rownum',name: 'rownum'},
                    {data: 'kota',name: 'kota'},
                    {data: 'kec',name: 'kec'},
                    {data: 'name',name: 'name'},
                    {data: 'aksi',name: 'aksi'},
                ],
            });
        }

        function refreshTableDesa() {
            tableDesa.ajax.reload();
        }
        /** End Table Desa Component **/

    </script>
@endpush
