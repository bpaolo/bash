<?php
/*
* Abertura de Contrato
* Interface
* Cicero Vieira
*/

namespace App\Http\Controllers;

use App\Transformer\ProdutosTransformer;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Requests\AberturaContratosRule;

use GuzzleHttp;


class AberturaContratosController extends Controller
{
    
    const ERROR = 'Internal Server Error';

    public function __construct()
    {

         DB::enableQueryLog();

    }



    public function index()
    {

        try {

            $dataAtual = '2012-12-01'; // date('Y-m-d');


            $Contratos = DB::table('C009_Contratos AS C')
                ->select([
                    //'C.*',
                    //'CS.*',

                    'C.ContratoNro As ContratoNumero',
                    'C.Modalidade AS Modalidade',
                    'C.Upgrade AS Upgrade',

                    'C.ClienteID AS ClienteID',
                    'C.PagadorID AS PagadorID',
                    'C.AgenciaID AS AgenciaID',
                    'C.EmpresaID AS EmpresaID',
                    'C.ClienteID AS ClienteID',
                    'C.UsuarioA AS UsuarioA',
                    'C.UsuarioF AS UsuarioF',

                    'C.ReservaID AS ReservaID',
                    'CV.CanalID AS CanalID',
                    'RE.Referencia AS Referencia',
                    'RE.Data AS RE_Data',
                    'C.R_FilialID AS R_FilialID',
                    'C.R_Data AS R_Data',
                    'C.D_FilialID AS D_FilialID',
                    'C.D_Data AS D_Data',
                    'C.FrotaID AS FrotaID',
                    'C.GrupoID AS GrupoID',
                    'CS.ValorTotal AS ValorTotal',

                    'CS.DataIni  AS DataIni',
                    'CS.DataFinal AS DataFinal',

                    'L.DataLancto AS L_DataLancto',

                    //'L.Desconto AS Desconto',

                    'CS.DataFinal AS DataFinal',
                    'C.DataA AS DataA',
                    'C.DataF AS DataF',
                    'C.ValorID AS ValorID',
                    'C.FilialIDA AS FilialIDA',
                    'CS.Sequencia AS Sequencia',
                    'CS.IntegracaoID AS IntegracaoID',
                    'CS.DataIntegracao AS DataIntegracao',
                    'CV.CanalID AS CV_CanalID',
                    'RE.Referencia AS RE_Referencia',
                    'L.TID AS L_TID',
                    'L.Valor AS L_Valor',
                    'L.FormaID AS L_FormaID',
                    'L.PessoaID AS L_PessoaID'

                ])
                ->join('C009_ContratoSeq AS CS', 'C.ContratoNro', '=', 'CS.ContratoNro')
                ->leftJoin('C013_Reservas AS RE', 'C.ReservaID', '=', 'RE.ReservaID')
                ->leftJoin('L005_Canais_Venda AS CV', 'RE.CanalID', '=', 'CV.CanalID')
                ->leftJoin('C009_Lancamentos AS L', function($Contratos) {
                    $Contratos->on('CS.ContratoNro', '=', 'L.ContratoNro')
                        ->on('CS.UsuarioID', '=', 'L.UsuarioID')
                        ->on('CS.Sequencia', '=', 'L.Sequencia');
                })
                ->where('C.StatusID', 1)
                ->whereNull('CS.IntegracaoID')
                ->where('CS.Sequencia', '<=', 100)
                ->where(DB::raw('SUBSTR(CS.DataIni, 1, 7)'), '=', '2012-11')
                ->where(function($Contratos) use($dataAtual) {
                    $Contratos->where(DB::raw('SUBSTR(CS.DataFinal,1,10)'), '=', $dataAtual);
                    $Contratos->where(DB::raw('SUBSTR(CS.DataFinal,1,10)'), '=', 'SUBSTR(CS.DataF,1,10)');
                    $Contratos->orWhere('CS.DataF', '<>', '');
                })->limit(1)->get();

            //echo '<pre>';
            //print_r(DB::getQueryLog());

            foreach ($Contratos as $var){
                $i=0;

                $Produtos = DB::table('C009_Produtos AS P')
                    ->select([
                        //'PR.*',
                        'L.NroLancamento AS L_NroLancamento',
                        'L.TID AS L_TID',
                        'L.Valor AS L_Valor',
                        'L.NroParcelas AS L_NroParcelas',
                        'L.FormaID AS L_FormaID',
                        'F.Descricao AS F_Descricao',
                        'P.ContratoNro AS ContratoNro',
                        'P.ProdutoID AS ProdutoID',
                        'P.ValorUnitario AS ValorUnitario',
                        'P.Desconto AS Desconto',
                        'P.Total AS Total',
                        //'PR.Centro_de_Custo AS Centro_de_Custo'
                    ])
                    ->join('L008_Produtos as PR', 'P.ProdutoID', '=', 'PR.ProdutoID')
                    ->leftJoin('C009_Lancamentos as L', 'P.ContratoNro', '=', 'L.ContratoNro')
                    ->leftJoin('B013_FormasPagto AS F', 'L.FormaID', '=', 'F.FormaID')
                    ->where('P.ContratoNro', $var->ContratoNumero)
                    ->where('P.Sequencia', $var->Sequencia)
                    ->where('L.Sequencia', $var->Sequencia)
                    //->where('P.FilialIDA', $var->FilialIDA)
                    ->get();

                    //echo '<pre>';
                    //print_r($Produtos);
                    //exit();

                    foreach($Produtos as $value){

                      $var->Produtos[$i] = $value;

                      $i++;
                    }  
                    
            }


            $Contratos[] = $var;

         
            //echo '<pre>';
            //print_r($Contratos);
            //exit();

            if (count($Contratos) > 0) {

                $json = $this->AberturaContratos($Contratos);

                $integrate = $this->enviarContratos(

                    $json , 
                    AberturaContratosRule::$endpointSAP 

                );

                print_r($integrate);

            }

        }catch (exception $e){

            return $this->Error(ERROR);

        }


        $response = json_encode(
            $json ,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );

        return response($response)->header('Content-Type', 'application/json');

    }


