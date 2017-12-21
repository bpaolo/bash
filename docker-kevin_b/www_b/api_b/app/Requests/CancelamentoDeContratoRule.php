<?php

namespace App\Requests;

use Validator;

class CancelamentoDeContratoRule {

    public static $endpoint = 'CancelamentoContrato_I014';

    protected static $request = [
        'GUID'      => '',
        'VBELN'     => ''
    ];


    public static $rules =  [ 
        'GUID'      => '',
        'VBELN'     => ''
    ];

    public static function parse($array)
    {
        if ($array) {
            $data = [
                'GUID'      => $array['GUID'],
                'VBELN'     => $array['VBELN']
            ];   
        }

        return $data;
    }
}