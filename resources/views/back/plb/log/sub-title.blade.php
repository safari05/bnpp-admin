
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">Detail Lintas PLB {{$lintas->plb->nama_plb}}</div>
                    <div class="text-gray-600"><small>Tanggal {{\Carbon\Carbon::parse($lintas->tanggal_lintas)->locale('id')->translatedFormat('d F Y')}}</small></div>
                    <div class="text-gray-600"><small>Waktu {{$lintas->jam_lintas}} ({{$lintas->zona_waktu??'WIB'}})</small></div>
                    {{-- <div class="text-gray-600 mt-3"><small>Kecamatan {{ucwords(strtolower($lintas->plb->kecamatan->name))}}</small></div>
                    <div class="text-gray-600"><small>{{ucwords(strtolower($lintas->plb->kecamatan->kota->name.', '.$lintas->plb->kecamatan->kota->provinsi->name))}}</small></div> --}}
                </div>
