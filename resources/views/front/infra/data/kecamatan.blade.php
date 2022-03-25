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
            <div class="row mb-4">
                <div class="col-12 text-right">
                    <a href="{{route('infra.data')}}" class="btn btn-dark btn-custom">Kembali</a>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content p-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="listsearch-header fl-wrap">
                                        <h3>Cari Kecamatan</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6 text-left">
                                    <label for="prov">Provinsi</label>
                                    <select name="prov" id="prov" class="form-control">
                                    </select>
                                </div>
                                <div class="col-6 text-left">
                                    <label for="kota">Kota</label>
                                    <select name="kota" id="kota" class="form-control">
                                        <option value="0">Semua Kota</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <input type="text" placeholder="Nama Kecamatan" value="" class="form-control" id="q">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6 text-left">
                                    <label for="tipe">Tipe</label>
                                    <select name="tipe" id="tipe" class="form-control">
                                        <option value="1">Kec. Perbatasan</option>
                                        <option value="2">Kec. Perbatasan PKSN</option>
                                        <option value="3">Kec. Lokpri</option>
                                    </select>
                                </div>
                                <div class="col-6 d-none" id="optlokpri">
                                    <label for="tipe">Jenis Lokpri</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input lok-check" type="checkbox" value="1">
                                        <label class="form-check-label" for="inlineCheckbox1">Kec. Lokpri</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input lok-check" type="checkbox" id="inlineCheckbox2" value="2">
                                        <label class="form-check-label" for="inlineCheckbox2">Sebagai PKSN</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input lok-check" type="checkbox" id="inlineCheckbox3" value="3">
                                        <label class="form-check-label" for="inlineCheckbox3">Memiliki PPKT</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-3"></div>
                                <div class="col-6">
                                    <button class="btn btn-success btn-sm btn-block btn-custom btn-cari">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content p-3">
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="listsearch-header fl-wrap">
                                        <h3>Hasil Pencarian</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 mt-2">
                                <div class="col-12">
                                    <table class="table" id="list-content">
                                        <thead>
                                            <th style="max-width: 35px;">No</th>
                                            <th style="max-width: 150px;">Provinsi</th>
                                            <th style="max-width: 200px;">Kota</th>
                                            <th>Kecamatan</th>
                                            <th style="max-width: 60px;">Aksi</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script>
    var table;
    var oplok = [];
    var stoplok;
    var isEmpty = str => !str.trim().length;
    $(document).ready(function(){
        initTable();

        $('body').on('click', '.btn-detail', function(){
            const kec = $(this).data('kec');

            window.location.replace('{{route('infra.data.kec.detail')}}?&kec='+kec);
        });

        $('body').on('click', '.btn-cari', function(){
            resfreshTable();
        });

        initSelectSearch();

        initKota(11);
        $('#prov').on('change', function(){
            initKota($(this).val());
        })
    })

    function initKota(prov = 0){
        $.getJSON('{{route('opt.kota')}}?provid='+prov,
            res=>{
                $('#kota').html('');
                $('#kota').append('<option value="0">Semua Kota</option>');
                if(res){
                    res.forEach(element => {
                        let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                        $('#kota').append(opt);
                    });
                }
            },
        )
    }

    function initTable(){
        table = $('#list-content').DataTable({
            language: {
                "paginate": {
                'previous':'Prev',
                'next':'Next'
                }
            },
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("infra/data/kecamatan/list") }}',
                data: function(d) {
                    d.prov = $('#prov').val();
                    d.kota = $('#kota').val();
                    d.q = $('#q').val();
                    d.tipe = $('#tipe').val();
                    d.lokpri = stoplok;
                },
            },
            columns: [
                { data: 'rownum', name: 'rownum'},
                { data: 'provinsi', name: 'provinsi' },
                { data: 'kota', name: 'kota'},
                { data: 'name', name: 'name'},
                { data: 'aksi', name: 'aksi'},
            ],
        });
    }

    function resfreshTable(){
        table.ajax.reload();
    }

    function initSelectSearch(){
        $.getJSON('{{route('option.prov')}}', res=>{
            // $('#prov').append('<option value="0">Semua Provinsi</option>');
            res.forEach(element => {
                let opt = '<option value="'+element.id+'">'+element.name+'</option>';
                $('#prov').append(opt);
            });
        })

        $('#tipe').on('change', function(){
            if($(this).val() == 3){
                $('#optlokpri').removeClass('d-none');
            }else{
                $('#optlokpri').addClass('d-none');
            }
        })

        $('body').on('change','.lok-check', function(){
            if ($(this).is(':checked')) {
                oplok.push($(this).val());
            }else{
                const index = oplok.indexOf($(this).val());
                if (index > -1) {
                    oplok.splice(index, 1);
                }
            }
            stoplok = oplok.join();
        })
    }
</script>
@endpush
