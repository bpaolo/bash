<?php

namespace App\Requests;

use Validator;

class CancelaVendaCartaoRule {

    public static $endpointSAP = 'CancVendaCartao_I005';

    public static $request = ["GUID" => '',
        "LANCAMENTO"=> [
            "CABEC"=> [
                "TRANSACAO"         => "",
                "DATA_DOC"         => "",
                "TIPO_DOC"         => "",
                "EMPRESA"          => "",
                "DATA_LANCTO"      => "",
                "MOEDA"            => "",
                "REFERENCIA"       => "",
                "TEXTO_CABEC"      => "",
                "CHAVE_REF1"       => "",
                "CHAVE_REF2"       => ""
            ],
            "ITEM_CLIENTE"=> [
                "TRANSACAO"         => "",
                "COD_CLIENTE"      => "",
                "ATRIBUICAO"       => "",
                "MONTANTE"         => "",
                "VENCTO"           => "",
                "CHAVE_REF1"       => "",
                "CHAVE_REF2"       => "",
                "CHAVE_REF3"       => "",
                "CENTRO_LUCRO"     => "",
                "DIVISAO"          => "",
                "REF_PAGTO"        => "",
                "TEXTO"            => ""
            ],
            "ITEM_CARTAO"=> [
                "TRANSACAO"         => "",
                "COD_CLIENTE"      => "",
                "ATRIBUICAO"       => "",
                "MONTANTE"         => "",
                "VENCTO"           => "",
                "CHAVE_REF1"       => "",
                "CHAVE_REF2"       => "",
                "CHAVE_REF3"       => "",
                "CENTRO_LUCRO"     => "",
                "DIVISAO"          => "",
                "REF_PAGTO"        => "",
                "TEXTO"            => ""
            ]

        ]
    ];


    public static $rules =  [ 'GUID' => '',
        "CABEC_TRANSACAO"        => "required",
        "CABEC_DATA_DOC"         => "required",
        "CABEC_TIPO_DOC"         => "required",
        "CABEC_EMPRESA"          => "required",
        "CABEC_DATA_LANCTO"      => "required",
        "CABEC_MOEDA"            => "required",
        "CABEC_REFERENCIA"       => "required",
        "CABEC_TEXTO_CABEC"      => "required",
        "CABEC_CHAVE_REF1"       => "required",
        "CABEC_CHAVE_REF2"       => "required",
        "ITEM_CLIENTE_TRANSACAO"        => "required",
        "ITEM_CLIENTE_COD_CLIENTE"      => "required",
        "ITEM_CLIENTE_ATRIBUICAO"       => "required",
        "ITEM_CLIENTE_MONTANTE"         => "required",
        "ITEM_CLIENTE_VENCTO"           => "required",
        "ITEM_CLIENTE_CHAVE_REF1"       => "required",
        "ITEM_CLIENTE_CHAVE_REF2"       => "required",
        "ITEM_CLIENTE_CHAVE_REF3"       => "required",
        "ITEM_CLIENTE_CENTRO_LUCRO"     => "required",
        "ITEM_CLIENTE_DIVISAO"          => "required",
        "ITEM_CLIENTE_REF_PAGTO"        => "required",
        "ITEM_CLIENTE_TEXTO"            => "required",
        "ITEM_CARTAO_TRANSACAO"         => "required",
        "ITEM_CARTAO_COD_CLIENTE"       => "required",
        "ITEM_CARTAO_ATRIBUICAO"        => "required",
        "ITEM_CARTAO_MONTANTE"          => "required",
        "ITEM_CARTAO_VENCTO"            => "required",
        "ITEM_CARTAO_CHAVE_REF1"        => "required",
        "ITEM_CARTAO_CHAVE_REF2"        => "required",
        "ITEM_CARTAO_CHAVE_REF3"        => "required",
        "ITEM_CARTAO_CENTRO_LUCRO"      => "required",
        "ITEM_CARTAO_DIVISAO"           => "required",
        "ITEM_CARTAO_REF_PAGTO"         => "required",
        "ITEM_CARTAO_TEXTO"             => "required"
    ];

