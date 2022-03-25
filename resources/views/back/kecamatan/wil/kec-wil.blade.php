@extends('back.layout.main')

@push('css')
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet/leaflet.css"/>
<link rel="stylesheet" href="{{asset('assets/vendor')}}/leaflet-markercluster/MarkerCluster.Default.css"/>
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
                <a class="flex items-center" href="#wil-map"> <i data-feather="map" class="w-4 h-4 mr-2"></i> Peta Lokasi Kecamatan </a>
                <a class="flex items-center mt-5" href="#wil-admin"> <i data-feather="edit" class="w-4 h-4 mr-2"></i> Informasi Administrasi Wilayah</a>
                <a class="flex items-center mt-5" href="#wil-batas"> <i data-feather="hexagon" class="w-4 h-4 mr-2"></i> Batas Kecamatan </a>
                <a class="flex items-center mt-5" href="#grafik-ppkt"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Grafik Pulau Pulau Kecil Terluar </a>
                <a class="flex items-center mt-5" href="#daftar-ppkt"> <i data-feather="rss" class="w-4 h-4 mr-2"></i> Pulau Pulau Kecil Terluar </a>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                @include('back.kecamatan.sub-side')
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Map -->
        <div class="intro-y box mt-5" id="wil-map">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Peta Lokasi Kantor Kecamatan
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('kecamatan/wil')}}/{{$kec->id}}/pin">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Lokasi Kantor
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <div id="map-kec" style="width: 100%; height: 600px;"></div>
                </div>
            </div>
        </div>
        <!-- END: Map -->
        <!-- BEGIN: Administrasi -->
        <div class="intro-y box mt-5" id="wil-admin">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Administrasi Wilayah
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('kecamatan/wil')}}/{{$kec->id}}/atur/adm">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Wilayah
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Ibu Kota Kecamatan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->ibukota_kecamatan??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Luas Wilayah</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->luas_wilayah??'-'}} Km<sup>2</sup></div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jarak ke Kota</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->jarak_ke_kota??'-'}} Km<sup>2</sup></div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jarak ke Provinsi</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->jarak_ke_provinsi??'-'}} Km<sup>2</sup></div>
                    </div>
                </div>

                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jumlah Desa</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->jumlah_desa??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jumlah Kelurahan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->jumlah_kelurahan??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jumlah Pulau</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->jumlah_pulau??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">PLB</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->nama_plb??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Status PLB</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{(@$wilayah->status_plb==1)? 'Ada':'Tidak Ada'}}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Administrasi -->
        <!-- BEGIN: Batas Kecamatan -->
        <div class="intro-y box mt-5" id="wil-batas">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Batas Kecamatan
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('kecamatan/wil')}}/{{$kec->id}}/atur/batas">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Atur Wilayah
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Barat</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->batas_barat??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Timur</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->batas_timur??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Selatan</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->batas_selatan??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Utara</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->batas_utara??'-'}}</div>
                    </div>
                </div>
                <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Batas Negara</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$wilayah->batas_negara??'-'}}</div>
                    </div>
                    <div class="text-center rounded-md w-40 py-3">
                        <div class="text-gray-600">Jenis Batas Negara</div>
                        <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{(@$wilayah->batas_negara_jenis==1)? 'Darat':'Laut'}}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Batas Kecamatan -->

        <!-- BEGIN: Grafik PPKT -->
        <div class="intro-y box mt-5" id="grafik-ppkt">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Grafik Pulau Pulau Kecil Terluar
                </h2>
            </div>
            <div class="p-5">
                <div class="mt-4">
                    <canvas id="chart-ppkt" height="130"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Grafik PPKT -->
        <!-- BEGIN: Daftar PPKT -->
        <div class="intro-y box mt-5" id="daftar-ppkt">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Daftar Pulau Pulau Kecil Terluar
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{url('kecamatan/wil')}}/{{$kec->id}}/ppkt/create">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Tambah PPKT
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <table class="table -mt-2" id="list-ppkt">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama PPKT</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END: Daftar PPKT -->
    </div>
</div>
@endsection
@push('js')
<script src="{{asset('assets/vendor')}}/leaflet/leaflet.js"></script>
<script src="{{asset('assets/vendor')}}/leaflet-markercluster/leaflet.markercluster.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
<script>
    var table;
    const active_lat = '{{$coord["lat"]}}';
    const active_lng = '{{$coord["lng"]}}';
    $(document).ready(function(){
        initMapKecamatan();
        initTablePPKT();
        chartppkt();

        $('body').on('click', '.btn-delete-ppkt', function(){
            Swal.fire({
                title: 'Peringatan! Data akan dihapus',
                text: 'Data yang dihapus tidak dapat dikembalikan. Lanjutkan?',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Tutup',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    let data = $(this).data('id');
                    let send = {
                        '_token':'{{csrf_token()}}',
                        '_method':'delete',
                    }
                    $.post('{{url('kecamatan/wil')}}/{{$kec->id}}/ppkt/delete/'+data, send, res=>{
                        if(res.status=200){
                            table.ajax.reload();
                            showSuccess(res.msg);
                        }else{
                            showErro(res.msg);
                        }
                    })
                }
            })
        })
    })

    function initMapKecamatan(){
        var map = L.map('map-kec').setView([active_lat, active_lng], 5);
        L.tileLayer('https://www.google.cn/maps/vt?lyrs=m&x={x}&y={y}&z={z}', {
            attribution:'&copy; Google Street',
            maxZoom: 18,
        }).addTo(map);

        if(!isEmpty(active_lat) && !isEmpty(active_lng)){
            var markers = L.markerClusterGroup();
            markers.addLayer(L.marker([active_lat, active_lng]).bindPopup('<b>KECAMATAN {{$kec->name}}</b><br />{{$kec->kota->name.', '.$kec->kota->provinsi->name}}'));
            map.addLayer(markers);
        }

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
                url: '{{ url('kecamatan/wil').'/'.$kec->id.'/ppkt/list' }}',
                data : function(d){
                    d.q = $('#name').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'nama',name: 'nama'},
                {data: 'jenis',name: 'jenis'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function chartppkt(){
        var chartppkt;
        $.getJSON('{{url('kecamatan/wil')}}/{{$kec->id}}/ppkt/chart', res=>{
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
</script>
@endpush
