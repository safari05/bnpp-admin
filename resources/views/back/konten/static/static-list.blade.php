@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Static Konten</a>
</div>
@endsection
@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-12 grid grid-cols-12 gap-6">
        <!-- BEGIN: Sales Report -->
        <div class="col-span-12 lg:col-span-12 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Daftar Konten
                </h2>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Latar Belakang</td>
                            <td>
                                <a href="{{route('konten.static.edit.lt')}}">
                                <button class="button button--sm w-24 mr-1 mb-2 bg-theme-12 text-white">Edit</button>
                                </a>
                                <a target="_blank" href="{{url('profil-latar-belakang')}}">
                                <button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Preview</button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Maksud</td>
                            <td>
                                <a href="{{route('konten.static.edit.maksud')}}">
                                <button class="button button--sm w-24 mr-1 mb-2 bg-theme-12 text-white">Edit</button>
                                </a>
                                <a target="_blank" href="{{url('profil-maksud-tujuan')}}">
                                <button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Preview</button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Tujuan</td>
                            <td>
                                <a href="{{route('konten.static.edit.tujuan')}}">
                                <button class="button button--sm w-24 mr-1 mb-2 bg-theme-12 text-white">Edit</button>
                                </a>
                                <a target="_blank" href="{{url('profil-maksud-tujuan')}}">
                                <button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white">Preview</button>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END: Sales Report -->
    </div>
</div>
@endsection

@push('js')
<script>
</script>
@endpush
