@extends('back.layout.main')

@push('css')
<style>
    .d-none{
        display: none;
    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('dok.manage.index')}}">Dokumen</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Detail</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Detail Dokumen
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">{{@$dok->nama}}</div>
                    <div class="text-gray-600"><small>pemilik : {{@$dok->user->username}}</small></div>
                    <div class="text-gray-600"><small>waktu upload : {{@$dok->created_at}}</small></div>
                </div>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <a class="flex items-center" href="#info-kades"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Informasi Dokumen </a>
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Informasi Kades -->
        <div class="intro-y box lg:mt-5" id="info-kades">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Dokumen
                </h2>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <table class="table w-full">
                            <tr>
                                <th class="label-th">Nama Dokumen</th>
                                <td>{{@$dok->nama}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Kategori Dokumen</th>
                                <td>{{@$dok->kategori->keterangan}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Deskripsi</th>
                                <td>{{@$dok->deskripsi}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Tahun</th>
                                <td>{{@$dok->tahun}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Hak Akses</th>
                                <td>{{@$dok->ispublic==1? 'Publik':'Private / Rahasia'}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Tanggal Upload</th>
                                <td>{{@$dok->created_at}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Pemilik</th>
                                <td>{{@$dok->user->username}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Download</th>
                                <td>
                                    <a href="{{asset('upload/dokumen').'/'.(@$dok->file)}}" target="_blank">
                                        <button class="button button--sm w-24 mr-1 mb-2 bg-theme-9 text-white">Download</button>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Informasi Kades -->
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
    })
</script>
@endpush
