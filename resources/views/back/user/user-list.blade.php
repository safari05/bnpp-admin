@extends('back.layout.main')
@push('css')
@endpush

@section('bread')
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="" class="">Application</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="">User</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Daftar</a>
</div>
@endsection
@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-12 grid grid-cols-12 gap-6">
        <!-- BEGIN: General Report -->
        <div class="col-span-12 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Pencarian
                </h2>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="col-span-12 intro-y">
                    <div class="grid grid-cols-12 gap-2">
                        <input type="text" class="input w-full border col-span-12" placeholder="Nama User" name="name" id="name">
                        <select class="input input--lg col-span-5 border mr-2 w-full" name="role" id="role">
                            <option value="0">Semua</option>
                            @foreach ($roles as $item)
                                <option value="{{$item->idrole}}">{{$item->keterangan}}</option>
                            @endforeach
                        </select>
                        <select class="input input--lg col-span-5 border mr-2 w-full" name="aktif" id="aktif">
                            <option value="0">Semua</option>
                            <option value="1">Aktif</option>
                            <option value="2">Tidak Aktif</option>
                        </select>
                        <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full" onclick="refreshTable()">Cari</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: General Report -->
        <!-- BEGIN: Sales Report -->
        <div class="col-span-12 lg:col-span-12 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Daftar User
                </h2>
                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <a href="{{route('users.create')}}">
                        <button class="button button--sm mr-1 mb-2 bg-theme-1 text-white">
                            Tambah User
                        </button>
                    </a>
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <table class="table table-report -mt-2" id="list-desa">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END: Sales Report -->
    </div>


    {{-- START: Modal Edit Status --}}
    <div class="modal" id="modal-status">
        <div class="modal__content p-10">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 p-5 text-center">
                    <h2 class="text-2xl">Edit Status User</h2>
                </div>
                <div class="col-span-12">
                    <label for="">Username</label>
                    <input type="text" class="input w-full border mt-2 col-span-10 v-user" placeholder="Username" name="username" readonly>
                </div>
                <div class="col-span-12">
                    <label for="">Email</label>
                    <input type="text" class="input w-full border mt-2 col-span-10 v-email" placeholder="Email" name="email" readonly>
                </div>
                <div class="col-span-12">
                    <label for="">Status</label>
                    <select name="status" class="input input--lg col-span-4 border mr-2 w-full v-status">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-span-6">
                    <button class="button w-24 mr-1 mb-2 bg-theme-1 col-span-2 text-white w-full btn-save">Simpan</button>
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
    var table;
    $(document).ready(function () {
        initTable();
        $('body').on('click', '.btn-user-edit', function(){
            let id = $(this).data('id');
            window.location.replace('{{url('users/manage/edit')}}/'+id);
        })
    })

    async function initTable() {
        table = await $('#list-desa').DataTable({
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
                url: '{{ route('users.list') }}',
                data : function(d){
                    d.q = $('#name').val();
                    d.role = $('#role').val();
                    d.aktif = $('#aktif').val();
                }
            },
            columns: [
                {data: 'rownum',name: 'rownum'},
                {data: 'nama',name: 'nama'},
                {data: 'username',name: 'username'},
                {data: 'email',name: 'email'},
                {data: 'role',name: 'role'},
                {data: 'status',name: 'status'},
                {data: 'aksi',name: 'aksi'},
            ],
        });
    }

    function refreshTable() {
        table.ajax.reload();
    }

    function ubahStatus(id){
        $.getJSON('{{url('users/manage/get-status')}}/'+id, res=>{
            if(res.status == 200){
                $('#modal-status .v-user').val(res.data.user);
                $('#modal-status .v-email').val(res.data.mail);
                $('#modal-status .v-status').val(res.data.status);
                $('#modal-status .btn-save').off('click');
                $('#modal-status .btn-save').on('click', function(){
                    updateStatus(id)
                });
                cash('#modal-status').modal('show');

            }
        })
    }

    function updateStatus(id){
        const data = {
            '_token':'{{csrf_token()}}',
            '_method':'put',
            'id':id,
            'status':$('#modal-status .v-status').val()
        };
        $.post('{{route('users.update-status')}}', data, res=>{
            cash('#modal-status').modal('hide');
            if(res.status==200){
                showSuccess(res.msg);
                refreshTable();
            }else{
                showError(res.msg);
            }
        })
    }

</script>
@endpush
