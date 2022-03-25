<a class="flex items-center {{request()->is('kecamatan/detail*')? "text-theme-1":""}}" href="{{url('kecamatan/detail').'/'.$kec->id}}">
    <i data-feather="hash" class="w-4 h-4 mr-2"></i> Detail Kecamatan
</a>
<a class="flex items-center mt-5 {{request()->is('kecamatan/aset*')? "text-theme-1":""}}" href="{{url('kecamatan/aset').'/'.$kec->id}}">
    <i data-feather="box" class="w-4 h-4 mr-2"></i> Aset & Mobilitas
</a>
<a class="flex items-center mt-5 {{request()->is('kecamatan/kepeg*')? "text-theme-1":""}}" href="{{url('kecamatan/kepeg').'/'.$kec->id}}">
    <i data-feather="users" class="w-4 h-4 mr-2"></i> Kepegawaian
</a>
<a class="flex items-center mt-5 {{request()->is('kecamatan/sipil*')? "text-theme-1":""}}" href="{{url('kecamatan/sipil').'/'.$kec->id}}">
    <i data-feather="smile" class="w-4 h-4 mr-2"></i> Kependudukan
</a>
<a class="flex items-center mt-5 {{request()->is('kecamatan/wil*')? "text-theme-1":""}}" href="{{url('kecamatan/wil').'/'.$kec->id}}">
    <i data-feather="map-pin" class="w-4 h-4 mr-2"></i> Wilayah
</a>
