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
                        Grafik Potensi Desa
                    </h2>
                    {{-- <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a> --}}
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-12 xl:col-span-12 intro-y">
                        <div class="box p-5">
                            <div class="mt-4">
                                <canvas id="chart-pondes" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-12 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Daftar Desa Perbatasan
                    </h2>
                    {{-- <a href="" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a> --}}
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 mt-8 box p-5">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Pencarian
                            </h2>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 intro-y">
                                <div class="grid grid-cols-12 gap-6">
                                    <input type="text" class="input w-full border col-span-10" placeholder="Nama Desa" name="name" id="name">
                                    <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" onclick="refreshTable()">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-12 xl:col-span-12 intro-y">
                        <div class="intro-y block sm:flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Daftar Desa
                            </h2>
                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                                <button onclick="refreshTable()" class="ml-auto flex text-theme-1 dark:text-theme-10">
                                    <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                                </button>
                            </div>
                        </div>
                        <div class="intro-y box p-5 mt-12 sm:mt-5">
                            <table class="table table-report -mt-2" id="list-desa">
                                <thead>
                                    <th>No</th>
                                    <th>Kota</th>
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody></tbody>
                            </table>
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
        initTable();
        chartPondes();

        $('body').on('click', '.btn-desa-detail', function (){
            window.location.replace('{{url('desa/detail')}}/'+$(this).data('id'));
        })
    });

    function chartPondes(){
        var chartPondes;
        $.getJSON('{{route('camatGetPondes')}}', res=>{
            if(res){
                chartPondes = new Chart('chart-pondes', {
                    type: 'bar',
                    data: {
                        labels: res.data.label,
                        datasets: [
                            {
                                label: 'Jumlah Pondes',
                                data: res.data.pondes,
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

    async function initTable() {
        table = await $('#list-desa').DataTable({
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
                url: '{{ route('camatListDesa') }}',
                data : function(d){
                    d.q = $('#name').val();
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

    function refreshTable() {
        table.ajax.reload();
    }
</script>

@endpush
