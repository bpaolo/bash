<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Requests\RuleRequest;
use App\Requests\MovimentacaoAtivosRule;
use App\Requests\CancelaVendaAtivoRule;
use App\Requests\CancelaVendaCartaoRule;
use App\Models\ModelFrota;
use App\Models\ModelLancamento;


use App\Consumers\MovimentacaoAtivosConsumer;

class AtivosController extends Controller
{
    /**
     * Create Movimentação de Pedido no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Movimentacao(Request $request){
        
        $naoValidou = RuleRequest::isValid($request->all(), MovimentacaoAtivosRule::$rules );

        if($naoValidou){
            return response()->json($naoValidou, 400);
        }
        
        $consumer   = new MovimentacaoAtivosConsumer();
        $integrate  = $consumer->handle($request->all());

        if($integrate){

            var_dump($integrate);
            die();

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
     * Create Pedido On SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Cancelamento(Request $request)
    {

        $teste = ModelLancamento::limit(1)->offset(1)->get()->toArray();

         var_dump($teste);

        die();

        $integrate = RuleRequest::sendSAP(CancelaVendaCartaoRule::parseDB($teste), CancelaVendaCartaoRule::$endpointSAP );
        var_dump($integrate);
        die(   );

        $naoValidou = RuleRequest::isValid($request->all(), CancelaVendaAtivoRule::$rules );

        if($naoValidou){
            return response()->json($naoValidou, 400);
        }

        $integrate = RuleRequest::sendSAP(CancelaVendaAtivoRule::parse($request->all()), CancelaVendaAtivoRule::$endpointSAP );

        var_dump($integrate);
        die(   );

    }
}