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
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="{{route('plb.master.index')}}">Pos Lintas Batas</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">{{ucwords($mode)}}</a>
</div>
@endsection
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{ucwords($mode)}} Pos Lintas Batas
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
        <!-- BEGIN: Daftar Kepegawaian -->
        <div class="intro-y box mt-5">
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Informasi Pos
                </h2>
            </div>
            <div class="p-5">
                <form action="" id="form-dok">
                    @csrf
                    @if($mode == 'edit')
                        @method('put')
                        <input type="hidden" name="iduser" value="{{@$plb->idplb}}">
                    @endif
                    <div class="grid grid-cols-12 gap-6 form-plb" id="reg-1">
                        <div class="col-span-12">
                            <label for="">Nama Pos <span class="text-theme-6">*</span></label>
                            <input type="text" class="input w-full border" placeholder="Nama Pos" name="nama" id="nama" value="{{@$plb->nama_plb}}" required>
                        </div>
                        <div class="col-span-12">
                            <label for="">Tipe Pos <span class="text-theme-6">*</span></label>
                            <input type="text" class="input w-full border" placeholder="Tipe Pos" name="tipe" id="tipe" value="{{@$plb->tipe_plb}}" >
                        </div>
                        <div class="col-span-12 mt-2">
                            <label for="">Jenis Pos <span class="text-theme-6">*</span></label>
                            <select data-search="true" class="tail-select w-full" id="jenis" placeholder="Jenis Pos" name="jenis" required>
                                <option value="1" {{($mode=='edit')? ((@$plb->jenis_plb == 1)? 'selected':''):''}}>Non PLBN</option>
                                <option value="2" {{($mode=='edit')? ((@$plb->jenis_plb == 2)? 'selected':''):''}}>PLBN</option>
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Alamat Pos <span class="text-theme-6">*</span></label>
                            <textarea name="alamat" id="alamat" class="input w-full border" rows="10" required>{{@$plb->alamat_plb}}</textarea>
                        </div>
                        <div class="col-span-6">
                            <label for="">Provinsi <span class="text-theme-6">*</span></label>
                            <select  data-search="true" class="input border mr-2 w-full" name="provid" id="provid">
                                @if($mode == 'tambah')
                                    @foreach ($provinces as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                @else
                                <option value="">{{@$plb->kecamatan->kota->provinsi->name}}</option>
                                @endif
                            </select>
                            <small class="text-theme-6">Tidak dapat diubah setelah disimpan</small>
                        </div>
                        <div class="col-span-6">
                            <label for="">Kota / Kabupaten <span class="text-theme-6">*</span></label>
                            <select  data-search="true" class="input border mr-2 w-full" name="kotaid" id="kotaid">
                                @if($mode == 'tambah')
                                <option value="">Pilih Provinsi Terlebih Dahulu</option>
                                @else
                                <option value="">{{@$plb->kecamatan->kota->name}}</option>
                                @endif
                            </select>
                            <small class="text-theme-6">Tidak dapat diubah setelah disimpan</small>
                        </div>
                        <div class="col-span-6">
                            <label for="">Kecamatan <span class="text-theme-6">*</span></label>
                            <select  data-search="true" class="input border mr-2 w-full" name="kecid" id="kecid" required value="">
                                @if($mode == 'tambah')
                                <option value="">Pilih Kota Terlebih Dahulu</option>
                                @else
                                <option value="{{@$plb->kecamatanid}}">{{@$plb->kecamatan->name}}</option>
                                @endif
                            </select>
                            <small class="text-theme-6">Tidak dapat diubah setelah disimpan</small>
                        </div>
                        <div class="col-span-6">
                            <label for="">Desa <span class="text-theme-6">*</span></label>
                            <select  data-search="true" class="input border mr-2 w-full" name="desaid" id="desaid" required>
                                @if($mode == 'tambah')
                                <option value="">Pilih Kecamatan Terlebih Dahulu</option>
                                @else
                                <option value="{{@$plb->desaid}}">{{@$plb->desa->name}}</option>
                                @endif
                            </select>
                            <small class="text-theme-6">Tidak dapat diubah setelah disimpan</small>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6 form-plb d-none" id="reg-2">
                        <div class="col-span-12">
                            <label for="">Status Imigrasi</label>
                            <input type="text" class="input w-full border" placeholder="Status Imigrasi" name="staimig" id="staimig" value="{{@$plb->status_imigrasi}}">
                        </div>
                        <div class="col-span-12">
                            <label for="">Status Karantina Kesehatan</label>
                            <input type="text" class="input w-full border" placeholder="Status Karantina Kesehatan" name="karkes" id="karkes" value="{{@$plb->status_karantina_kesehatan}}">
                        </div>
                        <div class="col-span-12">
                            <label for="">Status Karantina Pertanian</label>
                            <input type="text" class="input w-full border" placeholder="Status Karantina Pertanian" name="kartan" id="kartan" value="{{@$plb->status_karantina_pertanian}}">
                        </div>
                        <div class="col-span-12">
                            <label for="">Status Karantina Perikanan</label>
                            <input type="text" class="input w-full border" placeholder="Status Karantina Perikanan" name="karkan" id="karkan" value="{{@$plb->status_karantina_perikanan}}">
                        </div>
                        <div class="col-span-12">
                            <label for="">Status Keamanan TNI</label>
                            <input type="text" class="input w-full border" placeholder="Status Keamanan TNI" name="kamtni" id="kamtni" value="{{@$plb->status_keamanan_tni}}">
                        </div>
                        <div class="col-span-12">
                            <label for="">Status Keamanan POLRI</label>
                            <input type="text" class="input w-full border" placeholder="Status Keamanan Polri" name="kampol" id="kampol" value="{{@$plb->status_keamanan_polri}}">
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6 form-plb d-none" id="reg-3">
                        <div class="col-span-12 mt-2">
                            <label for="">Jenis Perbatasan</label>
                            <select data-search="true" class="tail-select w-full" id="jenisbatas" placeholder="Jenis Perbatasan" name="jenisbatas" required>
                                <option value="0">Tidak Ada</option>
                                <option value="1" {{($mode=='edit')? ((@$plb->jenis_perbatasan == 1)? 'selected':''):''}}>Darat</option>
                                <option value="2" {{($mode=='edit')? ((@$plb->jenis_perbatasan == 2)? 'selected':''):''}}>Laut</option>
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Batas Negara Barat</label>
                            <input type="text" class="input w-full border mt-2" placeholder="Batas Negara Barat" name="barat" id="barat" value="{{@$plb->batas_negara_barat}}">
                        </div>
                        <div class="col-span-12">
                            <label for="">Batas Negara Timur</label>
                            <input type="text" class="input w-full border mt-2" placeholder="Batas Negara Timur" name="timur" id="timur" value="{{@$plb->batas_negara_timur}}">
                        </div>
                        <div class="col-span-12 mt-2">
                            <label for="">Batas Negara Utara</label>
                            <input type="text" class="input w-full border mt-2" placeholder="Batas Negara Utara" name="utara" id="utara" value="{{@$plb->batas_negara_utara}}">
                        </div>
                        <div class="col-span-12 mt-2">
                            <label for="">Batas Negara Selatan</label>
                            <input type="text" class="input w-full border mt-2" placeholder="Batas Negara Selatan" name="selatan" id="selatan" value="{{@$plb->batas_negara_selatan}}">
                        </div>
                    </div>
                </form>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <div class="text-right mt-5">
                            <button type="button" class="button w-24 mr-1 mb-2 bg-gray-200 text-gray-600 d-none" id="prevbtn" onclick="stepForm(-1)">Sebelumnya</button>
                            <button type="button" class="button w-24 bg-theme-1 text-white" id="nextbtn" onclick="stepForm(1)">Selanjutnya</button>

                            @if($mode == 'tambah')
                            <button type="button" class="button w-24 bg-theme-9 text-white btn-save d-none" onclick="submitPos()">Simpan</button>
                            @else
                            <button type="button" class="button w-24 bg-theme-9 text-white btn-save d-none" onclick="updatePos()">Update</button>
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
    var formIndex = 1;
    var max = 3
    $(document).ready(function(){
        @if($mode == 'tambah')
            initKota(11);
            $('#provid').on('change', function(){
                initKota($(this).val());
            })

            initKec();
            $('#kotaid').on('change', function(){
                initKec($(this).val());
            })

            initDesa();
            $('#kecid').on('change', function(){
                initDesa($(this).val());
            })
        @endif
    })

    function initKota(prov = 0){
        $.getJSON('{{route('opt.kota')}}?provid='+prov,
            res=>{
                $('#kotaid').html('');
                if(res){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
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
                if(res){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#kecid').append(opt);
                    });
                }
                initDesa(res[0].id||0)
            },
        )
    }

    function initDesa(kec = 0){
        $.getJSON('{{route('opt.desa')}}?kecid='+kec,
            res=>{
                $('#desaid').html('');
                if(res){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#desaid').append(opt);
                    });
                }
            },
        )
    }

    function stepForm(step){
        formIndex += step;
        if(formIndex == max){
            $('#nextbtn').addClass('d-none');
            document.getElementsByClassName('btn-save')[0].classList.remove('d-none');
        }else if(formIndex == 1){
            $('#prevbtn').addClass('d-none');
        }else{
            $('#prevbtn').removeClass('d-none');
            $('#nextbtn').removeClass('d-none');
            document.getElementsByClassName('btn-save')[0].classList.add('d-none');
        }

        toggleform();
    }

    function toggleform(){
        let forms = document.querySelectorAll('.form-plb');
        forms.forEach(elem => {
            elem.classList.add('d-none');
        })

        let current = document.getElementById('reg-'+formIndex);
        current.classList.remove('d-none');
    }


    function submitPos(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan menginput Data Pos Lintas Batas, pastikan data yang Anda masukan benar. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-dok')[0]);
                $.ajax({
                    url:'{{route('plb.master.store')}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{route('plb.master.index')}}');
                            });
                        } else {
                            showError(res.msg);
                        }
                    }
                })
            }
        })
    }

    function updatePos(){
        Swal.fire({
            title: 'Yakin data sudah benar?',
            text: 'Anda akan mengupdate Data Pos Lintas Batas, pastikan data yang Anda masukan benar. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-dok')[0]);
                $.ajax({
                    url:'{{url('plb/master/update')}}/{{@$plb->idplb}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{route('plb.master.index')}}');
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
