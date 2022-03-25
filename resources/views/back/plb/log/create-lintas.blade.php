@extends('back.layout.main')
@push('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                    Informasi Lintasan
                </h2>
            </div>
            <div class="p-5">
                <form action="" id="form-dok">
                    @csrf
                    @if($mode == 'edit')
                        @method('put')
                        <input type="hidden" name="iduser" value="{{@$plb->idplb}}">
                    @endif
                    <div class="form-plb" id="reg-1">
                        <div class="grid grid-cols-12 gap-6">
                            <select data-search="true" class="input col-span-3 border mr-2 w-full" name="provid" id="provid">
                                {{-- <option value="0">Semua Provinsi</option> --}}
                                @foreach ($provinces as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <select data-search="true" class="input col-span-3 border mr-2 w-full" name="kotaid" id="kotaid">
                                <option value="0">Semua Kota</option>
                            </select>
                            <select data-search="true" class="input col-span-3 border mr-2 w-full" name="kecid" id="kecid">
                                <option value="0">Semua Kecamatan</option>
                            </select>
                            <select data-search="true" class="input col-span-3 border mr-2 w-full" name="desaid" id="desaid">
                                <option value="0">Semua Desa</option>
                            </select>
                            <select data-search="true" class="input col-span-3 border mr-2 w-full" name="tipeplb" id="tipeplb">
                                <option value="0">Semua Tipe PLB</option>
                                <option value="1">Non PLBN</option>
                                <option value="2">PLBN</option>
                            </select>
                            <select data-search="true" class="input col-span-9 border mr-2 w-full" name="plb" id="plb">
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6 form-plb d-none" id="reg-2">
                        <div class="col-span-12">
                            <h2 class="text-xl">Informasi Pelintas</h2>
                        </div>
                        <div class="col-span-12">
                            <label for="">Tanggal Lintas <span class="text-theme-6">*</span></label>
                            <input class="datepicker input w-56 border block mx-auto w-full" data-single-mode="true" name="tanggal_lintas" id="tanggal_lintas">
                        </div>
                        <div class="col-span-12">
                            <label for="">Waktu Lintas <span class="text-theme-6">*</span></label>
                            <input class="timepicker input w-56 border block mx-auto w-full" data-single-mode="true" name="waktu_lintas" id="waktu_lintas">
                        </div>
                        <div class="col-span-12">
                            <label for="">Zona Waktu <span class="text-theme-6">*</span></label>
                            <input type="text" class="input w-full border" placeholder="Contoh: WIB" name="zona_waktu" id="zona" value="{{@$plb->tipe_plb}}">
                        </div>
                        <div class="col-span-12">
                            <label for="">Jenis Identitas <span class="text-theme-6">*</span></label>
                            <select data-search="true" class="tail-select w-full" id="jenis" placeholder="Jenis Identitas" name="jenis_identitas" required>
                                <option value="KTP" {{($mode=='edit')? ((@$plb->jenis_plb == 1)? 'selected':''):''}}>Kartu Tanda Penduduk (KTP)</option>
                                <option value="SIM" {{($mode=='edit')? ((@$plb->jenis_plb == 2)? 'selected':''):''}}>Surat Izin Mengemudi (SIM)</option>
                                <option value="PASPOR" {{($mode=='edit')? ((@$plb->jenis_plb == 2)? 'selected':''):''}}>PASPOR</option>
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Tipe Penduduk Pelintas <span class="text-theme-6">*</span></label>
                            <select data-search="true" class="tail-select w-full" id="tipe" placeholder="Tipe Pelintas" name="tipe_penduduk_pelintas" required>
                                <option value="1" {{($mode=='edit')? ((@$plb->jenis_plb == 1)? 'selected':''):''}}>Warga Negara Indonesia</option>
                                <option value="2" {{($mode=='edit')? ((@$plb->jenis_plb == 2)? 'selected':''):''}}>Warga Negara Asing</option>
                            </select>
                        </div>
                        <div class="col-span-12">
                            <label for="">Nomor Identitas <span class="text-theme-6">*</span></label>
                            <input type="text" class="input w-full border" placeholder="Nomor Identitas" name="nomor_identitas" id="nomor" value="{{@$plb->tipe_plb}}" >
                        </div>
                        <div class="col-span-12">
                            <label for="">Nama Pelintas <span class="text-theme-6">*</span></label>
                            <input type="text" class="input w-full border" placeholder="Nama Pelintas" name="nama_pelintas" id="nama_pel" value="{{@$plb->tipe_plb}}" >
                        </div>
                        <div class="col-span-12">
                            <label for="">Gender Pelintas <span class="text-theme-6">*</span></label>
                            <div class="flex flex-col sm:flex-row mt-2">
                                <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">
                                    <input type="radio" class="input border mr-2" id="laki" name="gender_pelintas" value="l" {{($mode=='edit')? ((@$user->detail->gender == 'l')? 'checked':''):'checked'}}>
                                    <label class="cursor-pointer" for="laki">Laki - Laki</label>
                                </div>
                                <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">
                                    <input type="radio" class="input border mr-2" id="perempuan" name="gender_pelintas" value="p" {{($mode=='edit')? ((@$user->detail->gender == 'p')? 'checked':''):''}}>
                                    <label class="cursor-pointer select-none" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="reg-3" class="form-plb d-none">
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12">
                                <h2 class="text-xl">Informasi Muatan Barang</h2>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-6" id="holder-barang">
                            <div class="col-span-2" id="jenis_barang-1">
                                <input type="text" class="input w-full border mt-2" placeholder="Jenis Barang" name="jenis_barang[]">
                            </div>
                            <div class="col-span-5" id="nama_barang-1">
                                <input type="text" class="input w-full border mt-2" placeholder="Nama Barang" name="nama_barang[]">
                            </div>
                            <div class="col-span-2" id="jumlah_barang-1">
                                <input type="text" class="input w-full border mt-2" placeholder="Jumlah Barang" name="jumlah_barang[]">
                            </div>
                            <div class="col-span-2" id="satuan_barang-1">
                                <input type="text" class="input w-full border mt-2" placeholder="Satuan Barang" name="satuan_barang[]">
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-2">
                            <div class="col-span-10"></div>
                            <div class="col-span-2">
                                <span class="button block bg-theme-12 text-white" onclick="addBarang()">
                                    Tambah Barang
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-plb d-none" id="reg-4">
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-12">
                                <h2 class="text-xl">Informasi Muatan Orang</h2>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-6" id="holder-barang">
                            <div class="col-span-12">
                                <label for="">Jumlah Muatan Orang</label>
                                <input type="text" class="input w-full border mt-2" placeholder="Jenis Barang" id="jumlah_orang" name="jumlah_orang[]">
                            </div>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var table;
    var formIndex = 1;
    var max = 4
    $(document).ready(function(){
        setAutocomplete('jenis_barang-1');

        $('.timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 15,
            minTime: '0',
            maxTime: '23:59pm',
            defaultTime: '11',
            startTime: '00:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        initKota(11);
        $('#provid').on('change', function(){
            initKota($(this).val());
        })

        $('#kotaid').on('change', function(){
            initKec($(this).val());
        })

        $('#kecid').on('change', function(){
            initDesa($(this).val());
            initPlb($(this).val(), $('#desaid').val());
        })

        $('#desaid').on('change', function(){
            initPlb($('#kecid').val(), $(this).val());
        })
    })

    function initKota(prov = 0){
        $.getJSON('{{route('opt.kota')}}?provid='+prov,
            res=>{
                $('#kotaid').empty();
                // $('#kotaid').append('<option value="0">Semua Kota</option>');
                console.log(res && prov > 0);
                if(res && prov > 0){
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
                // $('#kecid').append('<option value="0">Semua Kecamatan</option>');
                if(res && kota > 0){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#kecid').append(opt);
                    });
                }

                initDesa(res[0].id||0)
                initPlb(res[0].id||0, $('#desaid').val());
            },
        )
    }

    function initDesa(kec = 0){
        $.getJSON('{{route('opt.desa')}}?kecid='+kec,
            res=>{
                $('#desaid').html('');
                $('#desaid').append('<option value="0">Semua Desa</option>');
                if(res && kec > 0){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#desaid').append(opt);
                    });
                }
                initPlb($('#kecid').val(), res[0].id||0);
            },
        )
    }
    var panggil = 1;
    function initPlb(kec = 0, desa = 0){
        console.log(panggil);
        panggil++;
        $.getJSON('{{route('plb.log.opt.plb')}}?kecid='+kec+'&desaid'+desa,
            res=>{
                $('#plb').html('');
                if(res && (kec > 0 || desa > 0)){
                    res.forEach(element => {
                        let opt = '<option value="'+element.idplb+'">'+element.nama_plb+'</option>';
                        $('#plb').append(opt);
                    });
                }
            },
        )
    }

    function setAutocomplete(idtarget){
        $.getJSON('{{route('plb.log.muatan.jenis-barang')}}', data=>{
            $( "#"+idtarget+' :input').autocomplete({
                source: data
            });
        })
    }

    var index_barang = 1;
    function addBarang(){
        index_barang ++;
        let barang_row =    '<div class="col-span-2" id="jenis_barang-'+index_barang+'">'+
                                '<input type="text" class="input w-full border mt-2" placeholder="Jenis Barang" name="jenis_barang[]">'+
                            '</div>'+
                            '<div class="col-span-5" id="nama_barang-'+index_barang+'">'+
                                '<input type="text" class="input w-full border mt-2" placeholder="Nama Barang" name="nama_barang[]">'+
                            '</div>'+
                            '<div class="col-span-2" id="jumlah_barang-'+index_barang+'">'+
                                '<input type="text" class="input w-full border mt-2" placeholder="Jumlah Barang" name="jumlah_barang[]">'+
                            '</div>'+
                            '<div class="col-span-2" id="satuan_barang-'+index_barang+'">'+
                                '<input type="text" class="input w-full border mt-2" placeholder="Satuan Barang" name="satuan_barang[]">'+
                            '</div>'+
                            '<div class="col-span-1" id="remove_barang-'+index_barang+'">'+
                                '<button class="button button--sm block bg-theme-6 text-white mt-2" onclick="removeBarang('+index_barang+')">'+
                                    'Hapus Barang'+
                                '</button>'+
                            '</div>';
        setAutocomplete('jenis_barang-'+index_barang);
        $('#holder-barang').append(barang_row);
    }

    function removeBarang(id){
        $('#jenis_barang-'+id).remove();
        $('#nama_barang-'+id).remove();
        $('#jumlah_barang-'+id).remove();
        $('#satuan_barang-'+id).remove();
        $('#remove_barang-'+id).remove();
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
            text: 'Data Lintas yang telah disimpan TIDAK DAPAT DIUBAH!, pastikan data yang Anda masukan benar. Lanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Tutup',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let formData = new FormData($('#form-dok')[0]);
                $.ajax({
                    url:'{{route('plb.log.store')}}',
                    method:'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:res=>{
                        if (res.status == 200) {
                            showSuccess(res.msg, ()=>{
                                window.location.replace('{{route('plb.log.index')}}');
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
