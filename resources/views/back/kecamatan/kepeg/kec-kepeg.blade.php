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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('kec.index')}}">Kecamatan</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Kepegawaian</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Pegawai Kecamatan
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                @include('back.kecamatan.sub-title')
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <a class="flex items-center" href="#graik-peg"> <i data-feather="users" class="w-4 h-4 mr-2"></i> Grafik Pegawai </a>
                <a class="flex items-center mt-5" href="#grafik-asn"> <i data-feather="user-check" class="w-4 h-4 mr-2"></i> Grafik ASN </a>
                <a class="flex items-center mt-5" href="#grafik-lembaga"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Grafik Kelembagaan </a>
                <a class="flex items-center mt-5" href="#daftar-kepeg"> <i data-feather="box" class="w-4 h-4 mr-2"></i> Daftar Kepegawaian </a>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                @include('back.kecamatan.sub-side')
            </div>
            {{-- <div class="p-5 border-t flex">
                <button type="button" class="button button--sm block bg-theme-1 text-white">New Group</button>
                <button type="button" class="button button--sm border text-gray-700 dark:border-dark-5 dark:text-gray-300 ml-auto">New Quick Link</button>
            </div> --}}
        </div>
        {{-- <div class="intro-y box p-5 bg-theme-1 text-white mt-5">
            <div class="flex items-center">
                <div class="font-medium text-lg">Important Update</div>
                <div class="text-xs bg-white dark:bg-theme-1 dark:text-white text-gray-800 px-1 rounded-md ml-auto">New</div>
            </div>
            <div class="mt-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</div>
            <div class="font-medium flex mt-5">
                <button type="button" class="button button--sm border border-white text-white dark:border-dark-5 dark:text-gray-300">Take Action</button>
                <button type="button" class="button button--sm dark:text-gray-500 ml-auto">Dismiss</button>
            </div>
        </div> --}}
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Grafik Pegawai -->
        <div class="intro-y box mt-5" id="grafik-peg">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Grafik Pegawai
                </h2>
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <canvas id="chart-peg" height="130"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Grafik Pegawai -->

        <!-- BEGIN: Grafik ASN -->
        <div class="intro-y box mt-5" id="grafik-asn">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Grafik ASN
                </h2>
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <canvas id="chart-asn" height="130"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Grafik ASN -->

        <!-- BEGIN: Grafik Lembaga -->
        <div class="intro-y box mt-5" id="grafik-lembaga">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Grafik Kelembagaan
                </h2>
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <canvas id="chart-lembaga" height="130"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Grafik Lembaga -->

        <!-- BEGIN: Daftar Pegawai -->
        <div class="intro-y box mt-5" id="daftar-kepeg">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Daftar Kepegawaian
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('kecamatan/kepeg')}}/{{$kec->id}}/create">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Tambah Pegawai
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <table class="table -mt-2" id="list-kepeg">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis ASN</th>
                            <th>Staf Bagian</th>
                            <th>Kelembagaan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END: Daftar Pegawai -->

    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
<script>
    var table_aset;
    var table_mobil;
    $(document).ready(function(){
        initTableKepeg();
        chartPeg();
        chartASN();
        chartLembaga();

        $('body').on('click', '.btn-edit-kepeg', function(){
            window.location.replace("{{url('kecamatan/kepeg').'/'.$kec->id.'/edit' }}/"+$(this).data('id'));
        })
    })

    async function initTableKepeg() {
        table_aset = await $('#list-kepeg').DataTable({
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
                url: '{{ url('kecamatan/kepeg').'/'.$kec->id.'/list' }}',
                data : function(d){
                    d.q = $('#name').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'jenis_asn',name: 'jenis_asn'},
                {data: 'staf',name: 'staf'},
                {data: 'lemb',name: 'lemb'},
                {data: 'jumlah',name: 'jumlah'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function chartPeg(){
        var chart_aset;
        $.getJSON('{{url('kecamatan/kepeg')}}/{{$kec->id}}/c/peg', res=>{
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
        })

    }

    function chartASN(){
        var chart_aset;
        $.getJSON('{{url('kecamatan/kepeg')}}/{{$kec->id}}/c/asn', res=>{
            chart_aset = new Chart('chart-asn', {
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

    function chartLembaga(){
        var chart_aset;
        $.getJSON('{{url('kecamatan/kepeg')}}/{{$kec->id}}/c/lembaga', res=>{
            chart_aset = new Chart('chart-lembaga', {
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
</script>
@endpush
