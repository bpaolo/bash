<?php

namespace App\Requests;

use Validator;

class MovimentacaoAtivosRule {

    public static $endpoint = 'CamposMovAtivo_I024';

    protected static $request = [
        "GUID"                => '',
        "IMOBILIZADO"         => [
            'TRANSACAO'              => '',
            'CHASSI'                 => '',
            "EMPRESA"                => ''
        ],
        "ITEM_IMOBILIZADO"    => [
            'TRANSACAO'              => '',
            'FILIAL'                 => '',
            'PLACA'                  => '',
            'STATUS'                 => '',
            'RENAVAM'                => '',
            "CID_EMPLAC"             => ''
        ]
    ];


    public static $rules =  [ 
        'GUID'                   => '',
        'IMOBILIZADO_TRANSACAO'  => 'required',
        'IMOBILIZADO_CHASSI'     => 'required',
        "IMOBILIZADO_EMPRESA"    => 'required',
        'ITEM_TRANSACAO'         => 'required',
        'ITEM_FILIAL'            => '',
        'ITEM_PLACA'             => '',
        'ITEM_STATUS'            => '',
        'ITEM_RENAVAM'           => '',
        "ITEM_CID_EMPLAC"        => ''
    ];

    public static function parse($array)
    {
        if ($array) {

            $data = [
                "GUID"          => $array['GUID'],
                "IMOBILIZADO"   =>
                    [
                        'TRANSACAO' => $array['IMOBILIZADO_TRANSACAO'],
                        'CHASSI'    => $array['IMOBILIZADO_CHASSI'],
                        'EMPRESA'   => $array['IMOBILIZADO_EMPRESA']
                    ],
                "ITEM_IMOBILIZADO"  => [
                        'TRANSACAO'     => $array['ITEM_TRANSACAO'],
                        'FILIAL'        => $array['ITEM_FILIAL']??'',
                        'PLACA'         => $array['ITEM_PLACA']??'',
                        'STATUS'        => $array['ITEM_STATUS']??'',
                        'RENAVAM'       => $array['ITEM_RENAVAM']??'',
                        "CID_EMPLAC"    => $array['ITEM_CID_EMPLAC']??''
                    ]
            ];
        }

        return $data;
    }

    public static function parseDB($array)
    {
        if ($array) {

            $status = '';

            switch ($array[0]['StatusID']){
                case 1:
                    $status = 'PIMP';
                    break;
                case 2:
                    $status = 'OPEP';
                    break;
                case 3:
                    $status = 'DV';
                    break;
                case 4:
                    $status = 'ROUB';
                    break;
                default:
                    $status = '';
                    break;
            }

            $data = [
                "GUID" => '123456',
                "IMOBILIZADO" =>
                    [
                        'TRANSACAO' => $array[0]['FrotaID'],
                        'CHASSI'    => $array[0]['Chassi'],
                        'EMPRESA'   => 9000
                    ],
                "ITEM_IMOBILIZADO"           => [
                    'TRANSACAO'  => $array[0]['FrotaID'],
                    'FILIAL'     => $array[0]['L001_FilialID']??'',
                    'PLACA'      => $array[0]['Placa']??'',
                    'STATUS'     => $status??'',
                    'RENAVAM'    => $array[0]['Renavam']??'',
                    "CID_EMPLAC" => 'Validar?'??''
                ]
            ];
        }

        return $data;
    }
}