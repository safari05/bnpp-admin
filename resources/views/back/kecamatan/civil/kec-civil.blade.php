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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('kec.index')}}" >Kecamatan</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Aset</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Aset Kecamatan
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
                <a class="flex items-center" href="#detail-sipil"> <i data-feather="truck" class="w-4 h-4 mr-2"></i> Detail Penduduk </a>
                <a class="flex items-center mt-5" href="#grafik-gender"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Grafik Penduduk (Gender) </a>
                <a class="flex items-center mt-5" href="#grafik-age"> <i data-feather="box" class="w-4 h-4 mr-2"></i> Grafik Penduduk (Umur) </a>
                <a class="flex items-center mt-5" href="#daftar-sipil"> <i data-feather="truck" class="w-4 h-4 mr-2"></i> Daftar Penduduk (Umur) </a>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                @include('back.kecamatan.sub-side')
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Detail Penduduk -->
        <div class="intro-y box mt-5" id="detail-sipil">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Detail Penduduk
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('kecamatan/sipil')}}/{{$kec->id}}/detail/create">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Kelola Penduduk
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jumlah Penduduk</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg" id="total">-</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jumlah KK</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg" id="kk">-</div>
                    </div>
                </div>
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Penduduk Pria</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg" id="pria">-</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Penduduk Wanita</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg" id='wanita'>-</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Daftar Aset -->

        <!-- BEGIN: Grafik Aset -->
        <div class="intro-y box mt-5" id="grafik-gender">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Grafik Penduduk (Gender)
                </h2>
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <canvas id="chart-gender" height="130"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Grafik Aset -->

        <!-- BEGIN: Grafik Mobilitas -->
        <div class="intro-y box mt-5" id="grafik-age">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Grafik Penduduk (Umur)
                </h2>
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <canvas id="chart-age" height="130"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Grafik Mobilitas -->

        <!-- BEGIN: Daftar Mobilitas -->
        <div class="intro-y box mt-5" id="daftar-sipil">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Daftar Penduduk (Umur)
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('kecamatan/sipil')}}/{{$kec->id}}/ages/create">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Tambah Kategori Penduduk
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <table class="table -mt-2" id="list-sipil">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
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
        getDetailSipil();
        initTableSipil();
        chartGender();
        chartUmur();

        $('body').on('click', '.btn-edit-sipil', function(){
            window.location.replace("{{url('kecamatan/sipil').'/'.$kec->id.'/edit' }}/"+$(this).data('id'));
        })
    })

    function getDetailSipil(){
        $.getJSON('{{url('kecamatan/sipil')}}/{{$kec->id}}/data-detail', res=>{
            if(res.status == 200){
                $('#total').html(res.data.total+' Orang');
                $('#kk').html(res.data.kk+' Orang');
                $('#pria').html(res.data.pria+' Orang');
                $('#wanita').html(res.data.wanita+' Orang');
            }
        });
    }

    async function initTableSipil() {
        table_aset = await $('#list-sipil').DataTable({
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
                url: '{{ url('kecamatan/sipil').'/'.$kec->id.'/list' }}',
                data : function(d){
                    d.q = $('#name').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'ket',name: 'ket'},
                {data: 'jumlah',name: 'jumlah'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function chartGender(){
        var chart_gender;
        $.getJSON('{{url('kecamatan/sipil')}}/{{$kec->id}}/c/gender', res=>{
            chart_gender = new Chart('chart-gender', {
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

    function chartUmur(){
        var chart_age;
        $.getJSON('{{url('kecamatan/sipil')}}/{{$kec->id}}/c/age', res=>{
            chart_age = new Chart('chart-age', {
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
        })

    }
</script>
@endpush
