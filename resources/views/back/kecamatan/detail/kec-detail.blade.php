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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('kec.index')}}">Kecamatan</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Detail</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Detail Kecamatan
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
                <a class="flex items-center" href="#info-camat"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Informasi Camat </a>
                <a class="flex items-center mt-5" href="#kantor-camat"> <i data-feather="briefcase" class="w-4 h-4 mr-2"></i> Kantor Kecamatan </a>
                <a class="flex items-center mt-5" href="#balai-camat"> <i data-feather="home" class="w-4 h-4 mr-2"></i> Balai Kecamatan </a>
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
        <!-- BEGIN: Informasi Camat -->
        <div class="intro-y box lg:mt-5" id="info-camat">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Camat
                </h2>
                {{-- <div class="dropdown ml-auto sm:hidden">
                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-700 dark:text-gray-300"></i> </a>
                    <div class="dropdown-box w-40">
                        <div class="dropdown-box__content box dark:bg-dark-1 p-2">
                            <a href="javascript:;" class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Excel </a>
                        </div>
                    </div>
                </div>
                <button class="button border relative flex items-center text-gray-700 dark:border-dark-5 dark:text-gray-300 hidden sm:flex"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Excel </button> --}}
            </div>
            <div class="p-5">
                <div class="relative flex items-center">
                    {{-- <div class="w-12 h-12 flex-none image-fit">
                        <img alt="Dashboard BNPP" class="rounded-full" src="{{asset('assets/back')}}/images/profile-4.jpg">
                    </div> --}}
                    <div class="ml-4 mr-4">
                        <a href="" class="font-medium">Nama</a>
                        <div class="text-gray-600 mr-5 sm:mr-5">Gender</div>
                        <div class="text-gray-600 mr-5 sm:mr-5">Pendidikan</div>
                    </div>
                    <div class="ml-2 mr-auto">
                        <a href="" class="font-medium">: {{@$camat->nama_camat??'-'}}</a>
                        <div class="text-gray-600 mr-5 sm:mr-5">: {{empty(@$camat->gender_camat)? '-':((@$camat->gender_camat=='l')? 'Laki - laki':'Perempuan')}}</div>
                        <div class="text-gray-600 mr-5 sm:mr-5">: {{@$camat->pendidikan_camat??'-'}}</div>
                    </div>
                    <div class="font-medium text-gray-700 dark:text-gray-500">
                        <button type="button" class="button button--sm block bg-theme-1 text-white" onclick="getCamat()">
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Informasi Camat -->
        <!-- BEGIN: Kantor Kecamatan -->
        <div class="intro-y box col-span-12 mt-5" id="kantor-camat">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Kantor Kecamatan
                </h2>
                <button type="button" class="button button--sm block bg-theme-1 text-white" onclick="getKantor()">Edit</button>
                {{-- <button data-carousel="new-products" data-target="prev" class="tiny-slider-navigator button px-2 border relative flex items-center text-gray-700 dark:text-gray-300 mr-2"> <i data-feather="chevron-left" class="w-4 h-4"></i> </button>
                <button data-carousel="new-products" data-target="next" class="tiny-slider-navigator button px-2 border relative flex items-center text-gray-700 dark:text-gray-300"> <i data-feather="chevron-right" class="w-4 h-4"></i> </button> --}}
            </div>
            <div class="py-5" id="new-products">
                <div class="px-5">
                    <div class="flex flex-col lg:flex-row items-center pb-5">
                        @if(@$camat->status_kantor == 1)
                        <div class="flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                            <div class="sm:mr-5">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                    <img alt="Kantor Camat" class="rounded-full" src="{{@$camat->foto_kantor??'-'}}">
                                </div>
                            </div>
                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                <a href="" class="font-medium text-lg">Alamat</a>
                                <div class="text-gray-600 mt-1 sm:mt-0">{{@$camat->alamat_kantor??'-'}}</div>
                            </div>
                        </div>
                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Status</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$camat->sta_kan??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Kondisi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$camat->kon_kan??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Regulasi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$camat->regulasi??'-'}}</div>
                            </div>
                        </div>
                        @else
                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Status</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$camat->sta_kan??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Kondisi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$camat->kon_kan??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Regulasi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$camat->regulasi??'-'}}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    {{-- <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">3 January 2021</div>
                            <div class="text-gray-600">Date of Release</div>
                        </div>
                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                            <button class="button w-20 justify-center block bg-gray-200 dark:bg-dark-5 dark:text-gray-300 text-gray-600 ml-auto">Preview</button>
                            <button class="button w-20 justify-center block bg-gray-200 dark:bg-dark-5 dark:text-gray-300 text-gray-600 ml-2">Details</button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- END: Kantor Kecamatan -->
        <!-- BEGIN: Balai Kecamatan -->
        <div class="intro-y box col-span-12 mt-5" id="balai-camat">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Balai Kecamatan
                </h2>
                <button type="button" class="button button--sm block bg-theme-1 text-white" onclick="getBalai()">Edit</button>
                {{-- <button data-carousel="new-products" data-target="prev" class="tiny-slider-navigator button px-2 border relative flex items-center text-gray-700 dark:text-gray-300 mr-2"> <i data-feather="chevron-left" class="w-4 h-4"></i> </button>
                <button data-carousel="new-products" data-target="next" class="tiny-slider-navigator button px-2 border relative flex items-center text-gray-700 dark:text-gray-300"> <i data-feather="chevron-right" class="w-4 h-4"></i> </button> --}}
            </div>
            <div class="py-5" id="new-products">
                <div class="px-5">
                    <div class="flex flex-col lg:flex-row items-center pb-5">
                        @if(@$camat->kondisi_balai)
                        <div class="flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                            <div class="sm:mr-5">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                    <img alt="Kantor Camat" class="rounded-full" src="{{$camat->foto_balai}}">
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Status</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$camat->sta_bal??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Kondisi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$camat->kon_bal??'-'}}</div>
                            </div>
                        </div>
                        @else
                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Status</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$camat->sta_bal??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Kondisi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$camat->kon_bal??'-'}}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    {{-- <div class="flex flex-col sm:flex-row items-center border-t border-gray-200 dark:border-dark-5 pt-5">
                        <div class="w-full sm:w-auto flex justify-center sm:justify-start items-center border-b sm:border-b-0 border-gray-200 dark:border-dark-5 pb-5 sm:pb-0">
                            <div class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium mr-3">3 January 2021</div>
                            <div class="text-gray-600">Date of Release</div>
                        </div>
                        <div class="flex sm:ml-auto mt-5 sm:mt-0">
                            <button class="button w-20 justify-center block bg-gray-200 dark:bg-dark-5 dark:text-gray-300 text-gray-600 ml-auto">Preview</button>
                            <button class="button w-20 justify-center block bg-gray-200 dark:bg-dark-5 dark:text-gray-300 text-gray-600 ml-2">Details</button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- END: Balai Kecamatan -->

        <!-- BEGIN: General Statistics -->
        {{-- <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    General Statistics
                </h2>
                <div class="dropdown ml-auto">
                    <a class="dropdown-toggle w-5 h-5 block sm:hidden" href="javascript:;"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-700 dark:text-gray-300"></i> </a>
                    <button class="dropdown-toggle button font-normal border dark:border-dark-5 text-white relative items-center text-gray-700 dark:text-gray-300 hidden sm:flex"> Export <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> </button>
                    <div class="dropdown-box w-40">
                        <div class="dropdown-box__content box dark:bg-dark-1">
                            <div class="px-4 py-2 border-b border-gray-200 dark:border-dark-5 font-medium">Export Tools</div>
                            <div class="p-2">
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="printer" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> Print </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="external-link" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> Excel </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> CSV </a>
                                <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="archive" class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> PDF </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <div class="flex flex-col sm:flex-row items-center">
                    <div class="flex flex-wrap sm:flex-no-wrap mr-auto">
                        <div class="flex items-center mr-5 mb-1 sm:mb-0">
                            <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>
                            <span>Author Sales</span>
                        </div>
                        <div class="flex items-center mr-5 mb-1 sm:mb-0">
                            <div class="w-2 h-2 bg-theme-1 rounded-full mr-3"></div>
                            <span>Product Profit</span>
                        </div>
                    </div>
                    <div class="dropdown mt-3 sm:mt-0 mr-auto sm:mr-0">
                        <button class="dropdown-toggle button font-normal border dark:border-dark-5 text-white relative flex items-center text-gray-700 dark:text-gray-300"> Filter by Month <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> </button>
                        <div class="dropdown-box w-40">
                            <div class="dropdown-box__content box dark:bg-dark-1 p-2 overflow-y-auto h-32"> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">January</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">February</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">March</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">June</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">July</a> </div>
                        </div>
                    </div>
                </div>
                <div class="report-chart mt-8">
                    <canvas id="report-line-chart" height="130"></canvas>
                </div>
            </div>
        </div> --}}
        <!-- END: General Statistics -->
    </div>

    {{-- START: Modal Edit Camat --}}
    <div class="modal" id="modal-camat">
        <div class="modal__content p-10 text-center">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 p-5 text-center">
                    <h2 class="text-2xl">Edit Informasi Camat</h2>
                </div>
                <div class="col-span-12 text-center">
                    <input type="text" class="input w-full border mt-2 col-span-10 input-nama" placeholder="Nama Camat" name="nama">
                </div>
                <div class="col-span-12 text-center">
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">
                            <input type="radio" class="input border mr-2" id="gender_l" name="gender" value="l">
                            <label class="cursor-pointer select-none" for="gender_l">
                                Laki - Laki
                            </label>
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2 mt-2 sm:mt-0">
                            <input type="radio" class="input border mr-2" id="gender_p" name="gender" value="p">
                            <label class="cursor-pointer select-none" for="gender_p">
                                Perempuan
                            </label>
                        </div>

                    </div>
                </div>
                <div class="col-span-12 text-center">
                    <input type="text" class="input w-full border mt-2 col-span-10 input-pendidikan" placeholder="Pendidikan Camat" name="pendidikan">
                </div>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" onclick="updateCamat()">Simpan</button>
                </div>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-2 col-span-2 text-gray-700 w-full" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Modal Edit Camat --}}

    {{-- START: Modal Edit Kantor --}}
    <div class="modal" id="modal-kantor">
        <div class="modal__content p-10">
            <div class="grid grid-cols-12 gap-6">
                <form class="col-span-12" action="" enctype="multipart/form-data" id="form-kantor">
                    @csrf
                    @method('put')
                    <div class="col-span-12 p-5 text-center">
                        <h2 class="text-2xl">Edit Kantor Kecamatan</h2>
                    </div>
                    <div class="col-span-12">
                        <label for="">Status Kantor</label>
                        <select name="status"class="input input--lg col-span-4 border mr-2 w-full input-status">
                            <option value="0" selected>Tidak Ada</option>
                            <option value="1">Ada</option>
                        </select>
                    </div>
                    <div id="detail-kantor" class="col-span-12 d-none">
                        <div class="col-span-12">
                            <label for="">Alamat Kantor</label>
                            <textarea name="alamat" class="input w-full border mt-2 col-span-10 input-alamat" rows="5" placeholder="Alamat Kantor"></textarea>
                        </div>
                        <div class="col-span-12">
                            <label for="">Kondisi Kantor</label>
                            <select name="kondisi"class="input input--lg col-span-4 border mr-2 w-full input-kondisi">
                                <option value="1" selected>Baik</option>
                                <option value="2">Rusak</option>
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Regulasi</label>
                            <input type="text" class="input w-full border mt-2 col-span-10 input-regulasi" placeholder="Regulasi Kantor" name="regulasi">
                        </div>
                        <div class="col-span-12">
                            <label for="">Foto Kantor</label>
                            <input type="file" class="input w-full border mt-2 col-span-10 input-foto" placeholder="Foto Kantor Camat" name="foto">
                        </div>
                    </div>
                </form>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" onclick="updateKantor()">Simpan</button>
                </div>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-2 col-span-2 text-gray-700 w-full" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Modal Edit Kantor --}}

    {{-- START: Modal Edit Balai --}}
    <div class="modal" id="modal-balai">
        <div class="modal__content p-10">
            <div class="grid grid-cols-12 gap-6">
                <form class="col-span-12" action="" enctype="multipart/form-data" id="form-balai">
                    @csrf
                    @method('put')
                    <div class="col-span-12 p-5 text-center">
                        <h2 class="text-2xl">Edit Balai Kecamatan</h2>
                    </div>
                    <div class="col-span-12">
                        <label for="">Status Balai</label>
                        <select name="status"class="input input--lg col-span-4 border mr-2 w-full input-status">
                            <option value="0" selected>Tidak Ada</option>
                            <option value="1">Ada</option>
                        </select>
                    </div>
                    <div id="detail-balai" class="col-span-12 d-none">
                        <div class="col-span-12">
                            <label for="">Kondisi Balai</label>
                            <select name="kondisi"class="input input--lg col-span-4 border mr-2 w-full input-kondisi">
                                <option value="1" selected>Baik</option>
                                <option value="2">Rusak</option>
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Foto Balai</label>
                            <input type="file" class="input w-full border mt-2 col-span-10 input-foto" placeholder="Foto Balai Camat" name="foto">
                        </div>
                    </div>
                </form>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" onclick="updateBalai()">Simpan</button>
                </div>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-2 col-span-2 text-gray-700 w-full" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Modal Edit Balai --}}
</div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        $('#modal-kantor .input-status').on('change', function(){
            if($(this).val() == 1){
                $('#detail-kantor').removeClass('d-none');
            }else{
                $('#detail-kantor').addClass('d-none');
            }
        })
        $('#modal-balai .input-status').on('change', function(){
            if($(this).val() == 1){
                $('#detail-balai').removeClass('d-none');
            }else{
                $('#detail-balai').addClass('d-none');
            }
        })
    })

    function getCamat(){
        $.getJSON('{{url('kecamatan/camat')."/".$kec->id}}', res=>{
            $('#modal-camat .input-nama').val(res.nama_camat);
            $('#modal-camat .input-pendidikan').val(res.pendidikan_camat);
            if(res.gender_camat == 'l') document.getElementById('gender_l').checked = true;
            else if(res.gender_camat == 'p') document.getElementById('gender_p').checked = true;
            cash('#modal-camat').modal('show');
        })

    }

    function updateCamat(){
        let gender = 'l';
        if (document.getElementById('gender_p').checked) {
            gender = 'p';
        }
        const input = {
            '_token':'{{csrf_token()}}',
            '_method':'put',
            'nama_camat':$('#modal-camat .input-nama').val(),
            'gender_camat':gender,
            'pendidikan_camat':$('#modal-camat .input-pendidikan').val(),
        }

        console.log(input);
        $.ajax({
            url:'{{url('kecamatan/camat')."/".$kec->id}}/update',
            method:'post',
            data: input,
            success: res=>{
                if(res.status == 200){
                    showSuccess(res.msg, ()=>{
                        window.location.reload();
                    });
                }else{
                    showError(res.msg);
                }

                cash('#modal-camat').modal('hide');
                document.getElementById('gender_l').checked = true;
                $('#modal-camat .input-nama').val('');
                $('#modal-camat .input-pendidikan').val('');

            }
        });
    }

    function getKantor(){
        $.getJSON('{{url('kecamatan/kantor')."/".$kec->id}}', res=>{
            $('#modal-kantor .input-status').val(res.status ?? '0');
            if(res.status == 1){
                $('#detail-kantor').removeClass('d-none');
            }else{
                $('#detail-kantor').addClass('d-none');
            }
            $('#modal-kantor .input-alamat').val(res.alamat);
            $('#modal-kantor .input-kondisi').val(res.kondisi ?? '1');
            $('#modal-kantor .input-regulasi').val(res.regulasi);

            cash('#modal-kantor').modal('show');
        })

    }

    function updateKantor(){
        let form = new FormData($('#form-kantor')[0]);

        $.ajax({
            url:'{{url('kecamatan/kantor')."/".$kec->id}}/update',
            method:'post',
            data: form,
            contentType: false,
            processData: false,
            success: res=>{
                if(res.status == 200){
                    showSuccess(res.msg, ()=>{
                        window.location.reload()
                    });
                }else{
                    showError(res.msg);
                }

                cash('#modal-kantor').modal('hide');
                $('#modal-kantor .input-status').val('0');
                $('#modal-kantor .input-alamat').val('');
                $('#modal-kantor .input-kondisi').val('1');
                $('#modal-kantor .input-regulasi').val('');
                $('#modal-kantor .input-foto').val('');
                $('#detail-kantor').removeClass('d-none');

            }
        });
    }
    function getBalai(){
        $.getJSON('{{url('kecamatan/balai')."/".$kec->id}}', res=>{
            $('#modal-balai .input-status').val(res.status ?? '0');
            if(res.status == 1){
                $('#detail-balai').removeClass('d-none');
            }else{
                $('#detail-balai').addClass('d-none');
            }
            $('#modal-balai .input-kondisi').val(res.kondisi ?? '1');

            cash('#modal-balai').modal('show');
        })

    }

    function updateBalai(){
        let form = new FormData($('#form-balai')[0]);

        $.ajax({
            url:'{{url('kecamatan/balai')."/".$kec->id}}/update',
            method:'post',
            data: form,
            contentType: false,
            processData: false,
            success: res=>{
                if(res.status == 200){
                    showSuccess(res.msg, ()=>{
                        window.location.reload()
                    });
                }else{
                    showError(res.msg);
                }

                cash('#modal-balai').modal('hide');
                $('#modal-balai .input-status').val('0');
                $('#modal-balai .input-kondisi').val('1');
                $('#modal-balai .input-foto').val('');
                $('#detail-balai').removeClass('d-none');

            }
        });
    }
</script>
@endpush
