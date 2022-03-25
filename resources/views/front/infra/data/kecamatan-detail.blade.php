@extends('front.layout.main')

@push('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
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
                            <h2>Kecamatan {{strtolower(ucwords($data->name))??'-'}}</h2>
                            <small>{{ucwords(strtolower(@$data->kota->name))??'-'}}, {{ucwords(strtolower(@$data->kota->provinsi->name))??'-'}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="nav nav-tabs" id="myTab" role="tablist">
                        <a class="nav-link active" id="tab-1" data-toggle="pill" href="#tab-content-umum" role="tab" aria-controls="tab-content-umum" aria-selected="true">Data Umum</a>
                        <a class="nav-link" id="tab-2" data-toggle="pill" href="#tab-content-goven" role="tab" aria-controls="tab-content-goven" aria-selected="false">Data Pemerintahan Kecamatan</a>
                        {{-- <a class="nav-link" id="tab-3" data-toggle="pill" href="#tab-content-grap" role="tab" aria-controls="tab-content-grap" aria-selected="false">Grafik</a> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-content-umum" role="tabpanel" aria-labelledby="tab-umum">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-2">
                                        <div class="card-header">
                                            <h5>Informasi Umum <span class="text-primary">Kecamatan {{strtolower(ucwords($data->name))??'-'}}</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 mt-2">
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                <a class="nav-link active" id="tab-umum-1" data-toggle="pill" href="#tab-content-umum-1" role="tab" aria-controls="tab-content-umum-1" aria-selected="true">Data Kecamatan</a>
                                                <a class="nav-link" id="tab-umum-2" data-toggle="pill" href="#tab-content-umum-2" role="tab" aria-controls="tab-content-umum-2" aria-selected="false">Data Camat</a>
                                                <a class="nav-link" id="tab-umum-3" data-toggle="pill" href="#tab-content-umum-3" role="tab" aria-controls="tab-content-umum-3" aria-selected="false">Data Penduduk</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="tab-content-umum-1" role="tabpanel" aria-labelledby="tab-umum-1">
                                                    <h6>Data Administrasi Pemerintahan</h6><br>
                                                    <table class="table table-stripes mb-4">
                                                        <tr>
                                                            <th class="static-th">Luas Wilayah</th>
                                                            <td>{{$data->detail->wilayah->luas_wilayah??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Ibukota Kecamatan</th>
                                                            <td>{{$data->detail->wilayah->ibukota_kecamatan??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Alamat Kecamatan</th>
                                                            <td>{{$data->detail->camat->alamat_kantor??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Kodepos Kecamatan</th>
                                                            <td>{{$data->detail->camat->kodepos_kantor??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Regulasi Kecamatan</th>
                                                            <td>{{$data->detail->camat->regulasi??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jumlah Desa</th>
                                                            <td>{{$data->detail->wilayah->jumlah_desa??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jumlah Kelurahan</th>
                                                            <td>{{$data->detail->wilayah->jumlah_kelurahan??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jumlah Pulau</th>
                                                            <td>{{$data->detail->wilayah->jumlah_pulau??'-'}}</td>
                                                        </tr>
                                                    </table>

                                                    <h6 class="mt-4">Data Wilayah</h6><br>
                                                    <table class="table table-stripes">
                                                        <tr>
                                                            <th class="static-th">Jumlah PPKT</th>
                                                            <td>{{$data->jumlah_ppkt??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jumlah PPKT Berpenduduk</th>
                                                            <td>{{$data->ppkt_isi??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jumlah PPKT Tidak Berpenduduk</th>
                                                            <td>{{$data->ppkt_kosong??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Batas Kecamatan Barat</th>
                                                            <td>{{$data->detail->wilayah->batas_barat??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Batas Kecamatan Timur</th>
                                                            <td>{{$data->detail->wilayah->batas_timur??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Batas Kecamatan Utara</th>
                                                            <td>{{$data->detail->wilayah->batas_utara??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Batas Kecamatan Selatan</th>
                                                            <td>{{$data->detail->wilayah->batas_selatan??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Batas Negara Jenis</th>
                                                            <td>{{(@$data->detail->wilayah->batas_negara_jenis=='2')?'Laut':'Darat'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Batas Negara Nama</th>
                                                            <td>{{$data->detail->wilayah->batas_negara??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jarak Ibukota ke Provinsi</th>
                                                            <td>{{$data->detail->wilayah->jarak_ke_provinsi??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jarak Ibukota ke Kabupaten</th>
                                                            <td>{{$data->detail->wilayah->jarak_ke_kabupaten??'-'}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="tab-content-umum-2" role="tabpanel" aria-labelledby="tab-umum-2">
                                                    <h6>Data Camat</h6><br>
                                                    <table class="table table-stripes mb-4">
                                                        <tr>
                                                            <th class="static-th">Nama Camat</th>
                                                            <td>{{$data->detail->camat->nama_camat??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Gender Camat</th>
                                                            <td>{{(@$data->detail->camat->gender_camat=='p')?'Wanita':'Pria'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Pendidikan Camat</th>
                                                            <td>{{$data->detail->camat->pendidikan_camat??'-'}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="tab-content-umum-3" role="tabpanel" aria-labelledby="tab-umum-3">
                                                    <h6 class="">Data Penduduk</h6><br>
                                                    <table class="table table-stripes">
                                                        <tr>
                                                            <th class="static-th">Jumlah Penduduk</th>
                                                            <td>{{$total.' Orang'??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jumlah KK</th>
                                                            <td>{{$kk.' Orang'??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jumlah Penduduk Pria</th>
                                                            <td>{{$pria.' Orang'??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jumlah Penduduk Wanita</th>
                                                            <td>{{$wanita.' Orang'??'-'}}</td>
                                                        </tr>
                                                    </table>

                                                    <h6 class="mt-4">Klasifikasi Penduduk berdasarkan Umur</h6><br>
                                                    <table class="table table-stripes">
                                                        @foreach ($penduduk as $item)
                                                        <tr>
                                                            <th class="static-th">{{$item['ket']}}</th>
                                                            <td>{{$item['jumlah']}} Orang</td>
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-content-goven" role="tabpanel" aria-labelledby="tab-goven">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-2">
                                        <div class="card-header">
                                            <h5>Kondisi Sarana Prasarana <span class="text-primary">Kecamatan {{ucwords(strtolower($data->name))??'-'}}</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 mt-2">
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="nav flex-column nav-pills" id="v-pills-tab-2" role="tablist" aria-orientation="vertical">
                                                <a class="nav-link active" id="tab-goven-1" data-toggle="pill" href="#tab-content-goven-1" role="tab" aria-controls="tab-content-goven-1" aria-selected="true">Kantor Kecamatan</a>
                                                <a class="nav-link" id="tab-goven-3" data-toggle="pill" href="#tab-content-goven-2" role="tab" aria-controls="tab-content-goven-2" aria-selected="false">Sarana Mobilitas</a>
                                                <a class="nav-link" id="tab-goven-3" data-toggle="pill" href="#tab-content-goven-3" role="tab" aria-controls="tab-content-goven-3" aria-selected="false">Aset</a>
                                                <a class="nav-link" id="tab-goven-3" data-toggle="pill" href="#tab-content-goven-4" role="tab" aria-controls="tab-content-goven-4" aria-selected="false">SDM Kecamatan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="tab-content-goven-1" role="tabpanel" aria-labelledby="tab-goven-1">
                                                    <h6>Kantor Kecamatan</h6><br>
                                                    <table class="table table-stripes mb-4">
                                                        <tr>
                                                            <th class="static-th">Status</th>
                                                            <td>{{$data->detail->camat->status_kantor??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Kondisi</th>
                                                            <td>{{$data->detail->camat->kondisi_kantor??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Foto</th>
                                                            <td>{{$data->detail->camat->foto_kantor??'-'}}</td>
                                                        </tr>
                                                    </table>

                                                    <h6 class="mt-4">Balai Pertemuan Umum</h6><br>
                                                    <table class="table table-stripes">
                                                        <tr>
                                                            <th class="static-th">Status</th>
                                                            <td>{{$data->detail->camat->status_balai??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Kondisi</th>
                                                            <td>{{$data->detail->camat->kondisi_balai??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Foto</th>
                                                            <td>{{$data->detail->camat->foto_balai??'-'}}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <div class="tab-pane fade" id="tab-content-goven-2" role="tabpanel" aria-labelledby="tab-goven-2">
                                                    <h6>Sarana Mobilitas</h6><br>
                                                    <table class="table table-stripes mb-4">
                                                        <tr>
                                                            <th>Nama Item</th>
                                                            <th>Jumlah</th>
                                                            <th>Foto</th>
                                                        </tr>
                                                        @foreach (@$data->detail->mobilitas as $item)
                                                        <tr>
                                                            <th class="static-th">Jumlah {{$item->mobilitas->nama}}</th>
                                                            <td>{{$item->jumlah}}</td>
                                                            <td>{{$item->foto}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                </div>

                                                <div class="tab-pane fade" id="tab-content-goven-3" role="tabpanel" aria-labelledby="tab-goven-3">
                                                    <h6 class="">Aset</h6><br>
                                                    <table class="table table-stripes">
                                                        <tr>
                                                            <th>Nama Item</th>
                                                            <th>Jumlah Baik</th>
                                                            <th>Jumlah Rusak</th>
                                                        </tr>
                                                        @foreach (@$data->detail->aset as $item)
                                                        <tr>
                                                            <th class="static-th">Jumlah {{$item->aset->nama}}</th>
                                                            <td>{{$item->jumlah_baik}}</td>
                                                            <td>{{$item->jumlah_rusak}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                </div>

                                                <div class="tab-pane fade" id="tab-content-goven-4" role="tabpanel" aria-labelledby="tab-goven-4">
                                                    <h6>SDM Kecamatan</h6><br>
                                                    <table class="table table-stripes mb-4">
                                                        <tr>
                                                            <th class="static-th">Jumlah ASN</th>
                                                            <td>{{$kepeg_asn->asn.' Orang'??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jumlah Non ASN</th>
                                                            <td>{{$kepeg_asn->non.' Orang'??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Jumlah SDM</th>
                                                            <td>{{(int)$kepeg_asn->asn + (int)$kepeg_asn->non.' Orang'??'-'}}</td>
                                                        </tr>
                                                    </table>

                                                    <h6 class="mt-4">Staf Operasional</h6><br>
                                                    <table class="table table-stripes mb-4">
                                                        @foreach ($kepeg_opr as $item)
                                                        <tr>
                                                            <th class="static-th">{{$item->keterangan}}</th>
                                                            <td>{{$item->jumlah.' Orang'}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </table>

                                                    <h6>Kelembagaan Kecamatan</h6><br>
                                                    <table class="table table-stripes mb-4">
                                                        @foreach ($kepeg_leb as $item)
                                                        <tr>
                                                            <th class="static-th">{{$item->keterangan}}</th>
                                                            <td>{{$item->jumlah.' Orang'}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </table>

                                                    <h6>PLB</h6><br>
                                                    <table class="table table-stripes mb-4">
                                                        <tr>
                                                            <th class="static-th">Status</th>
                                                            <td>{{$data->detail->wilayah->status_plb??'-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="static-th">Nama</th>
                                                            <td>{{$data->detail->wilayah->nama_plb??'-'}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="tab-pane fade" id="tab-content-grap" role="tabpanel" aria-labelledby="tab-grap">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <canvas id="chart-umur" width="400" height="400"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){

    })
</script>
@endpush
