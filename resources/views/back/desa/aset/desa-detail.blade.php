@extends('back.layout.main')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<style>
    .d-none{
        display: none;
    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('desa.index')}}">Desa</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Aset</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Aset Desa
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                @include('back.desa.sub-title')
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <a class="flex items-center" href="#grafik-aset"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Grafik Aset </a>
                <a class="flex items-center mt-5" href="#daftar-aset"> <i data-feather="box" class="w-4 h-4 mr-2"></i> Daftar Aset </a>
                <a class="flex items-center mt-5" href="#grafik-mobil"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Grafik Mobilitas </a>
                <a class="flex items-center mt-5" href="#daftar-mobil"> <i data-feather="truck" class="w-4 h-4 mr-2"></i> Daftar Mobilitas </a>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                @include('back.desa.sub-side')
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Grafik Aset -->
        <div class="intro-y box mt-5" id="grafik-aset">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Grafik Aset
                </h2>
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <canvas id="chart-aset" height="130"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Grafik Aset -->

        <!-- BEGIN: Daftar Aset -->
        <div class="intro-y box mt-5" id="daftar-aset">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Daftar Aset
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('desa/aset')}}/{{$desa->id}}/create">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Tambah Aset
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <table class="table -mt-2" id="list-aset">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Aset</th>
                            <th>Jumlah Baik</th>
                            <th>Jumlah Rusak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END: Daftar Aset -->


        <!-- BEGIN: Grafik Mobilitas -->
        <div class="intro-y box mt-5" id="grafik-mobil">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Grafik Mobilitas
                </h2>
                {{-- <div class="dropdown ml-auto">
                    <a class="dropdown-toggle w-5 h-5 block sm:hidden" href="javascript:;"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-700 dark:text-gray-300"></i> </a>
                    <button class="dropdown-toggle button font-normal border dark:border-dark-5 text-white relative items-center text-gray-700 dark:text-gray-300 hidden sm:flex"> Export <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> </button>
                    <div class="dropdown-box w-40">
                        <div class="dropdown-box__content box dark:bg-dark-1">
                            <div class="px-4 py-2 border-b border-gray-200 dark:border-dark-5 font-medium">Export Tools</div>
                            <div class="p-2">
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="printer" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> Print </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="external-link" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> Excel </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> CSV </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="archive" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> PDF </a>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <canvas id="chart-mobil" height="130"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Grafik Mobilitas -->

        <!-- BEGIN: Daftar Mobilitas -->
        <div class="intro-y box mt-5" id="daftar-mobil">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Daftar Mobilitas
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('desa/mobilitas')}}/{{$desa->id}}/create">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Tambah Mobilitas
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <table class="table -mt-2" id="list-mobil">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama mobilitas</th>
                            <th>Jumlah</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END: Daftar Mobilitas -->
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
<script>
    var table_aset;
    var table_mobil;
    $(document).ready(function(){
        initTableAset();
        initTableMobil();
        chartAset();
        chartMobilitas();

        $('body').on('click', '.btn-edit-aset', function(){
            window.location.replace("{{url('desa/aset').'/'.$desa->id.'/edit' }}/"+$(this).data('id'));
        })

        $('body').on('click', '.btn-edit-mobil', function(){
            window.location.replace("{{url('desa/mobilitas').'/'.$desa->id.'/edit' }}/"+$(this).data('id'));
        })

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
            searching: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url('desa/aset').'/'.$desa->id.'/list' }}',
                data : function(d){
                    d.q = $('#name').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'nama',name: 'nama'},
                {data: 'jumlah_baik',name: 'jumlah_baik'},
                {data: 'jumlah_rusak',name: 'jumlah_rusak'},
                {data: 'aksi',name: 'aksi'},
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
                url: '{{ url('desa/mobilitas').'/'.$desa->id.'/list' }}',
                data : function(d){
                    d.q = $('#name').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'nama',name: 'nama'},
                {data: 'jumlah',name: 'jumlah'},
                {data: 'foto',name: 'foto'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function chartAset(){
        var chart_aset;
        $.getJSON('{{url('desa/aset')}}/{{$desa->id}}/chart', res=>{
            chart_aset = new Chart('chart-aset', {
                type: 'bar',
                data: {
                    labels: res.chart.label,
                    datasets: [
                        {
                            label: 'Baik',
                            data: res.chart.baik,
                            backgroundColor: res.warna_baik,
                            borderColor:  res.border_baik,
                            borderWidth: 1
                        },
                        {
                            label: 'Rusak',
                            data: res.chart.rusak,
                            backgroundColor: res.warna_rusak,
                            borderColor:  res.border_rusak,
                            borderWidth: 1
                        },
                    ],
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        })

    }

    function chartMobilitas(){
        var chart_aset;
        $.getJSON('{{url('desa/mobilitas')}}/{{$desa->id}}/chart', res=>{
            chart_aset = new Chart('chart-mobil', {
                type: 'bar',
                data: {
                    labels: res.chart.label,
                    datasets: [
                        {
                            label: 'Jumlah Item',
                            data: res.chart.jumlah,
                            backgroundColor: res.warna_baik,
                            borderColor:  res.border_baik,
                            borderWidth: 1
                        },
                    ],
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        })

    }
</script>
@endpush
