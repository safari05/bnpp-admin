
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">DESA {{$desa->name}}</div>
                    <div class="text-gray-600"><small>KECAMATAN {{$desa->kecamatan->name}}</small></div>
                    <div class="text-gray-600"><small>{{$desa->kecamatan->kota->name.', '.$desa->kecamatan->kota->provinsi->name}}</small></div>
                </div>
