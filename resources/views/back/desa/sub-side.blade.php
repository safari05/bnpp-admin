<a class="flex items-center {{request()->is('desa/detail*')? "text-theme-1":""}}" href="{{url('desa/detail').'/'.$desa->id}}">
    <i data-feather="hash" class="w-4 h-4 mr-2"></i> Detail Desa
</a>
<a class="flex items-center mt-5 {{request()->is('desa/aset*')? "text-theme-1":""}}" href="{{url('desa/aset').'/'.$desa->id}}">
    <i data-feather="box" class="w-4 h-4 mr-2"></i> Aset & Mobilitas
</a>
<a class="flex items-center mt-5 {{request()->is('desa/kepeg*')? "text-theme-1":""}}" href="{{url('desa/kepeg').'/'.$desa->id}}">
    <i data-feather="users" class="w-4 h-4 mr-2"></i> Kepegawaian
</a>
<a class="flex items-center mt-5 {{request()->is('desa/sipil*')? "text-theme-1":""}}" href="{{url('desa/sipil').'/'.$desa->id}}">
    <i data-feather="smile" class="w-4 h-4 mr-2"></i> Kependudukan
</a>
<a class="flex items-center mt-5 {{request()->is('desa/wil*')? "text-theme-1":""}}" href="{{url('desa/wil').'/'.$desa->id}}">
    <i data-feather="map-pin" class="w-4 h-4 mr-2"></i> Wilayah
</a>
<a class="flex items-center mt-5 {{request()->is('desa/pondes*')? "text-theme-1":""}}" href="{{url('desa/pondes').'/'.$desa->id}}">
    <i data-feather="crosshair" class="w-4 h-4 mr-2"></i> Potensi Desa
</a>