    /*
     * Criação de Json de contratos para encerrar no SAP.
     *
    */
    private function AberturaContratos($dados)
    {
        try {


            $dataDiferencaDias = null;
            $i=0;
            $tiposParceiros = [
                'AG'=>'ClienteID',
                'RG'=>'PagadorID',
                'ZG'=>'AgenciaID',
                'ZE'=>'EmpresaID',
                'ZA'=>'UsuarioA',
                'ZL'=>'UsuarioF'
            ];

            $modalidades = ['1' => 'Mensal', '2' => 'Eventual', '3' => 'Mensal Flex'];
            $upgrade = [ '1' => 'Upgrade', '2' => 'Upsell'];
            $canalId = [
                '1'  => 'Call Center',
                '2'  => 'Website Movida',
                '3'  => 'Portal Agência',
                '4'  => 'Loja - Walk in',
                '5'  => 'WebServices (XML)',
                '6'  => 'Mobile',
                '7'  => 'GDS Amadeus',
                '15' => 'Link',
                '16' => 'Portal Empresa',
                '17' => 'MIP – Ipiranga',
                '18' => 'SABRE',
                '19' => 'Website Movida',
                '20' => 'Parcerias',
                '21' => 'Travel Port',
                '22' => 'Redes Sociais',
                '23' => 'SIXT',
                '24' => 'Hotsite Mensal Flex'
            ];

            $tiposPagamentos = [
                '0'=>'Cartão de crédito/débito',
                '6'=>'Apropriação indébita',
                '7'=>'Cortesia (cliente)',
                '9'=>'Dinheiro',
                'D'=>'Duplicata/boleto'
            ];

            foreach($dados as $value){
                //Topo
                $arrayDados[$i]['GUID'] = 'I012';

                $arrayDados[$i]['DADOS_CONTRATO']['COD_INTERF'] = 'I012';
                $arrayDados[$i]['DADOS_CONTRATO']['TIPO_ORDEM'] = '';

                /*
                foreach ($tiposParceiros as $key => $tipoParceiro){
                if(isset($value->$tipoParceiro) && $value->$tipoParceiro != ''){
                    $arrayDados[$i]['DADOS_CONTRATO']['PARCEIROS']['PARVW'][$key] = $value->$tipoParceiro;
                    $arrayDados[$i]['DADOS_CONTRATO']['PARCEIROS']['KUNNR'][] = $value->$tipoParceiro;
                }
                }*/
             
                $arrayDados[$i]['DADOS_CONTRATO']['EMISSOR'] = 'AG';
                $arrayDados[$i]['DADOS_CONTRATO']['KUNNR_EMISSOR'] = isset($value->ClienteID) ? $value->ClienteID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['PAGADOR'] = 'RG';
                $arrayDados[$i]['DADOS_CONTRATO']['KUNNR_PAGADOR'] = isset($value->PagadorID) ? $value->PagadorID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['AGENCIA'] = 'ZG';
                $arrayDados[$i]['DADOS_CONTRATO']['KUNNR_AGENCIA'] = isset($value->AgenciaID) ? $value->AgenciaID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['AG_TRIPARTITE'] = 'ZE';
                $arrayDados[$i]['DADOS_CONTRATO']['KUNNR_AG_TRIPARTITE'] = isset($value->EmpresaID) ? $value->EmpresaID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['COND_ADICIONAL'] = 'ZC';
                $arrayDados[$i]['DADOS_CONTRATO']['KUNNR_COND_ADICIONAL'] = isset($value->ClienteID) ? $value->ClienteID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['AG_ABERTURA'] = 'ZA';
                $arrayDados[$i]['DADOS_CONTRATO']['PERNR_AG_ABERTURA'] = isset($value->UsuarioA) ? $value->UsuarioA : '';

                $arrayDados[$i]['DADOS_CONTRATO']['AG_ENCERRAMENTO'] = 'ZL';
                $arrayDados[$i]['DADOS_CONTRATO']['PERNR_AG_ENCERRAMENTO'] = isset($value->UsuarioF) ? $value->UsuarioF : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZTPCLIENTE'] = $modalidades[$value->Modalidade];

                if(isset($value->Upgrade) && in_array($value->Upgrade, array_keys($upgrade))){
                    $arrayDados[$i]['DADOS_CONTRATO']['ZZUPGRADE'] = $upgrade[$value->Upgrade];
                }else{
                    $arrayDados[$i]['DADOS_CONTRATO']['ZZUPGRADE'] = '';
                }

                $arrayDados[$i]['DADOS_CONTRATO']['ZZNRCONTRATO'] = isset($value->ContratoNro) ? $value->ContratoNro : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZNRPERIODO']  = '00';
                $arrayDados[$i]['DADOS_CONTRATO']['ZZNRADITIVO']  = '00';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZNRRESERVA'] = isset($value->ReservaID) ? $value->ReservaID : '';

                if(isset($value->CV_CanalID) && in_array($value->CV_CanalID, array_keys($canalId))){
                    $arrayDados[$i]['DADOS_CONTRATO']['ZZTPCANAL'] = $canalId[$value->CV_CanalID];
                }else{
                    $arrayDados[$i]['DADOS_CONTRATO']['ZZTPCANAL'] = '';
                }

                $arrayDados[$i]['DADOS_CONTRATO']['ZZCODREF'] = isset($value->RE_Referencia) ? $value->RE_Referencia : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZDTARES'] = isset($value->RE_Data) ? $this->formataData($value->RE_Data) : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZHRARES']  = isset($value->RE_Data) ? $this->formataData($value->RE_Data, 'h') : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZLJRET'] = isset($value->R_FilialID) ? $value->R_FilialID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZDTARET']  = isset($value->R_Data) ? $this->formataData($value->R_Data) : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZHRARET'] = isset($value->R_Data) ? $this->formataData($value->R_Data, 'h') : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZPLACARET'] = isset($value->FrotaID) ? $value->FrotaID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZGPRET']   = isset($value->GrupoID) ? $value->GrupoID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZLJDEV'] = isset($value->D_FilialID) ? $this->formataData($value->D_FilialID) : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZDTADEV']  = isset($value->D_Data) ? $this->formataData($value->D_Data) : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZHRADEV'] = isset($value->D_Data) ? $this->formataData($value->D_Data, 'h') : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZPLACADEV']  = isset($value->FrotaID) ? $value->FrotaID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZGPDEV'] =  isset($value->GrupoID) ? $value->GrupoID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZVLTOTAL_PED'] = isset($value->ValorTotal) ? $value->ValorTotal : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZDTAPGTO'] = isset($value->L_DataLancto) ? $this->formataData($value->L_DataLancto) : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZDTAENC'] = isset($value->DataFinal) ? $this->formataData($value->DataFinal) : '';

                  
