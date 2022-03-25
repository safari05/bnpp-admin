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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('users.index')}}">User</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($mode)}}</a>
</div>
@endsection
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ucwords($mode)}} Pengguna
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
        <!-- BEGIN: Daftar Kepegawaian -->
        <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Akun
                </h2>
            </div>
            <div class="p-5">
                <form action="" id="form-akun">
                    @csrf
                    @if($mode == 'edit')
                        @method('put')
                        <input type="hidden" name="iduser" value="{{@$user->iduser}}">
                    @endif
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12">
                            <label for="">Username <span class="text-theme-6">*</span></label>
                            <input type="text" class="input w-full border" placeholder="Username" name="username" id="username" value="{{@$user->username}}" required>
                        </div>
                        <div class="col-span-12">
                            <label for="">Email <span class="text-theme-6">*</span></label>
                            <input type="email" class="input w-full border" placeholder="Email" name="email" id="email" value="{{@$user->email}}" required>
                            <small class="text-theme-6">* email yang akan digunakan untuk login</small>
                        </div>
                        <div class="col-span-12 mt-2">
                            <label for="">Role Akun <span class="text-theme-6">*</span></label>
                            <select data-search="true" class="tail-select w-full" id="role" placeholder="Jenis ASN" name="role" required>
                                @foreach ($roles as $item)
                                <option value="{{$item->idrole}}" {{($mode=='edit')? ((@$user->idrole == $item->idrole)? 'selected':''):''}}>{{$item->keterangan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-2 {{@$user->idrole == 5? '':'d-none'}}" id="for-camat">
                        <select data-search="true" class="input col-span-3 border mr-2 w-full" name="provid" id="provid">
                            {{-- <option value="0">Semua Provinsi</option> --}}
                            @foreach ($provinces as $item)
                                <option value="{{$item->id}}" {{@$user->kecamatan->kecamatan->kota->provinsid == $item->id? 'selected':''}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                        <select data-search="true" class="input col-span-3 border mr-2 w-full" name="kotaid" id="kotaid">
                            <option value="0">Semua Kota</option>
                        </select>
                        <select data-search="true" class="input col-span-6 border mr-2 w-full" name="kecid" id="kecid">
                            <option value="0">Semua Kecamatan</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 mt-5">
                            <div class="w-full flex justify-center border-t border-gray-200 dark:border-dark-5 mt-2">
                                <div class="bg-white dark:bg-dark-3 px-5 -mt-3 text-gray-600 text-xl">Informasi Detail User</div>
                            </div>
                        </div>
                        <div class="col-span-12 mt-2">
                            <label for="">Nama Lengkap <span class="text-theme-6">*</span></label>
                            <input type="text" class="input w-full border" placeholder="Nama Lengkap" name="nama" id="nama" value="{{@$user->detail->nama}}" required>
                        </div>
                        <div class="col-span-12">
                            <label for="">Gender <span class="text-theme-6">*</span></label>
                            <div class="flex flex-col sm:flex-row mt-2">
                                <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">
                                    <input type="radio" class="input border mr-2" id="laki" name="gender" value="l" {{($mode=='edit')? ((@$user->detail->gender == 'l')? 'checked':''):'checked'}}>
                                    <label class="cursor-pointer" for="laki">Laki - Laki</label>
                                </div>
                                <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">
                                    <input type="radio" class="input border mr-2" id="perempuan" name="gender" value="p" {{($mode=='edit')? ((@$user->detail->gender == 'p')? 'checked':''):''}}>
                                    <label class="cursor-pointer select-none" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12">
                            <label for="">Alamat <span class="text-theme-6">*</span></label>
                            <textarea class="input w-full border" placeholder="Alamat Pengguna" name="alamat" id="alamat" required>{{@$user->detail->alamat}}</textarea>
                        </div>
                        <div class="col-span-12">
                            <label for="">Telepon</label>
                            <input type="text" class="input w-full border" placeholder="Telepon" name="telepon" id="telepon" value="{{@$user->detail->telepon}}">
                        </div>
                    </div>
                </form>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <div class="text-right mt-5">
                            @if($mode == 'tambah')
                            <button type="button" class="button w-24 bg-theme-1 text-white" onclick="submitAkun()">Simpan</button>
                            @else
                            <button type="button" class="button w-24 bg-theme-1 text-white" onclick="updateAkun()">Update</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: General Statistics -->
    </div>
</div>
@endsection
@push('js')
<script>
    var table;
    $(document).ready(function(){
        $('#role').on('change', function(){
            if($(this).val() == 5){
                $('#for-camat').removeClass('d-none');
            }else{
                $('#for-camat').addClass('d-none');
            }
        })

        initKota(11);
        $('#provid').on('change', function(){
            initKota($(this).val());
        })

        $('#kotaid').on('change', function(){
            initKec($(this).val());
        })
    })

    function initKota(prov = 0){
        $.getJSON('{{route('opt.kota')}}?provid='+prov,
            res=>{
                $('#kotaid').empty();
                // $('#kotaid').append('<option value="0">Semua Kota</option>');
                if(res && prov > 0){
                    let kotaid = '{{@$user->kecamatan->kecamatan->kotaid}}';
                    res.forEach(element => {
                        let selected = (kotaid == element.id)? 'selected':'';
                        let opt = '<option value="'+element.id+'" '+selected+'>'+element.name+'</option>';
                        $('#kotaid').append(opt);
                    });
                }
                initKec(res[0].id||0);
            },
        )
    }

    function initKec(kota = 0){
        $.getJSON('{{route('opt.kec')}}?kotaid='+kota,
            res=>{
                $('#kecid').html('');
                let kecid = '{{@$user->kecamatan->idkecamatan}}';
                // $('#kecid').append('<option value="0">Semua Kecamatan</option>');
                if(res && kota > 0){
                    res.forEach(element => {
                        let selected = (kecid == element.id)? 'selected':'';
                        let opt = '<option value="'+element.id+'" '+selected+'>'+element.name+'</option>';
                        $('#kecid').append(opt);
                    });
                }
            },
        )
    }

    function submitAkun(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan menginput Akun User dan Password akan otomatis dibuat. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-akun')[0]);
                $.ajax({
                    url:'{{route('users.store')}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{route('users.index')}}');
                            });
                        } else {
                            showError(res.msg);
                        }
                    }
                })
            }
        })
    }

    function updateAkun(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan mengupdate Data User. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-akun')[0]);
                $.ajax({
                    url:'{{route('users.update')}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{route('users.index')}}');
                            });
                        } else {
                            showError(res.msg);
                        }
                    }
                })
            }
        })
    }
</script>
@endpush
