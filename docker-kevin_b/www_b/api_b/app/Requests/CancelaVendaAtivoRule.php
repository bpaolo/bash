<?php

namespace App\Requests;

use Validator;

class CancelaVendaAtivoRule {

    public static $endpointSAP = 'CancelamentoVendaAtivo_I021';

    public static $request = ["GUID" => '',
        "VBELN_VA"      => "",
        "ZZANLN1"       => ""
    ];


    public static $rules =  [ 'GUID' => '',
        "VBELN_VA"      => "required",
        "ZZANLN1"       => "required"
    ];

    public static function parse($array)
    {
        if ($array) {

            $data = [
                "GUID"     => $array['GUID'],
                'VBELN_VA' => $array['VBELN_VA'],
                'ZZANLN1'  => $array['ZZANLN1']
            ];
        }

        return $data;
    }
}