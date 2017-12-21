<?php

namespace App\Requests;

use Validator;

class AtualizaStatusVeiculoEntregueRule {

    public static $endpoint = 'AtualizaStVeiculoEntregue_I020';

    public static $request = [
        "GUID"  => '',
        'VBELN' => '',
        'MVGR1' => ''
    ];


    public static $rules =  [ 
        'GUID'  => '',
        'VBELN' => 'required',
        'MVGR1' => 'required'
    ];

    public static function parse($array) {
        if ($array) {

            $data = [
                "GUID"  => $array['GUID'],
                'VBELN' => $array['VBELN'],
                'MVGR1' => $array['MVGR1']
            ];
        }

        return $data;
    }

    public static function isValid($request, $regra) {

        $validator = Validator::make($request, self::$rules[$regra]);

        if(count($validator->errors())){
            $retorno = [
                'header' => [
                    'code'      => 400,
                    'message'   => 'Bad Request',
                    'errors'    => $validator->errors()
                ]
            ];
            return $retorno;
        }
        return false;
    }

}