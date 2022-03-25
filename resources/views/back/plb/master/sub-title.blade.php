
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">PLB {{$plb->nama_plb}}</div>
                    <div class="text-gray-600"><small>KECAMATAN {{$plb->kecamatan->name}}</small></div>
                    <div class="text-gray-600"><small>{{$plb->kecamatan->kota->name.', '.$plb->kecamatan->kota->provinsi->name}}</small></div>
                </div>