// * Manuel vai confirmar (DIA 18/12 ou 19/12)-
// $dataDiferencaDias = strtotime(substr($value->DataFinal,0, 10)) -
// strtotime(substr($value->DataIni, 0, 10));
//$arrayDados[$i]['DADOS_CONTRATO']['ZZDURLOC'] = isset($value->DataFinal) ? ($dataDiferencaDias / 86400) : '';
                          

                $arrayDados[$i]['DADOS_CONTRATO']['ZZDTAINI'] = isset($value->DataA) ? $this->formataData($value->DataA) : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZDTAFIM'] = isset($value->DataF) ? $this->formataData($value->DataF) : '';

                $arrayDados[$i]['DADOS_CONTRATO']['ZZVLTOTAL'] = isset($value->ValorID) ? $value->ValorID : '';

                $arrayDados[$i]['DADOS_CONTRATO']['WAERK'] = 'BRL';
                $arrayDados[$i]['DADOS_CONTRATO']['MATNR'] = '';  //Código do serviço?
                $arrayDados[$i]['DADOS_CONTRATO']['KWMENG'] = ''; //Quantidade produtos?
                $arrayDados[$i]['DADOS_CONTRATO']['WERKS'] = isset($value->FilialIDA) ? $value->FilialIDA : '';

                foreach ($value->Produtos as $key => $produtos){
                    
                    $arrayDados[$i]['DADOS_CONTRATO']['COND_VALUE1'][$key] = $produtos->ValorUnitario;
                    $arrayDados[$i]['DADOS_CONTRATO']['COND_VALUE2'][$key] = $produtos->Desconto;
                    $arrayDados[$i]['DADOS_CONTRATO']['COND_VALUE3'][$key] = $produtos->Desconto;
                    $arrayDados[$i]['DADOS_CONTRATO']['COND_VALUE4'][$key] = $produtos->Total;
               
                }

                $arrayDados[$i]['DADOS_CONTRATO']['PRCTR'] = ''; //Centro de Custo?

                $arrayDados[$i]['DADOS_CONTRATO']['KUNNR'] = isset($value->PagadorID) ? $value->PagadorID : '';

                foreach ($value->Produtos as $key => $produtos){
               
                    $arrayDados[$i]['DADOS_CONTRATO']['ZLSCH'][$key] = $produtos->L_FormaID.'-'.$produtos->F_Descricao;
                }

                foreach ($value->Produtos as $key => $produtos){
               
                    $arrayDados[$i]['DADOS_CONTRATO']['COND_VALUE5'][$key] = $produtos->L_Valor; //?? Vai ter esse 
                }
                    
                $arrayDados[$i]['DADOS_CONTRATO']['ZZTRANSACAO'] = ''; //??

                $arrayDados[$i]['DADOS_CONTRATO']['ZTEXT_FORMAPGTO'] = '';
                //informações complementares se houver (observação no apropriação em débito)?

                $arrayDados[$i]['DADOS_CONTRATO']['ZTEXT_INFO_COMPLEM'] = '';
                //informações complementares se houver (observação no apropriação em cortesia);?

                $i++;
            }

     

            //echo "<pre>";
            //print_r($arrayDados);

            return $arrayDados;

        }catch (exception $e){
            return $this->Error(ERROR);
        }

    }


    /**
     * Envia Json de contratos para encerrar no SAP.
     *
     * @return void
    */

    private function enviarContratos($data, $endpoint) {

        $client = new GuzzleHttp\Client();

        $res = $client->request('POST', 'http://10.141.2.30:58500/RESTAdapter/'.$endpoint, [
            'auth' => ['PI-VETOR', '@Jsl1720'], 'json' => $data
        ]);

        $return = array();

        if($res){
            $return['code'] =  $res->getStatusCode();
            $return['data'] =  $res->getBody()->getContents();
            return $return;
        }

        return false;
    }



    private function Error($msg=ERROR){
        return $this->errorServer = response()->json(
            [
                'header' => [
                    'code'      => 500,
                    'message'   => $msg,
                ]
            ], 500);
    }

    private function formataData($dt, $tipo='d'){
        $dt = str_replace("-","", str_replace(":","", $dt));
        if($tipo=='d'){
            return substr($dt, 0, 8);
        }
        return substr($dt, 9, 6);
    }




}