    public static function parse($array)
    {
        if ($array) {

            $data = [
                "GUID" => $array['GUID'],
                "LANCAMENTO"=> [
                    "CABEC"=> [
                        "TRANSACAO"         => $array[''],
                        "DATA_DOC"         => $array[''],
                        "TIPO_DOC"         => $array[''],
                        "EMPRESA"          => $array[''],
                        "DATA_LANCTO"      => $array[''],
                        "MOEDA"            => $array[''],
                        "REFERENCIA"       => $array[''],
                        "TEXTO_CABEC"      => $array[''],
                        "CHAVE_REF1"       => $array[''],
                        "CHAVE_REF2"       => $array['']
                    ],
                    "ITEM_CLIENTE"=> [
                        "TRANSACAO"         => $array[''],
                        "COD_CLIENTE"      => $array[''],
                        "ATRIBUICAO"       => $array[''],
                        "MONTANTE"         => $array[''],
                        "VENCTO"           => $array[''],
                        "CHAVE_REF1"       => $array[''],
                        "CHAVE_REF2"       => $array[''],
                        "CHAVE_REF3"       => $array[''],
                        "CENTRO_LUCRO"     => $array[''],
                        "DIVISAO"          => $array[''],
                        "REF_PAGTO"        => $array[''],
                        "TEXTO"            => $array['']
                    ],
                    "ITEM_CARTAO"=> [
                        "TRANSACAO"         => $array[''],
                        "COD_CLIENTE"      => $array[''],
                        "ATRIBUICAO"       => $array[''],
                        "MONTANTE"         => $array[''],
                        "VENCTO"           => $array[''],
                        "CHAVE_REF1"       => $array[''],
                        "CHAVE_REF2"       => $array[''],
                        "CHAVE_REF3"       => $array[''],
                        "CENTRO_LUCRO"     => $array[''],
                        "DIVISAO"          => $array[''],
                        "REF_PAGTO"        => $array[''],
                        "TEXTO"            => $array['']
                    ]

                ]
            ];
        }

        return $data;
    }

    public static function parseDB($array)
    {
        if ($array) {

            $data = [
                "GUID" => $array[0]['GUID']??1,
                "LANCAMENTO"=> [
                    "CABEC"=> [
                        "TRANSACAO"         => $array[0]['PedidoID'],
                        "DATA_DOC"         => $array[0]['DTIntegracao'],
                        "TIPO_DOC"         => 1,
                        "EMPRESA"          => 9000,
                        "DATA_LANCTO"      => $array[0]['DataLancto'],
                        "MOEDA"            => 'BRL',
                        "REFERENCIA"       => $array[0]['TID'],
                        "TEXTO_CABEC"      => $array[0]['BandeiraID'], // ???
                        "CHAVE_REF1"       => $array[0]['DataLancto'],
                        "CHAVE_REF2"       => '???'
                    ],
                    "ITEM_CLIENTE"=> [
                        "TRANSACAO"         => $array[0]['TID'],
                        "COD_CLIENTE"      => '1',//criar campo
                        //"COD_CLIENTE"      => $array[0][''],//criar campo
                        "ATRIBUICAO"       => $array[0]['PedidoID'],
                        "MONTANTE"         => $array[0]['Valor'],
                        "VENCTO"           => $array[0]['DataLancto'],
                        "CHAVE_REF1"       => $array[0][''],//??
                        "CHAVE_REF2"       => $array[0][''],//??
                        "CHAVE_REF3"       => $array[0]['Origem'],
                        "CENTRO_LUCRO"     => $array[0]['PedidoID'], //???
                        "DIVISAO"          => 7000,
                        "REF_PAGTO"        => $array[0]['NroParcelas'],
                        "TEXTO"            => $array[0]['Estabelecimento']
                    ],
                    "ITEM_CARTAO"=> [
                        "TRANSACAO"         => $array[0]['TID'],
                        "COD_CLIENTE"      => $array[0]['UsuarioID'],
                        "ATRIBUICAO"       => $array[0]['PeriodoID'], //???
                        "MONTANTE"         => $array[0]['Valor'],
                        "VENCTO"           => $array[0]['DataLancto'],
                        "CHAVE_REF1"       => $array[0][''], //??//???
                        "CHAVE_REF2"       => $array[0][''],//???
                        "CHAVE_REF3"       => $array[0][''],//???
                        "CENTRO_LUCRO"     => $array[0][''],//???
                        "DIVISAO"          => 7000,
                        "REF_PAGTO"        => $array[0]['NroParcelas'],
                        "TEXTO"            => $array[0]['Estabelecimento']
                    ]

                ]
            ];
        }

        return $data;
    }
}