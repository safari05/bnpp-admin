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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Potensi Desa</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Potensi Desa
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
                <a class="flex items-center" href="#grafik-pondes"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Grafik Potensi Desa </a>
                <a class="flex items-center mt-5" href="#daftar-pondes"> <i data-feather="box" class="w-4 h-4 mr-2"></i> Daftar Potensi Desa </a>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                @include('back.desa.sub-side')
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Grafik Potensi Desa -->
        <div class="intro-y box mt-5" id="grafik-pondes">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Grafik Potensi Desa
                </h2>
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <canvas id="chart-pondes" height="130"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Grafik Potensi Desa -->

        <!-- BEGIN: Daftar Potensi Desa -->
        <div class="intro-y box mt-5" id="daftar-pondes">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Daftar Potensi Desa
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('desa/pondes')}}/{{$desa->id}}/create">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Tambah Potensi Desa
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <table class="table -mt-2" id="list-pondes">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Potensi Desa</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END: Daftar Potensi Desa -->
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
<script>
    var table_pondes;
    $(document).ready(function(){
        initTablePondes();
        chartPondes();

        $('body').on('click', '.btn-edit-pondes', function(){
            window.location.replace("{{url('desa/pondes').'/'.$desa->id.'/edit' }}/"+$(this).data('id'));
        })
    })

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
                url: '{{ url('desa/pondes').'/'.$desa->id.'/list' }}',
                data : function(d){
                    d.q = $('#name').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'nama',name: 'nama'},
                {data: 'jumlah',name: 'jumlah'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function chartPondes(){
        var chart_pondes;
        $.getJSON('{{url('desa/pondes')}}/{{$desa->id}}/chart', res=>{
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
