@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('dok.manage.index')}}">Dokumen</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($mode)}}</a>
</div>
@endsection
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ucwords($mode)}} Dokumen
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
        <!-- BEGIN: Daftar Kepegawaian -->
        <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Dokumen
                </h2>
            </div>
            <div class="p-5">
                <form action="" id="form-dok">
                    @csrf
                    @if($mode == 'edit')
                        @method('put')
                        <input type="hidden" name="iduser" value="{{@$dok->id}}">
                    @endif
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12">
                            <label for="">Nama Dokumen <span class="text-theme-6">*</span></label>
                            <input type="text" class="input w-full border" placeholder="Nama Dokumen" name="nama" id="name" value="{{@$dok->nama}}" required>
                        </div>
                        <div class="col-span-12">
                            <label for="">Upload Dokumen @if($mode == 'tambah')<span class="text-theme-6">*</span> @endif</label>
                            <input type="file" class="input w-full border" placeholder="File Dokumen" name="file" id="file">
                        </div>
                        <div class="col-span-12 mt-2">
                            <label for="">Hak Akses <span class="text-theme-6">*</span></label>
                            <select data-search="true" class="tail-select w-full" id="akses" placeholder="Hak Akses Dokumen" name="akses" required>
                                <option value="1" {{($mode=='edit')? ((@$dok->ispublic == 1)? 'selected':''):''}}>Publik</option>
                                <option value="0" {{($mode=='edit')? ((@$dok->ispublic == 0)? 'selected':''):''}}>Rahasia / Private</option>
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="input w-full border" rows="10">{{@$dok->deskripsi}}</textarea>
                        </div>
                        <div class="col-span-12">
                            <label for="">Tahun</label>
                            <input type="text" class="input w-full border" placeholder="Tahun" name="tahun" id="tahun" value="{{@$dok->tahun}}" required>
                        </div>
                        <div class="col-span-12 mt-2">
                            <label for="">Kategori Dokumen <span class="text-theme-6">*</span></label>
                            <select data-search="true" class="tail-select w-full" id="kategori" placeholder="Kategori Dokumen" name="kategori" required>
                                @foreach ($kategoris as $item)
                                <option value="{{$item->idkategori}}" {{($mode=='edit')? ((@$dok->idkategori == $item->idkategori)? 'selected':''):''}}>{{$item->keterangan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <div class="text-right mt-5">
                            @if($mode == 'tambah')
                            <button type="button" class="button w-24 bg-theme-1 text-white" onclick="submitDok()">Simpan</button>
                            @else
                            <button type="button" class="button w-24 bg-theme-1 text-white" onclick="updateDok()">Update</button>
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
    })

    function submitDok(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan menginput Dokumen dengan data tersebut. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-dok')[0]);
                $.ajax({
                    url:'{{route('dok.manage.store')}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{route('dok.manage.index')}}');
                            });
                        } else {
                            showError(res.msg);
                        }
                    }
                })
            }
        })
    }

    function updateDok(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan mengupdate Data Dokumen. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-dok')[0]);
                $.ajax({
                    url:'{{url('dokumen/manage/update')}}/{{@$dok->id}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{route('dok.manage.index')}}');
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
