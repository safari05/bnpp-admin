@extends('back.layout.main')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
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
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Grafik Lokasi Prioritas
                    </h2>
                    {{-- <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a> --}}
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-12 xl:col-span-12 intro-y">
                        <div class="box p-5">
                            <div class="mt-4">
                                <canvas id="chart-lokpri" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-12 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Grafik Tipe Kecamatan
                    </h2>
                    <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-12 xl:col-span-12 intro-y">
                        <div class="box p-5">
                            <div class="mt-4">
                                <canvas id="chart-tipe" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-6 xxl:col-span-6 grid grid-cols-6 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Grafik Kecamatan Binaan
                    </h2>
                    {{-- <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a> --}}
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-12 xl:col-span-12 intro-y">
                        <div class="box p-5">
                            <div class="mt-4">
                                <canvas id="chart-kec" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-6 xxl:col-span-6 grid grid-cols-6 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Grafik Desa Binaan
                    </h2>
                    {{-- <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a> --}}
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-12 xl:col-span-12 intro-y">
                        <div class="box p-5">
                            <div class="mt-4">
                                <canvas id="chart-desa" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        chartLokpri();
        // chartTipe();
        chartKecamatan();
        chartDesa();
    });

    function chartLokpri(){
        var chartLokrpi;
        $.getJSON('{{route('masterGetLokpri')}}', res=>{
            if(res){
                chartLokrpi = new Chart('chart-lokpri', {
                    type: 'bar',
                    data: {
                        labels: res.data.label,
                        datasets: [
                            {
                                label: 'Lokpri',
                                data: res.data.lokpri,
                                backgroundColor: 'rgba(247, 55, 55, 0.8)',
                                borderColor: 'rgba(247, 55, 55, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'PKSN',
                                data: res.data.pksn,
                                backgroundColor: 'rgba(158, 247, 45, 0.8)',
                                borderColor: 'rgba(158, 247, 45, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'PPKT',
                                data: res.data.ppkt,
                                backgroundColor: 'rgba(247, 186, 45, 0.8)',
                                borderColor: 'rgba(247, 186, 45, 1)',
                                borderWidth: 1
                            }
                        ]
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
            }
        })
    }

    // function chartTipe(){
    //     var chartTipe;
    //     $.getJSON('{{route('masterGetTipe')}}', res=>{
    //         if(res){
    //             chartTipe = new Chart('chart-tipe', {
    //                 type: 'bar',
    //                 data: {
    //                     labels: res.data.label,
    //                     datasets: [
    //                         {
    //                             label: '778',
    //                             data: res.data.tipe778,
    //                             backgroundColor: 'rgba(247, 55, 55, 0.8)',
    //                             borderColor: 'rgba(247, 55, 55, 1)',
    //                             borderWidth: 1
    //                         },
    //                         {
    //                             label: '562',
    //                             data: res.data.tipe562,
    //                             backgroundColor: 'rgba(158, 247, 45, 0.8)',
    //                             borderColor: 'rgba(158, 247, 45, 1)',
    //                             borderWidth: 1
    //                         },
    //                         {
    //                             label: '231',
    //                             data: res.data.tipe231,
    //                             backgroundColor: 'rgba(247, 186, 45, 0.8)',
    //                             borderColor: 'rgba(247, 186, 45, 1)',
    //                             borderWidth: 1
    //                         }
    //                     ]
    //                 },
    //                 options: {
    //                     scales: {
    //                         yAxes: [{
    //                             ticks: {
    //                                 beginAtZero: true
    //                             }
    //                         }]
    //                     }
    //                 }
    //             });
    //         }
    //     })
    // }

    function chartKecamatan(){
        var chartKec;
        $.getJSON('{{route('masterGetKecByProv')}}', res=>{
            if(res){
                chartKec = new Chart('chart-kec', {
                    type: 'bar',
                    data: {
                        labels: res.data.label,
                        datasets: [
                            {
                                label: 'Kecamatan Binaan',
                                data: res.data.jumlah,
                                backgroundColor: 'rgba(247, 55, 55, 0.8)',
                                borderColor: 'rgba(247, 55, 55, 1)',
                                borderWidth: 1
                            },
                        ]
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
            }
        })
    }

    function chartDesa(){
        var chartDesa;
        $.getJSON('{{route('masterGetDesaByProv')}}', res=>{
            if(res){
                chartDesa = new Chart('chart-desa', {
                    type: 'bar',
                    data: {
                        labels: res.data.label,
                        datasets: [
                            {
                                label: 'Desa Binaan',
                                data: res.data.jumlah,
                                backgroundColor: 'rgba(247, 55, 55, 0.8)',
                                borderColor: 'rgba(247, 55, 55, 1)',
                                borderWidth: 1
                            },
                        ]
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
            }
        })
    }
</script>

@endpush
