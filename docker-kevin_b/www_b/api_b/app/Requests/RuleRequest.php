<?php

namespace App\Requests;

use Validator;
use GuzzleHttp;

class RuleRequest
{
    public static function isValid($request, $regra) {
        $validator = Validator::make($request, $regra);
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