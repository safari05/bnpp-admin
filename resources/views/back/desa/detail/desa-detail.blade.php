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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('desa.index')}}">Desa</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Detail</a>
</div>
@endsection

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Detail Desa
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
                <a class="flex items-center" href="#info-kades"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Informasi Kades </a>
                <a class="flex items-center mt-5" href="#kantor-kades"> <i data-feather="briefcase" class="w-4 h-4 mr-2"></i> Kantor Desa </a>
                <a class="flex items-center mt-5" href="#balai-kades"> <i data-feather="home" class="w-4 h-4 mr-2"></i> Balai Desa </a>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                @include('back.desa.sub-side')
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Informasi Kades -->
        <div class="intro-y box lg:mt-5" id="info-kades">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Kepala Desa
                </h2>
            </div>
            <div class="p-5">
                <div class="relative flex items-center">
                    <div class="ml-4 mr-4">
                        <a href="" class="font-medium">Nama</a>
                        <div class="text-gray-600 mr-5 sm:mr-5">Gender</div>
                        <div class="text-gray-600 mr-5 sm:mr-5">Pendidikan</div>
                    </div>
                    <div class="ml-2 mr-auto">
                        <a href="" class="font-medium">: {{@$kades->nama_kades??'-'}}</a>
                        <div class="text-gray-600 mr-5 sm:mr-5">: {{empty(@$kades->gender_kades)? '-':((@$kades->gender_kades=='l')? 'Laki - laki':'Perempuan')}}</div>
                        <div class="text-gray-600 mr-5 sm:mr-5">: {{@$kades->pendidikan_kades??'-'}}</div>
                    </div>
                    <div class="font-medium text-gray-700 dark:text-gray-500">
                        <button type="button" class="button button--sm block bg-theme-1 text-white" onclick="getKades()">
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Informasi Kades -->
        <!-- BEGIN: Kantor Desa -->
        <div class="intro-y box col-span-12 mt-5" id="kantor-kades">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Kantor Desa
                </h2>
                <button type="button" class="button button--sm block bg-theme-1 text-white" onclick="getKantor()">Edit</button>
                {{-- <button data-carousel="new-products" data-target="prev" class="tiny-slider-navigator button px-2 border relative flex items-center text-gray-700 dark:text-gray-300 mr-2"> <i data-feather="chevron-left" class="w-4 h-4"></i> </button>
                <button data-carousel="new-products" data-target="next" class="tiny-slider-navigator button px-2 border relative flex items-center text-gray-700 dark:text-gray-300"> <i data-feather="chevron-right" class="w-4 h-4"></i> </button> --}}
            </div>
            <div class="py-5" id="new-products">
                <div class="px-5">
                    <div class="flex flex-col lg:flex-row items-center pb-5">
                        @if(@$kades->status_kantor == 1)
                        <div class="flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                            <div class="sm:mr-5">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                    <img alt="Kantor Desa" class="rounded-full" src="{{@$kades->foto_kantor??'-'}}">
                                </div>
                            </div>
                            <div class="mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                <a href="" class="font-medium text-lg">Alamat</a>
                                <div class="text-gray-600 mt-1 sm:mt-0">{{@$kades->alamat_desa??'-'}}</div>
                            </div>
                        </div>
                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Status</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$kades->sta_kan??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Kondisi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$kades->kon_kan??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Regulasi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$kades->regulasi??'-'}}</div>
                            </div>
                        </div>
                        @else
                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Status</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$kades->sta_kan??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Kondisi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$kades->kon_kan??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Regulasi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$kades->regulasi??'-'}}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Kantor Desa -->
        <!-- BEGIN: Balai Desa -->
        <div class="intro-y box col-span-12 mt-5" id="balai-kades">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Balai Desa
                </h2>
                <button type="button" class="button button--sm block bg-theme-1 text-white" onclick="getBalai()">Edit</button>
                {{-- <button data-carousel="new-products" data-target="prev" class="tiny-slider-navigator button px-2 border relative flex items-center text-gray-700 dark:text-gray-300 mr-2"> <i data-feather="chevron-left" class="w-4 h-4"></i> </button>
                <button data-carousel="new-products" data-target="next" class="tiny-slider-navigator button px-2 border relative flex items-center text-gray-700 dark:text-gray-300"> <i data-feather="chevron-right" class="w-4 h-4"></i> </button> --}}
            </div>
            <div class="py-5" id="new-products">
                <div class="px-5">
                    <div class="flex flex-col lg:flex-row items-center pb-5">
                        @if(@$kades->kondisi_balai)
                        <div class="flex flex-col sm:flex-row items-center pr-5 lg:border-r border-gray-200 dark:border-dark-5">
                            <div class="sm:mr-5">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                    <img alt="Balai Desa" class="rounded-full" src="{{$kades->foto_balai}}">
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Status</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$kades->sta_bal??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Kondisi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$kades->kon_bal??'-'}}</div>
                            </div>
                        </div>
                        @else
                        <div class="w-full lg:w-auto mt-6 lg:mt-0 pt-4 lg:pt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-t-0 border-gray-200 dark:border-dark-5">
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Status</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$kades->sta_bal??'-'}}</div>
                            </div>
                            <div class="text-center rounded-md w-40 py-3">
                                <div class="text-gray-600">Kondisi</div>
                                <div class="font-semibold text-theme-1 dark:text-theme-10 text-lg">{{@$kades->kon_bal??'-'}}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Balai Desa -->
    </div>

    {{-- START: Modal Edit Kades --}}
    <div class="modal" id="modal-kades">
        <div class="modal__content p-10 text-center">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 p-5 text-center">
                    <h2 class="text-xl">Edit Informasi Kepala Desa</h2>
                </div>
                <div class="col-span-12 text-center">
                    <input type="text" class="input w-full border mt-2 col-span-10 input-nama" placeholder="Nama Kades" name="nama">
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
                    <input type="text" class="input w-full border mt-2 col-span-10 input-pendidikan" placeholder="Pendidikan Kades" name="pendidikan">
                </div>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" onclick="updateKades()">Simpan</button>
                </div>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-2 col-span-2 text-gray-700 w-full" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Modal Edit Kades --}}

    {{-- START: Modal Edit Kantor --}}
    <div class="modal" id="modal-kantor">
        <div class="modal__content p-10">
            <div class="grid grid-cols-12 gap-6">
                <form class="col-span-12" action="" enctype="multipart/form-data" id="form-kantor">
                    @csrf
                    @method('put')
                    <div class="col-span-12 p-5 text-center">
                        <h2 class="text-xl">Edit Kantor Desa</h2>
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
                            <input type="file" class="input w-full border mt-2 col-span-10 input-foto" placeholder="Foto Kantor Kades" name="foto">
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
                        <h2 class="text-xl">Edit Balai Desa</h2>
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
                            <input type="file" class="input w-full border mt-2 col-span-10 input-foto" placeholder="Foto Balai Kades" name="foto">
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

    function getKades(){
        $.getJSON('{{url('desa/kades')."/".$desa->id}}', res=>{
            $('#modal-kades .input-nama').val(res.nama_kades);
            $('#modal-kades .input-pendidikan').val(res.pendidikan_kades);
            if(res.gender_kades == 'l') document.getElementById('gender_l').checked = true;
            else if(res.gender_kades == 'p') document.getElementById('gender_p').checked = true;
            cash('#modal-kades').modal('show');
        })

    }

    function updateKades(){
        let gender = 'l';
        if (document.getElementById('gender_p').checked) {
            gender = 'p';
        }
        const input = {
            '_token':'{{csrf_token()}}',
            '_method':'put',
            'nama_kades':$('#modal-kades .input-nama').val(),
            'gender_kades':gender,
            'pendidikan_kades':$('#modal-kades .input-pendidikan').val(),
        }

        $.ajax({
            url:'{{url('desa/kades')."/".$desa->id}}/update',
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

                cash('#modal-kades').modal('hide');
                document.getElementById('gender_l').checked = true;
                $('#modal-kades .input-nama').val('');
                $('#modal-kades .input-pendidikan').val('');

            }
        });
    }

    function getKantor(){
        $.getJSON('{{url('desa/kantor')."/".$desa->id}}', res=>{
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
            url:'{{url('desa/kantor')."/".$desa->id}}/update',
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
        $.getJSON('{{url('desa/balai')."/".$desa->id}}', res=>{
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
            url:'{{url('desa/balai')."/".$desa->id}}/update',
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
