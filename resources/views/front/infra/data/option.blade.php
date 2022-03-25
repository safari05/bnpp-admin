@extends('front.layout.main')

@push('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<style>
    .btn-custom{
        color: #fff;
    }
</style>
@endpush

@section('content')
<!-- section -->
<section class="gray-bg no-pading no-top-padding">
    <div class="col-list-wrap fh-col-list-wrap  left-list">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="mb-4">Data Desa/Kelurahan</h3>
                            <a href="#" class="btn btn-info btn-custom">Lihat Data</a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="mb-4">Data Kecamatan</h3>
                            <a href="{{route('infra.data.kec')}}" class="btn btn-info btn-custom">Lihat Data</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@endpush
