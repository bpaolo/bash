<?php

namespace App\Interfaces;

use GuzzleHttp;

class SicClientInterface
{
    public static function send($data, $endpoint){
    /*
         * GUZZLE DE EXEMPLO
         *
         */
        // $client = new GuzzleHttp\Client();

        // $res = $client->request('POST', 'http://10.141.2.30:58500/RESTAdapter/'.$endpoint, [
        //     'auth' => ['PI-VETOR', '@Jsl1720'], 'json' => $data
        // ]);

        // $return = array();

        // if($res){
        //     $return['code'] =  $res->getStatusCode();
        //     $return['data'] =  $res->getBody()->getContents();
        //     return $return;
        // }

        // return false;
    }
}

