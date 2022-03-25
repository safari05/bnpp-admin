
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">KECAMATAN {{$kec->name}}</div>
                    <div class="text-gray-600">{{$kec->kota->name.', '.$kec->kota->provinsi->name}}</div>
                    <div class="flex items-center mt-3">
                        <div class="border-l-2 border-theme-1 pl-4">
                            <a href="" class="font-medium">Lokasi Prioritas</a>
                            <div class="text-gray-600">{{$detail['lokpri']}}</div>
                        </div>
                    </div>
                    <div class="flex items-center mt-3">
                        <div class="border-l-2 border-theme-1 pl-4">
                            <a href="" class="font-medium">Tipe Kecamatan</a>
                            <div class="text-gray-600">{{$detail['tipe']}}</div>
                        </div>
                    </div>
                </div>
