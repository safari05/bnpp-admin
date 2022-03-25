@extends('front.layout.main')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<style>
    .btn-custom{
        color: #fff;
    }
    h3{
        font-size: 16pt !important;
        font-weight: 500 !important;
    }
    .static-th{
        width: 40%;
    }
</style>
@endpush

@section('content')
<!-- section -->
<section class="gray-bg no-pading no-top-padding">
    <div class="col-list-wrap fh-col-list-wrap  left-list">
        <div class="container">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{route('infra.data.kec')}}" class="btn btn-dark btn-custom">Kembali</a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2>Kecamatan {{$data->name??'-'}}</h2>
                            <small>{{@$data->kota->name??'-'}}, {{@$data->kota->provinsi->name??'-'}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h3>Grafik Penduduk</h3>
                                </div>
                                <div class="col-12">
                                    <small>Berdasarkan Umur</small>
                                </div>
                            </div>
                            <canvas id="chart-umur" width="400" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        chartUmur();
    })

    function chartUmur(){
        let ctx = $('#chart-umur');
        let dataumur = '{{$chart_umur}}';
        dataumur = dataumur.replaceAll('&quot;','');
        console.log(dataumur);

        datachart = [];
        dataumur.forEach(element => {
            datachart.push({
                label:element.label,
                data:[element.data],
                backgroundColor:[element.bg],
                borderColor:[element.border],
                borderWidth:1,
            });
        });
        console.log(datachart);
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Umur Penduduk'],
                datasets: datachart,
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
</script>
@endpush
