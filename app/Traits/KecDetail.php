<?php

namespace App\Traits;

use App\Models\Refactored\Kecamatan\KecamatanDetail;
use App\Models\Refactored\Kecamatan\KecamatanLokpri;
use App\Models\Refactored\Kecamatan\KecamatanType;

/**
 *
 */
trait KecDetail
{
    public function getDetailKecamatan($id){
        $detail = KecamatanDetail::where('id', $id)->first();
        $temp_lokpri = explode(',', $detail['lokpriid']);
        $data['lokpri'] ='';

        if($temp_lokpri[0] != '') {
            foreach ($temp_lokpri as $key => $value) {
                $temp = KecamatanLokpri::where('lokpriid', $value)->first()->nickname;
                $data['lokpri'] .= $temp;
                if ($key < (count($temp_lokpri) - 1)) {
                    $data['lokpri'] .= ', ';
                }
            }
        }else{
            $data['lokpri'] = '-';
        }

        $temp_tipe = explode(',', $detail['typeid']);
        $data['tipe'] = '';

        if($temp_tipe[0] != ''){
            foreach ($temp_tipe as $key => $value) {
                $temp = KecamatanType::where('typeid', $value)->first()->nickname;
                $data['tipe'] .= $temp;
                if ($key < count($temp_tipe)-1) {
                    $data['tipe'] .= ', ';
                }
            }
        }else{
            $data['tipe'] = '-';
        }
        return $data;
    }
}
