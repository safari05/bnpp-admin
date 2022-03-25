@extends('front.layout.main')

@section('title', '| Detail Grafik '.$title)

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
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
        @include('front.infrastruktur-grafik.detail-kecamatan')
    @else
        @include('front.infrastruktur-grafik.detail-kelurahan')
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/echarts@4.9.0/dist/echarts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <script>
        @if($title == 'Kecamatan')
            var apiURL = '{{ url('api/chart-kecamatan') }}';
            var selectedId = '{{ $kec->id }}';
        @else
            var apiURL = '{{ url('api/chart-kelurahan') }}';
            var selectedId = '{{ $desa->id }}';
        @endif

        $(document).ready(function(){
            chartAset();
            chartMobilitas();
            chartPPKT();
            chartUmur();
            chartPeg();
            chartPondes();
        })

        function chartAset(){
            var chart_aset;
            $.getJSON(apiURL+'/aset/'+selectedId, res=>{
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
            $.getJSON(apiURL+'/mobilitas/'+selectedId, res=>{
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

        function chartPPKT(){
            var chartppkt;
            $.getJSON(apiURL+'/ppkt/'+selectedId, res=>{
                chartppkt = new Chart('chart-ppkt', {
                    type: 'bar',
                    data: {
                        labels: ['Jumlah Pulau'],
                        datasets: res.data
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

        function chartUmur(){
            var chart_age;
            $.getJSON(apiURL+'/penduduk/'+selectedId, res=>{
                chart_age = new Chart('chart-penduduk-age', {
                    type: 'bar',
                    data: {
                        labels: ['Jumlah Penduduk'],
                        datasets: res.data
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
            });

            $.getJSON(apiURL+'/penduduk-gender/'+selectedId, res=>{
                chart_gender = new Chart('chart-penduduk-gender', {
                    type: 'doughnut',
                    data: {
                        labels: res.chart.label,
                        datasets: [
                            {
                                label:['Jumlah Penduduk'],
                                data:res.chart.data,
                                backgroundColor:res.chart.backgroundColor,
                                borderColor:res.chart.borderColor,
                                borderWidth:'1'
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
            })
        }

        function chartPeg(){
            var chart_aset;
            //default
            $.getJSON(apiURL+'/kepeg/'+selectedId, res=>{
                chart_aset = new Chart('chart-peg', {
                    type: 'bar',
                    data: {
                        labels: res.chart.label,
                        datasets: [
                            {
                                label: 'ASN',
                                data: res.chart.asn,
                                backgroundColor: res.warna_asn,
                                borderColor:  res.border_asn,
                                borderWidth: 1
                            },
                            {
                                label: 'Non ASN',
                                data: res.chart.non,
                                backgroundColor: res.warna_non,
                                borderColor:  res.border_non,
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
            });

            //asn
            $.getJSON(apiURL+'/kepeg-asn/'+selectedId, res=>{
                chart_aset = new Chart('chart-peg-asn', {
                    type: 'bar',
                    data: {
                        labels: ['Jumlah Pegawai'],
                        datasets: res.data
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

            //lembaga
            $.getJSON(apiURL+'/kepeg-lembaga/'+selectedId, res=>{
                chart_aset = new Chart('chart-peg-lembaga', {
                    type: 'bar',
                    data: {
                        labels: ['Jumlah Pegawai'],
                        datasets: res.data
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

        function chartPondes(){
            var chart_pondes;
            $.getJSON(apiURL+'/pondes/'+selectedId, res=>{
                chart_pondes = new Chart('chart-pondes', {
                    type: 'bar',
                    data: {
                        labels: ['Jumlah Potensi Desa'],
                        datasets: res.data
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
