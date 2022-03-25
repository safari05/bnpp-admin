@extends('back.layout.main')

@push('css')
<style>
    .d-none{
        display: none;
    }
    .label-th{
        width: 160px !important;
    }
</style>
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Profile</a>
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
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">{{$user->detail->nama}}</div>
                    <div class="text-gray-600"><small>{{$user->role->keterangan}}</small></div>
                </div>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                <a class="flex items-center" href="#info-akun"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Informasi Akun </a>
                <a class="flex items-center mt-5" href="#repass"> <i data-feather="briefcase" class="w-4 h-4 mr-2"></i> Ganti Password </a>
                <a class="flex items-center mt-5" href="#info-user"> <i data-feather="home" class="w-4 h-4 mr-2"></i> Informasi User </a>
                @if(Auth::user()->idrole == 5)
                <a class="flex items-center mt-5" href="#info-kec"> <i data-feather="home" class="w-4 h-4 mr-2"></i> Kecamatan </a>
                @endif
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                @if(Auth::user()->idrole == 5)
                <a class="flex items-center mt-5" href="{{url('kec/detail').'/'.@Auth::user()->kecamatan->idkecamatan}}">
                    <i data-feather="box" class="w-4 h-4 mr-2"></i> Kecamatan
                </a>
                @endif
                <a class="flex items-center" href="{{url('logout')}}">
                    <i data-feather="hash" class="w-4 h-4 mr-2"></i> Logout
                </a>
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Informasi Akun -->
        <div class="intro-y box lg:mt-5" id="info-akun">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Akun
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{route('profile.edit')}}">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Edit Profile
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <table class="table w-full">
                            <tr>
                                <th class="label-th">Username</th>
                                <td>{{$user->username}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Email</th>
                                <td>{{$user->email}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Role</th>
                                <td>{{$user->role->keterangan}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Status</th>
                                <td>{{$user->active==1? 'Aktif':'Tidak Aktif'}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Tanggal Buat</th>
                                <td>{{\Carbon\Carbon::parse($user->created_at)->locale('id')->translatedFormat('d F Y @ H:i:s')}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Informasi Akun -->

        <!-- BEGIN: Ganti Password -->
        <div class="intro-y box col-span-12 mt-5" id="kantor-kades">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Ganti Password
                </h2>
            </div>
            <div class="py-5" id="new-products">
                <div class="flex flex-col sm:flex-row items-center">
                    <label class="w-full sm:w-40 sm:text-right sm:mr-5">Password Baru</label>
                    <input type="password" class="input w-full border mt-2 flex-1" placeholder="Password Baru" id="pass">
                </div>
                <div class="flex flex-col sm:flex-row items-center mt-3">
                    <label class="w-full sm:w-40 sm:text-right sm:mr-5">Konfirmasi Password Baru</label>
                    <input type="password" class="input w-full border mt-2 flex-1" placeholder="Konfirmasi Password Baru" id="con_pass">
                </div>
                <div class="flex flex-col sm:flex-row items-center mt-5">
                    <label class="w-full sm:w-40 sm:text-right sm:mr-5">Password Lama</label>
                    <input type="password" class="input w-full border mt-2 flex-1" placeholder="Password Lama" id="old_pass">
                </div>
                <div class="sm:ml-40 sm:pl-5 mt-5">
                    <button type="button" class="button bg-theme-1 text-white" onclick="updatePass()">Ganti Password</button>
                </div>
            </div>
        </div>
        <!-- END: Ganti Password -->

        <!-- BEGIN: Informasi User -->
        <div class="intro-y box lg:mt-5" id="info-akun">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi User
                </h2>
                <div class="font-medium text-gray-700 dark:text-gray-500">
                    <a href="{{route('profile.edit')}}">
                        <button type="button" class="button button--sm block bg-theme-1 text-white">
                            Edit Profile
                        </button>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <table class="table w-full">
                            <tr>
                                <th class="label-th">Nama Lengkap</th>
                                <td>{{$user->detail->nama}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Gender</th>
                                <td>{{($user->detail->gender=='l')?'Laki - laki':'Perempuan'}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Alamat</th>
                                <td>{{$user->detail->alamat}}</td>
                            </tr>
                            <tr>
                                <th class="label-th">Telepon</th>
                                <td>{{$user->detail->telepon}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Informasi Akun -->
    </div>
</div>
@endsection
@push('js')
<script>
    function updatePass(){
        let data = {
            '_token':'{{csrf_token()}}',
            'password':$('#pass').val(),
            'password_confirmation':$('#con_pass').val(),
            'old_password':$('#old_pass').val(),
        };

        $.post('{{route('profile.repass')}}', data, res=>{
            if(res.status == 200){
                showSuccess(res.msg);
                $('#pass').val('');
                $('#con_pass').val('');
                $('#old_pass').val('');
            }else{
                showError(res.msg);
            }
        });
    }
</script>
@endpush
