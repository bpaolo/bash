<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

// Rules
use App\Requests\RuleRequest;
use App\Requests\AberturaDeContratoRule;
use App\Requests\CancelamentoDeContratoRule;
use App\Requests\EncerramentoDeContratoRule;
// Consumers
use App\Consumers\AberturaDeContratoConsumer;
use App\Consumers\CancelamentoDeContratoConsumer;
use App\Consumers\EncerramentoDeContratoConsumer;

class RacController extends Controller
{
    /**
     * Abertura de Contrato no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function AberturaDeContrato(Request $request){
        
        $valid = RuleRequest::isValid($request->all(), AberturaDeContratoRule::$rules );

        if($valid){
            return response()->json($valid, 400);
        }

        $consumer   = new AberturaDeContratoConsumer();
        $integrate  = $consumer->handle($request->all());

        return $integrate;
        
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
     * Cancelamento de Contrato no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function CancelamentoDeContrato(Request $request){
        
        $valid = RuleRequest::isValid($request->all(), CancelamentoDeContratoRule::$rules );

        if($valid){
            return response()->json($valid, 400);
        }

        $consumer   = new CancelamentoDeContratoConsumer();
        $integrate  = $consumer->handle($request->all());

        dd($integrate);

        return $integrate;
        
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
                        'code'      => 200,
                        'message'   => 'OK',
                    ],
                    'data' => [
                        'docnum' => $docnum
                    ]
                ], 200);
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
     * Encerramento de Contrato no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function EncerramentoDeContrato(Request $request){
        
        $valid = RuleRequest::isValid($request->all(), EncerramentoDeContratoRule::$rules );

        if($valid){
            return response()->json($valid, 400);
        }

        $consumer   = new EncerramentoDeContratoConsumer();
        $integrate  = $consumer->handle($request->all());

        return $integrate;
        
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