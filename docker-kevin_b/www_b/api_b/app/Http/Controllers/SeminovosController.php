<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
// Rules
use App\Requests\RuleRequest;
use App\Requests\CriacaoPedidoAtivoRule;
use App\Requests\AtualizaStatusVeiculoEntregueRule;
use App\Requests\AtualizaStatusFinanceiroRule;
// Consumers
use App\Consumers\AtualizaStatusVeiculoEntregueConsumer;
use App\Consumers\AtualizaStatusFinanceiroConsumer;
use App\Consumers\CriacaoPedidoAtivoConsumer;

class SeminovosController extends Controller
{
    /**
     * Criar Pedido Ativo no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function CriarPedidoAtivo(Request $request){
        
        $valid = RuleRequest::isValid($request->all(), CriacaoPedidoAtivoRule::$rules );

        if($valid){
            return response()->json($valid, 400);
        }

        $consumer   = new CriacaoPedidoAtivoConsumer();
        $integrate  = $consumer->handle($request->all());

        if($integrate){

            $rsap    = json_decode($integrate['data']);
            $rsap    = $rsap->MT_RetornoProcessamento_I999;
            $guid    = $rsap->GUID;
            $status  = $rsap->RET->STATUS;

            if($status == 'S'){
                $docnum = $rsap->RET->KEY->KEYNR;
                return response()->json(
                [
                    'header' => [
                        'code'      => 201,
                        'message'   => 'Create'
                    ],
                    'data' => [
                        'docnum' => $docnum
                    ]
                ], 201);
            }

            if($status == 'E'){

                $message = $rsap->RET->KEY->RET_LOG->LOG->MESSAGE;
                return response()->json(
                [
                    'header' => [
                        'code'      => 422,
                        'message'   => $message,
                    ]
                ], 422);
            }
        }

        return response()->json(
        [
            'header' => [
                'code'      => 500,
                'message'   => 'Internal Server Error',
            ]
        ], 500);
    }

    /**
     * Atualizar Status do Veículo Entregue no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function AtualizaStatusVeiculoEntregue(Request $request){
        
        $valid = RuleRequest::isValid($request->all(), AtualizaStatusVeiculoEntregueRule::$rules );

        if($valid){
            return response()->json($valid, 400);
        }

        $consumer   = new AtualizaStatusVeiculoEntregueConsumer();
        $integrate  = $consumer->handle($request->all());

        if($integrate){

            $rsap    = json_decode($integrate['data']);
            $rsap    = $rsap->MT_RetornoProcessamento_I999;
            $guid    = $rsap->GUID;
            $status  = $rsap->RET->STATUS;

            if($status == 'S'){

                $docnum = $rsap->RET->KEY->KEYNR;

                return response()->json(
                [
                    'header' => [
                        'code'      => 201,
                        'message'   => 'Create',
                    ],
                    'data' => [
                        'docnum' => $docnum
                    ]
                ], 201);
            }

            if($status == 'E'){

                $message = $rsap->RET->KEY->RET_LOG->LOG->MESSAGE;

                return response()->json(
                [
                    'header' => [
                        'code'      => 422,
                        'message'   => $message,
                    ]
                ], 422);
            }
        }

        return response()->json(
        [
            'header' => [
                'code'      => 500,
                'message'   => 'Internal Server Error',
            ]
        ], 500);
    }

    /**
     * Atualizar Status Financeiro no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function AtualizaStatusFinanceiro(Request $request){
        
        $valid = RuleRequest::isValid($request->all(), AtualizaStatusFinanceiroRule::$rules );

        if($valid){
            return response()->json($valid, 400);
        }

        $consumer   = new AtualizaStatusFinanceiroConsumer();
        $integrate  = $consumer->handle($request->all());

        if($integrate){

            $rsap    = json_decode($integrate['data']);
            $rsap    = $rsap->MT_RetornoProcessamento_I999;
            $guid    = $rsap->GUID;
            $status  = $rsap->RET->STATUS;

            if($status == 'S'){

                $docnum = $rsap->RET->KEY->KEYNR;

                return response()->json(
                [
                    'header' => [
                        'code'      => 201,
                        'message'   => 'Create',
                    ],
                    'data' => [
                        'docnum' => $docnum
                    ]
                ], 201);
            }

            if($status == 'E'){

                $message = $rsap->RET->KEY->RET_LOG->LOG->MESSAGE;

                return response()->json(
                [
                    'header' => [
                        'code'      => 422,
                        'message'   => $message,
                    ]
                ], 422);
            }
        }

        return response()->json(
        [
            'header' => [
                'code'      => 500,
                'message'   => 'Internal Server Error',
            ]
        ], 500);
    }
}