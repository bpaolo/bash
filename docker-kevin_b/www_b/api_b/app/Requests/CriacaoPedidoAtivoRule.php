<?php

namespace App\Requests;

use Validator;

class CriacaoPedidoAtivoRule {

    public static $endpoint = 'CriacaoPedidoAtivo_I022';

    protected static $request = [
        "GUID"                        => '',
        "PEDIDO_ATIVO"                => [
            'COD_INTERF'              => '',
            'TIPO_ORDEM'              => "",
            "VBELN"                   => '',
            "KUNNR_EMISSOR"           => '',
            "KUNNR_PAGADOR"           => '',
            "KUNNR_BOLETO"            => '',
            "PERN"                    => '',
            "ERDAT"                   => "",
            "PLANT"                   => "",
            "PURCH_NO_C"              => '',
            "ZLSCH"                   => "",
            "ZTERM"                   => "",
            "VBAK"                    => "",
            "MATNR"                   => "",
            "KBMENG"                  => "",
            "ZZNPEDVETOR"             => "",
            "ZZNLOTEVETOR"            => "",
            "ZZTPLOTE"                => "",
            "ZZTIPLOTE_SUBTIPO"       => "",
            "COND_VALUE"              => "",
            "COND_VALUE2"             => "",
            "COND_VALUE3"             => "",
            "ZDADOSADDB_INTEG_ATIVOS" => "",
            "MVGR1"                   => "",
            "MVGR2"                   => "",
            "ZTEXT_FORMAPGTO"         => "",
            "ZTEXT_INFO_COMPLEM"      => "",
            "ZTEXT_OBSERVACAO"        => "",
            "ZZDTARES"                => "",
            "PRCTR"                   => "",
            "KUNNR"                   => "",
            "COND_VALUE5"             => "",
            "ZZTRANSACAO"             => ""
        ]
    ];


    public static $rules =  [ 
        'GUID'                      => '',
        'COD_INTERF'                => '',
        'TIPO_ORDEM'                => 'required',
        'VBELN'                     => '',
        'KUNNR_EMISSOR'             => 'required',
        'KUNNR_PAGADOR'             => 'required',
        'KUNNR_BOLETO'              => '',
        'PERN'                      => 'required',
        'ERDAT'                     => 'required',
        'PLANT'                     => 'required',
        'PURCH_NO_C'                => 'required',
        'ZLSCH'                     => 'required', /*gerar várias linhas com o mesmo número do pedido*/
        'ZTERM'                     => 'required',
        'VBAK'                      => 'required',
        'MATNR'                     => 'required',
        'KBMENG'                    => 'required',
        'ZZNPEDVETOR'               => 'required',
        'ZZNLOTEVETOR'              => '',
        'ZZTPLOTE'                  => '',
        'ZZTIPLOTE_SUBTIPO'         => '',
        'COND_VALUE'                => 'required',
        'COND_VALUE2'               => 'required',
        'COND_VALUE3'               => 'required',
        'ZDADOSADDB_INTEG_ATIVOS'   => 'required',
        'MVGR1'                     => 'required',
        'MVGR2'                     => 'required',
        'ZTEXT_FORMAPGTO'           => '',
        'ZTEXT_INFO_COMPLEM'        => '',
        'ZTEXT_OBSERVACAO'          => '',
        'ZZDTARES'                  => 'required',
        'PRCTR'                     => 'required',
        'KUNNR'                     => 'required',
        'COND_VALUE5'               => 'required', /*gerar várias linhas com o mesmo número do pedido*/
        'ZZTRANSACAO'               => 'required'  /*gerar várias linhas com o mesmo número do pedido*/
    ];

    public static function parse($array)
    {
        if ($array) {

            $data = [
                "GUID"  => $array['GUID'],
                "PEDIDO_ATIVO" =>
                    [
                        'COD_INTERF' => $array['COD_INTERF'],
                        'TIPO_ORDEM' => $array['TIPO_ORDEM'],
                        'VBELN' => $array['VBELN'],
                        'KUNNR_EMISSOR' => $array['KUNNR_EMISSOR'],
                        'KUNNR_PAGADOR' => $array['KUNNR_PAGADOR'],
                        'KUNNR_BOLETO' => $array['KUNNR_BOLETO'],
                        'PERN' => $array['PERN'],
                        'ERDAT' => $array['ERDAT'],
                        'PLANT' => $array['PLANT'],
                        'PURCH_NO_C' => $array['PURCH_NO_C'],
                        'ZLSCH' => $array['ZLSCH'],
                        'ZTERM' => $array['ZTERM'],
                        'VBAK' => $array['VBAK'],
                        'MATNR' => $array['MATNR'],
                        'KBMENG' => $array['KBMENG'],
                        'ZZNPEDVETOR' => $array['ZZNPEDVETOR'],
                        'ZZNLOTEVETOR' => $array['ZZNLOTEVETOR'],
                        'ZZTPLOTE' => $array['ZZTPLOTE'],
                        'ZZTIPLOTE_SUBTIPO' => $array['ZZTIPLOTE_SUBTIPO'],
                        'COND_VALUE' => $array['COND_VALUE'],
                        'COND_VALUE2' => $array['COND_VALUE2'],
                        'COND_VALUE3' => $array['COND_VALUE3'],
                        'ZDADOSADDB_INTEG_ATIVOS' => $array['ZDADOSADDB_INTEG_ATIVOS'],
                        'MVGR1' => $array['MVGR1'],
                        'MVGR2' => $array['MVGR2'],
                        'ZTEXT_FORMAPGTO' => $array['ZTEXT_FORMAPGTO'],
                        'ZTEXT_INFO_COMPLEM' => $array['ZTEXT_INFO_COMPLEM'],
                        'ZTEXT_OBSERVACAO' => $array['ZTEXT_OBSERVACAO'],
                        'ZZDTARES' => $array['ZZDTARES'],
                        'PRCTR' => $array['PRCTR'],
                        'KUNNR' => $array['KUNNR'],
                        'COND_VALUE5' => $array['COND_VALUE5'],
                        'ZZTRANSACAO' => $array['ZZTRANSACAO']
                    ]
            ];
        }

        return $data;
    }
}